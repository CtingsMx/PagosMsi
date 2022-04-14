
let btnValida = document.getElementById('btn-validar-pago');

const urlcompra = `https://localhost/pagosmsi/revisaId?folio=`;
//const urlcompra = `https://msi.kober.com.mx/revisaId?folio=`;
const params = new Proxy(new URLSearchParams(window.location.search), {
  get: (searchParams, prop) => searchParams.get(prop),
});

let folio = params.folio;

(() => {
  validaParams();
})();


function validaParams()
{
  if (!folio) {
    ingresaVenta();
    return 0;
  }
}

/**
 * Muestra en pantalla la pasarela, asi como los datos de la venta
 *
 * @returns void
 */
function imprimeResumenCompra(data) {

 
  btnValida.removeAttribute('hidden');

  //data = getCompra(folio);

  console.log(folio);

  document.getElementById("idPedido").value = folio;

  const encabezados = [
    {
      encabezado: "# Pedido",
      indice: "movid",
    },
    {
      encabezado: "Sucursal",
      indice: "Sucursal",
    },
    {
      encabezado: "Cliente",
      indice: "Nombre",
    },
    {
      encabezado: "RFC",
      indice: "RFC",
    },
    {
      encabezado: "Email",
      indice: "eMail1",
    },
    {
      encabezado: "Total a Pagar",
      indice: "VentaTotal",
    },
  ];

  const body = document.getElementById("resumenCompra");
  body.innerHTML = '';
  let html = "";

  encabezados.forEach((e) => {
    html = ` 
    <tr>
      <td>${e.encabezado}</td>
      <td align="center" width="50%">
        <b> ${data[e.indice]} </b>
      </td>
    </tr>`;


    body.innerHTML += html;
  });

  //console.log(Object.values(data).length);
}

/**
 * Regresa el contenido de una busqueda de informacion
 *
 * @deprecated en su lugar usar IngresaVenta()
 * @param {string} folio id de la compra
 * @returns {object}
 */
function getCompra(folio) {
  let data = [];

  $.ajax({
    type: "GET",
    dataType: "json",
    async: false,
    url: `${urlcompra}${folio}`,
    success: (resp) => {
      data = resp;
    },
    error: (e) => {
      console.log(`Se ha producido un error: `);
      console.log(e.responseText);
    },
  });

  return data.resumen;
}

/**
 * Muestra la pasarela en el DOM
 */
function getPasarela() {
  let pasarela = document.getElementById("pasarela");
  pasarela.removeAttribute("hidden");
}

function ingresaVenta() {
  Swal.fire({
    title: "Ingresa el ID de la compra",
    input: "text",
    showCancelButton: false,
    confirmButtonText: "Validar Pedido",
    showLoaderOnConfirm: true,
    preConfirm: (idVenta) => {
      //    imprimeResumenCompra();
      return fetch(`${urlcompra}${idVenta}`)
        .then((response) => {
          if (!response.ok) {
            btnValida.setAttribute('hidden')
            throw new Error(response.mensaje);
          }
          return response.json();
        })
        .catch((error) => {
          console.log(error);
          Swal.showValidationMessage(`Request failed: ${error}`);
        });
    },
    allowOutsideClick: false// () => !Swal.isLoading(),
  }).then((result) => {
    if (result.value.error) {
      Swal.fire({
        confirmButtonText: "reintentar",
        html: `
              <div class="swal2-validation-message" 
                  id="swal2-validation-message" style="display: flex;">
                      Error en la solicitud: ${result.value.mensaje}
                  </div>`,
      }).then(() => {
        ingresaVenta();
      });
    } else {
      folio = result.value.resumen.movid;
      imprimeResumenCompra(result.value.resumen);
    }
  });
}

/**
 * Muestra modal cargando
 */
function cargandoModal() {
  let timerInterval;
  Swal.fire({
    title: "Cargando Información",
    html: "Por favor Espere",
    timer: 1000,
    timerProgressBar: true,
    didOpen: () => {
      Swal.showLoading();
    },
    willClose: () => {
      clearInterval(timerInterval);
    },
  }).then(() => { });
}

/////// MASCARAS DE ENTRADA PARA PASARELA

const carNumber = document.getElementById("cardNumber");
const month = document.getElementById("month");
const year = document.getElementById("year");
const ccv = document.getElementById("ccv");

const maskCardNumber = IMask(carNumber, {
  mask: "0000000000000000",
});
const maskMonth = IMask(month, {
  mask: "{0}0",
});
const maskYear = IMask(year, {
  mask: "{0}0",
});
const maskCvv = IMask(ccv, {
  mask: "000",
});
