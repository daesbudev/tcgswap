<main class="container-fluid" style="padding-top: 100px; padding-bottom: 80px;">
    <div hidden id="id_user" data-id_user="<?= $_SESSION['sesion']['id_usu'] ?>" data-username="<?= $_SESSION['sesion']['username'] ?>"></div>
    <div hidden id="id_user_ofertado" data-id_user_ofertado="<?php foreach ($cartas as $carta) :
                                                        echo $carta['id_usu_carta'];
                                                        break;
                                                    endforeach;  ?>"></div>
    <div class="pt-3 pt-md-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-8 container-gris p-4 m-2">
                <h1 id="nombre_usu">Hacer oferta</h1>
                <hr />
                <p class="fw-light fst-italic fs-4"><?php foreach ($cartas as $carta) :
                                                        echo $carta['username'];
                                                        break;
                                                    endforeach; ?></p>
                <div class="row d-flex justify-content-between p-4">
                    <div class="col col-md-5 border border-secondary rounded-1 p-2 h-100">
                        <p class="fs-5 fw-bold">Tus cartas</p>
                        <hr />
                        <div class="table-responsive" id="contenido_ofertador">
                        </div>
                    </div>
                    <div class="col col-md-5 border border-secondary rounded-1 p-2 h-100">
                        <p class="fs-5 fw-bold">Sus cartas</p>
                        <hr />
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped table-warning">
                                <thead class="table bg-light">
                                    <th scope="col" style="width: 46%;">Nombre</th>
                                    <th scope="col" style="width: 27%;">Información</th>
                                    <th scope="col" style="width: 27%;">Cantidad</th>
                                </thead>
                                <tbody id="contenido_ofertado">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-end p-4">
                    <button id="confirmarCambio" class="btn btn-sm btn-warning fw-bold">Confirmar intercambio</button>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 container-gris p-4 mx-2">
                <form action="#" method="post">
                    <div class="row mb-3 pb-3 pt-2 border rounded">
                        <p class="fs-4 fw-bold">Opciones de filtrado</p>
                        <div class="col-4 col-md-2 mb-3">
                            <label for="filt_nombre" class="fw-bold">Nombre</label>
                            <input type="text" name="filt_nombre" id="filt_nombre" class="form-control form-control-sm">
                        </div>
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
                        <div class="col col-md-2 mb-3 d-flex align-items-end">
                            <input type="submit" value="Añadir filtros" title="Añadir filtros" id="filtrar_result" class="btn btn-warning w-100 btn-sm fw-bold" />
                        </div>
                        <div class="col col-md-2 mb-3 d-flex align-items-end">
                            <input type="submit" value="Limpiar filtros" title="Limpiar filtros" id="reset_filtro" class="btn btn-secondary w-100 btn-sm fw-bold" />
                        </div>
                    </div>
                </form>
                <div id="tabla_coleccion" class="table-responsive">
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/oferta.js"></script>