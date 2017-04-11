<?php


$db->where('id',$_SESSION[PREFIX.'login_cid']);
$comparte_cargo = $db->getOne('m_cuenta','compartirCargo');
$comparte_cargo['compartirCargo'];

if( $comparte_cargo['compartirCargo'] == 1 ){
    $registros = $db->rawQuery('SELECT * from m_centrocosto where empresa_id IN ( SELECT id FROM m_empresa WHERE cuenta_id = '.$_SESSION[PREFIX.'login_cid'].') ');
    $centrocostos = $registros;    
} else {
    $registros = $db->rawQuery("SELECT * FROM m_centrocosto WHERE empresa_id = " . $_SESSION[PREFIX.'login_eid'] );
    $centrocostos = $registros;
}

$empresas = $db->get("m_empresa");

function fnNombreEmpresa($id_empresa){
    global $empresas;    
    foreach( $empresas as $e ){
        if( $e['id_empresa'] == $id_empresa ){
            return $e['nombre'];
            break;
        }
    }
}

if( $_POST ){
    
    extract($_POST);        
    
    if( @$_POST['action'] == 'edit' ){
        $activo = $centrocostoActivo[0];
        $data = Array (
            "nombre" => $nombreCentrocosto,
            "empresa_id" => $_SESSION[ PREFIX . 'login_eid']
        );

        if( editarCentrocosto($centrocosto_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$action,'centrocosto',$centrocosto_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$centrocosto_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $centrocosto_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$centrocosto_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $centrocosto_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarCentrocosto( $centrocosto_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'centrocosto',$centrocosto_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$centrocosto_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la centrocosto porque tiene trabajadores asociados&id='.$centrocosto_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        $activo = $centrocostoActivo[0];        
        
        $data = Array (
            "nombre" => $nombreCentrocosto,
            "empresa_id" => $_SESSION[ PREFIX . 'login_eid']
        );
        
        $create_id = crearCentrocosto($data);
        
        if(!$create_id){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'centrocosto',$create_id,$db->getLastQuery() );
            $response = encrypt('status=warning&mensaje=Hubo un error creando el registro en la BD&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();                
        }
                   
    }
    
          
}

if( $parametros ){
    /** Consultar datos de centrocosto **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $centrocosto = $db->getOne("m_centrocosto");        
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

