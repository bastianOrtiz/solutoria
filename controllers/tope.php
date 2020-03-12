<?php

$registros = $db->get("m_tope");

$db->where('tipomoneda_id',2);
$db->orderBy('ano','DESC');
$db->orderBy('mes','DESC');
$valor_uf = $db->getOne("m_tipomonedavalor");

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){
        
        $data = Array (
            "nombre" => $nombreTope,
            "direccion" => $topeDireccion,
            "comuna_id" => $topeComuna,
            "empresa_id" => $_SESSION[ PREFIX . 'login_eid']
        );

        if( editarTope($tope_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'tope',$tope_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $tope_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $tope_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarTope( $tope_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'tope',$tope_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$tope_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la tope porque tiene trabajadores asociados&id='.$tope_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){                
        
        $data = Array (
            "nombre" => $nombreTope,
            "direccion" => $topeDireccion,
            "comuna_id" => $topeComuna,
            "empresa_id" => $_SESSION[ PREFIX . 'login_eid']
        );
        
        $create_id = crearTope($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD'.$db->getLastError().'&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'tope',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de tope **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $tope = $db->getOne("m_tope");        
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

