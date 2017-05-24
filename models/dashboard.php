<?php

function obtenerAusencias($trabajador_id){
    global $db;

    $periodo            = getPeriodoCorte();

    $mes = getMesMostrarCorte();
    $year = getAnoMostrarCorte();


    //Proceso para obtener el
    $sql_fecha_fin = "
    SELECT * FROM `m_trabajador` WHERE id = $trabajador_id
    AND month(fechaContratoFin) = $mes
    AND year(fechaContratoFin) = $year
    ";
    $finiquito_este_mes = $db->rawQueryOne($sql_fecha_fin);

    if( $finiquito_este_mes ){
        $hasta = $finiquito_este_mes['fechaContratoFin'] . "  23:59:59";
    } else {
        $hasta = $periodo['hasta'].' 23:59:59';
    }

    $desde              = $periodo['desde'].' 00:00:00';

    $fechaInicio        = strtotime($desde);
    $fechaFin           = strtotime($hasta);
    $arr_ausencias      = array();
    $total_ausencias    = 0;
    $dias_licencia      = 0;




    /** AUSENCIAS SIN INC. LICENCIAS **/
    $raw_query = "
    SELECT fecha_inicio, fecha_fin,  DATEDIFF(fecha_fin,fecha_inicio)+1 as dias, ausencia_id
    FROM t_ausencia
    WHERE (
            fecha_inicio <= '$desde'
            AND fecha_fin <= '$hasta'
            AND fecha_fin >= '$desde'
            AND trabajador_id = $trabajador_id
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )
            )
    OR (
        fecha_inicio >= '$desde'
        AND fecha_fin >= '$hasta'
        AND fecha_inicio <= '$hasta'
        AND trabajador_id = $trabajador_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )
        )
    OR (
        fecha_inicio <= '$desde'
        AND fecha_fin >= '$hasta'
        AND trabajador_id = $trabajador_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )
        )
    OR (
        fecha_inicio >= '$desde'
        AND fecha_fin <= '$hasta'
        AND trabajador_id = $trabajador_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 0 )
        )
        ORDER BY fecha_inicio
    ";
    $res = $db->rawQuery($raw_query,'',false);

    if( $res ){
        foreach($res as $aus){
            $ausencias = 0;
            $date_fin_corte = new DateTime( $hasta );
            $date_fin_ausen = new DateTime( $aus['fecha_fin'] );

            $date_ini_corte = new DateTime( $desde );
            $date_ini_ausen = new DateTime( $aus['fecha_inicio'] );

            if( ( $date_ini_ausen <= $date_ini_corte ) && ( $date_fin_ausen <= $date_fin_corte ) ){
                $interval = $date_ini_corte->diff($date_fin_ausen);
                $ausencias += ( $interval->days + 1 );
                $n_dias = diasNoLaborales($desde,$aus['fecha_fin'],$trabajador_id);
                $ausencias -= $n_dias;
                $arr_ausencias[] = array(
                    'fecha_inicio' => $desde,
                    'fecha_fin' => $aus['fecha_fin'],
                    'dias' => $ausencias,
                    'ausencia_id' => $aus['ausencia_id']
                );
                $total_ausencias += $ausencias;
                //echo "1<br />";
            } elseif( ( $date_ini_ausen >= $date_ini_corte ) && ( $date_fin_ausen >= $date_fin_corte ) && ( $date_ini_ausen <= $date_fin_corte ) ){
                $interval = $date_ini_ausen->diff($date_fin_corte);
                $ausencias += ( $interval->days + 1 );
                $n_dias = diasNoLaborales($aus['fecha_inicio'],$hasta,$trabajador_id);
                $ausencias -= $n_dias;
                $arr_ausencias[] = array(
                    'fecha_inicio' => $aus['fecha_inicio'],
                    'fecha_fin' => $hasta,
                    'dias' => $ausencias,
                    'ausencia_id' => $aus['ausencia_id']
                );
                $total_ausencias += $ausencias;
                //echo "2<br />";
            } elseif( ( $date_ini_ausen <= $date_ini_corte ) && ( $date_fin_ausen >= $date_fin_corte ) ){
                $interval = $date_ini_ausen->diff($date_fin_corte);
                $ausencias += ( $interval->days + 1 );
                $n_dias = diasNoLaborales($aus['fecha_inicio'],$hasta,$trabajador_id);
                $ausencias -= $n_dias;
                $arr_ausencias[] = array(
                    'fecha_inicio' => $aus['fecha_inicio'],
                    'fecha_fin' => $hasta,
                    'dias' => $ausencias,
                    'ausencia_id' => $aus['ausencia_id']
                );
                $total_ausencias += $ausencias;
                //echo "3<br />";
            } else {
                $ausencias += $aus['dias'];
                $n_dias = diasNoLaborales($aus['fecha_inicio'],$aus['fecha_fin'],$trabajador_id);
                $ausencias -= $n_dias;
                $arr_ausencias[] = array(
                    'fecha_inicio' => $aus['fecha_inicio'],
                    'fecha_fin' => $aus['fecha_fin'],
                    'dias' => $ausencias,
                    'ausencia_id' => $aus['ausencia_id']
                );
                $total_ausencias += $ausencias;
                //echo "4<br />";
            }
        }
    }


    /** Ahora Se Recorren Las LICENCIAS **/
    $mes = getMesMostrarCorte();
    $year = getAnoMostrarCorte();
    $total_days_month = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
    $desde_licencia = $year . '-' . leadZero($mes) . '-01';
    $hasta_licencia = $year . '-' . leadZero($mes) . '-' . $total_days_month;
    $sql_licencia = "
    SELECT fecha_inicio, fecha_fin,  DATEDIFF(fecha_fin,fecha_inicio)+1 as dias, ausencia_id
    FROM t_ausencia
    WHERE (
            fecha_inicio <= '$desde_licencia'
            AND fecha_fin <= '$hasta_licencia'
            AND fecha_fin >= '$desde_licencia'
            AND trabajador_id = $trabajador_id
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
            AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 )
            )
    OR (
        fecha_inicio >= '$desde_licencia'
        AND fecha_fin >= '$hasta_licencia'
        AND fecha_inicio <= '$hasta_licencia'
        AND trabajador_id = $trabajador_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1)
        )
    OR (
        fecha_inicio <= '$desde_licencia'
        AND fecha_fin >= '$hasta_licencia'
        AND trabajador_id = $trabajador_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 )
        )
    OR (
        fecha_inicio >= '$desde_licencia'
        AND fecha_fin <= '$hasta_licencia'
        AND trabajador_id = $trabajador_id
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.descuenta = 1 )
        AND ausencia_id IN ( SELECT id from m_ausencia M WHERE M.licencia = 1 )
        )
        ORDER BY fecha_inicio
    ";
    $res_licencias = $db->rawQuery($sql_licencia,'',false);


    foreach($res_licencias as $aus){
        $ausencias = 0;
        $date_fin_mes = new DateTime( $hasta_licencia . ' 23:59:59' );
        $date_fin_ausen = new DateTime( $aus['fecha_fin'] );

        $date_ini_mes = new DateTime( $desde_licencia . ' 00:00:00' );
        $date_ini_ausen = new DateTime( $aus['fecha_inicio'] );

        if( ( $date_ini_ausen <= $date_ini_mes ) && ( $date_fin_ausen <= $date_fin_mes ) ){
            $interval = $date_ini_mes->diff($date_fin_ausen);
            $ausencias += ( $interval->days + 1 );
            $arr_ausencias[] = array(
                'fecha_inicio' => $desde,
                'fecha_fin' => $aus['fecha_fin'],
                'dias' => $ausencias,
                'ausencia_id' => $aus['ausencia_id']
            );
            $dias_licencia += $ausencias;
            //echo "1<br />";
        } elseif( ( $date_ini_ausen >= $date_ini_mes ) && ( $date_fin_ausen >= $date_fin_mes ) && ( $date_ini_ausen <= $date_fin_mes ) ){
            $interval = $date_ini_ausen->diff($date_fin_mes);
            $ausencias += ( $interval->days + 1 );
            $arr_ausencias[] = array(
                'fecha_inicio' => $aus['fecha_inicio'],
                'fecha_fin' => $hasta,
                'dias' => $ausencias,
                'ausencia_id' => $aus['ausencia_id']
            );
            $dias_licencia += $ausencias;
            //echo "2<br />";
        } elseif( ( $date_ini_ausen <= $date_ini_mes ) && ( $date_fin_ausen >= $date_fin_mes ) ){
            $interval = $date_ini_ausen->diff($date_fin_mes);
            $ausencias += ( $interval->days + 1 );
            $arr_ausencias[] = array(
                'fecha_inicio' => $aus['fecha_inicio'],
                'fecha_fin' => $hasta,
                'dias' => $ausencias,
                'ausencia_id' => $aus['ausencia_id']
            );
            $dias_licencia += $ausencias;
            //echo "3<br />";
        } else {
            $ausencias += $aus['dias'];
            $arr_ausencias[] = array(
                'fecha_inicio' => $aus['fecha_inicio'],
                'fecha_fin' => $aus['fecha_fin'],
                'dias' => $ausencias,
                'ausencia_id' => $aus['ausencia_id']
            );
            $dias_licencia += $ausencias;
            //echo "4<br />";
        }
    }
    if( $dias_licencia > 30 ){
        $dias_licencia = 30;
    }



    /** Proceso para determinar dias de NO enrolado **/
    $diasNoEnrolado = 0;

    $db->where('id',$trabajador_id);
    $fecha_inicio_contrato_plano = $db->getValue('m_trabajador','fechaContratoInicio');
    $fecha_inicio_contrato_plano .= ' 00:00:00';
    $fecha_inicio_contrato = strtotime($fecha_inicio_contrato_plano);

    $mes_enrolado = date('m',$fecha_inicio_contrato);
    $ano_enrolado = date('Y',$fecha_inicio_contrato);
    $mes_enrolado = (int)$mes_enrolado;


    if( ($mes_enrolado == $mes) && ( $ano_enrolado == $year ) ){
        /*
        $db->where('trabajador_id',$trabajador_id);
        $db->where('activo',1);
        $db->get('t_contrato');
        if( $db->count <= 2 ){
        */
            $datetime1 = new DateTime( $year.'-'.$mes.'-01 00:00:00' );
            $datetime2 = new DateTime( $fecha_inicio_contrato_plano );
            $interval = $datetime1->diff($datetime2);

            $diasNoEnrolado = $interval->days;
        //}
    }
    /** END **/


    /** Proceso para determinar dias que no trabajo por Finiquito **/
    $diasNoTrabajados = 0;

    $db->where('id',$trabajador_id);
    $fecha_fin_contrato_plano = $db->getValue('m_trabajador','fechaContratoFin');
    if($fecha_fin_contrato_plano != "0000-00-00"){
        $fecha_fin_contrato = strtotime($fecha_fin_contrato_plano);
        $mes = getMesMostrarCorte();
        $mes = leadZero($mes);
        $ano = getAnoMostrarCorte();
        $fechaFin=strtotime( $ano.'-'.$mes.'-30' );
        if( $mes == 2 ){
            $fechaFin=strtotime( $ano.'-'.$mes.'-28' );
        }
        if($fecha_fin_contrato < $fechaFin){
            $datetime1 = new DateTime( $year.'-'.$mes.'-01' );
            $datetime2 = new DateTime( $fecha_fin_contrato_plano );
            $interval = $datetime1->diff($datetime2);
            $diasAlcanzoATrabajar = $interval->days;
            $diasAlcanzoATrabajar++;
            $diasNoTrabajados = ( 30 - $diasAlcanzoATrabajar );
        }
    }
    /** END **/


    $arr_ausencias['dias_finiquito'] = $diasNoTrabajados;
    $arr_ausencias['dias_no_enrolado'] = $diasNoEnrolado;
    $arr_ausencias['dias_ausentismo'] = $total_ausencias;
    $arr_ausencias['dias_licencia'] = $dias_licencia;
    $arr_ausencias['total'] = ($total_ausencias + $dias_licencia + $diasNoEnrolado + $diasNoTrabajados );

    return $arr_ausencias;
}

?>
