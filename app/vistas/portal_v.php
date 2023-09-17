<main class="container-fluid" style="padding-top: 100px; padding-bottom: 80px;">
<div hidden id="id_user" data-id_user="<?= $_SESSION['sesion']['id_usu'] ?>" data-username="<?= $_SESSION['sesion']['username'] ?>"></div>
  <div class="pt-3 pt-md-5">
    <?php if (isset($_SESSION['sesion'])) : ?>
      <div class="row justify-content-center">
        <div class="col-md-10 col-sm-8 container-gris pt-3">
          <p class="fs-2">Notificaciones</p>
          <hr />
          <p class="text-muted fs-5 ps-3">Sistema de notificaciones en desarrollo.</p>
          <hr class="mt-5" />
        </div>
      </div>
    <?php endif; ?>

    <div class="row justify-content-center">
      <div class="col-md-5 col-sm-8 container-gris">
        <p class="fs-2">Novedades</p>
        <hr />
        <div id="tabla_novedades" class="table-responsive">
        </div>
      </div>
      <div class="col-md-5 col-sm-8 container-gris">
        <p class="fs-2">Más intercambiadas</p>
        <hr />
        <p class="text-muted fs-5 ps-3">En desarrollo.</p>
        <!-- <div class="table-responsive">
          <table class="table table-striped table-warning">
            <thead class="table">
              <th scope="col"></th>
              <th scope="col">Nombre</th>
            </thead>
            <tbody id="tbody-masint">
              <tr>
                <td scope="row" class="w-auto fs-6">1</td>
                <td>DataNombre</td>
              </tr>
              <tr>
                <td scope="row" class="w-auto fs-6">2</td>
                <td>DataNombre</td>
              </tr>
              <tr>
                <td scope="row" class="w-auto fs-6">3</td>
                <td>DataNombre</td>
              </tr>
              <tr>
                <td scope="row" class="w-auto fs-6">4</td>
                <td>DataNombre</td>
              </tr>
              <tr>
                <td scope="row" class="w-auto fs-6">5</td>
                <td>DataNombre</td>
              </tr>
              <tr>
                <td scope="row" class="w-auto fs-6">6</td>
                <td>DataNombre</td>
              </tr>
              <tr>
                <td scope="row" class="w-auto fs-6">7</td>
                <td>DataNombre</td>
              </tr>
              <tr>
                <td scope="row" class="w-auto fs-6">8</td>
                <td>DataNombre</td>
              </tr>
              <tr>
                <td scope="row" class="w-auto fs-6">9</td>
                <td>DataNombre</td>
              </tr>
              <tr>
                <td scope="row" class="w-auto fs-6">10</td>
                <td>DataNombre</td>
              </tr>
            </tbody>
          </table>
        </div> -->
      </div>
    </div>
    <!-- <div class="row justify-content-center">
      <div class="col-md-10 col-sm-8 pt-3">
        <div id="carouselExampleControls" class="carousel slide my-3" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="https://via.placeholder.com/700x200.png?text=vivan" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="https://via.placeholder.com/700x200.png?text=las" class="d-block w-100" alt="..." />
            </div>
            <div class="carousel-item">
              <img src="https://via.placeholder.com/700x200.png?text=lentejas" class="d-block w-100" alt="..." />
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div> -->
  </div>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/portal.js"></script>