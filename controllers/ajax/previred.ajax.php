<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


switch ($_POST['action']) {
	case 'create_new_revisor':
		sleep(1);
	    $db->delete('m_previred_paso');

	    $json['status'] = 'OK';
	    $json['mensaje'] = 'registros borrados';
		break;

	case 'save_row':

		$rut = $_POST['rut'];
		$dv = $_POST['dv'];

		$line_data = $_POST['apellido_paterno'] . 
		$_POST['apellido_materno'] . 
		$_POST['nombres'] . 
		$_POST['sexo'] . 
		$_POST['extranjero'] . 
		$_POST['tipo_pago'] . 
		$_POST['periodo_desde'] . 
		$_POST['periodo_hasta'] . 
		$_POST['regimen_prev'] . 
		$_POST['tipo_trabajador'] . 
		$_POST['dias_trabajados'] . 
		$_POST['tipo_linea'] . 
		$_POST['cod_mov_personal'] . 
		$_POST['fecha_desde'] . 
		$_POST['fecha_hasta'] . 
		$_POST['tramo_asig_fam'] . 
		$_POST['nro_cargas_simples'] . 
		$_POST['nro_cargas_maternales'] . 
		$_POST['nro_cargas_invalidas'] . 
		$_POST['asig_familiar'] . 
		$_POST['asig_familiar_retro'] . 
		$_POST['reintegro_cargas_fam'] . 
		$_POST['solicitud_trabajador_joven'] . 
		$_POST['codigo_afp'] . 
		$_POST['renta_imponible_afp'] . 
		$_POST['cotizacion_obligatoria_afp'] . 
		$_POST['cotizacion_sis'] . 
		$_POST['apv_afp'] . 
		$_POST['renta_imponible_sust_afp'] . 
		$_POST['tasa_pactada_sust'] . 
		$_POST['aporte_indem_sust'] . 
		$_POST['nro_periodo_sust'] . 
		$_POST['periodo_desde_sust'] . 
		$_POST['periodo_hasta_sust'] . 
		$_POST['puesto_trabajo_pesado'] . 
		$_POST['percent_cotizac_trabajo_pesado'] . 
		$_POST['cotizacion_trabajo_pesado'] . 
		$_POST['codigo_inst_apvi'] . 
		$_POST['nro_contrato_apvi'] . 
		$_POST['forma_pago_apvi'] . 
		$_POST['cotizacion_apvi'] . 
		$_POST['cotizacion_depositos_convencidos'] . 
		$_POST['cod_inst_autorizada_apvc'] . 
		$_POST['nro_contrato_apvc'] . 
		$_POST['forma_de_pago_apvc'] . 
		$_POST['cotizacion_trabajador_apvc'] . 
		$_POST['cotizacion_empleador_apvc'] . 
		$_POST['rut_afiliado_voluntario'] . 
		$_POST['dv_afiliado_voluntario'] . 
		$_POST['apellido_paterno_af_voluntario'] . 
		$_POST['apellido_materno_af_voluntario'] . 
		$_POST['nombres_af_voluntario'] . 
		$_POST['codigo_movimiento_de_personal'] . 
		$_POST['fecha_desde_movimiento'] . 
		$_POST['fecha_hasta_movimiento'] . 
		$_POST['codigo_de_la_afp'] . 
		$_POST['monto_capitalizacion_voluntaria'] . 
		$_POST['monto_ahorro_voluntario'] . 
		$_POST['numero_de_periodos_de_cotizacion'] . 
		$_POST['codigo_ex_caja_regimen'] . 
		$_POST['tasa_cotizacion_ex_cajas_de_prevision'] . 
		$_POST['renta_imponible_ips'] . 
		$_POST['cotizacion_obligatoria_ips'] . 
		$_POST['renta_imponible_desahucio'] . 
		$_POST['codigo_ex_caja_regimen_desahucio'] . 
		$_POST['tasa_cotizac_desahucio_ex_cajas_prevision'] . 
		$_POST['cotizacion_desahucio'] . 
		$_POST['cotizacion_fonasa'] . 
		$_POST['cotizacion_acc__trabajo_isl'] . 
		$_POST['bonificacion_ley_15_386'] . 
		$_POST['descuento_por_cargas_familiares_isl'] . 
		$_POST['bonos_de_gobierno'] . 
		$_POST['codigo_institucion_de_salud'] . 
		$_POST['numero_de_fun'] . 
		$_POST['renta_imponible_isapre'] . 
		$_POST['moneda_del_plan_pactado_isapre'] . 
		$_POST['cotizacion_pactada'] . 
		$_POST['cotizacion_obligatoria_isapre'] . 
		$_POST['cotizacion_adicional_voluntaria'] . 
		$_POST['monto_ges_futuro'] . 
		$_POST['codigo_ccaf'] . 
		$_POST['renta_imponible_ccaf'] . 
		$_POST['creditos_personales_ccaf'] . 
		$_POST['dscto_dental_ccaf'] . 
		$_POST['dsctos_por_leasing'] . 
		$_POST['dsctos_por_seguro_de_vida_ccaf'] . 
		$_POST['otros_descuentos_ccaf'] . 
		$_POST['cotizac_a_ccaf_no_afiliados_isapres'] . 
		$_POST['descuento_cargas_familiares_ccaf'] . 
		$_POST['otros_descuentos_ccaf_1_futuro'] . 
		$_POST['otros_descuentos_ccaf_2_futuro'] . 
		$_POST['bonos_gobierno_futuro'] . 
		$_POST['codigo_de_sucursal_futuro'] . 
		$_POST['codigo_mutualidad'] . 
		$_POST['renta_imponible_mutual'] . 
		$_POST['cotizacion_mutual'] . 
		$_POST['sucursal_para_pago_mutual'] . 
		$_POST['renta_imp_seguro_cesantia'] . 
		$_POST['aporte_trabajador_seguro_cesantia'] . 
		$_POST['aporte_empleador_seguro_cesantia'] . 
		$_POST['rut_pagadora_subsidio'] . 
		$_POST['dv_pagadora_subsidio'] . 
		$_POST['ccosots_suc_agencia_obra_region'];

		$db->where ('rut', $rut);
		$db->where ('dv', $dv);
		$db->where ('linea', $_POST['linea']);
		
		$data_update = [
			'data' => $line_data
		];

		if($db->update ('m_previred_paso', $data_update)){
			$json['status'] = 'OK';
	    	$json['mensaje'] = 'UPDATED';
		} else {
			$json['status'] = 'ERROR';
	    	$json['mensaje'] = 'ERROR UPDATED';
		}

		break;
	
	default:
		# code...
		break;
}


$json = json_encode($json);
echo $json;

?>