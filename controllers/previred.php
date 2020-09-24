<?php
global $db;
$id_empresa = $_SESSION[PREFIX.'login_eid'];
$nombre_empresa = $_SESSION[PREFIX.'login_empresa'];

$revisor = [];

if( $_POST ){

    if( @$_POST['action'] == 'enviarEmpleados' ){
        crearTxt($_POST);
    }
    
    if( @$_POST['action'] == 'new' ){        
                   
    }    

    if( @$_POST['action'] == 'generar_archivo_previred' ){
        
        $total_reg = ( count($_POST['rut']) / 2 );

        $uniqid = uniqid();
        $archivo = ROOT . "/private/uploads/docs/previred_" . $uniqid . ".txt"; // el nombre de tu archivo
        $fch = fopen($archivo, "a"); // Abres el archivo para escribir en él

        for ($i=0; $i < $total_reg; $i++) { 
            $rut = rellenar($_POST['rut'][$i], 11, "i");
            $dv = rellenar($_POST['dv'][$i], 1, "s");
            $apellido_paterno = rellenar($_POST['apellido_paterno'][$i], 30, "s");
            $apellido_materno = rellenar($_POST['apellido_materno'][$i], 30, "s");
            $nombres = rellenar($_POST['nombres'][$i], 30, "s");
            $sexo = rellenar($_POST['sexo'][$i], 1, "s");
            $extranjero = rellenar($_POST['extranjero'][$i], 1, "i");
            $tipo_pago = rellenar($_POST['tipo_pago'][$i], 2, "i");
            $periodo_desde = rellenar($_POST['periodo_desde'][$i], 6, "i");
            $periodo_hasta = rellenar($_POST['periodo_hasta'][$i], 6, "i");
            $regimen_prev = rellenar($_POST['regimen_prev'][$i], 3, "s");
            $tipo_trabajador  = rellenar($_POST['tipo_trabajador'][$i], 1, "i");
            $dias_trabajados  = rellenar($_POST['dias_trabajados'][$i], 2, "i");
            $tipo_linea = rellenar($_POST['tipo_linea'][$i], 2, "s");
            $cod_mov_personal = rellenar($_POST['cod_mov_personal'][$i], 2, "i");
            $fecha_desde  = rellenar($_POST['fecha_desde'][$i],10, "s");
            $fecha_hasta  = rellenar($_POST['fecha_hasta'][$i],10, "s");
            $tramo_asig_fam  = rellenar($_POST['tramo_asig_fam'][$i], 1, "s");
            $nro_cargas_simples  = rellenar($_POST['nro_cargas_simples'][$i], 2, "i");
            $nro_cargas_maternales  = rellenar($_POST['nro_cargas_maternales'][$i], 1, "i");
            $nro_cargas_invalidas  = rellenar($_POST['nro_cargas_invalidas'][$i], 1, "i");
            $asig_familiar  = rellenar($_POST['asig_familiar'][$i], 6, "i");
            $asig_familiar_retro = rellenar($_POST['asig_familiar_retro'][$i], 6, "i");
            $reintegro_cargas_fam = rellenar($_POST['reintegro_cargas_fam'][$i], 6, "i");
            $solicitud_trabajador_joven  = rellenar($_POST['solicitud_trabajador_joven'][$i], 1, "s");
            $codigo_afp  = rellenar($_POST['codigo_afp'][$i], 2, "i");
            $renta_imponible_afp = rellenar($_POST['renta_imponible_afp'][$i], 8, "i");
            $cotizacion_obligatoria_afp  = rellenar($_POST['cotizacion_obligatoria_afp'][$i], 8, "i");
            $cotizacion_sis  = rellenar($_POST['cotizacion_sis'][$i], 8, "i");
            $apv_afp = rellenar($_POST['apv_afp'][$i], 8, "i");
            $renta_imponible_sust_afp = rellenar($_POST['renta_imponible_sust_afp'][$i], 8, "i");
            $tasa_pactada_sust  = rellenar($_POST['tasa_pactada_sust'][$i], 5, "i");
            $aporte_indem_sust  = rellenar($_POST['aporte_indem_sust'][$i], 9, "i");
            $nro_periodo_sust = rellenar($_POST['nro_periodo_sust'][$i], 2, "i");
            $periodo_desde_sust   = rellenar($_POST['periodo_desde_sust'][$i],10, "s");
            $periodo_hasta_sust   = rellenar($_POST['periodo_hasta_sust'][$i],10, "s");
            $puesto_trabajo_pesado   = rellenar($_POST['puesto_trabajo_pesado'][$i],40, "s");
            $percent_cotizac_trabajo_pesado  = rellenar($_POST['percent_cotizac_trabajo_pesado'][$i], 5, "i");
            $cotizacion_trabajo_pesado  = rellenar($_POST['cotizacion_trabajo_pesado'][$i], 6, "i");
            $codigo_inst_apvi = rellenar($_POST['codigo_inst_apvi'][$i], 3, "i");
            $nro_contrato_apvi   = rellenar($_POST['nro_contrato_apvi'][$i],20, "s");
            $forma_pago_apvi = rellenar($_POST['forma_pago_apvi'][$i], 1, "i");
            $cotizacion_apvi = rellenar($_POST['cotizacion_apvi'][$i], 8, "i");
            $cotizacion_depositos_convencidos = rellenar($_POST['cotizacion_depositos_convencidos'][$i], 8, "i");
            $cod_inst_autorizada_apvc = rellenar($_POST['cod_inst_autorizada_apvc'][$i], 3, "i");
            $nro_contrato_apvc   = rellenar($_POST['nro_contrato_apvc'][$i],20, "s");
            $forma_de_pago_apvc  = rellenar($_POST['forma_de_pago_apvc'][$i], 1, "i");
            $cotizacion_trabajador_apvc  = rellenar($_POST['cotizacion_trabajador_apvc'][$i], 8, "i");
            $cotizacion_empleador_apvc  = rellenar($_POST['cotizacion_empleador_apvc'][$i], 8, "i");
            $rut_afiliado_voluntario  = rellenar($_POST['rut_afiliado_voluntario'][$i],11, "i");
            $dv_afiliado_voluntario  = rellenar($_POST['dv_afiliado_voluntario'][$i], 1, "s");
            $apellido_paterno_af_voluntario   = rellenar($_POST['apellido_paterno_af_voluntario'][$i],30, "s");
            $apellido_materno_af_voluntario   = rellenar($_POST['apellido_materno_af_voluntario'][$i],30, "s");
            $nombres_af_voluntario   = rellenar($_POST['nombres_af_voluntario'][$i],30, "s");
            $codigo_movimiento_de_personal  = rellenar($_POST['codigo_movimiento_de_personal'][$i], 2, "i");
            $fecha_desde_movimiento   = rellenar($_POST['fecha_desde_movimiento'][$i],10, "s");
            $fecha_hasta_movimiento   = rellenar($_POST['fecha_hasta_movimiento'][$i],10, "s");
            $codigo_de_la_afp = rellenar($_POST['codigo_de_la_afp'][$i], 2, "i");
            $monto_capitalizacion_voluntaria = rellenar($_POST['monto_capitalizacion_voluntaria'][$i], 8, "i");
            $monto_ahorro_voluntario = rellenar($_POST['monto_ahorro_voluntario'][$i], 8, "i");
            $numero_de_periodos_de_cotizacion = rellenar($_POST['numero_de_periodos_de_cotizacion'][$i], 2, "i");
            $codigo_ex_caja_regimen  = rellenar($_POST['codigo_ex_caja_regimen'][$i], 4, "i");
            $tasa_cotizacion_ex_cajas_de_prevision  = rellenar($_POST['tasa_cotizacion_ex_cajas_de_prevision'][$i], 5, "i");
            $renta_imponible_ips = rellenar($_POST['renta_imponible_ips'][$i], 8, "i");
            $cotizacion_obligatoria_ips  = rellenar($_POST['cotizacion_obligatoria_ips'][$i], 8, "i");
            $renta_imponible_desahucio  = rellenar($_POST['renta_imponible_desahucio'][$i], 8, "i");
            $codigo_ex_caja_regimen_desahucio = rellenar($_POST['codigo_ex_caja_regimen_desahucio'][$i], 4, "i");
            $tasa_cotizac_desahucio_ex_cajas_prevision  = rellenar($_POST['tasa_cotizac_desahucio_ex_cajas_prevision'][$i], 5, "i");
            $cotizacion_desahucio = rellenar($_POST['cotizacion_desahucio'][$i], 8, "i");
            $cotizacion_fonasa  = rellenar($_POST['cotizacion_fonasa'][$i], 8, "i");
            $cotizacion_acc__trabajo_isl = rellenar($_POST['cotizacion_acc__trabajo_isl'][$i], 8, "i");
            $bonificacion_ley_15_386 = rellenar($_POST['bonificacion_ley_15_386'][$i], 8, "i");
            $descuento_por_cargas_familiares_isl = rellenar($_POST['descuento_por_cargas_familiares_isl'][$i], 8, "i");
            $bonos_de_gobierno  = rellenar($_POST['bonos_de_gobierno'][$i], 8, "i");
            $codigo_institucion_de_salud = rellenar($_POST['codigo_institucion_de_salud'][$i], 2, "i");
            $numero_de_fun   = rellenar($_POST['numero_de_fun'][$i],16, "s");
            $renta_imponible_isapre  = rellenar($_POST['renta_imponible_isapre'][$i], 8, "i");
            $moneda_del_plan_pactado_isapre  = rellenar($_POST['moneda_del_plan_pactado_isapre'][$i], 1, "i");
            $cotizacion_pactada  = rellenar($_POST['cotizacion_pactada'][$i], 8, "i");
            $cotizacion_obligatoria_isapre  = rellenar($_POST['cotizacion_obligatoria_isapre'][$i], 8, "i");
            $cotizacion_adicional_voluntaria = rellenar($_POST['cotizacion_adicional_voluntaria'][$i], 8, "i");
            $monto_ges_futuro = rellenar($_POST['monto_ges_futuro'][$i], 8, "i");
            $codigo_ccaf = rellenar($_POST['codigo_ccaf'][$i], 2, "i");
            $renta_imponible_ccaf = rellenar($_POST['renta_imponible_ccaf'][$i], 8, "i");
            $creditos_personales_ccaf = rellenar($_POST['creditos_personales_ccaf'][$i], 8, "i");
            $dscto_dental_ccaf  = rellenar($_POST['dscto_dental_ccaf'][$i], 8, "i");
            $dsctos_por_leasing  = rellenar($_POST['dsctos_por_leasing'][$i], 8, "i");
            $dsctos_por_seguro_de_vida_ccaf  = rellenar($_POST['dsctos_por_seguro_de_vida_ccaf'][$i], 8, "i");
            $otros_descuentos_ccaf  = rellenar($_POST['otros_descuentos_ccaf'][$i], 8, "i");
            $cotizac_a_ccaf_no_afiliados_isapres = rellenar($_POST['cotizac_a_ccaf_no_afiliados_isapres'][$i], 8, "i");
            $descuento_cargas_familiares_ccaf = rellenar($_POST['descuento_cargas_familiares_ccaf'][$i], 8, "i");
            $otros_descuentos_ccaf_1_futuro  = rellenar($_POST['otros_descuentos_ccaf_1_futuro'][$i], 8, "i");
            $otros_descuentos_ccaf_2_futuro  = rellenar($_POST['otros_descuentos_ccaf_2_futuro'][$i], 8, "i");
            $bonos_gobierno_futuro  = rellenar($_POST['bonos_gobierno_futuro'][$i], 8, "i");
            $codigo_de_sucursal_futuro   = rellenar($_POST['codigo_de_sucursal_futuro'][$i],20, "i");
            $codigo_mutualidad  = rellenar($_POST['codigo_mutualidad'][$i], 2, "i");
            $renta_imponible_mutual  = rellenar($_POST['renta_imponible_mutual'][$i], 8, "i");
            $cotizacion_mutual  = rellenar($_POST['cotizacion_mutual'][$i], 8, "i");
            $sucursal_para_pago_mutual  = rellenar($_POST['sucursal_para_pago_mutual'][$i], 3, "i");
            $renta_imp_seguro_cesantia  = rellenar($_POST['renta_imp_seguro_cesantia'][$i], 8, "i");
            $aporte_trabajador_seguro_cesantia  = rellenar($_POST['aporte_trabajador_seguro_cesantia'][$i], 8, "i");
            $aporte_empleador_seguro_cesantia = rellenar($_POST['aporte_empleador_seguro_cesantia'][$i], 8, "i");
            $rut_pagadora_subsidio   = rellenar($_POST['rut_pagadora_subsidio'][$i],11, "i");
            $dv_pagadora_subsidio = rellenar($_POST['dv_pagadora_subsidio'][$i], 1, "i");
            $ccosots_suc_agencia_obra_region  = rellenar($_POST['ccosots_suc_agencia_obra_region'][$i],20, "i");

            fwrite($fch, $rut);
            fwrite($fch, $dv);
            fwrite($fch, $apellido_paterno);
            fwrite($fch, $apellido_materno);
            fwrite($fch, $nombres);
            fwrite($fch, $sexo);
            fwrite($fch, $extranjero);
            fwrite($fch, $tipo_pago);
            fwrite($fch, $periodo_desde);
            fwrite($fch, $periodo_hasta);
            fwrite($fch, $regimen_prev);
            fwrite($fch, $tipo_trabajador);
            fwrite($fch, $dias_trabajados);
            fwrite($fch, $tipo_linea);
            fwrite($fch, $cod_mov_personal);
            fwrite($fch, $fecha_desde);
            fwrite($fch, $fecha_hasta);
            fwrite($fch, $tramo_asig_fam);
            fwrite($fch, $nro_cargas_simples);
            fwrite($fch, $nro_cargas_maternales);
            fwrite($fch, $nro_cargas_invalidas);
            fwrite($fch, $asig_familiar);
            fwrite($fch, $asig_familiar_retro);
            fwrite($fch, $reintegro_cargas_fam);
            fwrite($fch, $solicitud_trabajador_joven);
            fwrite($fch, $codigo_afp);
            fwrite($fch, $renta_imponible_afp);
            fwrite($fch, $cotizacion_obligatoria_afp);
            fwrite($fch, $cotizacion_sis);
            fwrite($fch, $apv_afp);
            fwrite($fch, $renta_imponible_sust_afp);
            fwrite($fch, $tasa_pactada_sust);
            fwrite($fch, $aporte_indem_sust);
            fwrite($fch, $nro_periodo_sust);
            fwrite($fch, $periodo_desde_sust);
            fwrite($fch, $periodo_hasta_sust);
            fwrite($fch, $puesto_trabajo_pesado);
            fwrite($fch, $percent_cotizac_trabajo_pesado);
            fwrite($fch, $cotizacion_trabajo_pesado);
            fwrite($fch, $codigo_inst_apvi);
            fwrite($fch, $nro_contrato_apvi);
            fwrite($fch, $forma_pago_apvi);
            fwrite($fch, $cotizacion_apvi);
            fwrite($fch, $cotizacion_depositos_convencidos);
            fwrite($fch, $cod_inst_autorizada_apvc);
            fwrite($fch, $nro_contrato_apvc);
            fwrite($fch, $forma_de_pago_apvc);
            fwrite($fch, $cotizacion_trabajador_apvc);
            fwrite($fch, $cotizacion_empleador_apvc);
            fwrite($fch, $rut_afiliado_voluntario);
            fwrite($fch, $dv_afiliado_voluntario);
            fwrite($fch, $apellido_paterno_af_voluntario);
            fwrite($fch, $apellido_materno_af_voluntario);
            fwrite($fch, $nombres_af_voluntario);
            fwrite($fch, $codigo_movimiento_de_personal);
            fwrite($fch, $fecha_desde_movimiento);
            fwrite($fch, $fecha_hasta_movimiento);
            fwrite($fch, $codigo_de_la_afp);
            fwrite($fch, $monto_capitalizacion_voluntaria);
            fwrite($fch, $monto_ahorro_voluntario);
            fwrite($fch, $numero_de_periodos_de_cotizacion);
            fwrite($fch, $codigo_ex_caja_regimen);
            fwrite($fch, $tasa_cotizacion_ex_cajas_de_prevision);
            fwrite($fch, $renta_imponible_ips);
            fwrite($fch, $cotizacion_obligatoria_ips);
            fwrite($fch, $renta_imponible_desahucio);
            fwrite($fch, $codigo_ex_caja_regimen_desahucio);
            fwrite($fch, $tasa_cotizac_desahucio_ex_cajas_prevision);
            fwrite($fch, $cotizacion_desahucio);
            fwrite($fch, $cotizacion_fonasa);
            fwrite($fch, $cotizacion_acc__trabajo_isl);
            fwrite($fch, $bonificacion_ley_15_386);
            fwrite($fch, $descuento_por_cargas_familiares_isl);
            fwrite($fch, $bonos_de_gobierno);
            fwrite($fch, $codigo_institucion_de_salud);
            fwrite($fch, $numero_de_fun);
            fwrite($fch, $renta_imponible_isapre);
            fwrite($fch, $moneda_del_plan_pactado_isapre);
            fwrite($fch, $cotizacion_pactada);
            fwrite($fch, $cotizacion_obligatoria_isapre);
            fwrite($fch, $cotizacion_adicional_voluntaria);
            fwrite($fch, $monto_ges_futuro);
            fwrite($fch, $codigo_ccaf);
            fwrite($fch, $renta_imponible_ccaf);
            fwrite($fch, $creditos_personales_ccaf);
            fwrite($fch, $dscto_dental_ccaf);
            fwrite($fch, $dsctos_por_leasing);
            fwrite($fch, $dsctos_por_seguro_de_vida_ccaf);
            fwrite($fch, $otros_descuentos_ccaf);
            fwrite($fch, $cotizac_a_ccaf_no_afiliados_isapres);
            fwrite($fch, $descuento_cargas_familiares_ccaf);
            fwrite($fch, $otros_descuentos_ccaf_1_futuro);
            fwrite($fch, $otros_descuentos_ccaf_2_futuro);
            fwrite($fch, $bonos_gobierno_futuro);
            fwrite($fch, $codigo_de_sucursal_futuro);
            fwrite($fch, $codigo_mutualidad);
            fwrite($fch, $renta_imponible_mutual);
            fwrite($fch, $cotizacion_mutual);
            fwrite($fch, $sucursal_para_pago_mutual);
            fwrite($fch, $renta_imp_seguro_cesantia);
            fwrite($fch, $aporte_trabajador_seguro_cesantia);
            fwrite($fch, $aporte_empleador_seguro_cesantia);
            fwrite($fch, $rut_pagadora_subsidio);
            fwrite($fch, $dv_pagadora_subsidio);
            fwrite($fch, $ccosots_suc_agencia_obra_region);
            if( $i < ($total_reg - 1) ){
                fwrite($fch, PHP_EOL); // Salto de linea    
            }
            
        }

        fclose($fch); // Cierras el archivo.

        $empresa_name_sanitized = _sanitize_redirect( $_SESSION[PREFIX . 'login_empresa'] );
        $empresa_name_sanitized = str_replace(".","",$empresa_name_sanitized);

        // Headers for an download:
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="previred_' . $empresa_name_sanitized . '_' . $uniqid . '.txt"');
        readfile($archivo);
        unlink($archivo);

        exit();
    }    


    if( $_POST['action'] == 'upload_previred' ){

        $upload = upload_doc('archivo_previred',ROOT.'/private/uploads/docs/');

        if( $upload['status'] == true ){
            
            $lines = file(ROOT.'/private/uploads/docs/' . $upload['filename']);
            unlink(ROOT.'/private/uploads/docs/' . $upload['filename']);

            foreach ($lines as $line) {
                $revisor[] = $line;
            }
        }
    }

}   

if( $parametros ){
    if ($_POST) {
        $empleados = buscarEmpleados($id_empresa, $_POST['mesAtraso'], $_POST['anoAtraso']);
    }
    $periodoDesde = getMesMostrarCorte().getAnoMostrarCorte(); 
    $periodoHasta = getMesMostrarCorte().getAnoMostrarCorte();
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

