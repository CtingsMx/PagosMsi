const baseUrl = window.location.origin;
const params = new Proxy(new URLSearchParams(window.location.search), {
  get: (searchParams, prop) => searchParams.get(prop),
});
const urlcompra = `${baseUrl}/pagos/pasarela/getCompra?folio=${params.folio}`;
const body = document.getElementById("resumenCompra");

(() => {
  imprimeResumenCompra();
})();

function imprimeResumenCompra() {
  let html = "";
  const data = getCompra();
  const encabezados = [
    {
      encabezado: "# Pedido",
      indice: "ID",
    },
    {
      encabezado: "Sucursal",
      indice: "Sucursal",
    },
    {
      encabezado: "Cliente",
      indice: "Cliente",
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

  encabezados.forEach((e, idx) => {
    console.log(e);

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
 * Genera un elemento Http en el DOM
 * @param {*} element Elemento a Generar
 * @returns httpElemento
 */
function createNode(element) {
  return document.createElement(element);
}

/**
 * Ingresa dentro de un elemento, otro dentro del arbol del Dom
 * @param {*} parent Elemento donde se añadira el hijo
 * @param {*} el Elemento a ingresar
 * @returns
 */
function append(parent, el) {
  return parent.appendChild(el);
}

function getCompra() {
  let data = [];
  $.ajax({
    type: "GET",
    dataType: "json",
    async: false,
    url: urlcompra,
    beforeSend: () => {
      console.log("cargando");
    },
    success: (resp) => {
      data = resp;
    },
  });

  return data.resumen;
}

function getPasarela()
{
  let pasarela = document.getElementById('pasarela');

  pasarela.removeAttribute('hidden');
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
