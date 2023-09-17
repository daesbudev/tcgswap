<?php
// Cargar clases del PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require ROOT . 'app/assets/libs/PHPMailer/src/Exception.php';
require ROOT . 'app/assets/libs/PHPMailer/src/PHPMailer.php';
require ROOT . 'app/assets/libs/PHPMailer/src/SMTP.php';

class Usuarios_c extends Controller
{
    private $usuarios_m; // Propiedad para instanciar el modelo

    public function __construct()
    {
        $this->usuarios_m = $this->load_model("Usuarios_m");
    }
    public function index()
    {
    }
    // login presenta la vista del Login
    public function login()
    {
        $titulo['nombre'] = "Inicia sesión";
        $contenido = "login_v";
        $this->load_view("plantilla/cabecerasinheader", $titulo);
        $this->load_view($contenido);
    }
    // logout es el metodo que permite a un usuario logeado desconectarse
    public function logout()
    {
        $carrito_m = $this->load_model("Carrito_m");
        // Destruimos el carrito
        $carrito_m->vaciarCarritoUsu($_SESSION['sesion']['id_usu']);
        // Destruimos la sesion
        unset($_SESSION['sesion']);
    }
    // miCuenta carga la vista que muestra la informacion personal del usuario que se encuentra logeado
    public function miCuenta()
    {
        // Recibo el usuario de session y lo envio al modelo para sacar sus datos
        $datos['usuario'] = $this->usuarios_m->leerUsu($_SESSION['sesion']['username']);
        // Visualizar la pagina de perfil
        $titulo['nombre'] = "Mi cuenta";
        $contenido = "cuenta_v";
        $this->load_view("plantilla/cabecera", $titulo);
        $this->load_view($contenido, $datos);
        $this->load_view("plantilla/pie");
    }
    //perfil_publico carga la vista que muestra el perfil publico de un usuario que se encuentre registrado en la web
    public function perfil_publico($datos)
    {
        if (!$datos[0]) {
            $this->load_view("errorPagina");
        } else {
            $usu = $datos[0];
            // Recibo el usuario y lo envio al modelo para sacar sus datos
            $datos['usuario'] = $this->usuarios_m->leerUsu($usu);
            // // Visualizar la pagina de perfil
            if (!$datos['usuario']) {
                $this->load_view("errorPagina");
            } else {
                $titulo['nombre'] = $datos['usuario']['username'];
                $contenido = "perfil_publico_v";
                $this->load_view("plantilla/cabecera", $titulo);
                $this->load_view($contenido, $datos);
                $this->load_view("plantilla/pie");
            }
        }
    }
    // coleccion carga la vista que muestra las cartas que un usuario tenga guardadas en su coleccion
    public function coleccion($datos)
    {
        if (!$datos[0]) {
            $this->load_view("errorPagina");
        } else {
            $usu = $datos[0];
            // Recibo el usuario y lo envio al modelo para sacar sus datos
            $datos['usuario'] = $this->usuarios_m->leerUsu($usu);
            // // Visualizar la pagina de perfil
            if (!$datos['usuario']) {
                $this->load_view("errorPagina");
            } else {
                $titulo['nombre'] = "Colección de " . $datos['usuario']['username'];
                $contenido = "coleccion_v";
                $this->load_view("plantilla/cabecera", $titulo);
                $this->load_view($contenido, $datos);
                $this->load_view("plantilla/pie");
            }
        }
    }
    // autenticar se encarga de confirmar que las credenciales usadas en el login son correctas
    public function autenticar()
    {
        // recibimos usuario y password y lo enviamos al metodo autenticar del modelo
        $fila = $this->usuarios_m->autenticar($_REQUEST['username'], $_REQUEST['password']);
        if ($fila) {
            $_SESSION['sesion'] = [
                'id_usu' => $fila['id_usu'],
                'username' => $fila['username'],
                'email' => $fila['email']
            ];
            header("location:" . BASE_URL . "Portal_c");
        } else {
            // Si el usuario no existe, retornar al login y dar mensaje de error
            $_SESSION['error'] = "El usuario o la contraseña son incorrectos. Intentalo de nuevo.";
            header("location:" . BASE_URL . "Usuarios_c/login");
        }
    }
    // registro carga la vista asociada al registro de un usuario
    public function registro()
    {
        $titulo['nombre'] = "Regístrate";
        $contenido = "registro_v";
        $this->load_view("plantilla/cabecerasinheader", $titulo);
        $this->load_view($contenido);
    }
    // insertar se encarga de añadir un registro de usuario
    public function insertar()
    {
        // A partir de lo recibido en el REQUEST formaremos los datos que van a la BBDD
        $_REQUEST['nombre_completo'] = $_REQUEST['nombre'] . " " . $_REQUEST['apellido'];
        $_REQUEST['direccion'] = $_REQUEST['calle'] . " " . $_REQUEST['numero'];
        $_REQUEST['fecha_creacion'] = date("Y/m/d");
        // Desechamos las partes que ya no necesitamos de REQUEST
        unset($_REQUEST['apellido']);
        unset($_REQUEST['calle']);
        unset($_REQUEST['numero']);
        unset($_REQUEST['confpassword']);
        $_REQUEST['token'] = md5($_REQUEST['username']);
        // Enviamos los datos al metodo insertar del modelo
        $retorno = $this->usuarios_m->insertar($_REQUEST);
        // Enviar correo al usuario con link para activar cuenta
        //$this->enviarCorreo($_REQUEST['email'], $_REQUEST['nombre_completo'], $_REQUEST['token']);
        $_SESSION['exito'] = "Tu usuario ha sido registrado. En breve recibirás un correo para activar tu cuenta.";
        header("location:" . BASE_URL . "Usuarios_c/login");
    }
    // activarCuenta se encarga de marcar como activada la cuenta que se especifique en la ruta (a este metodo se accede a traves del correo enviado en enviarCorreo)
    public function activarCuenta($par)
    {
        $this->usuarios_m->activarCuenta($par[0]);
        echo "Su cuenta ha sido activada, pulse <a href='" . BASE_URL . "usuarios_c/login'>aquí</a> para continuar";
    }
    // existeUsuario devuelve si existe un usuario o no mediante una llamada AJAX
    public function existeUsuario()
    {
        echo $this->usuarios_m->existeUsuario($_REQUEST);
    }
    // enviarCorreo (metodo deshabilitado actualmente) es el encargado de enviar el correo de activacion para los usuarios una vez se formaliza el registro usando la libreria PHPMailer
    private function enviarCorreo($dest, $nombre, $token)
    {

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;            //Enable verbose debug output
            $mail->isSMTP();                                           //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
            $mail->Username   = 'dario.estevez@educarex.es';                //SMTP username
            $mail->Password   = 'iajsarxrenxlidnt';                    //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('dario.estevez@educarex.es', 'TCGSwap');
            $mail->addAddress($dest, $nombre);     //Add a recipien
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Registro en TCGSwap';
            $mail->Body    = '
            <h3>¡Enhorabuena, te has registrado en TCGSwap!</h3>
            <p>Antes de poder operar en ella, deberás activar tu cuenta mediante el siguiente enlace:</p>
            <p><a href="' . BASE_URL . 'usuarios_c/activarCuenta/' . $token . '">Haga click aqui</a></p>
            ';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
