<?php
$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$registros = $db->get("m_contrato");
$contratos = $registros;

if( $_POST ){
    
    extract($_POST);
    
    if( $action == 'edit' ){        
        $data = Array (
            'nombre' => $nombreContrato,
            'descripcion' => $descripcionContrato,
            'texto' => htmlentities($textoContrato),
            'activo' => $estadoContrato,
            'empresa_id' => $_SESSION[PREFIX.'login_eid']
        );

        if( editarContrato($contrato_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'contrato',$contrato_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$contrato_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $contrato_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$contrato_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $contrato_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarContrato( $contrato_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'contrato',$contrato_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$contrato_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la contrato porque tiene trabajadores asociados&id='.$contrato_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$action == 'new' ){
        $data = Array (
            'nombre' => $nombreContrato,
            'descripcion' => $descripcionContrato,
            'texto' => htmlentities($textoContrato),
            'activo' => $estadoContrato,
            'empresa_id' => $_SESSION[PREFIX.'login_eid']
        );
        
        $create_id = crearContrato($data);
        
        if(!$create_id){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'contrato',$create_id,$db->getLastQuery() );
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de contrato **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $contrato = $db->getOne("m_contrato");        
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

