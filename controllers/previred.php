<?php

$id_empresa = $_SESSION[PREFIX.'login_eid'];
$nombre_empresa = $_SESSION[PREFIX.'login_empresa'];

if( $_POST ){
    if( @$_POST['action'] == 'enviarEmpleados' ){
        crearTxt($_POST);
    }
    
    if( @$_POST['action'] == 'new' ){        
                   
    }      
}

if( $parametros ){
    $empleados = buscarEmpleados($id_empresa);
    $periodoDesde = date("m").date("Y");
    $periodoHasta = date("m").date("Y");
}

include ROOT . '/views/comun/header.php';
include ROOT . '/views/comun/menu_top.php';
include ROOT . '/views/comun/menu_sidebar.php';

if( isset($parametros[0]) ){
    if( file_exists(ROOT . '/views/' . strtolower($entity) . '/' . $parametros[0] . '.php') ){
        include ROOT . '/views/' . $entity . '/' . $parametros[0] . '.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> Not Found </h2> </section></div>';
    }
} else {
    if( file_exists( ROOT . '/views/' . strtolower($entity) . '/dashboard.php') ){
        include ROOT . '/views/' . $entity .  '/dashboard.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> '. strtoupper($entity) .' </h2> </section></div>';
    }    
}

include ROOT . '/views/comun/footer.php';

?>

