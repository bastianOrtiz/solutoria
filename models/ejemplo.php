<?php  

function insidencias($tipo,$trabajador_id, $super_arreglo){
	if( $tipo == "apv" ){
		// proceso
		return $arreglo['cont','data'];
	}

	if( $tipo == "ausencia" ){
		// proceso
		return $arreglo['cont','data'];
	}

	if( $tipo == "afp" ){
		// proceso
		return $arreglo['cont','data'];
	}


}


$arr_trabajadores_con_incidencia = [];

foreach( $trabajadores as $trab_id ){

	fwrite(nombre);
	fwrite(rut);
	fwrite(linea_principal);

	$ausencias = insidencias('ausencia',$trab_id);

	if( $ausencias['count'] > 1 ){

		$indice = 0;
		foreach ($ausencias['data'] as $data) {
			if( $indice > 0 ){
				$arr_trabajadores_con_incidencia[] = [
					'trabajador_id' = $trab_id,
					'tipo_incidencia' = 'ausencia',
					'data' = $ausencias['data']
				];
			}

		$indice++;
		}
		
		fwrite( $ausencias['data'][0] );
	} else if( $ausencias['count'] == 1 ) {
		fwrite( $ausencias['data'][0] );
	} else {
		fwrite(0);
	}

	fwrite(otrawea);
	fwrite(otrawea);
	fwrite(otrawea);


	$apv = insidencias('apv',$trab_id);

	if( $apv['count'] > 1 ){

		$indice = 0;
		foreach ($apv['data'] as $data) {
			if( $indice > 0 ){
				$arr_trabajadores_con_incidencia[] = [
					'trabajador_id' = $trab_id,
					'tipo_incidencia' = 'ausencia',
					'data' = $apv['data']
				];
			}

		$indice++;
		}
		
		fwrite( $apv['data'][0] );

	}  else if( $apv['count'] == 1 ) {
		
		fwrite( $apv['data'][0] );

	} else {
		fwrite(0);
	}

	...... etc


}


// Recorre TODAS las adicionales

foreach ($arr_trabajadores_con_incidencia as $trab_incidencia) {
	$sql = "select * from m_trabajador where id = " . $trab_incidencia['trabajador_id'];
	fwrite(nombre);
	fwrite(rut);
	fwrite(linea_adicional);

	if( $trab_incidencia['tipo_incidencia'] == 'ausencia' ){
		fwrite($trab_incidencia['data']['fecha_inicio']);
		fwrite($trab_incidencia['data']['fecha_fin']);
	}

	if( $trab_incidencia['tipo_incidencia'] == 'apv' ){
		fwrite($trab_incidencia['data']['institucion']);
		fwrite($trab_incidencia['data']['monto']);
	}

	fwrite(0);
	fwrite(0);
	fwrite(0);

}

?>