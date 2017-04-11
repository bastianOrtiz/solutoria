<?php

$db->where('id',$_SESSION[PREFIX.'login_cid']);
$comparte_cargo = $db->getOne('m_cuenta','compartirCargo');
$comparte_cargo['compartirCargo'];

if( $comparte_cargo['compartirCargo'] == 1 ){
    $registros = $db->rawQuery('SELECT * from m_departamento where empresa_id IN ( SELECT id FROM m_empresa WHERE cuenta_id = '.$_SESSION[PREFIX.'login_cid'].') ');        
} else {
    $registros = $db->rawQuery("SELECT * FROM m_departamento WHERE empresa_id = " . $_SESSION[PREFIX.'login_eid'] );
}


function fnNombreEmpresa($id_empresa){
    global $db;    
    $db->where('id', $id_empresa);
    $empresa = $db->getOne('m_empresa','nombre');
    return $empresa['nombre'];    
}

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){
        $activo = $departamentoActivo[0];
        $data = Array (
            "nombre" => $nombreDepartamento,
            "activo" => $activo,
            "empresa_id" => $_SESSION[ PREFIX . 'login_eid' ]
        );

        if( editarDepartamento($departamento_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'departamento',$departamento_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $departamento_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $departamento_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarDepartamento( $departamento_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'departamento',$departamento_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$departamento_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la departamento porque tiene trabajadores asociados&id='.$departamento_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        $activo = $departamentoActivo[0];        
        
        $data = Array (
            "nombre" => $nombreDepartamento,
            "activo" => $activo,
            "empresa_id" => $_SESSION[ PREFIX . 'login_eid' ]
        );
        
        $create_id = crearDepartamento($data);
        
        if(!$create_id){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'departamento',$create_id,$db->getLastQuery() );
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
    /** Consultar datos de departamento **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $departamento = $db->getOne("m_departamento");        
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

