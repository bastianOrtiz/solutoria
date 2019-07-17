<?php

function convertToName($entidad,$id){
	$arr_entidades = [
		'origen' => ['','Liquidacion','Haberes','Descuentos','APV'],
		'tipo_criterio' => ['','Criterio x CCosto','Criterio x Entidad','Criterio x Individual']
	];

	return $arr_entidades[$entidad][$id];
}

?>