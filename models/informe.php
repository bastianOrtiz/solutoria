<?php


function getInfoSueldos($ano, $mes, $trabajador_id){
    global $db;
    
    $array_data = array();
    
    $super_sql = "
    SELECT ( remuneracionTributable - totalNoImponible ) as sueldo, ( ( totalImponible * 0.07 ) + afpMonto + afcMonto ) as prevision, impuestoPagar
    
    FROM liquidacion
    WHERE trabajador_id = $trabajador_id
    and mes = $mes
    and ano = $ano
    ";        
    $resul = $db->rawQuery($super_sql);
    $resul = $resul[0];
        
    $sql_asignaciones = "
    select SUM( monto ) as rentaNoGravada
    FROM l_haber LH, liquidacion L, m_trabajador T
    where LH.liquidacion_id = L.id
    AND L.trabajador_id = T.id
    AND LH.haber_id IN ( select id from m_haber WHERE m_haber.asignacion = 1 )
    AND LH.liquidacion_id IN ( SELECT id FROM liquidacion L WHERE L.mes = $mes AND L.ano = $ano AND L.trabajador_id = $trabajador_id )        
    ";
    $resul_asignaciones = $db->rawQuery($sql_asignaciones);    

    
    $db->where('mes',$mes);
    $db->where('ano',$ano);
    $factor = $db->getValue('m_factormonetario','factor');
    
    
    $array_data['col1'] = round($resul['sueldo']);
    $array_data['col2'] = round($resul['prevision']);
    $array_data['col3'] = round( $resul['sueldo'] - $resul['prevision'] );
    $array_data['col4'] = round($resul['impuestoPagar']);
    $array_data['col5'] = round($resul_asignaciones[0]['rentaNoGravada']);
    $array_data['col6'] = $factor;
    $array_data['col7'] = round( ( $resul['sueldo'] - $resul['prevision'] ) * $factor );
    $array_data['col8'] = round( $resul['impuestoPagar'] * $factor );
    $array_data['col9'] = round( $resul_asignaciones[0]['rentaNoGravada'] * $factor );    
    
    return $array_data;
}


function getAusencia($trabajador_id, $fecha, $ids_ausencia = array() ){    
    global $db;
    
    $sql = "
    SELECT * FROM t_ausencia 
    WHERE  fecha_inicio <= '$fecha'  
    AND fecha_fin >=  '$fecha'  
    AND trabajador_id = '$trabajador_id'    
    ";
    
    if( count($ids_ausencia) > 0 ){
        $ausencias_ids = "";
        foreach( $ids_ausencia as $id ){
            $ausencias_ids .= $id.',';
        }    
        $ausencias_ids = trim($ausencias_ids,",");
        $sql .= "
        AND ausencia_id IN ($ausencias_ids)
        ";    
    }
        
    $res_check = $db->rawQuery($sql);
    $res_check = $res_check[0];        
    
    if( ! $res_check ){
        $res_check['stat'] = false;        
    } else {
        $res_check['stat'] = true;        
    }
    
    return $res_check;        
}


function sumaMes($fechaOriginal,$cuantosMeses){
    $fecha = date($fechaOriginal);
    $nuevafecha = strtotime ( "+$cuantosMeses month" , strtotime ( $fecha ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
     
    return $nuevafecha;
}

function getAlcanceLiquido( $trabajador_id,$mes,$ano ){
    global $db;
    $alcanceLiquido = 0;
    $db->where('trabajador_id',$trabajador_id);
    $db->where('mes',$mes);
    $db->where('ano',$ano);
    $totalCosto = $db->get('liquidacion',1, array('remuneracionTributable', 'totalNoImponible', 'totalImponible'));
    $totalImponible = $totalCosto[0]['totalImponible']; 
    
    
    $db->where('id',$trabajador_id);
    $tipoContrato = $db->getValue('m_trabajador','tipocontrato_id');
    
    
    $db->where('mes',$mes);
    $db->where('ano',$ano);
    $db->orderBy('costoempresa_id', 'ASC');
    $costosEmpresa = $db->get('m_costoempresa');
    
    
    $factor_costo_sis = ( $costosEmpresa[0]['valor'] / 100 );
    $factor_costo_achs = ( $costosEmpresa[1]['valor'] / 100 );
    
    if( $tipoContrato == 1 ){
        $factor_costo_afc = ( $costosEmpresa[2]['valor'] / 100 );
    } else {
        $factor_costo_afc = ( $costosEmpresa[3]['valor'] / 100 );
    }
    
    $totalCostosEmpresa = ( ( $totalImponible * $factor_costo_sis ) + ( $totalImponible * $factor_costo_achs ) + ( $totalImponible * $factor_costo_afc ) );
    $alcanceLiquido = ( $totalCosto[0]['remuneracionTributable'] + $totalCosto[0]['totalNoImponible'] + $totalCostosEmpresa );
    
    return  $alcanceLiquido;        
}

function marcoAtrasado( $trabajador_id, $horario_id, $checktime ){
    global $db;
    $db->where('id',$horario_id);
    $horario_entrada_db = $db->getValue('m_horario','entradaTrabajo');
    $arr_checktime = explode(" ",$checktime);    
    $horario_entrada_marcado = $arr_checktime[1]; 
        
        
    $entrada = strtotime( $horario_entrada_db );
    $marcado = strtotime( $horario_entrada_marcado );
    $entrada_mas_5min = strtotime ( '+' . MINUTOS_GRACIA_CARTA_AMONESTACION . ' minute' , $entrada ) ;
    
    if( $marcado > $entrada_mas_5min ) {
        return true;
    } else {
        return false;
    }
}

function fotoEmpresa($eid){
    global $db;
    $db->where('id',$eid);
    $foto = $db->getValue('m_empresa','foto');    

    return $foto;
}

function value($col_name,$col_value){
    $ret = '';
    switch( $col_name ){
        case 'sexo': $ret = fnSexo($col_value); break;        
        case 'idNacionalidad': 
            if($col_value == 1) { $col_value = 46; } 
            $ret = fnGetNombre($col_value,'m_pais',0); break;
        case 'marcaTarjeta': 
        case 'gratificacion':
            $ret = booleano($col_value); break;
        case 'cargo_id': $ret = fnGetNombre($col_value,'m_cargo',0); break;
        case 'departamento_id': $ret = fnGetNombre($col_value,'m_departamento',0); break;
        case 'comuna_id': $ret = fnGetNombre($col_value,'m_comuna',0); break;
        case 'tipocontrato_id': $ret = fnGetNombre($col_value,'m_contrato',0); break;          
        default: $ret = $col_value; break;
    }
    
    return $ret;
    
    
}

?>
