//#region CARGA ZONA DE ULTIMAS ADICIONES
cargarUltimasCartas();
function cargarUltimasCartas() {
  $.post(base_url + "Portal_c/ultimasCartas", "", function (datos) {
    generarTablaUltimas(JSON.parse(datos));
  });
}
function generarTablaUltimas(colecciones) {
  let cadena = "";
  let count = 1;
  if (colecciones.length == 0) {
    cadena = `<p class="text-center fs-3 fw-bold">No hay cartas actualmente. ¡Disculpad!</p>`;
  } else {
    cadena = `<table class="table table-striped table-warning">
      <thead class="table">
        <th scope="col"></th>
        <th scope="col">Nombre</th>
        <th scope="col">Info</th>
        <th scope="col">Subida por</th>
      </thead>
      <tbody>
    `;
    for (carta of colecciones) {
      cadena += `<tr class="align-middle">
        <td scope="row" class="w-auto fs-6">${count}</td>
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
      if (carta.nombre_usu == $("#id_user").data("username")) {
        cadena += `</td>
        <td>Tú</td>
        </tr>`;
      } else {
        cadena += `</td>
        <td><a href="${base_url}Usuarios_c/perfil_publico/${carta.nombre_usu}" class="text-primary fs-7 fw-bold text-decoration-none">${carta.nombre_usu}</a></td>
        </tr>`;
      }

      count++;
    }
    cadena += `</tbody></table>`;
  }
  $("#tabla_novedades").html(cadena);
}
//#endregion