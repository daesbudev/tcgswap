<!DOCTYPE html>
<html lang="es">
<!-- CABECERA CON TODAS LAS LLAMADAS CORRESPONDIENTES -->

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

<body id="fondo-color" class="position-relative" style="min-height: 100vh;">
    <script>
        const base_url = '<?= BASE_URL; ?>'
    </script>
    <header id="header" class="fixed-top">
        <nav class="navbar navbar-light row">
            <div class="col-md-6 col-2">
                <a class="text-decoration-none" href="<?= BASE_URL ?>Portal_c">
                    <img src="<?= BASE_URL ?>app/assets/img/logo2.png" style="width: 50px;" class="me-2 img-fluid" />
                    <span class="navbar-brand fs-3 align-middle d-none d-md-inline d-lg-none d-xl-inline text-white">TCGSwap</span>
                </a>
            </div>
            <?php if (isset($_SESSION['sesion'])) : ?>
                <div class="justify-content-end d-flex col-md-6 col-10">
                    <div class="btn-group">
                        <button class="btn btn-warning" type="button">
                            <i class="bi bi-person-fill"></i> <span class="d-none d-md-inline"><?= $_SESSION['sesion']['username']; ?></span>
                        </button>
                        <button type="button" class="btn btn-warning me-2 dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>Usuarios_c/miCuenta">Mi perfil</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>Usuarios_c/coleccion/<?= $_SESSION['sesion']['username'] ?>">Mi colección</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>Mensajes_c/mensajes">Mensajes</a></li>
                            <li><a class="dropdown-item" id="cerrarSesion">Cerrar sesión</a></li>
                        </ul>
                    </div>
                    <a href="<?= BASE_URL ?>Ofertas_c/misOfertas" class="btn btn-warning me-2"><i class="bi bi-arrow-left-right"></i><span class="d-none d-md-inline"> Intercambios</span></a>
                    <a href="<?= BASE_URL ?>Carrito_c" class="btn btn-warning me-2"><i class="bi bi-cart-fill"></i><span class="d-none d-md-inline"> Cesta</span></a>
                </div>
            <?php else : ?>
                <div class="justify-content-end d-flex col-md-6 col-10">
                    <a class="btn btn-warning me-2" href="<?= BASE_URL ?>Usuarios_c/login">
                        <i class="bi bi-box-arrow-in-right"></i><span class="d-none d-md-inline"> Iniciar sesión</span>
                    </a>
                    <a class="btn btn-warning me-2" href="<?= BASE_URL ?>Usuarios_c/registro">
                        <i class="bi bi-person-plus-fill"></i><span class="d-none d-md-inline"> Registrarse</span>
                    </a>
                </div>
            <?php endif; ?>

        </nav>
        <nav class="navbar nabvar-light">
            <form action="#" method="get" id="buscador" class="position-relative d-inline-block" autocomplete="off">
                <div class="form-group mb-0 row">
                    <div class="col-md col">
                        <div class="input-group">
                            <input type="text" placeholder="Busca en TCGSwap..." id="buscar" name="buscar" class="form-control busqueda" />
                            <button class="btn btn-light" type="submit">Buscar</button>
                        </div>
                    </div>
                    <div id="resultados"></div>
                </div>
            </form>
        </nav>
    </header>
    <script src="<?= BASE_URL; ?>app/vistas/js/cabecera.js"></script>