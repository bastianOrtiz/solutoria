<?php
if( $_SESSION[PREFIX.'login_eid'] == "" ){
    $empresa_logged = 1;
} else {
    $empresa_logged = $_SESSION[PREFIX.'login_eid'];
}
$sql = "
SELECT DEP.id, DEP.nombre, COUNT(TRA.id) total
FROM m_departamento DEP, m_trabajador TRA 
WHERE TRA.departamento_id = DEP.id 
AND TRA.empresa_id = " . $empresa_logged . "
AND TRA.tipocontrato_id NOT IN (3,4)
GROUP BY DEP.nombre
";
$deptos = $db->rawQuery( $sql );

$arr_deptos_data = array();
$js_var_PieData = '';
$colors = array('#d76a6a','#b46ad7','#6a6dd7','#6ab2d7','#fe7575','#0ee669','#7fd76a','#d3d76a','#dca13a','#8b8baf');
$color_cont = 0;
foreach( $deptos as $d ){
    $js_var_PieData .= '{ value: '. $d['total'] .', color: "'.$colors[$color_cont].'", highlight: "'.$colors[$color_cont].'", label: "'. strtoupper($d['nombre']) .'" },';
    $arr_deptos_data[] = array(
        'departamento' => $d['nombre'],
        'total' => $d['total'],
        'color' => $colors[$color_cont]
    );
    $color_cont++;
    if( $color_cont == 10 )
        $color_cont = 0;
}
$js_var_PieData = trim($js_var_PieData,',');

 

/** Sexo de los trabajadores **/
$sql_sexo = "SELECT   sexo, 
             COUNT(*) total
             FROM     m_trabajador
             WHERE empresa_id = $empresa_logged
             AND tipocontrato_id NOT IN (3,4)
             GROUP BY sexo";
$sexos = $db->rawQuery( $sql_sexo );
$arr_sexos = array( 'Mujeres','Hombres' );
$js_var_sexos = '';

$sex_tot = ( $sexos[0]['total'] + $sexos[1]['total'] );
$porc_M = round( ($sexos[0]['total'] * 100 / $sex_tot),2 );
$porc_H = round(( $sexos[1]['total'] * 100 / $sex_tot ),2);
$arr_porcentaje = array($porc_M,$porc_H);

$colors = array('#F0629E','#2085FF');
foreach( $sexos as $s ){
    $js_var_sexos .= '{ value: '. $arr_porcentaje[$s['sexo']] .', color: "'.$colors[$s['sexo']].'", highlight: "'.$colors[$s['sexo']].'", label: "'. strtoupper( $arr_sexos[$s['sexo']] ) .'" },';        
}
$js_var_sexos = trim($js_var_sexos,',');


// Atrasos
$atraso_acumulado['total_atrasos'] = count($entradas);
$atraso_acumulado = getMinutosAtrasoMes(date('m'), date('Y'), $_SESSION[PREFIX.'login_uid']);

// Ausencias
$ausencias = obtenerAusencias( $_SESSION[PREFIX . 'login_uid'] );
$ausencias_total = ( $ausencias['dias_ausentismo'] + $ausencias['dias_licencia'] );


// Vacaciones
$sql_v = "SELECT * FROM t_ausencia TA
WHERE TA.ausencia_id IN ( select ausenciaVacaciones from m_empresa E WHERE E.id = ".$_SESSION[PREFIX . 'login_eid']." )
AND TA.trabajador_id = ".$_SESSION[PREFIX . 'login_uid']."
AND year(TA.fecha_inicio) = " . date('Y');
$resul_vacaciones = $db->rawQuery($sql_v);

$dias_vac = 0;
foreach($resul_vacaciones as $rango){
    $fechaInicio = strtotime($rango['fecha_inicio'].' 00:00:00');
    $fechaFin = strtotime($rango['fecha_fin'].' 23:59:59');
    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
        if ( date("N",$i) < 6 ){
            $dias_vac++;
        }
    }
}


if( $_SESSION[PREFIX.'is_trabajador'] ){
    $db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);
    $db->orderBy('ano','DESC');
    $db->orderBy('mes','DESC');
    $ultima_liquidacion = $db->getOne('liquidacion');

    $limite = (int)$ultima_liquidacion['ano'].leadZero($ultima_liquidacion['mes']).'28';
    $hoy = (int)date('Ymd');

    if( $hoy < $limite ){
        $ultima_liquidacion = $db->rawQuery("SELECT  * FROM liquidacion WHERE  trabajador_id = '".$_SESSION[PREFIX.'login_uid']."'  ORDER BY ano DESC, mes DESC  LIMIT 1 OFFSET 1");
        $ultima_liquidacion = $ultima_liquidacion[0];
    }

    $mes_ultima_liquidacion = getNombreMes($ultima_liquidacion['mes']);
}

include ROOT . '/views/comun/header.php';
include ROOT . '/views/comun/menu_top.php';
include ROOT . '/views/comun/menu_sidebar.php';

if( isset($parametros[0]) ){
    if( file_exists(ROOT . '/views/' . strtolower($entity) . '/' . $parametros[0] . '.php') ){
        include ROOT . '/views/' . $entity . '/' . $parametros[0] . '.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> Not Found </h2> </section></div>';
    }
} else {    
    if( file_exists( ROOT . '/views/' . strtolower($entity) . '/dashboard.php') ){
        include ROOT . '/views/' . $entity .  '/dashboard.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> '. strtoupper($entity) .' </h2> </section></div>';
    }    
}

include ROOT . '/views/comun/footer.php';

?>
