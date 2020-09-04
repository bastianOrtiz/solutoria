<?php

//show_array(ini_get('max_input_vars'));

global $db;
$id_empresa = $_SESSION[PREFIX.'login_eid'];
$nombre_empresa = $_SESSION[PREFIX.'login_empresa'];

$revisor = [];

if( $_POST ){

    if( @$_POST['action'] == 'enviarEmpleados' ){
        crearTxt($_POST);
    }
    
    if( @$_POST['action'] == 'new' ){        
                   
    }    


    if( $_POST['action'] == 'upload_previred' ){

        $upload = upload_doc('archivo_previred',ROOT.'/private/uploads/docs/');

        if( $upload['status'] == true ){
            
            $lines = file(ROOT.'/private/uploads/docs/' . $upload['filename']);
            unlink(ROOT.'/private/uploads/docs/' . $upload['filename']);

            foreach ($lines as $line) {
                $revisor[] = $line;
            }
        }
    }

}   

if( $parametros ){
    if ($_POST) {
        $empleados = buscarEmpleados($id_empresa, $_POST['mesAtraso'], $_POST['anoAtraso']);
    }
    $periodoDesde = getMesMostrarCorte().getAnoMostrarCorte(); 
    $periodoHasta = getMesMostrarCorte().getAnoMostrarCorte();
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

