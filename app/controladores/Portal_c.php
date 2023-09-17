<?php
class Portal_c extends Controller
{
    public function __construct()
    {
    }
    // index carga la vista del portal de la web que se encuentra despues de la landing
    public function index()
    {
        $titulo['nombre']= "Portal";
        $contenido = "portal_v";
        $this->load_view("plantilla/cabecera", $titulo);
        $this->load_view($contenido);
        $this->load_view("plantilla/pie");
    }
    // ultimasCartas se encarga de crear un JSON a partir de las ultimas cartas añadidas a colecciones para mostrarlo en el portal
    public function ultimasCartas()
    {
        $cartas = $this->load_model("Cartas_m");
        $datos = $cartas->ultimasCartas();
        echo json_encode($datos);
    }
}
