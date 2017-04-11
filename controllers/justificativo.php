<?php

$registros = $db->get("m_justificativo");
$justificativos = $registros;

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){
        
        $tipo = $justificativoTipo[0];
        $data = Array (
            "nombre" => $nombreJustificativo,            
            "tipo" => $tipo,
            "cuenta_id" => $_SESSION[PREFIX.'login_cid']
        );

        if( editarJustificativo($justificativo_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'Justificativo',$justificativo_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $justificativo_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $justificativo_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarJustificativo( $justificativo_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'Justificativo',$justificativo_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$justificativo_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la justificativo porque tiene trabajadores asociados&id='.$justificativo_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        
        $tipo = $justificativoTipo[0];
        $data = Array (
            "nombre" => $nombreJustificativo,            
            "tipo" => $tipo,
            "cuenta_id" => $_SESSION[PREFIX.'login_cid']
        );
        
        $create_id = crearJustificativo($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'Justificativo',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de justificativo **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $justificativo = $db->getOne("m_justificativo");        
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

