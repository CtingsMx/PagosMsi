
let btnValida = document.getElementById('btn-validar-pago');
//const urlcompra =  window.location.origin+'/pagos/revisaId?folio=';
const urlcompra = `https://msi.kober.com.mx/revisaId?folio=`;

const params = new Proxy(new URLSearchParams(window.location.search), {
  get: (searchParams, prop) => searchParams.get(prop),
});

//variables de error

const error_codes = {
  1001: 'Por Favor, ingrese el número de tarjeta, mes y fecha de expiración validos. ',
  1012: 'El monto transacción esta fuera de los limites permitidos.',
  2005: 'La fecha de expiración de la tarjeta es anterior a la fecha actual.',
  2006: 'El código de seguridad de la tarjeta (CVV2) no fue proporcionado.',
  2010: 'Autenticación 3D Secure fallida',
  3001: 'La tarjeta fue declinada por el banco.',
  3002: 'La tarjeta ha expirado.',
  3003: 'La tarjeta no tiene fondos suficientes.',
  3004: 'La tarjeta ha sido identificada como una tarjeta robada.',
  3005: 'La tarjeta ha sido rechazada por el sistema antifraudes.'
};


let folio = params.folio;
let error_code = params.code;

(() => {

  validaErrores();
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
 * Muestra la pasarela en el DOM
 */
function getPasarela() {
  let pasarela = document.getElementById("pasarela");
  let footer = document.getElementById("footer");
  pasarela.removeAttribute("hidden");
  footer.removeAttribute("hidden");
}

function ingresaVenta() {
  Swal.fire({
    title: "Ingresa el ID de la compra",
    input: "text",
    showCancelButton: false,
    confirmButtonText: "Validar Pedido",
    showLoaderOnConfirm: true,
    preConfirm: (idVenta) => {
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
      document.getElementById('pk').value = result.value.public_key;
      document.getElementById('opMerchant').value = result.value.merchant;

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

//FUNCIONES PARA ERRORES




function validaErrores() {

  console.log(error_code);


  if (error_code){
    Swal.fire({
      icon: 'error',
      title:  error_codes[error_code],
      text: 'Por favor, vuelve a validar tu compra e ingresa una tarjeta de crédito valida',
    })
  }
}

