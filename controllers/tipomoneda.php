<?php

$db->where("id",1,'!=');
$registros = $db->get("m_tipomoneda");
$tipomonedas = $registros;

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){
        $activo = $activoTipomoneda[0];
        $data = Array (
            "nombre" => $nombreTipomoneda,
            "descripcion" => $descTipomoneda,
            "activo" => $activo,
            "empresa_id" => $_SESSION[PREFIX.'login_eid']
        );
        
        if( !in_array($tipomoneda_id, array(1,2)) ){
            $edited = editarTipomoneda($tipomoneda_id, $data);
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'tipomoneda',$tipomoneda_id,$db->getLastQuery() );
        } else {
            $edited = false;
        }
        
        if( $edited ){
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $tipomoneda_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo editar el registro&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $tipomoneda_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        if( !in_array($tipomoneda_id, array(1,2)) ){
            $delete = eliminarTipomoneda( $tipomoneda_id );
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'tipomoneda',$tipomoneda_id,$db->getLastQuery() );
        } else {
            $delete = false;
        }
        if( $delete ){
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$tipomoneda_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la tipomoneda&id='.$tipomoneda_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        $activo = $activoTipomoneda[0];
        $data = Array (
            "nombre" => $nombreTipomoneda,
            "descripcion" => $descTipomoneda,
            "activo" => $activo,
            "empresa_id" => $_SESSION[PREFIX.'login_eid']
        );
        
        $create_id = crearTipomoneda($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'tipomoneda',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de tipomoneda **/
    if( isset($parametros[1]) ){
        if( $parametros[1] == 1 ){
            redirect(BASE_URL.'/'.$entity.'/listar');
            exit();
        }
        $db->where ("id", $parametros[1]);
        $tipomoneda = $db->getOne("m_tipomoneda");        
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

