//#region TODOS LOS ARTICULOS DISPONIBLES DE UNA CARTA
// datos de la carta
let opciones = {
  id_carta: $("#id_carta").data("id_carta"),
};

mostrarCartasColeccion(opciones);
// llamada del controlador a traves de ajax
function mostrarCartasColeccion(opciones) {
  $.post(
    base_url + "Coleccion_c/listarCartaColecciones",
    opciones,
    function (datos) {
      generarTablaColeccion(JSON.parse(datos));
    }
  );
}
// con el JSON recibido construyo la tabla que contendra los resultados o el mensaje advirtiendo que aún no hay articulos disp para esa carta
function generarTablaColeccion(colecciones) {
  let cadena = "";
  let sumCart = 0;
  // validador de cantidad de resultados
  if (colecciones.length == 0) {
    cadena = `<p class="text-center fs-3 fw-bold">Lo sentimos, este carta no tiene ofertas. ¡Sé el primero en añadirla!</p>`;
  } else {
    cadena = `<table class="table table-bordered table-striped table-warning">
  <thead class="table bg-light">
      <th scope="col">Nombre</th>
      <th scope="col">Información</th>
      <th scope="col">Cantidad</th>
  </thead>
  <tbody>
  `;
    // construye cada una de las filas de la tabla con los datos de la carta
    for (carta of colecciones) {
      cadena += `<tr class="align-middle">
      <td><a href="${base_url}Usuarios_c/perfil_publico/${carta.nombre_usu}" class="text-primary fs-7 fw-bold text-decoration-none">${carta.nombre_usu}</a></td>
      <td>`;
      switch (carta.estado) {
        case "CN":
          cadena += `Casi nueva, `;
          break;
        case "EX":
          cadena += `Excelente, `;
          break;
        case "BI":
          cadena += `Bien, `;
          break;
        case "US":
          cadena += `Usada, `;
          break;
        case "MA":
          cadena += `Mal, `;
          break;
      }
      switch (carta.idioma) {
        case "ES":
          cadena += ` español`;
          break;
        case "IN":
          cadena += ` inglés`;
          break;
        case "FR":
          cadena += ` francés`;
          break;
        case "AL":
          cadena += ` alemán`;
          break;
        case "IT":
          cadena += ` italiano`;
          break;
        case "RU":
          cadena += ` ruso`;
          break;
      }
      cadena += `</td>
        <td class="d-flex justify-content-between align-items-center"><span>${carta.cantidad}</span>`;
      // ¿La carta es del usuario logeado?
      if (carta.nombre_usu == $("#id_user").data("username"))
        cadena += `<!-- <span><button class="btn btn-sm btn-success m-1 agregarStock"><i class="bi bi-plus"></i></button>
        <button class="btn btn-sm btn-danger m-1 eliminarStock"><i class="bi bi-dash"></i></button></span> -->
        <span data-bs-toggle="tooltip" data-bs-placement="left" title="Esta carta es tuya, no puedes añadirla al carrito."><button class="btn btn-sm btn-danger m-1 agregarCarrito disabled"><i class="bi bi-exclamation-lg"></i></button></span></td></tr>
        </td>
        </tr>`;
      else if ($("#id_user").data("username"))
        cadena += `<div class="id_usu" data-id_usu="${carta.id_usu}" data-id_carta="${carta.id_carta}" data-estado="${carta.estado}" data-idioma="${carta.idioma}"><button class="btn btn-sm btn-info m-1 agregarCarrito"><i class="bi bi-cart-plus"></i></button></div></td></tr>`;
      // ¿Hay un usuario logeado?
      else
        cadena += `<span data-bs-toggle="tooltip" data-bs-placement="left" title="Para poder añadir cartas al carrito debes iniciar sesión."><button class="btn btn-sm btn-info m-1 agregarCarrito disabled"><i class="bi bi-cart-plus"></i></button></span></td></tr>`;
      sumCart += carta.cantidad;
    }
    cadena += `</tbody></table>`;
  }
  $("#ud_disp").html(sumCart);
  // insercion de la cadena en el div correspondiente
  $("#tabla_cartas").html(cadena);

  // añadir al carrito
  $(".agregarCarrito").on("click", function (evento) {
    // Introducirá el producto en el carrito
    // Hacer llamada AJAX al metodo
    $.post(
      base_url + "Carrito_c/insertarCarta_ajax",
      {
        id_usuario: $("#id_user").data("id_user"),
        id_usu_carta: $(this).parent().data("id_usu"),
        id_carta: $(this).parent().data("id_carta"),
        estado: $(this).parent().data("estado"),
        idioma: $(this).parent().data("idioma"),
      },
      function () {
        filtrarCartas();
      }
    );
  });
}
// realizar el filtrado de cartas segun los parametros introducidos
$("#filtrar_result").on("click", function (evento) {
  evento.preventDefault();
  filtrarCartas();
});
// reseteo de parametros del formulario de busqueda
$("#btnReset").on("click", function (evento) {
  $("#filt_estado").val("vacio");
  $("#filt_idioma").val("vacio");
  $("#filtrar_result").trigger("click");
});
// llamada a la busqueda de cartas con los parametros de busqueda introducidos
function filtrarCartas() {
  opciones = {
    id_carta: $("#id_carta").data("id_carta"),
    estado: $("#filt_estado").val(),
    idioma: $("#filt_idioma").val(),
  };
  mostrarCartasColeccion(opciones);
}
//#endregion
