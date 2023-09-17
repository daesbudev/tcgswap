<?php
class Mensajes_c extends Controller
{
    // parametrizar los modelos de mensajes y usuarios
    private $mensajes_m, $usuarios_m;
    public function __construct()
    {
        $this->mensajes_m = $this->load_model("Mensajes_m");
        $this->usuarios_m = $this->load_model("Usuarios_m");
    }
    public function index()
    {
    }
    // mensajes se encarga de cargar la vista de las conversaciones que tenga el usuario logeado
    public function mensajes()
    {
        $titulo['nombre'] = "Mensajes";
        $contenido = "mensajes_v";
        $this->load_view("plantilla/cabecera", $titulo);
        $this->load_view($contenido);
        $this->load_view("plantilla/pie");
    }
    // enviarMensaje se encarga de cargar la vista que lleva a una conversacion con un usuario
    public function enviarMensaje($datos)
    {
        if (!$datos[0]) {
            $this->load_view("errorPagina");
        } else {
            $usu = $datos[0];
            // Recibo el usuario y lo envio al modelo para sacar sus datos
            $datos['usuario'] = $this->usuarios_m->leerUsu($usu);
            // Visualizar la pagina de mensajeria
            if (!$datos['usuario']) {
                $this->load_view("errorPagina");
            } else {
                $titulo['nombre'] = "Conversacion con " . $datos[0];
                $contenido = "enviar_mensaje_v";
                $this->load_view("plantilla/cabecera", $titulo);
                $this->load_view($contenido, $datos);
                $this->load_view("plantilla/pie");
            }
        }
    }
    // metodo que se encarga de mostrar todas las conversaciones entre entre el usuario logeado y otros usuarios
    public function verConver()
    {
        $datos = $this->mensajes_m->verConver($_POST);
        echo json_encode($datos);
    }
    // verMensajes se encarga de cargar los mensajes entre el usuario que se encuentra logeado
    public function verMensajes()
    {
        $datos = $this->mensajes_m->verMensajes($_POST);
        echo json_encode($datos);
    }
    // crearMensaje se encarga de insertar un nuevo mensaje cuando es enviado
    public function crearMensaje(){
        //$datos['id_conv'] = '(SELECT id_conv FROM conversacion WHERE (id_user1= :id_remi OR id_user2= :id_remi) AND (id_user1= :id_dest OR id_user2= :id_dest))';
        $datos['id_remi'] = $_POST['id_remi'];
        $datos['id_dest'] = $_POST['id_dest'];
        $datos['mensaje'] = $_POST['mensaje'];
        $datos['fecha_creado'] = date('Y-m-d H:i:s');
        $this->mensajes_m->crearMensaje($datos);
    }
}
