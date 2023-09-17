//#region FUNCIONES DEL ENVIO DE MENSAJES
$(document).ready(function () {
  //boton de enviar desactivado si el textarea se encuentra vacio
  var textarea = $("#contenidoMsg");
  var button = $("#enviarMsg");
  textarea.keyup(function () {
    if (textarea.val() === "") {
      button.prop("disabled", true);
    } else {
      button.prop("disabled", false);
    }
  });
  //Boton de enviar mensaje asociado a la tecla Intro
  textarea.keydown(function (evento) {
    if (evento.keyCode === 13) {
      evento.preventDefault();
      if (!button.prop("disabled")) button.click();
    }
  });
});
//#endregion
//#region CARGA DE LOS MENSAJES
let opciones = {
  id_user: $("#id_user").data("id_user"),
  id_dest: $("#id_dest").data("id_dest"),
};
verMensajes(opciones);
function verMensajes(opciones) {
  $.post(base_url + "Mensajes_c/verMensajes", opciones, function (datos) {
    generarMensajes(JSON.parse(datos));
  });
}
function generarMensajes(mensajes) {
  let cadena = "";
  // ¿Hay mensajes anteriores?
  if (mensajes.length == 0) {
    cadena = `<p class="text-center fs-3 fw-bold">No hay mensajes.</p>`;
  } else {
    for (mensaje of mensajes) {
      // ¿El mensaje es del usuario logeado?
      if (mensaje.id_remi == $("#id_user").data("id_user")) {
        cadena += `<div class="mensaje m-2 d-flex w-100 justify-content-end">`;
        cadena += `<div class="bg-info-subtle p-3 w-75 rounded border border-info ">
                        <div class="">${mensaje.mensaje}</div>
                        <div class="mt-2 d-flex justify-content-between">
          <span class="fw-bold">Tú</span> <small>${mensaje.fecha} ${mensaje.hora}:`;
        mensaje.minutos < 10
          ? (cadena += `0${mensaje.minutos}`)
          : (cadena += `${mensaje.minutos}`);
        cadena += `</small></div></div>`;
        // ¿No lo es?
      } else {
        cadena += `<div class="mensaje m-2 d-flex w-100">`;
        cadena +=
          `<div class="bg-warning-subtle p-3 w-75 rounded border border-warning">
                        <div class="">${mensaje.mensaje}</div>
                        <div class="mt-2 d-flex justify-content-between">` +
          `<a href="${base_url}Usuarios_c/perfil_publico/` +
          $("#id_dest").data("username_dest") +
          `" class="fw-bold text-decoration-none">` +
          $("#id_dest").data("username_dest") +
          `</a> <small class="">${mensaje.fecha} ${mensaje.hora}:`;
        mensaje.minutos < 10
          ? (cadena += `0${mensaje.minutos}`)
          : (cadena += `${mensaje.minutos}`);
        cadena += `</small></div></div>`;
      }
      cadena += `</div>`;
    }
  }
  $("#conversacion").html(cadena);
  $("#ventana-chat").scrollTop($("#ventana-chat")[0].scrollHeight);
}
// Enviar mensaje
$("#enviarMsg").on("click", function (evento) {
  console.log($("#contenidoMsg").val());
  $.post(
    base_url + "Mensajes_c/crearMensaje",
    {
      id_remi: $("#id_user").data("id_user"),
      id_dest: $("#id_dest").data("id_dest"),
      mensaje: $("#contenidoMsg").val(),
    },
    function () {
      $("#contenidoMsg").val("");
      opciones = {
        id_user: $("#id_user").data("id_user"),
        id_dest: $("#id_dest").data("id_dest"),
      };
      verMensajes(opciones);
    }
  );
});
//#endregion
