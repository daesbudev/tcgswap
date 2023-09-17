//#region CARGA DE LAS CONVERSACIONES
let opciones = {
  id_user: $("#id_user").data("id_user"),
};
mostrarConver(opciones);
function mostrarConver(opciones) {
  $.post(base_url + "Mensajes_c/verConver", opciones, function (datos) {
    generarListaConver(JSON.parse(datos));
  });
}
function generarListaConver(convers) {
  let cadena = "";
  // ¿Hay conversaciones disponibles?
  if (convers.length == 0) {
    cadena = `<p class="text-center fs-3 fw-bold">No hay conversaciones disponibles.</p>`;
  } else {
    cadena = `<div class="list-group">`;
    for (conver of convers) {
      if (conver.user1 != $("#id_user").data("username"))
        cadena += `<a href="${base_url}Mensajes_c/enviarMensaje/${conver.user1}" class="list-group-item">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">${conver.user1}</h5>
        <small>Último mensaje: ${conver.fecha} ${conver.hora}:${conver.minutos}</small>
      </div>
      <p class="mb-1">${conver.ultmsg}</p>
    </a>`;
      else
        cadena += `<a href="${base_url}Mensajes_c/enviarMensaje/${conver.user2}" class="list-group-item">
      <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">${conver.user2}</h5>
        <small>Último mensaje: ${conver.fecha} ${conver.hora}:${conver.minutos}</small>
      </div>
      <p class="mb-1">${conver.ultmsg}</p>
    </a>`;
    }
    cadena += `</div>`;
  }
  $("#lista-convers").html(cadena);
}
//#endregion