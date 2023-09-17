<main class="container-fluid" style="padding-top: 100px; padding-bottom: 80px;">
    <div hidden id="id_user" data-id_user="<?= $_SESSION['sesion']['id_usu'] ?>" data-username="<?= $_SESSION['sesion']['username'] ?>"></div>
    <div hidden id="id_dest" data-id_dest="<?= $usuario['id_usu'] ?>" data-username_dest="<?= $usuario['username'] ?>"></div>
    <div class="pt-3 pt-md-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-8 container-gris p-4 m-2">
                <h1>Mensajes con <?= $usuario['username'] ?></h1>
            </div>
            <div id="ventana-chat" class="col-md-8 col-sm-8 container-gris p-4 mx-2 overflow-auto" style="min-height: 60vh; max-height: 60vh;">
                <div id="conversacion" class="p-1">
                </div>
            </div>
            <div id="enviarMensaje" class="col-md-8 col-sm-8 container-gris m-1">
                <div class="input-group align-items-center justify-content-between w-100 px-3 py-2">
                    <textarea id="contenidoMsg" placeholder="Envia un mensaje a <?= $usuario['username'] ?>..." rows="1" maxlength="1600" autofocus class="form-control" style="resize: none"></textarea>
                    <div class="input-group-append">
                        <button id="enviarMsg" class="btn btn-warning"><i class="bi bi-send-fill"></i><span class="d-none d-md-inline ms-2">Enviar</span></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<script src="<?= BASE_URL; ?>app/vistas/js/mensajes.js"></script>