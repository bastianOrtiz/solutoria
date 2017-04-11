<?php

$registros = $db->get("m_institucion");
$institucions = $registros;

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){        
        $data = Array (
            "nombre" => $nombreInstitucion,
            "activo" => $estadoInstitucion
        );

        if( editarInstitucion($institucion_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'institucion',$institucion_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $institucion_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $institucion_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarInstitucion( $institucion_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'institucion',$institucion_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$institucion_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la institucion porque tiene trabajadores asociados&id='.$institucion_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        $data = Array (
            "nombre" => $nombreInstitucion,
            "activo" => $estadoInstitucion
        );
        
        $create_id = crearInstitucion($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'institucion',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de institucion **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $institucion = $db->getOne("m_institucion");        
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

