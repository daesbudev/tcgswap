// Pero... y si no tengo cartas para realizar intercambios?
$(document).ready(function (evento) {
  $.post(
    base_url + "Coleccion_c/listarCartaColecciones",
    {
      id_user: $("#id_user").data("id_user"),
    },
    function (datos) {
      if (jQuery.isEmptyObject(JSON.parse(datos))) {
        $(".hacerOferta").addClass("disabled");
        $(".hacerOferta").wrap(
          '<span data-bs-toggle="tooltip" data-bs-placement="top" title="Para poder enviar una oferta debes tener cartas en tu colección."> </span>'
        );
      }
    }
  );
});
// Vaciar Carrito
// Llamar al metodo eliminarUsuCarrito
$(".borrarUsuCarrito").on("click", function (evento) {
  let id_usu = $(this).data("id_usu");
  Swal.fire({
    title: "¿Seguro?",
    text: "Todas las cartas de este usuario se borrarán del carrito.",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Hacer la llamada ajax
      $.post(
        base_url + "Carrito_c/eliminarUsuCarrito",
        { id_usu_carta: id_usu },
        function (dev) {
          location.reload();
        }
      );
    }
  });
});
// Boton Borrar Linea
$(".borrarFilaCarrito").on("click", function (evento) {
  let id = $(this).parents("tr").data("id");
  Swal.fire({
    title: "¿Seguro?",
    text: "La carta será borrada del carrito.",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Hacer la llamada ajax
      $.post(base_url + "Carrito_c/borrarLinea", { id: id }, function (dev) {
        // Refrescar carrito
        location.reload();
      });
    }
  });
});

