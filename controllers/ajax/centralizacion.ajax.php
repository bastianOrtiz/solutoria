<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


switch ($_POST['ajax_action']) :
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


	case 'get_campos':
		$json['tabla'] = $_POST['tabla'];
		switch ($_POST['tabla']) {
			case 'liquidacion':
				$json['campos'] = ['diaAusencia','diaLicencia','sueldoBase','gratificacion','horaExtra','horaExtraMonto','horaExtraFestivo','horaExtraFestivoMonto','horaAtraso','horaAtrasoMonto','semanaCorrida','totalImponible','totalNoImponible','remuneracionTributable','afp_id','afpMonto','afpPorcentaje','isapre_id','saludMonto','isaprePactado','monedaIsaprePactado','afcMonto','apvMonto','cuenta2Id','cuenta2Monto','descuentoPrevisional','totalTributable','impuestoTotal','impuestoRebajar','impuestoPagar','impuestoAgricola','totalDescuento','alcanceLiquido','totalPagar','topeAfc','rentaNoGravada','sis','sces'];
				break;
			
			case 'l_haber':
				$json['campos'] = ['haber_id','glosa', 'monto', 'cuotaActual', 'cuotaTotal', 'imponible'];
				break;
			
			case 'l_descuento':
				$json['campos'] = ['descuento_id','glosa', 'monto', 'cuotaActual', 'cuotaTotal', 'imponible'];
				break;
			
			case 'l_apv':
				$json['campos'] = ['institucion_id', 'monto', 'tipo'];
				break;
			
			default:
				$json['tabla'] = '';
				$json['campos'] = [];
				break;
		}
	break;

	case 'get_criterios':
		switch ($_POST['tipo_criterio']) {
			case 1:
				$table = 'c_crixccostos';
				break;
			case 2:
				$table = 'c_crixentidad';
				break;
			case 3:
				$table = 'c_crixindividual';
				break;
		}


		$criterios = $db->get($table,null,['id','criterio']);
    
	    if( $criterios ){
	        $json['status'] = 'success';
	        $json['mensaje'] = 'OK';    
	        $json['criterios'] = $criterios;
	    } else {
	        $json['status'] = 'error';
	        $json['mensaje'] = $db->getLastError();;   
	    }
	break;

		
	default:
		break;
endswitch;

$json = json_encode($json);
echo $json;

?>