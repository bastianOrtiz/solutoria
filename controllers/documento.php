<?php
$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$registros = $db->get("m_documento");
$documentos = $registros;

if( $_POST ){
    
    extract($_POST);
        
    if( $action == 'edit' ){ 
        
        $docImprimir = $docImprimir[0];
        $docGuardar = $docGuardar[0];
        
        $data = Array (
            'nombre' => $nombreDocumento,            
            'texto' => htmlentities($textoDocumento),
            'activo' => 1,
            'empresa_id' => $_SESSION[PREFIX.'login_eid']
        );

        if( editarDocumento($documento_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'documento',$documento_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$documento_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $documento_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$documento_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $documento_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarDocumento( $documento_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'documento',$documento_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$documento_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la documento porque tiene trabajadores asociados&id='.$documento_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$action == 'new' ){
        $docImprimir = $docImprimir[0];
        $docGuardar = $docGuardar[0];
        $data = Array (
            'nombre' => $nombreDocumento,            
            'texto' => htmlentities($textoDocumento),
            'activo' => 1,
            'empresa_id' => $_SESSION[PREFIX.'login_eid']
        );
        
        $create_id = crearDocumento($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'documento',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$create_id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de documento **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $documento = $db->getOne("m_documento");        
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

