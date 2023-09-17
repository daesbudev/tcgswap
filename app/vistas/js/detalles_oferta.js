//#region CARGA DE CARTAS DE LA OFERTA
// cartas user logeado
let datos_user1 = {
  id_usu: $("#id_user").data("id_user"),
  id_oferta: $("#id_oferta").data("id_oferta"),
};
mostrarCartasUser1(datos_user1);
function mostrarCartasUser1(datos_user) {
  $.post(base_url + "Ofertas_c/leerCartasOferta", datos_user, function (datos) {
    generarTablaUser1(JSON.parse(datos));
  });
}
// cartas otro user
let datos_user2 = {
  id_usu: $("#id_user2").data("id_user2"),
  id_oferta: $("#id_oferta").data("id_oferta"),
};
mostrarCartasUser2(datos_user2);
function mostrarCartasUser2(datos_user) {
  $.post(base_url + "Ofertas_c/leerCartasOferta", datos_user, function (datos) {
    generarTablaUser2(JSON.parse(datos));
  });
}
// tablas con las cartas de ambos users
function generarTablaUser1(cartas_user1) {
  let cadena = "";
  for (carta of cartas_user1) {
    cadena += `<tr class="align-middle">
      <td>${carta.nombre_carta.replaceAll("-", " ")}</td>
      <td>${carta.estado}, ${carta.idioma}</td>
      <td>${carta.cantidad}</td></tr>`;
  }
  $("#cartas_oferta_user1").html(cadena);
}

function generarTablaUser2(cartas_user2) {
  let cadena = "";
  for (carta of cartas_user2) {
    cadena += `<tr class="align-middle">
      <td>${carta.nombre_carta.replaceAll("-", " ")}</td>
      <td>${carta.estado}, ${carta.idioma}</td>
      <td>${carta.cantidad}</td></tr>`;
  }
  $("#cartas_oferta_user2").html(cadena);
}
//#endregion
//#region SWEET ALERTS ASOCIADOS A LOS INTERCAMBIOS
$("#aceptarOferta").on("click", function (evento) {
  let id_oferta= $(this).data("id_oferta");
  Swal.fire({
    title: "¿Aceptas la oferta?",
    text: "Si aceptas dará comienzo el proceso de intercambio.",
    icon: "success",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Hacer la llamada ajax
      $.post(
        base_url + "Ofertas_c/actualizarOferta",
        { id_oferta: id_oferta, status: "OK" },
        function (dev) {
          location.reload();
        }
      );
    }
  });
});
$("#rechazarOferta").on("click", function (evento) {
  let id_oferta= $(this).data("id_oferta");
  Swal.fire({
    title: "¿Rechazas la oferta?",
    text: "Todas las cartas de esta oferta volverán a sus respectivas colecciones.",
    icon: "error",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      // Hacer la llamada ajax
      $.post(
        base_url + "Ofertas_c/actualizarOferta",
        { id_oferta: id_oferta, status: "NO" },
        function (dev) {
          location.reload();
        }
      );
    }
  });
});
//#endregion