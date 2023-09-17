<main class="container-fluid min-vh-100" style="padding-top: 100px; padding-bottom: 80px">
    <div class="pt-3 pt-md-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-8 container-gris p-4 m-2">
                <h1><?= $usuario['username'] ?></h1>
                <hr />
                <div class="row mt-3">
                    <div class="col-md-5 mt-2 col-6 fw-bold">Usuario desde:</div>
                    <div class="col-md-5 mt-2 col-6"><?= $usuario['fecha_creacion'] ?></div>
                    <div class="col-md-5 mt-2 col-6 fw-bold">Nombre:</div>
                    <div class="col-md-5 mt-2 col-6"><?= $usuario['nombre_completo'] ?></div>
                    <div class="col-md-5 mt-2 col-6 fw-bold">Dirección:</div>
                    <div class="col-md-5 mt-2 col-6"><?= $usuario['direccion'] ?></div>
                </div>
                <div class="row">

                    <div class="col-md-5 mt-2 col-6 fw-bold">Código postal:</div>
                    <div class="col-md-5 mt-2 col-6"><?= $usuario['codpostal'] ?></div>
                    <div class="col-md-5 mt-2 col-6 fw-bold">Localidad:</div>
                    <div class="col-md-5 mt-2 col-6"><?= $usuario['localidad'] ?></div>
                </div>
                <div class="row">
                    <div class="col-md-5 mt-2 col-6 fw-bold">Puntuacion:</div>
                    <div class="col-md-5 mt-2 col-6"><?php if ($usuario['puntuacion'] == NULL) echo "Sin puntuación";
                                                        else echo $usuario['puntuacion']; ?></div>
                    <div class="col-md-5 mt-2 col-6 fw-bold">Intercambios:</div>
                    <div class="col-md-5 mt-2 col-6"><?php if ($usuario['transacciones'] == NULL) echo "Sin transacciones";
                                                        else echo $usuario['transacciones']; ?></div>
                </div>
                <div class="row mt-4">
                    <?php if (isset($_SESSION['sesion']['username'])&&($usuario['username'] != $_SESSION['sesion']['username'])) : ?>
                        <div class="col-md-2 col-6">
                            <a href="<?= BASE_URL ?>Mensajes_c/enviarMensaje/<?= $usuario['username'] ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-envelope"></i> Contactar
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-2 col-6">
                        <a href="<?= BASE_URL ?>Usuarios_c/coleccion/<?= $usuario['username'] ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-box"></i> Ver colección
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 container-gris p-4 mx-2">
                <h1>Ultimas puntuaciones</h1>
                <hr />
                <div class="table-responsive">
                <p class="text-muted fs-5 ps-3">En desarrollo.</p>
                    <!-- <table class="table table table-striped table-warning">
                        <thead class="table">
                            <th scope="col">Usuario</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Puntuacion</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                            <tr>
                                <td>Usuario</td>
                                <td>XX/XX/XXXX</td>
                                <td>x/5</td>
                            </tr>
                        </tbody>
                    </table> -->
                </div>
            </div>
        </div>
    </div>
</main>