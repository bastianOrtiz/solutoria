<?php
@session_start();
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);

if( $action == 'generate_carta' ){
    $_SESSION[PREFIX.'carta_amonestacion'] = $id;
    $json['id'] = str_replace("#","",$id);
}

if( $action == 'resumen_anual' ){
    
    $sql = "
    SELECT MA.nombre, SUM( DATEDIFF( date(TA.fecha_fin), date(TA.fecha_inicio) ) + 1 ) AS total_dias 
    FROM t_ausencia TA, m_ausencia MA
    WHERE TA.ausencia_id = MA.id
    AND TA.trabajador_id = $trabajador_id
    AND year( TA.fecha_inicio ) = '$ano'
    GROUP BY MA.nombre
    ";
    $ausencias_resumen = $db->rawQuery( $sql );   
    
    $json['sql'] = $sql;
    
    if ($db->count > 0){        
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';
        foreach( $ausencias_resumen as $t ){
            $json['registros'][] = array(
                'nombre' => $t['nombre'],
                'total_dias' => $t['total_dias']
            );
        }
    } else {
        $json['status'] = 'no_reg';
        $json['mensaje'] = 'NO HAY REGISTROS';
    }
    
    
    $db->where("id",$_SESSION[PREFIX.'login_eid']);
    $umbral = $db->getValue('m_empresa','umbralRelojControl');
    
    $db->where('id',$trabajador_id);
    $trabajador = $db->getOne('m_trabajador');
    $nombre_completo = $trabajador['apellidoPaterno'] . ' ' . $trabajador['apellidoMaterno'] . ' ' . $trabajador['nombres'];
    $reloj_control_id = $trabajador['relojcontrol_id'];
    
    $db->where('id',$trabajador_id);
    $horario_id = $db->getValue('m_trabajador','horario_id');
    
    $db->where('id',$horario_id);
    $horario_entrada = $db->getValue('m_horario','entradaTrabajo');
    
    if( marcaTarjeta($trabajador_id) ){
        $sql_atrasos = "
        SELECT count(*) as total_atrasos FROM `m_relojcontrol` 
        WHERE `userid` = $reloj_control_id 
        AND time(checktime) > '$horario_entrada'
        AND time(checktime) < '$umbral'
        AND date(checktime) >= '$ano-01-01'
        AND date(checktime) <= '$ano-12-31'
        ";
        
        $res_total_atrasos = $db->rawQuery( $sql_atrasos );
        $total_atrasos = $res_total_atrasos[0]['total_atrasos'];        
        $json['total_atrasos'] = $res_total_atrasos[0]['total_atrasos'];
        
        $date1 = new DateTime("$ano-01-01");
        $date2 = new DateTime( $ano . '-' . date('m-d'));
        $interval = $date1->diff($date2);
        
        $dias_no_habiles = diasNoLaborales("2016-01-01",date('Y-m-d'),1);
        $total_dias_laborales = ( $interval->days - $dias_no_habiles );        

                
        $porcentaje_atraso = round( ( 100 * $total_atrasos ) / $total_dias_laborales,0 );
        
        if( ( $porcentaje_atraso >= 0 ) && ( $porcentaje_atraso <= 25 ) ){ $json['progress_class'] = 'progress-bar-0-25'; }
        if( ( $porcentaje_atraso > 25 ) && ( $porcentaje_atraso <= 50 ) ){ $json['progress_class'] = 'progress-bar-25-50'; }
        if( ( $porcentaje_atraso > 50 ) && ( $porcentaje_atraso <= 75 ) ){ $json['progress_class'] = 'progress-bar-50-75'; }
        if( ( $porcentaje_atraso > 75 ) && ( $porcentaje_atraso <= 100 ) ){ $json['progress_class'] = 'progress-bar-75-100'; }
        
        $json['total_marcaje'] = $total_dias_laborales;
        $json['porcentaje_atraso'] = $porcentaje_atraso;
    
    } else {
        $json['total_atrasos'] = 'Trabajador no marca tarjeta';
    }               
    
}

$json = json_encode($json);
echo $json;

?>