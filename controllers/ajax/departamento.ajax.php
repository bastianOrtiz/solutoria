<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


$departamentos = $db->get("m_departamento");
$empresas = $db->get("m_empresa");

function fnNombreEmpresa($id_empresa){
    global $empresas;    
    foreach( $empresas as $e ){
        if( $e['id'] == $id_empresa ){
            return $e['nombre'];
            break;
        }
    }
}

function fnNombreDepartamento($id_departamento){
    global $departamentos;    
    foreach( $departamentos as $e ){
        if( $e['id'] == $id_departamento ){
            return $e['nombre'];
            break;
        } else {
            return 'Ninguno';
        }
    }
}


if( $_POST['action'] == 'detalle' ){
    
    $db->where ("id", $regid);
    $departamento = $db->getOne("m_departamento");
    
    if( $departamento ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';    
        $json['titulo'] = $departamento['nombre'];
        
        $json['registros'] = array(
            "Nombre" => $departamento['nombre'],            
            "Activo" => booleano($departamento['activo']),
            "Empresa" => fnNombreEmpresa($departamento['empresa_id'])
        );
    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }     
    
    
    
    
}

$json = json_encode($json);
echo $json;

?>