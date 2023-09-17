//#region CARGA DE TODAS LAS OFERTAS
let opciones = {
  id_user_oferta: $("#id_user").data("id_user"),
  id_user_recibe: $("#id_user").data("id_user"),
};
mostrarOfertas(opciones);
function mostrarOfertas(opciones) {
  $.post(base_url + "Ofertas_c/cargarOfertas", opciones, function (datos) {
    generarTablaEnvios(JSON.parse(datos));
  });
}
function generarTablaEnvios(ofertas) {
  let cadena = "";
  // ¿Hay ofertas?
  if (ofertas.length == 0) {
    cadena = `<p class="text-center fs-3 fw-bold">No hay ofertas disponibles para mostrar.</p>`;
  }
  // Si hay ofertas
  else {
    cadena = `<table class="table table-bordered table-striped table-warning">
      <thead class="table bg-light">
          <th scope="col" style="width: 25%;">Ofertador</th>
          <th scope="col" style="width: 25%;">Ofertado</th>
          <th scope="col" style="width: 25%;">Fecha</th>
          <th scope="col" style="width: 25%;">Estado</th></thead>
      <tbody>`;
    for (oferta of ofertas) {
      if (oferta.usu_envia == $("#id_user").data("username")) {
        cadena += `<tr class="align-middle">
          <td>Tú</td>`;
      } else {
        cadena += `<tr class="align-middle">
          <td><a href="${base_url}Usuarios_c/perfil_publico/${oferta.usu_envia}" class="text-primary fs-7 fw-bold text-decoration-none">${oferta.usu_envia}</a></td>`;
      }
      if (oferta.usu_recibe == $("#id_user").data("username")) {
        cadena += `
          <td>Tú</td>`;
      } else {
        cadena += `<td><a href="${base_url}Usuarios_c/perfil_publico/${oferta.usu_recibe}" class="text-primary fs-7 fw-bold text-decoration-none">${oferta.usu_recibe}</a></td>`;
      }
      cadena += `<td>${oferta.fecha_oferta}</td><td class="d-flex justify-content-between align-items-center">`;
      switch (oferta.status) {
        case "EN":
          cadena += `<span class="d-none d-md-inline">Enviado</span><span class="d-md-none d-inline">EN</span> <a href="${base_url}Ofertas_c/detallesOferta/${oferta.id_oferta}"><button class="btn btn-sm btn-info"><i class="bi bi-search"></i></button></a>`;
          break;
        case "OK":
          cadena += `<span class="d-none d-md-inline">Aceptado</span><span class="d-md-none d-inline">OK</span> <a href="${base_url}Ofertas_c/detallesOferta/${oferta.id_oferta}"><button class="btn btn-sm btn-info"><i class="bi bi-search"></i></button></a>`;
          break;
        case "NO":
          cadena += `<span class="d-none d-md-inline">Rechazado</span><span class="d-md-none d-inline">NO</span> <a href="${base_url}Ofertas_c/detallesOferta/${oferta.id_oferta}"><button class="btn btn-sm btn-info"><i class="bi bi-search"></i></button></a>`;
          break;
      }
      cadena += `</td>`;
    }
  }
  cadena += `</tbody></table>`;
  $("#tabla_intercambios").html(cadena);
}
// Filtro segun el que envia la oferta
$("#select_envios").on("change", function (evento) {
  filtrarEnvios();
});
function filtrarEnvios() {
  if ($("#select_envios").val() == "todos") {
    opciones = {
      id_user_oferta: $("#id_user").data("id_user"),
      id_user_recibe: $("#id_user").data("id_user"),
    };
  } else if ($("#select_envios").val() == "enviados") {
    opciones = {
      id_user_oferta: $("#id_user").data("id_user"),
    };
  } else {
    opciones = {
      id_user_recibe: $("#id_user").data("id_user"),
    };
  }
  mostrarOfertas(opciones);
}
//#endregion
