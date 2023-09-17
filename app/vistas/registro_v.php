<main class="container-fluid">
    <div class="pt-3 pt-md-5">
        <div class="row">
            <div class="col col-sm-8 offset-sm-2 d-none d-lg-block align-items-center">
                <a href="<?= BASE_URL ?>Portal_c" class="d-block text-center mb-md-2 mb-lg-4 text-reset text-decoration-none">
                    <img src="<?= BASE_URL ?>app/assets/img/logo2.png" style="width: 50px;"" alt="" class="img-fluid" />
                    <span class="fs-2 align-middle">TCGSwap</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col col-sm-8 offset-sm-2 container-gris my-5">
                <h1 class="text-center mt-1">Formulario de registro</h1>
                <p class="fs-5 form-text text-center">
                    Crea tu cuenta de usuario en TCGSwap
                </p>
                <hr />
                <form name="frmRegistro" action="<?= BASE_URL; ?>Usuarios_c/insertar" method="post" novalidate>
                    <p class="fs-6 text-danger">Los campos con * son obligatorios</p>
                    <fieldset>
                        <legend>
                            Datos personales<span class="text-danger">*</span>
                        </legend>
                        <div class="row">
                            <div class="col">
                                <label for="nombre" class="col-form-label col-form-label-sm">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="nombre" placeholder="Nombre" required autofocus tabindex="1" class="form-control" />
                            </div>
                            <div class="col">
                                <label for="apellido" class="col-form-label col-form-label-sm">Apellido/s <span class="text-danger">*</span></label>
                                <input type="text" name="apellido" id="apellido" placeholder="Apellido/s" required tabindex="2" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 col-md-4">
                                <label for="fecha_nac" class="col-form-label col-form-label-sm">Fecha de nacimiento
                                    <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_nac" id="fecha_nac" value placeholder="yyyy-mm-dd" min="1900-01-01" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" required tabindex="3" class="form-control" />
                            </div>
                        </div>
                    </fieldset>
                    <hr />
                    <fieldset>
                        <legend>Dirección <span class="text-danger">*</span></legend>
                        <div class="row mt-2">
                            <div class="col-12 col-md-6">
                                <label for="calle" class="col-form-label col-form-label-sm">Calle <span class="text-danger">*</span></label>
                                <input type="text" name="calle" id="calle" placeholder="Calle" required tabindex="4" class="form-control" />
                            </div>
                            <div class="col-6 col-md-4">
                                <label for="numero" class="col-form-label col-form-label-sm">Número/Piso <span class="text-danger">*</span></label>
                                <input type="text" name="numero" id="numero" placeholder="Numero/Piso" required tabindex="5" class="form-control" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-2">
                                <label for="codpos" class="col-form-label col-form-label-sm">Código postal <span class="text-danger">*</span></label>
                                <input type="text" name="codpostal" id="codpostal" placeholder="Código postal" required tabindex="6" class="form-control" />
                            </div>
                            <div class="col-6 col-md-4">
                                <label for="localidad" class="col-form-label col-form-label-sm">Ciudad <span class="text-danger">*</span></label>
                                <input type="text" name="localidad" id="localidad" placeholder="Localidad" required tabindex="7" class="form-control" />
                            </div>
                        </div>
                    </fieldset>
                    <hr />
                    <fieldset class="mb-5">
                        <legend>
                            Datos de la cuenta <span class="text-danger">*</span>
                        </legend>
                        <div class="row">
                            <div class="col-7 col-md-7">
                                <label for="email" class="col-form-label col-form-label-sm">Email <span class="text-danger">*</span></label>
                                <input type="text" name="email" id="email" placeholder="Email" required tabindex="8" class="form-control" />
                                <div class="invalid-feedback">
                                    Este email ya ha sido usado.
                                </div>
                            </div>
                            <div class="col-5 col-md-5">
                                <label for="username" class="col-form-label col-form-label-sm">Nombre de usuario
                                    <span class="text-danger">*</span></label>
                                <input type="text" name="username" id="username" placeholder="Nombre de usuario" required tabindex="9" class="form-control" />
                                <div class="invalid-feedback">
                                    Ese nombre de usuario ya existe.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <label for="password" class="col-form-label col-form-label-sm">Contraseña
                                    <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" placeholder="Contraseña" required tabindex="10" class="form-control" />
                            </div>
                            <div class="col-6 col-md-6">
                                <label for="confpassword" class="col-form-label col-form-label-sm">Confirmar contraseña
                                    <span class="text-danger">*</span></label>
                                <input type="password" name="confpassword" id="confpassword" placeholder="Repita la contraseña" required tabindex="11" class="form-control" />
                                <div class="invalid-feedback">
                                    Las contraseñas no son iguales.
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <input type="submit" value="Registrarse" id="btn-registro" class="btn btn-warning mb-3 btn-lg w-100">
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    // Producir validacion
    $(document.frmRegistro).on("submit", function(evento) {
        evento.preventDefault();
        // Ver validación
        if (!this.checkValidity()) {
            this.classList.add("was-validated");
        } else {
            if ($(".no-valido").length == 0) this.submit();
        }
    });
    // Verificar no existencia de usuario y email
    $(document.frmRegistro.username).on("blur", function(evento) {
        if (this.value.length > 0) {
            comprobarUsuEmail("username", this.value);
        }
    })
    $(document.frmRegistro.email).on("blur", function(evento) {
        if (this.value.length > 0) {
            comprobarUsuEmail("email", this.value);
        }
    })

    function comprobarUsuEmail(campo, valor) {
        let datos = new Object();
        datos[campo] = valor;
        $.post(base_url + "Usuarios_c/existeUsuario", datos, function(dev) {
            if (dev.replace(/(\r\n|\n|\r)/gm, "") == '1') {  
                document.frmRegistro[campo].classList.add("is-invalid");
                document.frmRegistro[campo].classList.add("no-valido");
            } else {
                document.frmRegistro[campo].classList.remove("is-invalid");
                document.frmRegistro[campo].classList.remove("no-valido");
            }
            return dev;
        })
    }
    // verificar que contraseña y confcontraseña son iguales
    $(document.frmRegistro.confpassword).on("keyup", function(evento) {
        if (this.value != document.frmRegistro.password.value) {
            this.classList.add("is-invalid");
            this.classList.add("no-valido");
        } else {
            this.classList.remove("is-invalid");
            this.classList.remove("no-valido");
        }
    })
</script>