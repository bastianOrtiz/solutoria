<?php

@session_start();
$year = getAnoMostrarCorte();
$mes = getMesMostrarCorte();


$corte = getPeriodoCorte();


$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$registros = $db->get("m_trabajador");

if( $_SESSION[PREFIX.'is_trabajador'] ){    
    $db->where('trabajador_id',$_SESSION[PREFIX.'login_uid']);
    $db->where('terminada',1);
    $db->orderBy('ano','DESC');
    $db->orderBy('mes','DESC');
    $liquidaciones_trabajador = $db->get('liquidacion',12);
}

if( $_POST ){
    
    extract($_POST);


    if( $action == "actualizar_sis_sces" ){

        $db->orderBy('apellidoPaterno','ASC');
        $trabajadores_todos = $db->get('m_trabajador');

        foreach ($trabajadores_todos as $key => $trabajador) {
            $db->where('mes',$_POST['mes']);
            $db->where('ano',$_POST['ano']);
            $db->where('trabajador_id',$trabajador['id']);
            $data_trabajador = $db->getOne('liquidacion');

            if( $data_trabajador ){

                $sis = calcularSis($data_trabajador['totalImponible'],$trabajador['id'], $_POST['mes'], $_POST['ano']);
                $sces = calcularSCes($data_trabajador['totalImponible'],$trabajador['id'],$_POST['mes'],$_POST['ano']);

                $data_array = [
                    'sis' => $sis,
                    'sces' => $sces
                ];

                $db->where('mes',$_POST['mes']);
                $db->where('ano',$_POST['ano']);
                $db->where('trabajador_id',$trabajador['id']);
                if($db->update('liquidacion', $data_array))
                     show_array($trabajador['apellidoPaterno'] . ' ' . $trabajador['nombres'] . ' ........................................... Actualizado OK! <br>',0);
                else 
                    show_array($trabajador['apellidoPaterno'] . ' ' . $trabajador['nombres'] . ' ........................................... Actualizado ERROR! <br>',0);
            }
        }


    }

                  
    if( @$action == 'liquidar' ){                
        
        extract($_SESSION[PREFIX.'totales_liquidar']);                
                        
        $mes = getMesMostrarCorte();
        $sueldo_maestro = $db->getValue('m_trabajador','sueldoBase');

        $array_data = array
        (
            "trabajador_id" => $trabajador_id,
            "mes" => $mes,
            "ano" => $year,
            "sueldoMaestro" => $sueldo_maestro,
            "diaAusencia" => $diaAusencia,
            "diaLicencia" => $diaLicencia,
            "diasTrabajados" => $diasTrabajados,
            "sueldoBase" => $sueldoBase,
            "gratificacion" => $gratificacion,
            "horaExtra" => $horaExtra,
            "horaExtraMonto" => $horaExtraMonto,
            "horaExtraFestivo" => $horaExtraFestivo,
            "horaExtraFestivoMonto" => $horaExtraFestivoMonto,
            "horaAtraso" => $horaAtraso,
            "horaAtrasoMonto" => $horaAtrasoMonto,
            "semanaCorrida" => $semanaCorrida,
            "totalImponible" => $totalImponible,
            'totalNoImponible' => $totalNoImponible,
            "remuneracionTributable" => $remuneracionTributable,
            "afp_id" => $afp_id,
            "afpMonto" => $afpMonto,
            "afpPorcentaje" => $afpPorcentaje,
            "isapre_id" => $isapre_id,
            "saludMonto" => $saludMonto,
            "isaprePactado" => $isaprePactado,
            "monedaIsaprePactado" => $monedaIsaprePactado,
            "afcMonto" => $afcMonto,
            "apvMonto" => $apvMonto,
            'topeAfc' => $topeAfc,
            'cuenta2Id' => $cuenta2Id,
            'cuenta2Monto' => $cuenta2Monto,
            "descuentoPrevisional" => $descuentoPrevisional,
            "totalTributable" => $totalTributable,
            'impuestoTotal' => $impuestoTotal,
            'impuestoRebajar' => $impuestoRebajar,                        
            "impuestoPagar" => $impuestoPagar,
            "impuestoAgricola" => $impuestoAgricola,
            'totalDescuento' => $totalDescuento,
            'alcanceLiquido' => $alcanceLiquido,            
            'totalPagar' => $totalPagar,
            'empresa_id' => $empresa_id,
            'departamento_id' => $departamento_id,
            'centrocosto_id' => $centrocosto_id
        );


        $db->where("trabajador_id",$trabajador_id);
        $db->where("mes",$mes);
        $db->where("ano",$year);
        $liq = $db->getOne('liquidacion');


        if( $db->count > 0 ){            
            $liquidacion_id = $liq['id'];
            $db->where('id',$liquidacion_id);
            $db->update('liquidacion', $array_data );
            $liquidacion_action = "UPDATE";
            logit( $_SESSION[PREFIX.'login_name'],'actualizar liquidacion','liquidacion',$liquidacion_id,$db->getLastQuery() );            
        } else {
            $liquidacion_id = $db->insert('liquidacion', $array_data );
            logit( $_SESSION[PREFIX.'login_name'],'insertar liquidacion','liquidacion',$liquidacion_id,$db->getLastQuery() );
            
            $liquidacion_action = "INSERT";
            if( $db->getLastError() ){
                goBack('Hubo un problema creando la Liquidación\nRevise que no falten datos del trabajador (Informacion Contractual o Previsional)');
                exit();
            }
        } 
        
        //Guardar SIS y SCes
        $sis = calcularSis($totalImponible,$trabajador_id,$mes,$year);
        $sces = calcularSCes($totalImponible,$trabajador_id,$mes,$year);
        

        $data_seguros = array(
            'sis' => $sis,
            'sces' => $sces
        );
        $db->where('id',$liquidacion_id);
        $db->update('liquidacion',$data_seguros);

        // Descuentos
        $db->where('liquidacion_id',$liquidacion_id);
        $db->delete('l_descuento');     
        
        //$query_desc = "SELECT * FROM t_descuento WHERE activo = 1 OR ( activo = 0 AND fechaFinalizacion = '$mes-$year' ) ORDER BY mesInicio DESC";
        $query_desc = "SELECT * FROM t_descuento WHERE (activo = 1 OR ( activo = 0 AND fechaFinalizacion = '".leadZero($mes)."-$year' )) and trabajador_id = $trabajador_id ORDER BY mesInicio DESC";        
        $debes_trabajador = $db->rawQuery( $query_desc );


        
        foreach( $debes_trabajador as $d ){
            if( $d['trabajador_id'] == $trabajador_id ){
                
                if( $liquidacion_action == 'INSERT' ){ // Liquidacion Nueva
                    $cuotaActual = $d['cuotaActual']; 
                    
                    // Campo "FechaFinalizacion" es equivalente a la fecha de Proceso del dscto.    
                    if( ( $d['cuotaActual'] < $d['cuotaTotal'] ) && ( $d['fechaFinalizacion'] != leadZero($mes)."-".$year ) ){
                        $db->where('id',$d['id']);
                        $db->update( 't_descuento', array( 'cuotaActual' => ( $cuotaActual + 1 ), 'procesado' => '1', 'fechaFinalizacion' => leadZero($mes)."-".$year, )  );                    
                    } elseif( $d['cuotaTotal'] != 0 ) {
                        
                        // Actualizar campo FINALIZACION con mes y año de periodo y Activo = 0
                        $db->where('id',$d['id']); 
                        $db->update( 't_descuento', array( 'activo' => 0, 'fechaFinalizacion' => leadZero($mes)."-".$year, 'procesado' => '1' )  ); 
                    }         
                } else { // Sino, es UPDATE de liquidacion
                    if(  ( $d['fechaFinalizacion'] == leadZero($mes)."-".$year ) && ( $d['activo'] == 1 ) ){
                        $cuotaActual = ( $d['cuotaActual'] - 1 );
                    } else {
                        if( ( $d['cuotaActual'] < $d['cuotaTotal'] ) && ( $d['cuotaTotal'] != 0 ) ){
                            $cuotaActual = $d['cuotaActual'];
                            $db->where('id',$d['id']);
                            $db->update( 't_descuento', array( 'cuotaActual' => ( $cuotaActual + 1 ), 'procesado' => '1', 'fechaFinalizacion' => leadZero($mes)."-".$year )  );
                        } elseif( $d['cuotaTotal'] != 0 ) {
                            // Actualizar campo FINALIZACION con mes y año de periodo y Activo = 0
                            $cuotaActual = $d['cuotaActual'];
                            $db->where('id',$d['id']); 
                            $db->update( 't_descuento', array( 'activo' => 0, 'fechaFinalizacion' => leadZero($mes)."-".$year, 'procesado' => '1' )  ); 
                        } 
                    }                                                    
                }
                
                
                
                $valor_tipo_moneda = getValorMoneda(getMesMostrarCorte(),getAnoMostrarCorte(),$d['tipomoneda_id']);
                $valor_subtotal = ( $valor_tipo_moneda * $d['valor'] );
                
                $monto = $valor_subtotal;
            

                $arr_l_debe = array(
                    'liquidacion_id' => $liquidacion_id,
                    'descuento_id' => $d['descuento_id'],
                    'glosa' => $d['glosa'],
                    'monto' => $monto,
                    'cuotaActual' => $cuotaActual,
                    'cuotaTotal' => $d['cuotaTotal']
                );
                $db->insert('l_descuento',$arr_l_debe);            
            }
        }
        



        
        // Haberes
        $db->where('liquidacion_id',$liquidacion_id);
        $db->delete('l_haber');     
        
        $query_desc = "SELECT * FROM t_haber WHERE activo = 1 OR ( activo = 0 AND fechaFinalizacion = '".leadZero($mes)."-$year' ) ORDER BY mesInicio DESC";
        $haberes_trabajador = $db->rawQuery( $query_desc );                
        
        
        foreach( $haberes_trabajador as $d ){
        if( $d['trabajador_id'] == $trabajador_id ){
            if( $liquidacion_action == 'INSERT' ){ // Liquidacion Nueva
                $cuotaActual = $d['cuotaActual']; 
                
                if( ( $d['cuotaActual'] < $d['cuotaTotal'] ) && ( $d['cuotaTotal'] != 0 ) ){
                    $db->where('id',$d['id']);
                    $db->update( 't_haber', array( 'cuotaActual' => ( $cuotaActual + 1 ), 'procesado' => '1' )  );                    
                } elseif( $d['cuotaTotal'] != 0 ) {
                    
                    // Actualizar campo FINALIZACION con mes y año de periodo y Activo = 0
                    $db->where('id',$d['id']); 
                    $db->update( 't_haber', array( 'activo' => 0, 'fechaFinalizacion' => leadZero($mes)."-".$year, 'procesado' => '1' )  ); 
                }         
            } else { // Sino, es UPDATE de liquidacion
                if( $d['procesado'] == 1 ){
                    $cuotaActual = ( $d['cuotaActual'] - 1 );   
                } else {
                    if( ( $d['cuotaActual'] < $d['cuotaTotal'] ) && ( $d['cuotaTotal'] != 0 ) ){
                        $cuotaActual = $d['cuotaActual'];
                        $db->where('id',$d['id']);
                        $db->update( 't_haber', array( 'cuotaActual' => ( $cuotaActual + 1 ), 'procesado' => '1' )  );
                    } elseif( $d['cuotaTotal'] != 0 ) {
                        // Actualizar campo FINALIZACION con mes y año de periodo y Activo = 0
                        $db->where('id',$d['id']); 
                        $db->update( 't_haber', array( 'activo' => 0, 'fechaFinalizacion' => leadZero($mes)."-".$year, 'procesado' => '1' )  ); 
                    } 
                }                                                    
            }
            
            if( $d['tipomoneda_id'] == ID_UF ){
                $uf = getUF($mes,$year);
                $monto = ( $d['valor'] * $uf );
            } else {
                $monto = $d['valor']; 
            }
            
            
            $arr_l_haber = array(
                'liquidacion_id' => $liquidacion_id,
                'haber_id' => $d['haber_id'],
                'glosa' => $d['glosa'],
                'monto' => $monto,
                'cuotaActual' => $cuotaActual,
                'cuotaTotal' => $d['cuotaTotal']
            );
                                                
            $db->insert('l_haber',$arr_l_haber);            
        }
        }
        
        
        
                
        
        
        // APVs
        $db->where('liquidacion_id',$liquidacion_id);
        $db->delete('l_apv');                         
        
        $apv_trabajador = apvTrabajador($trabajador_id);        
        
        foreach( $apv_trabajador as $apv ){            
            $arr_l_apv = array(
                'liquidacion_id' => $liquidacion_id,
                'institucion_id' => $apv['institucion_id'],
                'monto' => $apv['monto'],
                'tipo' => $apv['tipo']
            );
                                                
            $db->insert('l_apv',$arr_l_apv);            
        }
        
        
        $_SESSION[PREFIX.'totales_liquidar'] = null;                          
        $response = encrypt('status=success&mensaje=El registro se ha guardado correctamente&id='.$liquidacion_id);
        redirect(BASE_URL . '/' . $entity . '/ver/' . $trabajador_id . '/response/' . $response );
        exit();
    }
    
    
    if( $action == 'historial' ){
        $db->setTrace(1);
        $db->where("trabajador_id",$hdn_trabajador_id);
        $db->where("mes",$mes_ver_liquidacion);
        $db->where("ano",$ano_ver_liquidacion);
        $liq_id = $db->getValue('liquidacion','id');
        
        if( $liq_id ){ 
            redirect(BASE_URL.'/private/pdfgen.php?id='.encrypt($liq_id));
        } else {
            goBack('No existen liquidaciones con los datos ingresados');
        }
            
    }


    if( $action == 'liquidar_batch'){
        
        $liquidacion_id = liquidarBatch($_POST['trabajador_id']);

        $json = [
            'data' => $_POST,
            'liquidacion_id' => $liquidacion_id
        ];

        echo json_encode($json);
        exit();

    }


        
}



if( isset($parametros[1]) ){

            
    $trabajador_id = $parametros[1];
    $total_descuento_atrasos = obtenerTotalDescuentoXAtrasos($trabajador_id);

    $db->where('trabajador_id',$trabajador_id);
    $db->orderBy('id', 'DESC');
    $ultima_liquidacion = $db->getOne('liquidacion');
    $ultima_liquidacion = getNombreMes($ultima_liquidacion['mes']).'/'.$ultima_liquidacion['ano'];    
    
    $mes = getMesMostrarCorte();
    $uf = getUF($mes,$year);
    
    $db->where ("id", $trabajador_id);
    $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
    $trabajador = $db->getOne("m_trabajador");      

    $nombre_split = explode(" ", $trabajador['nombres']);
    $trabajador['nombres'] = $nombre_split[0];
    
    if( !$trabajador ){
        redirect(BASE_URL.'/trabajador/listar','',true,'El trabajador no existe en la empresa\n(Acceda a la lista de trabajadores y presione el boton liquidar o revise la empresa seleccionada actualmente)');        
        exit();
    } 


    //Determinar si eltrabajador esta contratado en la fecha que se esta liquidando
    $sql = "select 
                month(T.fechaContratoInicio) AS mes,
                year(T.fechaContratoInicio) AS ano
            FROM m_trabajador T 
            WHERE T.id = $trabajador_id";
    $result = $db->rawQuery($sql);
    $result = $result[0];
    $concat_fecha_contrato = $result['ano'].$result['mes'];

    $concat_fecha_liq = getAnoMostrarCorte().leadZero($mes);

    if( $concat_fecha_liq < $concat_fecha_contrato ){
        redirect(BASE_URL.'/trabajador/editar/'.$trabajador_id,'',true,'No se puede liquidar el trabajador, porque la fecha de inicio de su contrato es despueés del mes que se esta liquidando');
        exit();
    }
        
    
    /*    
    $sql_haberes = "
    SELECT H.nombre, TH.valor, H.comision AS es_comision, TH.glosa
    FROM m_haber H, t_haber TH 
    WHERE H.imponible = 1 
    AND H.id = TH.haber_id 
    AND TH.trabajador_id = $trabajador_id
    AND TH.activo = 1
    ORDER by H.nombre DESC
    ";
    */

            
    $sql_haberes = "
    SELECT H.nombre, TH.valor, TH.tipomoneda_id, H.comision AS es_comision, TH.glosa        
    FROM m_haber H, t_haber TH 
    WHERE trabajador_id = $trabajador_id
    AND H.imponible = 1
    AND H.id = TH.haber_id  
    AND TH.activo = 1 
    OR (
        TH.activo = 0 
        AND fechaFinalizacion = '".leadZero($mes)."-$year' 
        AND trabajador_id=$trabajador_id
        AND H.imponible = 1
        AND H.id = TH.haber_id 
    )              
    ORDER BY mesInicio DESC ";                            
    $haberes_imponibles = $db->rawQuery($sql_haberes);
                    
    $total_haberes_comision = 0;
    $total_haberes_imponibles = 0;

    foreach( $haberes_imponibles as $h ){
        $valor_tipo_moneda = getValorMoneda(getMesMostrarCorte(),getAnoMostrarCorte(),$h['tipomoneda_id']);
        $valor_subtotal = ( $valor_tipo_moneda * $h['valor'] );
        
        if( $h['es_comision'] == 1 ){                                
            $total_haberes_comision += $valor_subtotal;
        }
        $total_haberes_imponibles += $valor_subtotal;
    }                    
    

    $sql_haberes_no_imp = "
    SELECT H.nombre, TH.valor, H.comision AS es_comision, TH.glosa        
    FROM m_haber H, t_haber TH 
    WHERE trabajador_id = $trabajador_id
    AND H.imponible = 0
    AND H.id = TH.haber_id  
    AND TH.activo = 1 
    OR (
        TH.activo = 0 
        AND fechaFinalizacion = '".leadZero($mes)."-$year' 
        AND trabajador_id=$trabajador_id
        AND H.imponible = 0
        AND H.id = TH.haber_id 
    )              
    ORDER BY mesInicio DESC ";
    $haberes_no_imponibles = $db->rawQuery($sql_haberes_no_imp);

            
    
    if( ( empresaUsaRelojControl() ) && ( relojControlSync() ) && ( marcaTarjeta($trabajador_id) ) ){        
        $atrasos_entrada = obtenerAtrasosAusenciasTrabajador($trabajador_id,'I');
        $atrasos_salida = obtenerAtrasosAusenciasTrabajador($trabajador_id,'O');
    } else {
        
        $mes = getMesMostrarCorte();            
        $ano = getAnoMostrarCorte();
        $query = "select * from t_relojcontrol where mes = $mes AND ano = $ano AND trabajador_id = $trabajador_id";
        $relojcontrol = $db->rawQuery( $query );
                    
        
        if( $relojcontrol ){
            $relojcontrol = $relojcontrol[0];
            $total_horas_atraso = ( $relojcontrol['hrRetraso'] * 60 ); // en min.
            $total_descontar_atrasos = $total_horas_atraso_minutos * $total_horas_atraso;
        } else {
            $total_horas_atraso = 0;
            $total_descontar_atrasos = 0;
        }
                    
        $atrasos_entrada = array(
            'total_atraso' => $total_horas_atraso
        );
        $atrasos_salida  = array(
            'total_atraso' => 0
        );
    }

    $licencias = obtenerLicencias($trabajador_id);

    $arr_ausencias = @obtenerAusencias($trabajador_id);
        
    $dias_del_mes = 30;

    $ausencias = $arr_ausencias['total'];


    $dias_licencia = $arr_ausencias['dias_licencia'];
    $dias_sin_goce = $arr_ausencias['dias_sin_goce'];

   

    $ausencias_efectivas = (
        $arr_ausencias['dias_licencia_efectivas'] + 
        $arr_ausencias['dias_ausentismo'] + 
        $arr_ausencias['dias_finiquito'] + 
        $arr_ausencias['dias_no_enrolado'] 
    );


    // AUSENCIAS
    // 31 - AUSENCIAS
    // 30 - AUSENCIAS
    // 28 - AUSENCIAS
    // 29 - AUSENCIAS

    $dias_no_enrolado = 0;    
    $horas_extra = obtenerHoraExtraTrabajador($trabajador_id);                

    $total_atrasos = obtenerTotalAtrasos($atrasos_entrada['total_atraso'], $atrasos_salida['total_atraso'],$ausencias); 

    $dias_trabajados = $dias_del_mes - $ausencias_efectivas;

    
    if( ( getLimiteMes(getMesMostrarCorte()) < 30) && ( $arr_ausencias['dias_licencia'] >= getLimiteMes(getMesMostrarCorte()) ) ){
        $dias_trabajados = 0;
    }

    if( $dias_trabajados < 0 ){
        $dias_trabajados = 0;
    }


    if( gratificacion( $trabajador_id ) ){
        $gratificacion = calcularGratificacion($dias_trabajados);
    } else {
        $gratificacion = 0;
    }
    
    $sueldo = calcularSueldo($trabajador_id, $gratificacion);

    $hh = calcularValorHH($trabajador_id);
                
    $db->where('id',$trabajador_id);
    $factor_extra_normal = $db->getValue('m_trabajador','factorHoraExtra');
    
    $db->where('id',$trabajador_id);
    $factor_extra_festivos = $db->getValue('m_trabajador','factorHoraExtraEspecial');                                
    
    $hora_extra_normal = round($hh * $factor_extra_normal * $horas_extra['normal'],0 );
            
    
    $hora_extra_festivo = ($hh * $factor_extra_festivos * $horas_extra['festivo'] );
    
    $semana_corrida = obtenerSemanaCorrida($total_haberes_comision);        
    /*
    if( !$semana_corrida ){
        goBack('No ha definido la semana corrida para el mes');
        exit();
    }
    */

    $remuneracion_tributable = ( $sueldo + $gratificacion + $hora_extra_normal + $hora_extra_festivo + $total_haberes_imponibles + $semana_corrida );        
    
    $tope = obtenerTope(1);
    
    if(!$tope){
        redirect( BASE_URL.'/trabajador/listar','',true,'No ha definido el valor de Renta Tope Imponible');
        exit();   
    }   

    if( $remuneracion_tributable > $tope ){
        if( ( $ausencias > 0 ) && ( $ausencias != 30 ) ){
            $total_imponible = ($tope / 30) * ( 30 - $ausencias );
        } else {
            $total_imponible = $tope;            
        }
    } else {
        $total_imponible = $remuneracion_tributable;
    }


    if($licencias > 0){
        $sueldo_SUPER = ( ( $total_imponible / ( 30 - $ausencias ) ) * 30 );

        if( $sueldo_SUPER > $tope ){
            $total_imponible = ( ( $tope / 30 ) * ( 30 - $ausencias ) );
        }
    }

    // Lineas comentadas por instruccion de Abigail
    /* Si el trabajador tiene ausencias, sean licencias o ausentismos
    la formula es ( $tope / 30 * dias_trabajados ) donde TOPE ya esta definidio si es mayo o menor
    Fecha: 07-Dic-2017

    $licencias = obtenerLicencias($trabajador_id);    
    if($licencias){
        if( ($remuneracion_tributable / ( 30 - $licencias ) * 30 ) > $tope ){
            $total_imponible_proporcional = ( ( $tope / 30  ) * ( 30 - $licencias ) );
            $total_imponible = $total_imponible_proporcional;
        }
    }
    */




    //$total_imponible = ($tope / 30) * ( 30 - $ausencias );




    $db->where('trabajador_id',$trabajador_id);
    $prevision_trabajador = $db->getOne('t_prevision');
            
    $afp_id = $prevision_trabajador['afp_id'];    
    $afp_trabajador['nombre'] = fnGetNombre($afp_id,'m_afp',0);
    
    $db->where('afp_id',$afp_id);
    $db->orderBy('ano','DESC');
    $db->orderBy('mes','DESC');
    $afp_trabajador['valor'] = $db->getValue('m_afpvalores','porCientoPension');
    
   
    if( trabajadorEstaEnFonasa($trabajador_id) ){
        $total_salud = ($total_imponible * 0.07);
        $total_salud_legal = round($total_imponible * 0.07, 0);
        $diferencia_isapre = 0;         
    } else {
        
        if($dias_licencia > 0){
            $dias_trabajados_licencia = ( $dias_del_mes - $arr_ausencias['dias_licencia_efectivas'] );
            $proporcional_pactado_licencia = ( ( $prevision_trabajador['montoPlan'] / 30 ) * ( $dias_trabajados_licencia ) );
        } else {
            $proporcional_pactado_licencia = $prevision_trabajador['montoPlan'];
        }

        // Licencia el MES COMPLETO en Febrero
        if( ( getLimiteMes(getMesMostrarCorte()) < 30) && ( $arr_ausencias['dias_licencia_efectivas'] >= 28 ) ){
            $proporcional_pactado_licencia = 0;
        }

        $total_salud_legal = ($total_imponible * 0.07);

        if( $prevision_trabajador['tipomoneda_id'] == ID_UF ){                                
            $total_pactado_isapre = ( $prevision_trabajador['montoPlan'] * $uf);
            $proporcional_pactado_licencia_en_pesos = ($proporcional_pactado_licencia * $uf);

        } else {
            $total_pactado_isapre = $prevision_trabajador['montoPlan'];
            $proporcional_pactado_licencia_en_pesos = $proporcional_pactado_licencia;
        }

        
        if( $proporcional_pactado_licencia_en_pesos > $total_salud_legal ){
            $diferencia_isapre = ( $proporcional_pactado_licencia_en_pesos - $total_salud_legal ); 


            if($arr_ausencias['dias_finiquito'] > 0){
                $prop = ($total_pactado_isapre / 30 ) * ( $dias_trabajados );
                
                if( $prop < $total_salud_legal ){
                    $prop = $total_salud_legal;
                }

                $diferencia_isapre = (( $total_salud_legal - $prop ) * -1);

                if( $_SESSION[PREFIX . 'login_eid'] == 14 ){
                    $diferencia_isapre = ( $proporcional_pactado_licencia_en_pesos - $total_salud_legal );
                }

            }
        } else {
            $diferencia_isapre = 0;
        }
        
    }
     
     /*   
    $db->where("trabajador_id", $parametros[1]);
    $db->where("activo", 1);
    $db->where("descuento_id", ID_ANTICIPO, "<>");
    $db->orderBy('mesInicio','DESC');
    $debes_trabajador = $db->get("t_descuento");        
    */
    

    
    
    /* ANTICIPO ******************************
    $db->where("trabajador_id", $parametros[1]);
    $db->where("activo", 1);
    $db->where("descuento_id", ID_ANTICIPO);
    $db->orderBy('mesInicio','DESC');        
    $anticipo = $db->getValue("t_descuento",'valor'); 
    */   
    
    $anticipo = 0;
    $sql_anticipo = "
    SELECT * FROM `t_descuento` 
    WHERE trabajador_id = $trabajador_id 
    AND activo = 1 
    AND descuento_id IN (select id from m_descuento where mostrarAbajo = 1)
    OR ((activo = 0 and fechaFinalizacion = '".leadZero($mes)."-$year') and trabajador_id = $trabajador_id AND descuento_id IN (select id from m_descuento where mostrarAbajo = 1) ) 
    ORDER BY id DESC";                
    $anticipos = $db->rawQuery( $sql_anticipo );
    
    if( $anticipos ){
        foreach( $anticipos as $a ){
            $anticipo += $a['valor'];    
        }            
    } 
    
    
    
    $db->where('id',$_SESSION[PREFIX.'login_eid']);
    $empresa = $db->getOne('m_empresa');      
    
       
    $db->where("trabajador_id",$trabajador_id);
    $db->where("mes",$mes);
    $db->where("ano",$year);
    $liq = $db->getOne('liquidacion');

    if( $db->count > 0 ){
        $puede_exportar = true;
        $liquidacion_id = $liq['id'];
    } else {
        $puede_exportar = false;
        $liquidacion_id = null;
    }
     
}


if($parametros[0] == 'batch'){


    if(!$_GET['depto']){
        $departamentos = $db->orderBy('nombre','ASC')
        ->get('m_departamento');
    } else {
        $nombre_depto = getNombre($_GET['depto'],'m_departamento', false);

        $trabajadores_liquidar = $db->where('empresa_id',$_SESSION[PREFIX.'login_eid'])
        ->where('tipocontrato_id',array(3,4),'NOT IN')
        ->where('departamento_id',$_GET['depto'])
        ->get('m_trabajador',null,['apellidoPaterno','apellidoMaterno','nombres','id','departamento_id']);

        if(count($trabajadores_liquidar) == 0){
            goBack('No hay trabajadores en el Departamento seleccionado');
            exit();
        }

        $trabajadores_ids_todos = [];
        $trabajadores_nombres = [];

        foreach ($trabajadores_liquidar as $key => $value) {
            $trabajadores_ids_todos[] = $value['id'];
            $trabajadores_nombres[$value['id']] = $value['apellidoPaterno'] . ' ' . $value['apellidoMaterno'] . ' ' . $value['nombres'];
        }


    }

}



if( $parametros[0] == 're_sis_sces' ){

    if( $parametros[1] && $parametros[2] ):


        $db->orderBy('apellidoPaterno','ASC');
        $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
        $db->where('tipocontrato_id',array(3,4),'NOT IN');
        $trabajadores_todos = $db->get('m_trabajador');
        
        //$trabajadores_todos = [ ['id' => 111] ]; // Probar con 1 solo trabjador

        foreach ($trabajadores_todos as $key => $trabajador) {
            
            $db->where('mes',$parametros[1]);
            $db->where('ano',$parametros[2]);
            $db->where('trabajador_id',$trabajador['id']);
            $data_trabajador = $db->getOne('liquidacion');

            if( $data_trabajador ){

                $sis = calcularSis($data_trabajador['totalImponible'],$trabajador['id'], $parametros[1], $parametros[2]);
                $sces = calcularSCes($data_trabajador['totalImponible'],$trabajador['id'],$parametros[1],$parametros[2]);

                $data_array = [
                    'sis' => $sis,
                    'sces' => $sces
                ];
                
                /*
                echo $parametros[1]."/".$parametros[2];
                show_array(getNombreTrabajador($trabajador['id'],true) . " - " . $parametros[1] ."/".$parametros[2],0);
                show_array($data_array,0);
                echo "<hr>";
                */
                
                $db->where('mes',$parametros[1]);
                $db->where('ano',$parametros[2]);
                $db->where('trabajador_id',$trabajador['id']);
                if($db->update('liquidacion', $data_array))
                     show_array($trabajador['apellidoPaterno'] . ' ' . $trabajador['nombres'] . ' ........................................... Actualizado OK! <br>',0);
                else 
                    show_array($trabajador['apellidoPaterno'] . ' ' . $trabajador['nombres'] . ' ........................................... Actualizado ERROR! <br>',0);
            }

        }

    else:
        echo "No ha pasado el mes y año por parametro";
    endif;

    exit();

}


if( $parametros[0] == 'reliquidar' ){

    $mes = 8;
    
    $db->orderBy('apellidoPaterno','ASC');
    $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
    $db->where('tipocontrato_id',array(3,4),'NOT IN');
    $db->where('marcaTarjeta',1);
    @$trabajadores_todos = $db->get('m_trabajador');

    $fecha_inicio_sql = $year."-".leadZero($mes)."-".getLimiteMes($mes);

    foreach ($trabajadores_todos as $trabjador) {


        $trabajador_id = $trabjador['id'];

        $query_habers = "
        SELECT T.valor FROM t_haber T, m_haber H
        WHERE T.trabajador_id = $trabajador_id
        AND T.fechaInicio <= '$fecha_inicio_sql'
        AND T.activo = 1 
        AND T.haber_id = H.id
        AND H.imponible = 1
        OR
            (
                T.activo = 0 
                and T.fechaFinalizacion = '$mes-$year' 
                AND T.trabajador_id = $trabajador_id
                AND T.haber_id = H.id
                AND H.imponible = 1
            )  
        ORDER BY mesInicio DESC
        ";
        $haberes_trabajador = $db->rawQuery($query_habers);
        
       
        $tot_habers_imponibles = 0;
        foreach ($haberes_trabajador as $h) {
            $tot_habers_imponibles += $h['valor'];
        }

        $db->where("trabajador_id",$trabajador_id);
        $db->where("mes",$mes);
        $db->where("ano",$year);
        $liq = $db->getOne('liquidacion');


        $array_data = [
            'totalHaberesImponibles' => $tot_habers_imponibles
        ];

        show_array(getNombreTrabajador($trabajador_id, 0) . ":" . $tot_habers_imponibles, 0);

        if( $db->count > 0 ){            
            $liquidacion_id = $liq['id'];
            //$db->where('id',$liquidacion_id);
            //$db->update('liquidacion', $array_data );
            $liquidacion_action = "UPDATE";
        } 


    }

}





if( $parametros[0] == 'reliquidar_bonos' ){

    $mes = $parametros[1];
    $year = $parametros[2];
    $ccosto = $parametros[3];


    $db->orderBy('apellidoPaterno','ASC');
    $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
    $db->where('tipocontrato_id',array(3,4),'NOT IN');
    $db->where('centrocosto_id',$ccosto); // ADM:2 - TEC:3 - COM:4

    @$trabajadores_todos = $db->get('m_trabajador');


    echo "<table class='table table-striped' style='width: 500px'>";

    foreach ($trabajadores_todos as $key => $trab) {

            $trabajador_id = $trab['id'];

            $db->where("trabajador_id",$trabajador_id);
            $db->where("mes",$mes);
            $db->where("ano",$year);
            $liq = $db->getOne('liquidacion');

            if( $liq ){

                $liquidacion_id = $liq['id'];
            
                $sql_haberes = "
                SELECT H.nombre, LH.monto, H.comision AS es_comision, LH.glosa
                FROM m_haber H, l_haber LH
                WHERE liquidacion_id = $liquidacion_id
                AND H.imponible = 1
                AND H.nombre like 'bono%'
                AND H.id = LH.haber_id
                ORDER BY LH.id ASC ";
                $haberes_imponibles = $db->rawQuery($sql_haberes);

               
                $total_haberes_imponibles = 0;
                foreach( $haberes_imponibles as $dt ){
                    if( $dt['es_comision'] == 0 ){
                        $valor_subtotal = $dt['monto'] ;
                        $total_haberes_imponibles += $valor_subtotal;
                    }
                }

                $array_data = [
                    'totalHaberesImponibles' => $total_haberes_imponibles
                ];

                $db->where('id',$liquidacion_id);
                $db->update('liquidacion', $array_data );

            }


            echo '
            <tr>
                <td>'.getNombreTrabajador($trab['id'], false).'</td>
                <td>'.$total_haberes_imponibles.'</td>
            </tr>';

    } 

    echo "</table>";  
}


if( ( $parametros[0] == 'ver' ) && ( !isset($parametros[1]) ) ){
    redirect(BASE_URL . '/trabajador/listar');
}


if( $parametros[0] == 'editar_sis_sces' ){

    if( $_GET['mes'] && $_GET['ano'] ){

        extract($_GET);
        $sql = "
        SELECT 
            T.id as trabajador_id, 
            L.id as liquidacion_id, 
            T.id, T.apellidoPaterno, 
            T.apellidoMaterno, 
            T.nombres, 
            L.sis, 
            L.sces
        from m_trabajador T, liquidacion L
        WHERE L.trabajador_id = T.id
        AND L.mes = $mes
        AND L.ano = $ano
        ";

        $registros = $db->rawQuery($sql);

    } else {
        $registros = [];
    }

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

<?php exit(); ?>

