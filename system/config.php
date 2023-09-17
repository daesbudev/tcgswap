
<?php
//ACCESO CASA
//////////////////////// CONFIGURACIONES ///////////////////////
define('URI', $_SERVER['REQUEST_URI']);
const DEFAULT_CONTROLLER = 'Inicio_c';
const DEFAULT_METHOD = 'index';
const CORE = "system/core/";
const PATH_CONTROLLERS = "app/controladores/";
const PATH_VIEWS = "app/vistas/";
const PATH_MODELS = "app/modelos/";

// ACCESO CASA
define('ROOT', $_SERVER['DOCUMENT_ROOT'] . "/tcgswap/");
define("BASE_URL", "http://localhost/tcgswap/");
////////////BBDD/////////////////
const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "";
const DB_NAME = "tcgswap";

// ACCESO SERVIDOR
// define('ROOT', "/home/destevezb01/public_html/");
// define("BASE_URL", "http://jmlcasa.dyndns.info:8080/~destevezb01/");
// ////////////BBDD/////////////////
// const DB_HOST = "localhost";
// const DB_USER = "destevezb01";
// const DB_PASS = "3268819";
// const DB_NAME = "destevezb01";