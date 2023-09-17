<main class="container-fluid min-vh-100" style="padding-top: 100px;">
    <div class="pt-3 pt-md-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-8 container-gris p-4 mx-2">
                <h1>Mi perfil</h1>
                <hr />
                <p class="fs-2 fw-bold"><?= $usuario['username'] ?></p>
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p class="fw-bold">Fecha de ingreso:</p>
                    </div>
                    <div class="col-md-6 col-6">
                        <p><?= $usuario['fecha_creacion'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p class="fw-bold">Nombre completo:</p>
                    </div>
                    <div class="col-md-6 col-6">
                        <p><?= $usuario['nombre_completo'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p class="fw-bold">Fecha de nacimiento:</p>
                    </div>
                    <div class="col-md-6 col-6">
                        <p><?= $usuario['fecha_nac'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p class="fw-bold">Estado de la cuenta:</p>
                    </div>
                    <div class="col-md-6 col-6">
                        <?php if ($usuario['disponible']) : ?>
                            <p class="text-success fw-bold">Activo</p>
                        <?php else : ?>
                            <p class="text-danger fw-bold">Inactivo</p>
                        <?php endif; ?>
                    </div>
                    <div hidden class="col-md-2 col-2">
                        <button class="btn btn-sm btn-success">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p class="fw-bold">Correo electrónico:</p>
                    </div>
                    <div class="col-md-6 col-6">
                        <p><?= $usuario['email'] ?></p>
                    </div>
                    <div hidden class="col-md-2 col-2">
                        <button id="cambiar_mail" class="btn btn-sm btn-success">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p class="fw-bold">Contraseña:</p>
                    </div>
                    <div class="col-md-6 col-6">
                        <p>*****</p>
                    </div>
                    <div hidden class="col-md-2 col-2">
                        <button id="cambiar_pass" class="btn btn-sm btn-success">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p class="fw-bold">Direccion:</p>
                    </div>
                    <div class="col-md-6 col-6">
                        <p><?= $usuario['direccion'] ?></p>
                    </div>
                    <div hidden class="col-md-2 col-2">
                        <button id="cambiar_dir" class="btn btn-sm btn-success">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p class="fw-bold">Localidad:</p>
                    </div>
                    <div class="col-md-6 col-6">
                        <p><?= $usuario['localidad'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-4">
                        <p class="fw-bold">Codigo postal:</p>
                    </div>
                    <div class="col-md-6 col-6">
                        <p><?= $usuario['codpostal'] ?></p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-6">
                        <a href="<?= BASE_URL ?>Usuarios_c/perfil_publico/<?= $usuario['username'] ?>" class="text-primary fs-7 fw-bold text-decoration-none">Ver mi perfil publico</a>
                    </div>
                    <div hidden class="col-6 text-end">
                        <a href="" class="text-danger fs-7 fw-bold text-decoration-none">Eliminar mi cuenta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/editar_perfil.js"></script>