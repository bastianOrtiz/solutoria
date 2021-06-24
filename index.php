<?php
error_reporting(0);
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);

@session_start();

/** Includes Comunes para todo el sistema **
=============================================
/** Configuracion **/
include 'libs/config.php';
include 'libs/constantes.php';

/** LIBRERIAS **/
include ROOT . '/libs/class.upload.php';
include ROOT . '/libs/libmail.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

/** ============================================= **/

/** Procesamiento de URL para obtener Entidad, Accion y Parametros  **/
$page_url = @explode('/',$_GET['p']);
$parametros = array(); 
for($i=1; $i<( count($page_url) ); $i++ ){
    if( $page_url[$i] != "" ){
        $parametros[] =  $page_url[$i];
    }
}

$action = @$parametros[0];
$entity = @$page_url[0];

/** Si entidad = "vacio", es INDEX **/
if( $entity == "" )
    $entity = 'dashboard';
    

/** Virificacion de Login de usuario **/
if( ( isset($_SESSION[ PREFIX . 'logged']) ) && ( $_SESSION[ PREFIX . 'logged'] == true )  ){
    
    require( ROOT . '/libs/control_usuarios.php' );
    
    /** Si no esta cargando ninguna entidad por URL: **/
    if( strlen($page_url[0]) > 0 ){        
        if( isset( $page_url[1] ) )
            $id = $page_url[1];    
        
        /** Verifica existencia de la vista **/
        if( ( is_dir('views/' . $entity . '/' ) ) && ( file_exists('views/' . $entity . '/' ) )  ){             
            include ROOT . '/models/' . $entity . '.php';
            include ROOT . '/controllers/' . $entity . '.php';            
        } else {
            echo "NOT FOUND";
        }
            
    } 
    /** Si no se carga ninguna vista, carga Dashboard General **/
    else {
        include ROOT . '/models/dashboard.php';
        include ROOT . '/controllers/dashboard.php';
    }    
} 

/** Si NO está logueado procesa la vista "login" **/
else {
    if($parametros[0] == 'api'){
        $db->where ("user", $_GET['u']);
        $db->where ("password", $_GET['secret']);
        $user = $db->getOne ("m_usuario");
        if( $user ){
            include ROOT . '/public/api/index.php'; 
        } else {
            echo json_encode(['msg'=>'login fail']);
        }
        exit();
    }
    if( $entity == "login_trabajador" ){
        include ROOT . '/models/login_trabajador.php';
        include ROOT . '/controllers/login_trabajador.php'; 
    } else {
        if( $entity != "login" ){
            redirect(BASE_URL . '/login');
        }    
        include ROOT . '/models/login.php';
        include ROOT . '/controllers/login.php';
    }    
}

/** comentario de pruebas desde MAC **/

?>