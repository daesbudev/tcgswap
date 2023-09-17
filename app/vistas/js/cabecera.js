//#region BOTON DE CIERRE DE SESION
// Si el usuario intenta cerrar sesion, vamos a avisarle de que el carrito va a ser eliminado.
$("#cerrarSesion").on("click", function (evento) {
  Swal.fire({
    title: "¿Vas a cerrar sesión?",
    text: "Si cierras sesión tu carrito se perderá.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Hacer la llamada ajax
      $.post(base_url + "Usuarios_c/logout", "", function (dev) {
        location.href=base_url+"Portal_c";
      });
    }
  });
});
//#endregion

//#region BARRA DE BUSQUEDA DE CARTAS
// variable con los parametros del buscador
let opcion = { buscar: "" };

// metodo que a traves de ajax llama al controlador
function buscarCartas(opcion) {
  $.post(base_url + "Cartas_c/buscarCartas", opcion, function (datos) {
    mostrarResultados(JSON.parse(datos));
  });
}
// metodo que muestra las cartas que resulten de la busqueda
function mostrarResultados(cartas) {
  let lista = document.createElement("DIV");
  lista.setAttribute("id", "lista-autocompletar");
  lista.setAttribute("class", "items-autocompletar");
  $("#resultados").html(lista);
  let item;
  if (cartas.length == 0) {
    item = document.createElement("DIV");
    item.setAttribute(
      "class",
      "resultados fw-bold rounded-1 text-warning d-flex d-md-flex"
    );
    item.innerHTML = "Lo sentimos, no existe la carta introducida.";
    lista.appendChild(item);
  } else {
    for (carta of cartas) {
      item = document.createElement("A");
      item.setAttribute(
        "class",
        "resultados fw-bold rounded-1 text-decoration-none d-flex d-md-flex"
      );
      item.setAttribute(
        "href",
        `${base_url}Cartas_c/datosCarta/${carta.nombre}`
      );
      item.innerHTML = `${carta.nombre.replaceAll("-", " ")}`;
      lista.appendChild(item);
    }
  }
}

function cerrarListas(elemento) {
  // cierra todas las listas que existan menos la introducida en el argumento
  // de momento no esta implementado
  var x = document.getElementsByClassName("items-autocompletar");
  for (var i = 0; i < x.length; i++) {
    if (elemento != x[i]) x[i].parentNode.removeChild(x[i]);
  }
}
$("#buscador").on("submit", function (evento) {
  evento.preventDefault();
});
$("#buscar").on("keyup", function (evento) {
  if ($("#buscar").val().length > 2) autocompletar();
  else cerrarListas(evento);
});
function autocompletar() {
  opcion = {
    buscar: $("#buscar").val().replaceAll(" ", "-"),
  };
  buscarCartas(opcion);
}
//cerrar las listas si se clica fuera
document.addEventListener("click", function (evento) {
  cerrarListas(evento.target);
});
//#endregion