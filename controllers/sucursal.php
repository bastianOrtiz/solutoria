<?php

$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$registros = $db->get("m_sucursal");
$empresas = $db->get("m_empresa");
$comunas = $db->get('m_comuna');
$regiones = $db->get('m_region');

function fnGetRegionSucursal($comuna_id){
    global $db;
    $db->where('id', $comuna_id);
    $id_reg = $db->getOne('m_comuna','region_id');
    return $id_reg['region_id'];
}

function fnNombreEmpresa($id_empresa){
    global $empresas;    
    foreach( $empresas as $e ){
        if( $e['id_empresa'] == $id_empresa ){
            return $e['nombre'];
            break;
        }
    }
}

function fnNombreComuna($id_comuna){
    global $db;    
    $db->where('id', $id_comuna);
    $comuna = $db->getOne('m_comuna','nombre');
    return $comuna['nombre'];
}

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){
        
        $data = Array (
            "nombre" => $nombreSucursal,
            "direccion" => $sucursalDireccion,
            "comuna_id" => $sucursalComuna,
            "empresa_id" => $_SESSION[ PREFIX . 'login_eid']
        );

        if( editarSucursal($sucursal_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'sucursal',$sucursal_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $sucursal_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $sucursal_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarSucursal( $sucursal_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'sucursal',$sucursal_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$sucursal_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la sucursal porque tiene trabajadores asociados&id='.$sucursal_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){                
        
        $data = Array (
            "nombre" => $nombreSucursal,
            "direccion" => $sucursalDireccion,
            "comuna_id" => $sucursalComuna,
            "empresa_id" => $_SESSION[ PREFIX . 'login_eid']
        );
        
        $create_id = crearSucursal($data);
        
        if(!$create_id){
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD'.$db->getLastError().'&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'sucursal',$create_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }
                   
    }      
}

if( $parametros ){
    /** Consultar datos de sucursal **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $sucursal = $db->getOne("m_sucursal");        
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

