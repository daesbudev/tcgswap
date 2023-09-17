<main class="container-fluid" style="padding-top: 100px; padding-bottom: 80px;">
    <div hidden id="id_user" data-id_user="<?= $_SESSION['sesion']['id_usu'] ?>" data-username="<?= $_SESSION['sesion']['username'] ?>"></div>
    <div hidden id="id_user2" data-id_user2="<?php if ($oferta['id_user_oferta'] == $_SESSION['sesion']['id_usu']) echo $oferta['id_user_recibe'];
                                                else echo $oferta['id_user_oferta']; ?>"></div>
    <div hidden id="id_oferta" data-id_oferta="<?= $oferta['id_oferta'] ?>"></div>
    <div class="pt-3 pt-md-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-8 container-gris p-4 m-2">
                <h1 id="nombre_usu">Intercambio #<?= $oferta['id_oferta'] ?></h1>
                <hr />
            </div>
            <div class="col-md-8 col-sm-8 container-gris p-4 mx-2">
                <div class="row mt-3 px-4">
                    <div class="col-md-2 col-6 fw-bold">Enviada por:</div>
                    <div class="col-md-2 col-6"><?php if ($oferta['user1'] == $_SESSION['sesion']['username'])
                                                    echo "<span class='fw-bold'>" . $oferta['user1'] . "</span>";
                                                else echo "<a href='" . BASE_URL . "Usuarios_c/perfil_publico/" . $oferta['user1'] . "' class='fw-bold text-decoration-none'>" . $oferta['user1'] . "</a>"; ?></div>
                </div>
                <div class="row mt-3 px-4">
                    <div class="col-md-2 col-6 fw-bold">Fecha de la oferta:</div>
                    <div class="col-md-2 col-6"><?= $oferta['fecha_oferta'] ?></div>
                </div>
                <div class="row mt-3 px-4">
                    <div class="col-md-2 col-6 fw-bold">Estado:</div>
                    <div class="col-md-2 col-6"><?php $estado = match ($oferta['status']) {
                                                    'EN' => "Pendiente",
                                                    'OK' => "Aceptada",
                                                    'NO' => "Rechazada",
                                                };
                                                echo $estado; ?></div>
                </div>
                <div class="row d-flex justify-content-between p-4">
                    <div class="col col-md-5 border border-secondary rounded-1 p-2 h-100">
                        <p class="fs-5 fw-bold">Tus cartas</p>
                        <hr />
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped table-warning">
                                <thead class="table bg-light">
                                    <th scope="col" style="width: 46%;">Nombre</th>
                                    <th scope="col" style="width: 27%;">Información</th>
                                    <th scope="col" style="width: 27%;">Cantidad</th>
                                </thead>
                                <tbody id="cartas_oferta_user1">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col col-md-5 border border-secondary rounded-1 p-2 h-100">
                        <p class="fs-5 fw-bold">Cartas de <?php if ($oferta['user1'] == $_SESSION['sesion']['username']) echo $oferta['user2'];
                                                            else echo $oferta['user1']; ?></p>
                        <hr />
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped table-warning">
                                <thead class="table bg-light">
                                    <th scope="col" style="width: 46%;">Nombre</th>
                                    <th scope="col" style="width: 27%;">Información</th>
                                    <th scope="col" style="width: 27%;">Cantidad</th>
                                </thead>
                                <tbody id="cartas_oferta_user2">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if ($oferta['id_user_oferta'] != $_SESSION['sesion']['id_usu'] && $oferta['status'] == "EN") echo
                '<div class="row d-flex justify-content-end py-4 w-100">
                    <div class="col-md-1 col-3"><button data-id_oferta=' . $oferta['id_oferta'] . ' id="aceptarOferta" class="btn btn-success me-2">Aceptar</button></div>
                    <div class="col-md-1 col-3"><button data-id_oferta=' . $oferta['id_oferta'] . ' id="rechazarOferta" class="btn btn-danger me-2">Rechazar</button></div>
                </div>';
                else if ($oferta['status'] == "OK") echo '<div class="row"><span class="fw-bold">La oferta ha sido aceptada.</span></div>';
                else if ($oferta['status'] == "NO") echo '<div class="row"><span class="fw-bold">La oferta ha sido rechazada.</span></div>';
                else echo '<div class="row"><span class="fw-bold">El usuario aún no ha respondido tu oferta.</span></div>'; ?>
            </div>
        </div>
    </div>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/detalles_oferta.js"></script>