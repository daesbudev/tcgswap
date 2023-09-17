//#region TODOS LOS ARTICULOS DISPONIBLES DE UN USUARIO
// datos del user
let opciones = {
  id_user: $("#id_usu_carta").data("id_usu_carta"),
};

mostrarCartasDisp(opciones);
// llamada del controlador a traves de ajax
function mostrarCartasDisp(opciones) {
  $.post(
    base_url + "Coleccion_c/listarCartaColecciones",
    opciones,
    function (datos) {
      generarTablaCartas(JSON.parse(datos));
    }
  );
}
// con el JSON recibido construyo la tabla que contendra los resultados o el mensaje advirtiendo que aún no hay articulos disp de ese usuario
function generarTablaCartas(coleccion) {
  let cadena = "";
  // validador de cantidad de resultados
  if (coleccion.length == 0) {
    cadena = `<p class="text-center fs-3 fw-bold">Lo sentimos, ningún resultado coincide con tu búsqueda.</p>`;
  } else {
    cadena = `<table class="table table-bordered table-striped table-warning">
    <thead class="table bg-light">
        <th scope="col">Nombre</th>
        <th scope="col">Información</th>
        <th scope="col">Cantidad</th></thead>
    <tbody>`;
    // construye cada una de las filas de la tabla con los datos de la carta
    for (carta of coleccion) {
      cadena += `<tr class="align-middle">
        <td><a href="${base_url}Cartas_c/datosCarta/${
        carta.nombre_carta
      }" class="text-primary fs-7 fw-bold text-decoration-none">${carta.nombre_carta.replaceAll(
        "-",
        " "
      )}</a></td>
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
      // ¿La carta es del usuario logeado? Boton de borrado para gestionar tu coleccion
      if (coleccion[0].nombre_usu == $("#id_user").data("username"))
        cadena += `<!-- <span><button class="btn btn-sm btn-success m-1 agregarStock"><i class="bi bi-plus"></i></button>-->
        <button data-id_entrada="${carta.id_entrada}" class="btn btn-sm btn-danger m-1 eliminarStock"><i class="bi bi-dash"></i></button></span>
        </td>
        </tr>`;
      else if ($("#id_user").data("username"))
        cadena += `<div class="id_usu" data-id_usu="${carta.id_usu}" data-id_carta="${carta.id_carta}" data-estado="${carta.estado}" data-idioma="${carta.idioma}"><button class="btn btn-sm btn-info m-1 agregarCarrito"><i class="bi bi-cart-plus"></i></button></div></td></tr>`;
      // ¿Hay un usuario logeado?
      else
        cadena += `<span data-bs-toggle="tooltip" data-bs-placement="left" title="Para poder añadir cartas al carrito debes iniciar sesión"><button class="btn btn-sm btn-info m-1 agregarCarrito disabled"><i class="bi bi-cart-plus"></i></button></span></td></tr>`;
    }
    cadena += `</tbody></table>`;
  }
  $("#tabla_coleccion").html(cadena);
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
        filtrarColeccion();
      }
    );
  });
  // Boton Borrar Carta
$(".eliminarStock").on("click", function (evento) {
  let id_entrada = $(this).data("id_entrada");
  Swal.fire({
    title: "¿Seguro?",
    text: "La carta será borrada de tu colección.",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Hacer la llamada ajax
      $.post(base_url + "Coleccion_c/borrarCarta", { id_entrada: id_entrada }, function (dev) {
        // Refrescar carrito
        location.reload();
      });
    }
  });
});
}
// realizar el filtrado de cartas segun los parametros introducidos
$("#filtrar_result").on("click", function (evento) {
  evento.preventDefault();
  filtrarColeccion();
});
// reseteo de parametros del formulario de busqueda
$("#btnReset").on("click", function (evento) {
  $("#filt_nombre").val("");
  $("#filt_estado").val("vacio");
  $("#filt_idioma").val("vacio");
  $("#filtrar_result").trigger("click");
});
// llamada a la busqueda de cartas con los parametros de busqueda introducidos
function filtrarColeccion() {
  opciones = {
    id_user: $("#id_usu_carta").data("id_usu_carta"),
    nombre: $("#filt_nombre").val(),
    estado: $("#filt_estado").val(),
    idioma: $("#filt_idioma").val(),
  };
  mostrarCartasDisp(opciones);
}
