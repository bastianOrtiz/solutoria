<?php

$registros = $db->get("m_semanacorrida");
$semanacorridas = $registros;

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){
        $data = Array (
            "mes" => $mesSemanacorrida,
            "ano" => $anoSemanacorrida,
            "diasHabiles" => $diasHabilesSemanacorrida,
            "domingosFestivos" => $festivosSemanacorrida
        );

        if( editarSemanacorrida($semanacorrida_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'semanacorrida',$semanacorrida_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $semanacorrida_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $semanacorrida_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarSemanacorrida( $semanacorrida_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'semanacorrida',$semanacorrida_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$semanacorrida_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la semanacorrida porque tiene trabajadores asociados&id='.$semanacorrida_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        
        $data = Array (
            "mes" => $mesSemanacorrida,
            "ano" => $anoSemanacorrida,
            "diasHabiles" => $diasHabilesSemanacorrida,
            "domingosFestivos" => $festivosSemanacorrida
        );
        
        $create_id = crearSemanacorrida($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'semanacorrida',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de semanacorrida **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $semanacorrida = $db->getOne("m_semanacorrida");    
    }
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

