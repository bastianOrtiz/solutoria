<?php

function convertToName($entidad,$id_or_table){
	$arr_entidades = [
		'origen' => [
			'liquidacion' => 'Liquidacion',
			'l_haber' => 'Haberes',
			'l_descuento' => 'Descuentos',
			'l_apv' => 'APV'
		],
		'tipo_criterio' => ['','Criterio x CCosto','Criterio x Entidad','Criterio x Individual']
	];

	return $arr_entidades[$entidad][$id_or_table];
}


function getNombreCriterio($idCriterio, $tipoCriterio){
	
	global $db;

	$table_criterio = ['','c_crixccostos','c_crixentidad','c_crixindividual'];

	$db->where('id',$idCriterio);
	$criterio = $db->getValue($table_criterio[$tipoCriterio],'criterio');

	return $criterio;
}


?>