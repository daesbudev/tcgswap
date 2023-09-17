<?php
class Inicio_c extends Controller
{
    public function __construct()
    {
    }
    // index lleva a la landing page
    public function index()
    {
        // Visualizar la pagina de aterrizaje
        $titulo['nombre']="Bienvenido a TCGSwap";
        $contenido = "landing_v";
        $this->load_view("plantilla/cabecerasinheader", $titulo);
        $this->load_view($contenido);
    }
}
