$("#cambiar_mail").on("click", function (evento) {
  Swal.fire({
    title: "Nuevo email",
    html: `<input type="email" id="mail" class="swal2-input" placeholder="Escribe el nuevo mail">`,
    confirmButtonText: "Cambiar",
    focusConfirm: false,
    preConfirm: () => {
      const email = Swal.getPopup().querySelector("#mail").value;
      const format =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if (!email || !email.toLowerCase().match(format)) {
        Swal.showValidationMessage(`Email vacío o incorrecto`);
      }
      return { email: email };
    },
  }).then((result) => {
    Swal.fire(`Email: ${result.value.email}`.trim());
  });
});
$("#cambiar_pass").on("click", function (evento) {
  Swal.fire({
    title: "Nueva contraseña",
    html: `<input type="password" id="pass_new" class="swal2-input" placeholder="Contraseña nueva">`,
    confirmButtonText: "Cambiar",
    focusConfirm: false,
    preConfirm: () => {
      const pass_new = Swal.getPopup().querySelector("#pass_new").value;
      if (!pass_new) {
        Swal.showValidationMessage(`El campo no puede estar vacío`);
      }
      return { pass_new: pass_new };
    },
  }).then((result) => {
    Swal.fire(`Pass: ${result.value.pass_new}`.trim());
  });
});
$("#cambiar_dir").on("click", function (evento) {});
