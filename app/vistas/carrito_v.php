<main class="container-fluid" style="padding-top: 100px; padding-bottom: 80px;">
    <div class="alert-container" style="padding-top: 25px;">
        <?php if (isset($_SESSION['exito'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                <span class="fw-bold"><?= $_SESSION['exito'] ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['exito']); ?>
        <?php endif; ?>
    </div>
    <div hidden id="id_user" data-id_user="<?= $_SESSION['sesion']['id_usu'] ?>" data-username="<?= $_SESSION['sesion']['username'] ?>"></div>
    <div class="pt-3 pt-md-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-8 container-gris p-4 m-2">
                <h1 id="nombre_usu">Carrito</h1>
                <hr />
                <p class="fw-light fst-italic fs-4"><?= $_SESSION['sesion']['username'] ?></p>
            </div>
            <div class="col-md-8 col-sm-8 container-gris p-4 mx-2">
                <!-- generacion del carrito usando php -->
                <?php if (empty($items)) : ?>
                    <p class="text-center fs-3 fw-bold">¡Tu carrito esta vacío! Añade algunas cartas de otros usuarios.</p>
                <?php endif; ?>
                <?php $userPrevio = "";
                ?>
                <?php foreach ($items as $clave => $item) : ?>
                    <?php if (($item['username'] == $userPrevio && $clave === array_key_last($items))) : ?>
                        <tr class="align-middle" data-id="<?= $item['id'] ?>">
                            <td><a href="<?= BASE_URL ?>Cartas_c/datosCarta/<?= $item['nombre_carta'] ?>" class="fw-bold text-decoration-none"><?= str_replace("-", " ", $item['nombre_carta']) ?></a></td>
                            <td><?= $item['estado'] ?>, <?= $item['idioma'] ?></td>
                            <td class="d-flex justify-content-between align-items-center"><span><?= $item['cantidad'] ?></span>
                                <div class="id_usu"><button class="btn btn-sm btn-danger m-1 borrarFilaCarrito"><i class="bi bi-trash"></i></button></div>
                            </td>
                        </tr>
                        </tbody>
                        </table>
            </div>
            <div class="d-flex justify-content-end">
                <a href="<?= BASE_URL ?>Ofertas_c/enviarOferta/<?= $item['id_usu_carta'] ?>" class="btn btn-sm btn-warning hacerOferta">Hacer oferta</a>
            </div>
        </div>
    <?php endif; ?>
    <?php if (($item['username'] != $userPrevio && $clave !== array_key_first($items))) : ?>
        </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end">
        <a href="<?= BASE_URL ?>Ofertas_c/enviarOferta/<?= $item['id_usu_carta'] ?>" class="btn btn-sm btn-warning hacerOferta">Hacer oferta</a>
    </div>
    </div>
<?php endif; ?>
<?php if ($userPrevio == $item['username'] && $clave !== array_key_last($items)) : ?>
    <tr class="align-middle" data-id="<?= $item['id'] ?>">
        <td><a href="<?= BASE_URL ?>Cartas_c/datosCarta/<?= $item['nombre_carta'] ?>" class="fw-bold text-decoration-none"><?= str_replace("-", " ", $item['nombre_carta']) ?></a></td>
        <td><?= $item['estado'] ?>, <?= $item['idioma'] ?></td>
        <td class="d-flex justify-content-between align-items-center"><span><?= $item['cantidad'] ?></span>
            <div class="id_usu"><button class="btn btn-sm btn-danger m-1 borrarFilaCarrito"><i class="bi bi-trash"></i></button></div>
        </td>
    </tr>
<?php endif; ?>
<?php if ($clave === array_key_first($items) || $item['username'] != $userPrevio) : ?>
    <div class="row border border-secondary rounded-1 p-2 mb-3">
        <div class="d-flex justify-content-between my-2">
            <a href="<?= BASE_URL ?>Usuarios_c/perfil_publico/<?= $item['username'] ?>" class="fw-bold fs-5 text-decoration-none"><?= $item['username'] ?></a>
            <button class="btn btn-sm btn-danger borrarUsuCarrito" data-id_usu="<?= $item['id_usu_carta'] ?>">Eliminar todo</button>
        </div>
        <hr>
        <div class="table-responsive tabla_carrito">
            <table class="table table-sm table-bordered table-striped table-warning">
                <thead class="table bg-light">
                    <th scope="col" style="width: 46%;">Nombre</th>
                    <th scope="col" style="width: 27%;">Información</th>
                    <th scope="col" style="width: 27%;">Cantidad</th>
                </thead>
                <tbody>
                    <tr class="align-middle" data-id="<?= $item['id'] ?>">
                        <td><a href="<?= BASE_URL ?>Cartas_c/datosCarta/<?= $item['nombre_carta'] ?>" class="fw-bold text-decoration-none"><?= str_replace("-", " ", $item['nombre_carta']) ?></a></td>
                        <td><?= $item['estado'] ?>, <?= $item['idioma'] ?></td>
                        <td class="d-flex justify-content-between align-items-center"><span><?= $item['cantidad'] ?></span>
                            <div><button class="btn btn-sm btn-danger m-1 borrarFilaCarrito"><i class="bi bi-trash"></i></button></div>
                        </td>
                    </tr>
                    <?php if ($clave === array_key_last($items)) : ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            <a href="<?= BASE_URL ?>Ofertas_c/enviarOferta/<?= $item['id_usu_carta'] ?>" class="btn btn-sm btn-warning hacerOferta">Hacer oferta</a>
        </div>
    </div>
<?php
                        endif;
                    endif;
                    $userPrevio = $item['username'];
?>
<?php endforeach; ?>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/carrito.js"></script>