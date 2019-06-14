<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


switch ($_POST['ajax_action']) {
	case 'get_entidades':
		$entidades = $db->get($_POST['nombre_tabla']);
    
	    if( $entidades ){
	        $json['status'] = 'success';
	        $json['mensaje'] = 'OK';    
	        $json['registros'] = $entidades;
	    } else {
	        $json['status'] = 'error';
	        $json['mensaje'] = $db->getLastError();;   
	    }
	break;


	case 'eliminarCriterio':
		$db->where('id',$_POST['id']);
		if( $db->delete($_POST['criterio']) ){
	        $json['status'] = 'success';
	        $json['mensaje'] = 'OK';    
	    } else {
	        $json['status'] = 'error';
	        $json['mensaje'] = $db->getLastError();;   
	    }
	break;
	
	default:
		break;
}

$json = json_encode($json);
echo $json;

?>