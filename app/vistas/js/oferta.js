//#region CREACION DE LA OFERTA
let datos_oferta = {
  id_user: $("#id_user").data("id_user"),
  id_usu_carta: $("#id_user_ofertado").data("id_user_ofertado"),
};
$("#confirmarCambio").on("click", function (params) {
  $.post(base_url + "Ofertas_c/crearOferta", datos_oferta, function () {
    location.href = base_url + "Carrito_c";
  });
});
//#endregion
//#region GENERACION TABLAS CON LAS CARTAS DE AMBAS PARTES 
// CARTAS DEL OFERTADO
let datos_ofertado = {
  id_usu: $("#id_user_ofertado").data("id_user_ofertado"),
};
mostrarCartasOfertado(datos_ofertado);
function mostrarCartasOfertado(datos_ofertado) {
  $.post(base_url + "Carrito_c/leerUsuAjax", datos_ofertado, function (datos) {
    generarTablaOfertado(JSON.parse(datos));
  });
}
function generarTablaOfertado(datos_ofertado) {
  let cadena = "";
  for (carta of datos_ofertado) {
    cadena += `<tr class="align-middle">
    <td>${carta.nombre_carta.replaceAll("-", " ")}</td>
    <td>${carta.estado}, ${carta.idioma}</td>
    <td>${carta.cantidad}</td></tr>`;
  }
  $("#contenido_ofertado").html(cadena);
}
// CARTAS DEL OFERTADOR
let datos_ofertador = {
  id_usu: $("#id_user").data("id_user"),
};
mostrarCartasOfertador(datos_ofertador);
function mostrarCartasOfertador(datos_ofertador) {
  $.post(base_url + "Carrito_c/leerUsuAjax", datos_ofertador, function (datos) {
    generarTablaOfertador(JSON.parse(datos));
  });
}
function generarTablaOfertador(datos_ofertador) {
  let cadena = "";
  if (datos_ofertador.length == 0) {
    cadena = `<p class="text-center fs-5 fw-bold">Añade cartas para continuar.</p>`;
    $("#confirmarCambio").addClass("disabled");
  } else {
    cadena += `<table class="table table-sm table-bordered table-striped table-warning">
    <thead class="table bg-light">
        <th scope="col" style="width: 46%;">Nombre</th>
        <th scope="col" style="width: 27%;">Información</th>
        <th scope="col" style="width: 27%;">Cantidad</th>
    </thead>
    <tbody>`;
    for (carta of datos_ofertador) {
      cadena += `<tr class="align-middle" data-id="${carta.id}">
    <td>${carta.nombre_carta.replaceAll("-", " ")}</td>
    <td>${carta.estado}, ${carta.idioma}</td>
    <td class="d-flex justify-content-between align-items-center">${
      carta.cantidad
    } <div class="id_usu" data-id_usu="${carta.id_usu}" data-id_carta="${
        carta.id_carta
      }" data-estado="${carta.estado}" data-idioma="${
        carta.idioma
      }"><button class="btn btn-sm btn-danger quitarOferta"><i class="bi bi-dash"></i></button></div></td></tr>`;
    }
    cadena += `</tbody></table>`;
    $("#confirmarCambio").removeClass("disabled");
  }
  $("#contenido_ofertador").html(cadena);
  $(".quitarOferta").on("click", function (evento) {
    // Hacer llamada AJAX al metodo
    $.post(
      base_url + "Carrito_c/borrarLinea",
      {
        id: $(this).parents("tr").data("id"),
      },
      function () {
        filtrarColeccion();
        datos_ofertador = {
          id_usu: $("#id_user").data("id_user"),
        };
        mostrarCartasOfertador(datos_ofertador);
      }
    );
  });
}
//#endregion
//#region CARTAS QUE PUEDE OFRECER EL USER
// CARTAS COLECCION OFERTADOR
let opciones = {
  id_user: $("#id_user").data("id_user"),
};

mostrarCartasDisp(opciones);

function mostrarCartasDisp(opciones) {
  $.post(
    base_url + "Coleccion_c/listarCartaColecciones",
    opciones,
    function (datos) {
      generarTablaCartas(JSON.parse(datos));
    }
  );
}

function generarTablaCartas(coleccion) {
  let cadena = "";
  if (coleccion.length == 0) {
    cadena = `<p class="text-center fs-3 fw-bold">Ningún filtro coincide con la búsqueda o no quedan cartas.</p>`;
  } else {
    cadena = `<table class="table table-bordered table-striped table-warning">
      <thead class="table bg-light">
          <th scope="col">Nombre</th>
          <th scope="col">Información</th>
          <th scope="col">Cantidad</th></thead>
      <tbody>`;
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
          <td class="d-flex justify-content-between align-items-center">
            <span>${carta.cantidad}</span>
            <div class="id_usu" data-id_usu="${carta.id_usu}" data-id_carta="${carta.id_carta}" data-estado="${carta.estado}" data-idioma="${carta.idioma}"><button class="btn btn-sm btn-success m-1 agregarOferta"><i class="bi bi-plus"></i></button></div>
          </td>
          </tr>`;
	
    }
	cadena += `</tbody></table>`;
  }
    $("#tabla_coleccion").html(cadena);
    // evento para añadir eventualmente al carrito las cartas que ofrece el user
    $(".agregarOferta").on("click", function (evento) {
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
          datos_ofertador = {
            id_usu: $("#id_user").data("id_user"),
          };
          mostrarCartasOfertador(datos_ofertador);
        }
      );
    });
}
// filtro de busqueda cartas del user
$("#filtrar_result").on("click", function (evento) {
  evento.preventDefault();
  filtrarColeccion();
});
// reset del filtro
$("#btnReset").on("click", function (evento) {
  $("#filt_nombre").val("");
  $("#filt_estado").val("vacio");
  $("#filt_idioma").val("vacio");
  $("#filtrar_result").trigger("click");
});
// llamada a mostrar cartas filtradas
function filtrarColeccion() {
  opciones = {
    id_user: $("#id_user").data("id_user"),
    nombre: $("#filt_nombre").val(),
    estado: $("#filt_estado").val(),
    idioma: $("#filt_idioma").val(),
  };
  mostrarCartasDisp(opciones);
}
//#endregion