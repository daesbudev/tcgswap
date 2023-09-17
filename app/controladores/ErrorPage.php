<?php
class ErrorPage extends Controller
{
    // index lleva a la vista de error cuando la pagina que se ha requerido no se encuentra
    public function index()
    {
        $titulo['nombre']="Error 404: no encontrado";
        $this->load_view("plantilla/cabecerasinheader", $titulo);
        $this->load_view("errorPagina");
    }
}
