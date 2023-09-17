<?php
//Cartas_m es el modelo encargado de mostrar resultados dentro del buscador de cartas, el listado de ultimas cartas añadidas y los datos de una carta
class Cartas_m extends Model
{
    public function __construct()
    {
        // Llamada al constructor del padre para conectar a la BBDD
        parent::__construct();
    }
    // buscarCartas realiza la consulta SQL que devuelve todos los resultados que coinciden con lo escrito en el buscador de cartas de la cabecera
    public function buscarCartas(){
        $cadSQL = "SELECT nombre FROM cartas WHERE (nombre like :carta)";
        $this->consultar($cadSQL);
        $this->enlazar(":carta", "%$_POST[buscar]%");
        return $this->resultado();
    }
    // datosCarta se encarga de sacar todos los datos de una carta para que sean mostrados en la vista de esa misma carta
    public function datosCarta($carta){
        $cadSQL = "SELECT * FROM cartas WHERE (nombre=:carta)";
        $this->consultar($cadSQL);
        $this->enlazar(":carta", $carta);
        $fila = $this->fila();
        return $fila;
    }
    // ultimasCartas realiza la consulta SQL que saca las ultimas 10 cartas añadidas a las colecciones de cualquier usuario para mostrarla en la portada
    // NOTA: este metodo no deberia estar aqui sino en Coleccion_m -> hay que moverlo.
    public function ultimasCartas()
    {
        $cadSQL = "SELECT usuarios.username as nombre_usu, cartas.nombre as nombre_carta, coleccion_usu.estado, coleccion_usu.idioma 
        FROM coleccion_usu 
        INNER JOIN usuarios on usuarios.id_usu=coleccion_usu.id_usuario 
        INNER JOIN cartas on cartas.id_carta=coleccion_usu.id_carta 
        ORDER BY id_entrada desc limit 10";
        $this->consultar($cadSQL);
        return $this->resultado();
    }
}