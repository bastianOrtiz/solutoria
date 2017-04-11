<?php

$db->where('id',$_SESSION[PREFIX.'login_cid']);
$comparte_cargo = $db->getOne('m_cuenta','compartirCargo');
$comparte_cargo['compartirCargo'];

if( $comparte_cargo['compartirCargo'] == 1 ){
    $sql = "
    SELECT C.id, C.nombre, C.descripcion, C.cargoPadreId, C.empresa_id, COUNT( T.cargo_id ) as total
    FROM m_cargo C, m_trabajador T
    WHERE C.empresa_id IN ( SELECT id FROM m_empresa WHERE cuenta_id = " . $_SESSION[PREFIX.'login_cid'] . ")
    AND C.id = T.cargo_id
    AND T.tipocontrato_id NOT IN (3,4)
    AND C.activo = 1
    GROUP BY C.id, C.nombre, C.descripcion, C.cargoPadreId
    ORDER BY C.nombre ASC
    ";
} else {
    $sql = "
    SELECT C.id, C.nombre, C.descripcion, C.cargoPadreId, C.empresa_id, COUNT( T.cargo_id ) as total
    FROM m_cargo C, m_trabajador T
    WHERE C.empresa_id = " . $_SESSION[PREFIX.'login_eid'] . "
    AND C.id = T.cargo_id
    AND T.tipocontrato_id NOT IN (3,4)
    AND C.activo = 1
    GROUP BY C.id, C.nombre, C.descripcion, C.cargoPadreId
    ORDER BY C.nombre ASC
    ";
}

$registros = $db->rawQuery( $sql );
$cargos = $registros;


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

function fnNombreCargo($id_cargo){
    global $cargos;    
    foreach( $cargos as $e ){
        if( $e['id'] == $id_cargo ){
            return $e['nombre'];
            break;
        } else {
            return 'Ninguno';
        }
    }
}

if( $_POST ){
    
    extract($_POST);
    
    if( @$_POST['action'] == 'edit' ){
        $activo = $cargoActivo[0];
        $data = Array (
            "nombre" => $nombreCargo,
            "descripcion" => $descipcionCargo,
            "cargoPadreId" => $cargoPadre,
            "activo" => $activo,
            "empresa_id" => $_SESSION[PREFIX.'login_eid']
        );

        if( editarCargo($cargo_id, $data) ){
            logit( $_SESSION[PREFIX.'login_name'],'editar','cargo',$cargo_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $cargo_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $cargo_id . '/response/' . $response );
            exit();
        }         
    }
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarCargo( $cargo_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],'borrar','cargo',$cargo_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$cargo_id);            
        } else {
            $response = encrypt('status=warning&mensaje=No se pudo eliminar la cargo porque tiene trabajadores asociados&id='.$cargo_id);
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){        
        $activo = $cargoActivo[0];        
        
        $data = Array (
            "nombre" => $nombreCargo,
            "descripcion" => $descipcionCargo,
            "cargoPadreId" => $cargoPadre,
            "activo" => $activo,
            "empresa_id" => $_SESSION[PREFIX.'login_eid']
        );
        
        $create_id = crearCargo($data);
        
        if(!$create_id){
            logit( $_SESSION[PREFIX.'login_name'],'crear','cargo',$create_id,$db->getLastQuery() );
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
    /** Consultar datos de cargo **/
    if( isset($parametros[1]) ){
        $db->where ("id", $parametros[1]);
        $cargo = $db->getOne("m_cargo");        
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

