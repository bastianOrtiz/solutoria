<?php

function getNombreEntidad($id,$tabla){
	global $db;
	if( $tabla != "fonasa" ){
	    $db->where('id',$id);
	    $dpto = $db->getOne($tabla,'nombre');
	    return $dpto['nombre']; 
	} else {
		return 'FONASA';
	}
}


function getTipoEntidad($tabla){
	if( $tabla == 'fonasa' ){
		return 'SALUD';
	} else {
		$arr = [
			'm_afp' => 'AFP',
			'm_isapre' => 'Isapre',
			'm_institucion' => 'Instituciones Aseguradoras'
		];

		return $arr[$tabla];
	}
}


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