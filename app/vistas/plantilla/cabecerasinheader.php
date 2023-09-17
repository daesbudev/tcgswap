<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="<?= BASE_URL; ?>app/assets/favicon.ico?" type="image/png" />
    <link rel="stylesheet" href="<?= BASE_URL; ?>app/assets/libs/bootstrap/css/bootstrap.min.css" />
    <script src="<?= BASE_URL; ?>app/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL; ?>app/assets/libs/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL; ?>app/vistas/css/style.css" />
    <link rel="stylesheet" href="<?= BASE_URL; ?>app/assets/libs/icons-1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css" rel="stylesheet">
    <title>
        <?php if (isset($nombre)) :
            echo $nombre;
        else : ?>
            TCGSwap
        <?php endif ?>
    </title>
</head>

<body id="fondo-color">
    <script>
        const base_url = '<?= BASE_URL; ?>'
    </script>