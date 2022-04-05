const baseUrl = window.location.origin;
const urlcompra = `${baseUrl}/pagos/pasarela/getCompra?folio=001`;
const body = document.getElementById("resumenCompra");

const url = "https://randomuser.me/api/?results=10";

(() => {
  imprimeResumenCompra();
})();

function imprimeResumenCompra() {
  const data = getCompra();




  console.log(Object.values(data).length);
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
