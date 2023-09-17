<?php
// Mensajes_m se encarga de gestionar todo lo relacionado con las conversaciones y los mensajes
class Mensajes_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    // verMensajes busca los mensajes que haya entre el usuario logeado y el user de la conversacion seleccionada y los ordena de mas antiguo a mas nuevo para montar la conversacion
    public function verMensajes()
    {
        $cadSQL = "SELECT *, DATE(fecha_creado) as fecha, HOUR(fecha_creado) as hora, MINUTE(fecha_creado) as minutos FROM conv_mensaje WHERE (id_remi = :id_usu OR id_dest = :id_usu) AND (id_remi= :id_dest OR id_dest = :id_dest) ORDER BY fecha_creado ASC";
        $this->consultar($cadSQL);
        $this->enlazar(":id_usu", $_POST['id_user']);
        $this->enlazar(":id_dest", $_POST['id_dest']);
        return $this->resultado();
    }
    // verConver se encarga de buscar todas las conversaciones en las que el usuario logeado ha participado y las ordena de mas nueva a mas antigua para ver las conversaciones mas recientes
    public function verConver()
    {
        $cadSQL = "SELECT conv.*, DATE(fecha_ultimo) as fecha, HOUR(fecha_ultimo) as hora, 
        MINUTE(fecha_ultimo) as minutos, u1.username AS user1, u2.username AS user2, m.mensaje AS ultmsg 
        FROM conversacion conv 
        JOIN usuarios u1 ON conv.id_user1 = u1.id_usu 
        JOIN usuarios u2 ON conv.id_user2 = u2.id_usu 
        LEFT JOIN conv_mensaje m ON conv.id_conv=m.id_conv
        AND m.fecha_creado = (SELECT MAX(fecha_creado)
                                FROM conv_mensaje
                                WHERE id_conv = conv.id_conv)
        WHERE id_user1 = :id_usu OR id_user2 = :id_usu ORDER BY fecha_ultimo DESC;";
        $this->consultar($cadSQL);
        $this->enlazar("id_usu", $_POST['id_user']);
        return $this->resultado();
    }
    // crearMensaje inserta un mensaje en la conversacion entre el usuario logeado y el destino
    public function crearMensaje($datos)
    {
        // Recibimos los datos del formulario en un array
        // Obtenemos cadena con las columnas desde las claves del array asociativo
        $columnas = implode(",", array_keys($datos));
        // Campos de columnas
        $campos = array_map(
            function ($col) {
                return ":" . $col;
            },
            array_keys($datos)
        );
        $parametros = implode(",", $campos); // Parametros para enlazar
        $cadSQL = "INSERT INTO conv_mensaje ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }
}
