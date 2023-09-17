<main class="container-fluid" style="padding-top: 100px; padding-bottom: 80px;">
    <div hidden id="id_user" data-id_user="<?= $_SESSION['sesion']['id_usu'] ?>" data-username="<?= $_SESSION['sesion']['username'] ?>"></div>
    <div hidden id="id_carta" data-id_carta="<?= $carta['id_carta'] ?>"></div>
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
    <div class="pt-3 pt-md-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-8 container-gris p-4 m-2">
                <h1><?= str_replace("-", " ", $carta['nombre'])  ?></h1>
                <hr />
                <div class="row my-3">
                    <div class="col-12 col-md-4 py-3 d-flex justify-content-center">
                        <img src="<?= BASE_URL . $carta['camino_img'] ?>" class="img-fluid" style="width: 239px; height: 338px;" alt="" />
                    </div>
                    <div class="col-12 col-md-4 py-3">
                        <p class="fs-4">Informacion de la carta</p>
                        <hr />
                        <div class="row">
                            <div class="col-5 col-md-5">
                                <p class="fw-bold">Rareza:</p>
                            </div>
                            <div class="col-7 col-md-7">
                                <p><?php switch ($carta['rareza']):
                                        case "IN":
                                            echo "Infrecuente";
                                            break;
                                        case "RA":
                                            echo "Rara";
                                            break;
                                        case "MI":
                                            echo "Mítica";
                                            break;
                                        default:
                                            echo "Común";
                                    endswitch; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-md-5">
                                <p class="fw-bold">Descripción:</p>
                            </div>
                            <div class="col-7 col-md-7">
                                <p>
                                    <?= $carta['descCarta'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 col-md-5">
                                <p class="fw-bold">Unidades disponibles</p>
                            </div>
                            <div class="col-7 col-md-7">
                                <p id="ud_disp"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 py-3">
                        <p class="fs-4">Añadir a mi colección</p>
                        <hr />
                        <?php if (isset($_SESSION['sesion'])) : ?>
                            <form action="<?= BASE_URL; ?>Coleccion_c/addCarta" method="post">
                                <div>
                                    <div class="row mt-3">
                                        <label for="add_cantidad" class="col-form-label col-form-label-sm col col-md-5 fw-bold">Cantidad</label>
                                        <div class="col col-md-7">
                                            <input type="number" name="add_cantidad" value="1" min="1" max="16" id="add_cantidad" placeholder="Cantidad" class="form-control form-control-sm" />
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <label for="add_estado" class="col-form-label col-form-label-sm col col-md-5 fw-bold">Estado</label>
                                        <div class="col col-md-7">
                                            <select size="1" name="add_estado" id="add_estado" class="form-select form-select-sm">
                                                <option value="CN" selected>Casi nueva</option>
                                                <option value="EX">Excelente</option>
                                                <option value="BI">Bien</option>
                                                <option value="US">Usada</option>
                                                <option value="MA">Mal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <label for="add_idioma" class="col-form-label col-form-label-sm col col-md-5 fw-bold">Idioma</label>
                                        <div class="col col-md-7">
                                            <select size="1" name="add_idioma" id="add_idioma" class="form-select form-select-sm">
                                                <option value="ES" selected>Español</option>
                                                <option value="IN">Inglés</option>
                                                <option value="FR">Francés</option>
                                                <option value="AL">Alemán</option>
                                                <option value="IT">Italiano</option>
                                                <option value="RU">Ruso</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="add_carta" name="add_carta" value="<?= $carta['id_carta'] ?>">
                                    <input type="hidden" id="add_nombre" name="add_nombre" value="<?= $carta['nombre'] ?>">
                                    <div class="row mt-5">
                                        <div class="col col-md">
                                            <input type="submit" value="Añadir a tu colección" title="Añadir a tu colección" class="btn btn-warning w-100 btn-sm fw-bold" />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php else : ?>
                            <div class="row mt-3">
                                <div class="col fw-bold">
                                    Para poder añadir esta carta a tu colección debes iniciar sesión.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 container-gris p-4 mx-2">
                <form action="#" method="post">
                    <div class="row mb-3 pb-3 pt-2 border rounded">
                        <p class="fs-4 fw-bold">Opciones de filtrado</p>
                        <div class="col-4 col-md-2 mb-3">
                            <label for="filt_estado" class="fw-bold">Estado</label>
                            <select size="1" name="filt_estado" id="filt_estado" class="form-select form-select-sm">
                                <option selected disabled value="vacio"></option>
                                <option value="CN">Casi nueva</option>
                                <option value="EX">Excelente</option>
                                <option value="BI">Bien</option>
                                <option value="US">Usada</option>
                                <option value="MA">Mal</option>
                            </select>
                        </div>
                        <div class="col-4 col-md-2 mb-3">
                            <label for="filt_idioma" class="fw-bold">Idioma</label>
                            <select size="1" name="filt_idioma" id="filt_idioma" class="form-select form-select-sm">
                                <option selected disabled value="vacio"></option>
                                <option value="ES">Español</option>
                                <option value="IN">Inglés</option>
                                <option value="FR">Francés</option>
                                <option value="AL">Alemán</option>
                                <option value="IT">Italiano</option>
                                <option value="RU">Ruso</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-none d-md-flex"></div>
                        <div class="col-md-2 d-none d-md-flex"></div>
                        <div class="col col-md-2 mb-3 d-flex align-items-end">
                            <input type="submit" value="Añadir filtros" title="Añadir filtros" id="filtrar_result" class="btn btn-warning w-100 btn-sm fw-bold" />
                        </div>
                        <div class="col col-md-2 mb-3 d-flex align-items-end">
                            <input type="submit" value="Limpiar filtros" title="Limpiar filtros" id="reset_filtro" class="btn btn-secondary w-100 btn-sm fw-bold" />
                        </div>
                    </div>
                </form>
                <div id="tabla_cartas" class="table-responsive">
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/cargarCartas.js"></script>