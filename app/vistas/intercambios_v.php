<main class="container-fluid" style="padding-top: 100px; padding-bottom: 80px;">
    <div hidden id="id_user" data-id_user="<?= $_SESSION['sesion']['id_usu'] ?>" data-username="<?= $_SESSION['sesion']['username'] ?>"></div>
    <div class="pt-3 pt-md-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-8 container-gris p-4 m-2">
                <h1 id="nombre_usu">Intercambios</h1>
                <hr />
                <p class="fw-light fst-italic fs-4"><?= $_SESSION['sesion']['username'] ?></p>
            </div>
            <div class="col-md-8 col-sm-8 container-gris p-4 mx-2">
                <select class="form-select form-select-lg mb-3" id="select_envios" aria-label=".form-select-lg example">
                    <option selected value="todos">Todos</option>
                    <option value="enviados">Enviados</option>
                    <option value="recibidos">Recibidos</option>
                </select>
                <div id="tabla_intercambios" class="table-responsive">
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/intercambios.js"></script>