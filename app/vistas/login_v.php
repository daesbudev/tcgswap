<section class="container-fluid">
  <div class="alert-container">
    <?php if (isset($_SESSION['error'])) : ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span class="fw-bold"><?= $_SESSION['error'] ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['exito'])) : ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <span class="fw-bold"><?= $_SESSION['exito'] ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['exito']); ?>
    <?php endif; ?>
  </div>
  <div class="row vw-100 vh-100 justify-content-center">
    <div id="login-logo" class="mh-auto col-md-4 col-lg-4 col-xl-4 text-center">
      <img src="<?= BASE_URL ?>app/assets/img/logo2.png" style="width: 250px;" class="img-fluid my-3" />
      <p class="fs-1">TCGSwap</p>
    </div>
    <div class="align-items-center justify-content-center d-flex col-md-8 col-lg-8 col-xl-8" style="background-color: white;">
      <form action="<?= BASE_URL; ?>Usuarios_c/autenticar" name="frmLogin" class="w-50" method="post" novalidate>
        <div class="justify-content-center justify-content-lg-start">
          <h1 class="mb-5">Inicio de sesión</h1>
          <!-- Email input -->
          <div class="form-outline mb-3">
            <label class="form-label" for="username">Usuario/Email</label>
            <input type="text" id="username" name="username" required class="form-control form-control-lg" />

          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <label class="form-label" for="password">Contraseña</label>

            <input type="password" name="password" id="password" required class="form-control form-control-lg" />

          </div>
        </div>
        <div class="row justify-content-end">
          <label class="form-label col-md-2 col-6" for="recuerdame">Recuérdame</label>
          <div class="col-2 col-md-1">
            <input type="checkbox" id="recuerdame" name="recuerdame" class="form-check-input" />
          </div>
        </div>
        <div class="text-center mt-4 pt-2">
          <button type="submit" class="btn btn-sm btn-warning w-75" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
          <p class="small fw-bold mt-2 pt-1 mb-0">¿Aun no tienes cuenta? <a href="<?= BASE_URL ?>Usuarios_c/registro" class="link-warning">Registrate aquí</a></p>
        </div>
    </div>
    </form>
  </div>
  </div>
</section>
<script src="<? echo BASE_URL; ?>app/assets/libs/cookies.js"></script>
<script>
  "use strict";
  // Cuando la aplicacion arranque ver si tenemos cookies y si es asi
  window.addEventListener("load", function(evento) {
    let username = localStorage["username"];
    let password = localStorage["password"];
    if (username) {
      document.frmLogin.username.value = username;
      document.frmLogin.password.value = password;
    }
  });
  document.addEventListener("submit", function(evento) {
    // Prevenir envio del formulario
    evento.preventDefault();

    if (document.frmLogin.recuerdame.value == true) {
      // Guardar una cookie con el usuario
      localStorage.username = document.frmLogin.username.value;
      localStorage.password = document.frmLogin.password.value;
    } else {
      localStorage.removeItem("username");
      localStorage.removeItem("password");
    }
    // Validacion
    if (
      document.frmLogin.username.value.length > 0 &&
      document.frmLogin.password.value.length > 0
    ) {
      document.frmLogin.submit();
    } else {
      //alert("Falta el usuario o el password");
      // Poner clase was-validated al formulario
      document.frmLogin.classList.add("was-validated");
    }
  });
</script>