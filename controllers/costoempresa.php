<?php
if( $_POST ){    
    extract($_POST);
        
    if( $action == 'new' ){
        $data = array(
            'costoempresa_id' => $costoempresa,
            'valor' => $valorCostoEmpresa,
            'mes' => $mesCostoEmpresa,
            'ano' => $anoCostoEmpresa
        );
        
        $create_id = crearCostoEmpresa($data);
        logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'costoEmpresa',$create_id,$db->getLastQuery() );
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');            
        } else {
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);                            
        }
        
        redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
        exit();        
    }      
}

if( $parametros ){
    
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

