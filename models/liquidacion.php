<?php

/**
 * Calcula el Costo empresa SIS
 * @param (int) $rentaImponible Total imponible del mes
 * @param (int) $trabajador_id ID del trabajador a calcular
 * @return (floar) $sis Total SIS calculado
 */


function calcularSis($rentaImponible, $trabajador_id = 0, $mes, $ano){
    global $db;

    $mes_corte = $mes;
    $ano_corte = $ano;

    //Tipos de trabajadores pensionados a quienes no se paga SIS
    $no_sis = [];
    $db->where ("sis", 0);
    $result_no_sis = $db->get('m_tipotrabajador');
    foreach ($result_no_sis as $res) {
        $no_sis[] = $res['id'];
    }
    
    //Trabajador cuyo "tipo_trabajador" NO paga SIS
    $db->where('tipotrabajador_id', $no_sis, 'IN');
    $db->where('id', $trabajador_id);
    $trabajador_no_sis = $db->get('m_trabajador');


    if(count($trabajador_no_sis) > 0){
        return 0;
    } else {

        $dias_ausencias = obtenerAusencias($trabajador_id);

        $dias_a_pago = (30 - $dias_ausencias['total']);


        // Si tiene licencias tomamos el imponible del ultimo mes que no tuvo licencia 
        if( $dias_ausencias['dias_licencia'] > 0 ){ 
            $db->where('trabajador_id',$trabajador_id);
            $db->where('mes',$mes_corte);
            $db->where('ano',$ano_corte);
            $result2 = $db->getOne('liquidacion');
            $imponible = $result2['totalImponible'];

            $db->where('trabajador_id',$trabajador_id);
            $db->where('diaLicencia',0);
            $db->orderBy("ano","DESC");
            $db->orderBy("mes","DESC");
            $result = $db->getOne('liquidacion');
            $imponible_licencia = $result['totalImponible'];

        } else {
            $db->where('trabajador_id',$trabajador_id);
            $db->where('mes',$mes_corte);
            $db->where('ano',$ano_corte);
            $result = $db->getOne('liquidacion');
            $imponible = $result['totalImponible'];

            $imponible_licencia = $imponible;
        }


        $db->where ("costoempresa_id", 1);
        $db->orderBy('ano',"desc");
        $db->orderBy('mes',"desc");
        $valores = $db->getOne("m_costoempresa");

        $porcentajeCostoEmpresa = ($valores['valor'] / 100);


        // Renta imponible Mes
        $renta_imponible_mes = $imponible;
        $sis__renta = ($renta_imponible_mes * $porcentajeCostoEmpresa);

         

        // Renta Imponible licencia médica
        $renta_imponible_licencia = ( ($imponible_licencia / 30) * $dias_ausencias['dias_licencia'] );
        $sis__licencia = ($renta_imponible_licencia * $porcentajeCostoEmpresa);

        $total_cotizacion_sis = ($sis__renta + $sis__licencia);



        return $total_cotizacion_sis;

    }
}



/**
 * Calcula el Costo empresa Seguro Cesantia
 * @param (int) $rentaImponible Total imponible del mes
 * @param (int) $trabajador_id ID del trabajador a calcular
 * @return (floar) Total SIS calculado
 */
function calcularSCes($rentaImponible, $trabajador_id = 0, $mes, $ano){
    global $db;

    $mes_corte = $mes;
    $ano_corte = $ano;


    //Tipos de trabajadores que solo la empresa paga, pero el 0.8%
    $no_sces_full_empresa = [];
    $db->where ("sces_full_empresa", 1);
    $result_no_sces = $db->get('m_tipotrabajador');
    foreach ($result_no_sces as $res) {
        $no_sces_full_empresa[] = $res['id'];
    }


    //Tipos de trabajadores sin SCES
    $no_sces = [];
    $db->where ("sces", 0);
    $result_no_sces = $db->get('m_tipotrabajador');
    foreach ($result_no_sces as $res) {
        $no_sces[] = $res['id'];
    }

    
    //Consulta si el "tipo_trabajador" es Empresa que paga el 0.8%
    $db->where('tipotrabajador_id', $no_sces_full_empresa, 'IN');
    $db->where('id', $trabajador_id);
    $trabajador_sces_full_empresa = $db->get('m_trabajador');

    
    //Consulta si el "tipo_trabajador" NO paga SCES
    $db->where('tipotrabajador_id', $no_sces, 'IN');
    $db->where('id', $trabajador_id);
    $trabajador_no_sces = $db->get('m_trabajador');


    if(count($trabajador_no_sces) > 0){
        return 0;
    } else {

        $dias_ausencias = obtenerAusencias($trabajador_id);

        $dias_a_pago = (30 - $dias_ausencias['total']);


        if( $dias_ausencias['dias_licencia'] > 0 ){ 
            $db->where('trabajador_id',$trabajador_id);
            $db->where('mes',$mes_corte);
            $db->where('ano',$ano_corte);
            $result2 = $db->getOne('liquidacion');
            $imponible = $result2['totalImponible'];

            $db->where('trabajador_id',$trabajador_id);
            $db->where('diaLicencia',0);
            $db->orderBy("ano","DESC");
            $db->orderBy("mes","DESC");
            $result = $db->getOne('liquidacion');
            $imponible_licencia = $result['totalImponible'];

        } else {
            $db->where('trabajador_id',$trabajador_id);
            $db->where('mes',$mes_corte);
            $db->where('ano',$ano_corte);
            $result = $db->getOne('liquidacion');
            $imponible = $result['totalImponible'];

            $imponible_licencia = $imponible;
        }



        //Obtener el tipo de contrato del trabajadaor para saber que Taza utilizar
        $db->where('id',$trabajador_id);
        $tipocontrato_id = $db->getValue("m_trabajador",'tipocontrato_id');

        switch( $tipocontrato_id ){
            case 1: $costoempresa_id = 3; break;
            case 2: $costoempresa_id = 4; break;
            default:  $costoempresa_id = 0; break;
        }

        $db->where ("costoempresa_id", $costoempresa_id);
        $db->orderBy('ano',"desc");
        $db->orderBy('mes',"desc");
        $valor = $db->getValue("m_costoempresa","valor");

        if( count( $trabajador_sces_full_empresa ) > 0 ){
            $valor = 0.8;
        }

        $porcentajeCostoEmpresa = ($valor / 100);

        // Renta imponible Mes
        $renta_imponible_mes = $imponible;
        $sces_renta = ($renta_imponible_mes * $porcentajeCostoEmpresa);
        


        // Renta Imponible licencia médica
        $renta_imponible_licencia = ( ($imponible_licencia / 30) * $dias_ausencias['dias_licencia'] );
        $sces_licencia = ($renta_imponible_licencia * $porcentajeCostoEmpresa);

        $total_cotizacion_sces = ($sces_renta + $sces_licencia);



        return $total_cotizacion_sces;


        
    }
}



/**
 * Calcula el impuesto y devuelve un array con la info  $trabajador_id
 * @param (int) $total_tributable
 * @return (array) Arreglo con el total de impuesto, la rebaja y el impuesto total a pagar
 */
function obtenerTotalRebajaImpuesto($total_afp,$total_salud_legal, $total_salud,$total_afc,$total_apv_A){
    global $db;
    $year = getAnoMostrarCorte();
    $valor_uf = getUF(getMesMostrarCorte(),$year);
    $tope = obtenerTope(1);
    $tope_en_uf = ( ( $tope * 0.07 ) / $valor_uf );         
    
    if( $total_salud_legal > $total_salud ){
        $rebaja_salud = $total_salud_legal;   
    } else {
        $rebaja_salud = $total_salud;
    }
    $rebaja_salud_en_uf = ( $rebaja_salud / $valor_uf );
    
    if( $rebaja_salud_en_uf > $tope_en_uf ){
        $rebaja_salud_total = $tope_en_uf;
    } else {
        $rebaja_salud_total = $rebaja_salud_en_uf;
    }
    
    $rebaja_salud_total = ( $rebaja_salud_total * $valor_uf );
    
    $total_rebaja = ( $total_afp + $rebaja_salud_total + $total_afc + $total_apv_A );
    
    return $total_rebaja;
}



/**
 * Calcula el impuesto para trabajadores agricolas y devuelve un array con la info  
 * @param (int) $totalHaberesImponible
 * @return (array) Arreglo con el total de impuesto, la rebaja y el impuesto total a pagar
 */
function calcularImpuestoAgricola( $totalHaberesImponible){
    global $db;   
    $mes = getMesMostrarCorte();
    $year = getAnoMostrarCorte();
    $valor_utm = getValorMoneda($mes,$year,ID_UTM);
    $utm_x_10 = ( $valor_utm * 10 );
    $impuestoAgricola = 0;
    
    if( $totalHaberesImponible > $utm_x_10 ){
        $impuestoAgricola = ( ( $totalHaberesImponible - $utm_x_10 ) * 0.035 );
    }
    
    return $impuestoAgricola;
}




/**
 * Calcula el impuesto y devuelve un array con la info  
 * @param (int) $total_tributable
 * @return (array) Arreglo con el total de impuesto, la rebaja y el impuesto total a pagar
 */
function calcularImpuesto( $total_tributable){
    global $db;   
    $mes = getMesMostrarCorte();
    $year = getAnoMostrarCorte();

    $valor_utm = getValorMoneda($mes,$year,ID_UTM);    
    
    $total_tributable_utm = ( $total_tributable / $valor_utm );
    
    $total_tributable_utm = round($total_tributable_utm,2);
    
    
    if( $total_tributable_utm > 0 ){    
        $db->where('desde',$total_tributable_utm,'<=');
        $db->where('hasta',$total_tributable_utm,'>=');
        $res = $db->getOne('m_impuestounico');
    } else {
        $res['factor'] = 0;
        $res['rebajar'] = 0;
    }
    
    $subtotal_tributable = ( $total_tributable * $res['factor'] );      
    $cantidad_rebajar = ( $valor_utm * $res['rebajar'] );
    
    $impuesto_pagar = $subtotal_tributable - $cantidad_rebajar;
    $impuesto_pagar = round($impuesto_pagar);                    

    $array_return = array(
        "total_impuesto" =>  $subtotal_tributable,
        "cantidad_rebajar" =>  $cantidad_rebajar,
        "impuesto_pagar" => $impuesto_pagar
    );
        
    return $array_return;
}



/**
 * Devuelve el total a descontar por AFC calculado segun los dias de licencia  
 * @param (int) $remuneracion_tributable
 * @param (int) $total_imponible  
 * @param (int) $ausencias Total de dias de ausencias
 * @param (int) $dias_licencia 
 * @return (number)  Total a descontar por AFC
 */
function obtenerTotalAfc( $remuneracion_tributable, $total_imponible, $ausencias,$dias_licencia ){
    global $db;    
    $tope = obtenerTope(1);            
    $tope_afc = obtenerTope(3);        
                
    
    if( ( $ausencias >=  0 ) && ( $dias_licencia == 0 ) ){        
        if( $remuneracion_tributable > $tope_afc ){            
            $sub_total_afc = ( ($tope_afc / 30 ) * (30 - $ausencias) );            
            $total_afc = ( $sub_total_afc * 0.006 );                            
        } else {
            $total_afc = ( $remuneracion_tributable * 0.006 );
        }
        
    } else {  
        if( $remuneracion_tributable > $tope_afc ){            
            $sub_total_afc = ( ($tope_afc / 30 ) * (30 - $ausencias) );            
            $total_afc = ( $sub_total_afc * 0.006 );                            
        } else {
            $total_afc = ( $remuneracion_tributable * 0.006 );
        }        
    }
    
    return $total_afc;
}

function obtenerTotalAfc2( $tope, $trabajador_id ){    
    global $db;
    
    $mes_corte = getMesMostrarCorte();        
    $year_corte = getAnoMostrarCorte();
    
    //Obtener fecha de inicio de contrato indefinido    
    $db->where('trabajador_id',$trabajador_id);
    $db->where('tipocontrato_id',2);
    $db->where('activo',1);
    $contrato_indefinido = $db->getOne('t_contrato');
    
    if( $contrato_indefinido ){        
        // Si Su contrato indefinido comenzo el mismo mes que se esta liquidando, se restan los dias        
        if(
            ( date('n',strtotime($contrato_indefinido['fechaInicio'])) == $mes_corte )
            &&
            ( date('Y',strtotime($contrato_indefinido['fechaInicio'])) == $year_corte )
          ){
            $datetime1 = new DateTime( $year_corte.'-'.$mes_corte.'-01' );
            $datetime2 = new DateTime( $contrato_indefinido['fechaInicio'] );
            $interval = $datetime1->diff($datetime2);
            
            $dias_sin_afc = $interval->days;

        }      
    }

    $afc_a_pagar = $tope * 0.006;
    
    if( $dias_sin_afc > 0 ){
        $afc_propor_diaria = ( $afc_a_pagar / 30 );
        $total_afc_no_pagar = ( $dias_sin_afc * $afc_propor_diaria );        
        
        $afc_a_pagar = $afc_a_pagar - $total_afc_no_pagar;
    }

    return ( $afc_a_pagar );
}




/**
 * Retorna sobre que monto se esta calculando la AFC  
 * @param (int) $remuneracion_tributable
 * @param (int) $total_imponible  
 * @param (int) $ausencias Total de dias de ausencias
 * @param (int) $dias_licencia 
 * @return (number)  Total a descontar por AFC
 */
function topeAfc( $remuneracion_tributable, $total_imponible, $ausencias,$dias_licencia, $tipocontrato_id){
    
    global $db;                    
    $tope_afc = obtenerTope(3);
    $tope_imponible = obtenerTope(1);
    $ausentismos = $ausencias - $dias_licencia;

    if( ( $ausencias >=  0 ) && ( $dias_licencia == 0 ) ){
        if( $remuneracion_tributable > $tope_afc ){
            if( $tipocontrato_id == 3 ){
                $topeAfcCalcular = $tope_afc;
            } else {
                $sub_total_afc = ( ($tope_afc / 30 ) * (30 - $ausencias) );
                $topeAfcCalcular = $sub_total_afc;
            }
            
        } else {
            $topeAfcCalcular = $remuneracion_tributable;
        }
        
    } else {
        //$res = (( $remuneracion_tributable / (30 - $ausencias) ) * (30 - $ausentismos ) );
        
        $topeAfcCalcular = $total_imponible;

        /*
        if( $res > $tope_afc ){
            $topeAfcCalcular = $tope_afc;
        } else {
            $topeAfcCalcular = $res;
        }
        */

        if( ( $ausencias == 30 ) || ( $dias_licencia == 30 ) ){
            $topeAfcCalcular = 0;
        }
    }

    return $topeAfcCalcular;
}




/**
 * Devuelve un arreglo con el total de atrasos y el monto total (EN PESOS) a descontar   
 * @param (int) $trabajador_id ID del trabajador  
 * @return (array)  Array con la canitdad de atrasos (en HORAS totales) y el monto a descontar (en pesos)
 */
function obtenerTotalDescuentoXAtrasos($trabajador_id, $aplica_gracia = true){
    global $db;
    
    $hh = calcularValorHH($trabajador_id);
    $minuto_hh = ( $hh / 60 );


    if( marcaTarjeta($trabajador_id) ){                              

        $atrasos_entrada = obtenerAtrasosAusenciasTrabajador($trabajador_id,'I');
        $atrasos_salida = obtenerAtrasosAusenciasTrabajador($trabajador_id,'O');


        $total_atrasos = ( $atrasos_entrada['total_atraso'] + $atrasos_salida['total_atraso'] );
        

        $db->where('id',$_SESSION[PREFIX.'login_eid']);
        $minutos_gracia = $db->getValue("m_empresa",'minutoGracia');
        
        if( $aplica_gracia ){
            if( $total_atrasos > $minutos_gracia ){
                $total_atrasos = ($total_atrasos - $minutos_gracia);
            } else{
                $total_atrasos = 0;
            }
        }
                
        $total_horas_atraso = ( $total_atrasos / 60 );
        $total_descontar_atrasos = $total_atrasos * $minuto_hh;

    } else {
        $mes = getMesMostrarCorte();
        $ano = getAnoMostrarCorte();
        $query = "select * from t_relojcontrol where mes = $mes AND ano = $ano AND trabajador_id = $trabajador_id";
        $relojcontrol = $db->rawQuery( $query );

        if( $relojcontrol ){
            $relojcontrol = $relojcontrol[0];
            $total_horas_atraso = $relojcontrol['hrRetraso'];
            $total_horas_atraso_minutos = ( $relojcontrol['hrRetraso'] * 60 ); // en min.
            $total_descontar_atrasos = $total_horas_atraso_minutos * $minuto_hh;
        } else {
            $total_horas_atraso = 0;
            $total_descontar_atrasos = 0;
        }
    }        
    
    
    $arr_return = array(
        "total_horas_atraso" => $total_horas_atraso,
        "total_descontar_atrasos" => $total_descontar_atrasos
    );

    
    return $arr_return;
}


/**
 * Retorna la CUENTA2 del trabajador y sus montos pactados (EN PESOS). Retorna FALSO en caso de no tener   
 * @param (int) $trabajador_id ID del trabajador  
 * @return (array)  Array con el nombre de la CUENTA2 y su valor o FALSE si no tiene
 */
function obtenerPrevisionTrabajador($trabajador_id){
    global $db;    
    $db->where('trabajador_id',$trabajador_id);
    $db->where('cuenta2_id',0,'!=');
    $res = $db->getOne('t_prevision');
    if( !$res ){
        return false;
    } else {
        $nombre_cuenta2 = fnGetNombre($res['cuenta2_id'],'m_afp',0);
        
        if( $res['tipomoneda2_id'] == 2 ){
            $year = getAnoMostrarCorte();
            $valor_uf = getUF(getMesMostrarCorte(),$year);
            $monto_cuenta2 = ( $res['montoCta2'] * $valor_uf );    
        } else {
            $monto_cuenta2 = $res['montoCta2'];
        }
        
        $arr_cuenta2 = array(
            "id" => $res['cuenta2_id'],
            "nombre" => $nombre_cuenta2,
            "monto" => $monto_cuenta2
        );
        
        return $arr_cuenta2;
    }
    
}
    

/**
 * Retorna las APV del trabajador y sus montos pactados (EN PESOS). Retorna FALSO en caso de no tener   
 * @param (int) $trabajador_id ID del trabajador  
 * @return (array)  Array con las APV y sus valores o FALSE si no tiene
 */
function apvTrabajador($trabajador_id){
    global $db;
    $db->where("trabajador_id", $trabajador_id);
    $apvs = $db->get("t_apv");
    $arr_apvs = array();
    $year = getAnoMostrarCorte();
    $valor_uf = getUF(getMesMostrarCorte(),$year);
    if( $db->count > 0 ){
        foreach( $apvs as $apv ){
            if( $apv['tipomoneda_id'] == ID_UF ){
                $arr_apvs[] = array(
                    'institucion_id' => $apv['institucion_id'],
                    'nombre' => fnGetNombre($apv['institucion_id'],'m_institucion',0),
                    'monto' => ( $valor_uf * $apv['monto'] ),
                    'tipo' => $apv['tipo'] 
                );                 
            } else {
                $arr_apvs[] = array(
                    'institucion_id' => $apv['institucion_id'], 
                    'nombre' => fnGetNombre($apv['institucion_id'],'m_institucion',0),
                    'monto' => $apv['monto'],
                    'tipo' => $apv['tipo']
                );            
            }
            
        }        
        return $arr_apvs;
    } else {
        return false;
    }
}


/**
 * Determina si el trabajador se le descuenta o no AFP, Salud, AFC  
 * @param (int) $trabajador_id ID del trabajador 
 * @param (string) $tipo tipo de descuento
 * @return Booleano se descuenta o no, el tipo de descuento pasado por parametro
 */
function tipoTrabajador($tipo, $trabajador_id){
    global $db;
    $db->where('id', $trabajador_id);
    $trabajador = $db->getOne('m_trabajador','tipotrabajador_id');
    
    $db->where($tipo,1);
    $db->where('id',$trabajador['tipotrabajador_id']);
    $res = $db->getValue('m_tipotrabajador',$tipo);
    
    if( $db->count > 0 ){
        return true;
    } else {
        return false;
    }
}

/**
 * Determina si el trabajador esta en Fonasa o no  
 * @param (int) $trabajador_id ID del trabajador 
 * @return Booleano si esta o no en fonasa
 */
function trabajadorEstaEnFonasa($trabajador_id){
    global $db;
    $db->where('trabajador_id', $trabajador_id);
    $res = $db->getValue('t_prevision','fonosa');
    if( $res == 1 ){
        return true;
    } else{
        return false;
    }
}


/**
 * Obtiene el valor de un tope segun el codigo pasado por parametro
 * 1: Rentas Topes Imponibles Para afiliados a una AFP
 * 2: Rentas Topes Imponibles Para afiliados al IPS (ex INP)
 * 3: Rentas Topes Imponibles Para Seguro de Cesantía
 * 4: Rentas Mínimas Imponibles trab. Dependientes e Independientes
 * 5: Rentas Mínimas Imponibles Menores de 18 y Mayores de 65
 * 6: Rentas Mínimas Imponibles Trabajadores de Casa Particular
 * 7: Tope Mensual APV
 * 8: Tope Anual APV
 * 9: Deposito Convenito Tope Anual
 * 
 * @param (int) $codigo Codigo del Tope 
 * @return (int) $valor_tope Valor del Tope en PESOS
 */
function obtenerTope($codigo){
    global $db;                
    
    $db->where('codigo',$codigo);
    $db->orderBy('id', 'DESC');
    $res = $db->getOne('m_tope','valor');    
    $tope_uf = $res['valor']; // En UF    
            
    $mes = getMesMostrarCorte();
    $year = getAnoMostrarCorte();
    $db->where('tipomoneda_id',2);
    $db->where('mes',$mes);
    $db->where('ano',$year);
    $valor_uf = $db->getValue('m_tipomonedavalor','valor');        
    
    
    $valor_tope = ( $valor_uf * $tope_uf);
    
    if( $valor_tope == 0 ){
        return false;
    } else {
        return $valor_tope;
    }        
}


/**
 * Calcula y retorna la semana corrida  
 * @param (int) $haberes_comision Total de Haberes que son de tipo COMISION 
 * @return (int) $semana_corrida Valor Semana Corrida
 */
function obtenerSemanaCorrida($haberes_comision){
    global $db;
    
    $year = getAnoMostrarCorte();
    $mes = getMesMostrarCorte();
    $db->where('mes',$mes);
    $db->where('ano',$year);
    $res = $db->getOne('m_semanacorrida');
    
    if($db->count > 0){
        
        $diashabiles = $res['diasHabiles'];
        $domingosFestivos = $res['domingosFestivos'];            
        $semana_corrida = @( $haberes_comision / $diashabiles ) * $domingosFestivos;                
        
        return round($semana_corrida);
                
    } else {
        return false;
    }  
    
      
}

/**
 * Retorna el valor de una Hora Hombre  
 * @param (int) $id_trabajador ID del trabajador 
 * @return (int) $hh Valor Hora Hombre en pesos
 */
function calcularValorHH($id_trabajador){
    global $db;
    $db->where ("id", $id_trabajador);
    $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
    $trabajador = $db->getOne("m_trabajador");
    $sueldo_base = $trabajador['sueldoBase'];
    
    $subtotal = ( ( ( $sueldo_base / 30 ) * 28 ) / 180 );
    
    $hh = $subtotal;
    
    return $hh;
}

/**
 * Verifica si el trabajador recibe o no gratificacion  
 * @param (int) $trabajador_id ID del trabajador a consultar 
 * @return (bool) TRUE o FALSE segun corresponda
 */
function gratificacion($trabajador_id){
    global $db;
    $db->where('id', $trabajador_id);
    $gratificacion = $db->getValue('m_trabajador','gratificacion');
    if( $gratificacion == 1 ){
        return true;
    } else {
        return false;            
    }
}



/**
 * Retorna el sueldo que debe recibir el trabajador  
 * @param (int) $ausencias Cantidad de dias de ausencias 
 * @return (int) Gratificacion
 */
function calcularGratificacion( $ausencias ){
    global $db;    
    $db->setTrace(true);
    $db->where('codigo',4);
    $db->orderBy('id','DESC');
    $sueldo_minimo = $db->getValue('m_tope','valor');        
    $gratificacion = ( ( $sueldo_minimo * FACTOR_GRATIFICACION ) / 12 );      
    
    if( $ausencias > 0 ){
        $gratificacion = ( $gratificacion / 30 * (30 - $ausencias) ); 
    }
    
    $gratificacion = round($gratificacion);        
    
    return $gratificacion;
}


/**
 * Retorna el sueldo que debe recibir el trabajador  
 * @param (int) $id_trabajador ID del Trabajador 
 * @return (int) Sueldo
 */
function calcularSueldo($id_trabajador){
    global $db;
    
    $sueldo_base    = 0;
    $ausencias      = 0;
    
    $db->where ("id", $id_trabajador);
    $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
    $trabajador = $db->getOne("m_trabajador");
    $sueldo_base = $trabajador['sueldoBase'];        
    
    if( relojControlSync() ){        
        $arr_ausencias = @obtenerAusencias($id_trabajador);                                
        $ausencias = $arr_ausencias['total'];               
    } else {        
        $arr_ausencias = @obtenerAusencias($id_trabajador);                                
        $ausencias = $arr_ausencias['total'];
    }
        
    
    $sueldo_mes = ( ( $sueldo_base / 30 ) * ( 30 - $ausencias ) );        
    
    return $sueldo_mes;
}



/**
 * Retorna el total de Atrasos del Trabajador en MINUTOS TOTALES  
 * @param (int) $id_trabajador ID del Trabajador
 * @param (char) $tipoMarcadoTarjeta Tipo de Marcado ( Entrada "I" o Salida "O" )
 * @return (Array) Arrego con 2 variables total_atraso y dias_ausencia
 */ 
function obtenerAtrasosAusenciasTrabajador($id_trabajador, $tipoMarcadoTarjeta=''){    
    global $db;
        
    $arr_no_marco = array();    
    $total_horas_atraso = 0;    
    
    $db->where ("id", $id_trabajador);
    $db->where ("empresa_id", $_SESSION[ PREFIX . 'login_eid']);
    $trabajador = $db->getOne("m_trabajador");
        
    $db->where('id',$trabajador['horario_id']);
    $m_horarios = $db->getOne('m_horario');    
    
    if( $tipoMarcadoTarjeta == 'I' ){
        $m_horario_definido = $m_horarios['entradaTrabajo'];    
    } elseif($tipoMarcadoTarjeta == 'O') {
        $m_horario_definido = $m_horarios['salidaTrabajo'];    
    } else {
        return false;
        exit();
    }

    $array_dias_temp = array($m_horarios['lun'],$m_horarios['mar'],$m_horarios['mie'],$m_horarios['jue'],$m_horarios['vie'],$m_horarios['sab'],$m_horarios['dom']);
    
    $dias_laborales_horario = array();
    
    foreach( $array_dias_temp as $k => $i ){
        if( $i == 1 ){
            $dias_laborales_horario[] = $k;
        }
    }
    
    $periodo = getPeriodoCorte();
       
    $desde = $periodo['desde'].' 00:00:00';        
    $hasta = $periodo['hasta'].' 23:59:59';        
    
    $fechaInicio = inicioPeriodo($desde,$id_trabajador);
    $fechaFin = finPeriodo($hasta, $id_trabajador);
    
    $db->where('id',$id_trabajador);
    $relojcontrol_id =  $db->getOne('m_trabajador','relojcontrol_id');
    $relojcontrol_id = $relojcontrol_id['relojcontrol_id'];
        
    /**
     * Primer metodo OBSOLETO: comparar con el tipo de marcaje I o O (input, output)
     * DESCARTADO, porque el relojcontrol no siempre marca bien este campo 
    $db->where('userid',$relojcontrol_id);
    $db->where('checktype',$tipoMarcadoTarjeta);
    $db->where ('checktime', $desde, ">=");
    $db->where ('checktime', $hasta, "<=");
    $db->orderBy('checktime', 'ASC');
    $registrosTargetas = $db->get('m_relojcontrol');    
          
    
    * Segundo metodo OBSOLETO: comparar con un umbral de horario seteado por el admin
    * DESCARTADO, porque los usuarios a veces marcan mas de una vez y el sistema se "marea" tomando el marcaje erróneo
    
    if( $tipoMarcadoTarjeta == 'I' ){
        $sql = "
        SELECT  * FROM m_relojcontrol 
        WHERE  userid = '$relojcontrol_id' 
        AND checktime >= '$desde'  
        AND checktime <= '$hasta'  
        AND time( checktime ) < '$umbral'
        ORDER BY checktime ASC
        ";     
    } else {
        $sql = "
        SELECT  * FROM m_relojcontrol 
        WHERE  userid = '$relojcontrol_id' 
        AND checktime >= '$desde'  
        AND checktime <= '$hasta'  
        AND time( checktime ) > '$umbral'
        ORDER BY checktime ASC
        "; 
    }   
    
    $registrosTargetas = $db->rawQuery($sql);
    */
    
    
    /** INICIO MODIFICACION REQ ATRASOS **/   
    /** Toma un rango de fechas y recorre una por una
     * por cada fecha obtiene el primer y ultimo marcaje (entrada y salida respectivamente) y asi omite los marcajes erroneos del usuario entre medio
     * Si hay solo 1 marcaje, recien ahi acude al umbral para saber si marco en la entrada o salida.
    **/
    
    $db->where("id",$_SESSION[PREFIX.'login_eid']);
    $umbral = $db->getValue('m_empresa','umbralRelojControl');
    
    $date_from = strtotime($desde);
    $date_to = strtotime($hasta);
    
    $entradas = array();
    $salidas = array();            
    for($unixtime=$date_from; $unixtime<=$date_to; $unixtime+=86400){            
        $dia_semana = date('N', $unixtime);
        $dia_semana--;
        
        if( in_array($dia_semana,$dias_laborales_horario) ){
            $date_iterar = date('Y-m-d',$unixtime);            
            if( ! isDiaFeriado($date_iterar) ){                    
                $sql = "
                SELECT  * FROM m_relojcontrol 
                WHERE  userid = '$relojcontrol_id' 
                AND checktime LIKE '$date_iterar %'              
                ORDER BY checktime ASC
                ";
                              
                $marcajes = $db->rawQuery($sql);
                if( $db->count == 1 ){
                    $unix_hora_umbral = strtotime( $date_iterar . ' ' . $umbral );                    
                    $unix_hora_marcada = strtotime( $marcajes[0]['checktime'] );
                    if( $unix_hora_marcada > $unix_hora_umbral ){
                        $salidas[] = array(
                            'id' => $marcajes[0]['id'],
                            'userid' => $marcajes[0]['userid'],
                            'checktime' => $marcajes[0]['checktime'],
                            'checktype' => $marcajes[0]['checktype'],
                            'logid' => $marcajes[0]['logid']
                        );
                    } else {
                        $entradas[] = array(
                            'id' => $marcajes[0]['id'],
                            'userid' => $marcajes[0]['userid'],
                            'checktime' => $marcajes[0]['checktime'],
                            'checktype' => $marcajes[0]['checktype'],
                            'logid' => $marcajes[0]['logid']
                        );
                    }   
                } 
                
                if( $db->count > 1 ){
                    
                    $primer_marcaje = 0;
                    $ultimo_marcaje = ( count($marcajes) - 1 );                        
                    $entradas[] = array(
                        'id' => $marcajes[$primer_marcaje]['id'],
                        'userid' => $marcajes[$primer_marcaje]['userid'],
                        'checktime' => $marcajes[$primer_marcaje]['checktime'],
                        'checktype' => $marcajes[$primer_marcaje]['checktype'],
                        'logid' => $marcajes[$primer_marcaje]['logid']
                    );
                    $salidas[] = array(
                        'id' => $marcajes[$ultimo_marcaje]['id'],
                        'userid' => $marcajes[$ultimo_marcaje]['userid'],
                        'checktime' => $marcajes[$ultimo_marcaje]['checktime'],
                        'checktype' => $marcajes[$ultimo_marcaje]['checktype'],
                        'logid' => $marcajes[$ultimo_marcaje]['logid']
                    );
                } 
            
            }
        }                 
                        
    }

    
    if( $tipoMarcadoTarjeta == 'I' ){
        $registrosTargetas = $entradas;
    } else {
        $registrosTargetas = $salidas;
    }   
    
      
    /** FIN MODIFICACION **/
    
    
    
    
    // Iterar cada fecha dentro del periodo
    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
        $flag=0;
        $fecha_iterar = date("Y-m-d", $i);
        
        if( !estaFiniquitado($id_trabajador,$fecha_iterar) ){
        
            if( !esAusencia($id_trabajador,$fecha_iterar) ){
                // Por cada fecha del periodo, comparar con cada registro de marcacion en el reloj control
                if( $registrosTargetas ){        
                    foreach( $registrosTargetas as $marcacion ){
                        $fecha_iterar = date("Y-m-d", $i);
                        $datereg = explode(" ",$marcacion['checktime']);            
                        $str_hora_registro = strtotime( $datereg[1] );
                        $hora_registro = $datereg[1];
            
                        $fecha_comparar = date_create($marcacion['checktime']);
                        $fecha_comparar = date_format($fecha_comparar,"Y-m-d");
                        
                        if($fecha_iterar == $fecha_comparar){
                            $dia_semana = date('N', strtotime($fecha_iterar));
                            $dia_semana--;                                           
                            /** SI es un dia laboral **/
                            if( in_array($dia_semana,$dias_laborales_horario) ){
                                if( !esAusencia($id_trabajador,$fecha_comparar) ){
                                    if( !isDiaFeriado($fecha_comparar) ){
                                        if( $tipoMarcadoTarjeta == 'I' ){
                                            if( $str_hora_registro > strtotime( $m_horario_definido ) ) {
                                                $diff_horas = RestarHoras($m_horario_definido,$hora_registro,$fecha_comparar);
                                                if( !checkIfAutorized(null,$id_trabajador,'A','I',$fecha_iterar) ){
                                                    $total_horas_atraso = ($total_horas_atraso + $diff_horas['minutos']);
                                                }
                                            }
                                        } else {
                                            if( $str_hora_registro < strtotime( $m_horario_definido ) ) {
                                                $diff_horas = RestarHoras($hora_registro,$m_horario_definido,$fecha_comparar);
                                                if( !checkIfAutorized(null,$id_trabajador,'A','O',$fecha_iterar) ){
                                                    $total_horas_atraso = ($total_horas_atraso + $diff_horas['minutos']);
                                                }                                        
                                            }                                                                                                            
                                        }
                                    }                                
                                }
                            }
                            
                            $flag++;
                            break;
                        }
                    }
                }
    
                //echo translateDia( date('D', strtotime($fecha_iterar)) ) . " : " . $fecha_iterar." : ".$flag. " : " . $tipoMarcadoTarjeta ."<br />";
                if( $flag == 0 ){
                    $arr_no_marco[$tipoMarcadoTarjeta][] = $fecha_iterar;
                }
            }
        
        }
    }     

              
    $arr_no_marco_NO_autorizado = array();
       
    if( $arr_no_marco ){        
        foreach( $arr_no_marco[$tipoMarcadoTarjeta] as $fechas_no_marcadas ){            

            $dia_semana = date('N', strtotime($fechas_no_marcadas));
            $dia_semana--;                        
            
            /** SI ES un dia laboral **/
            if( in_array($dia_semana,$dias_laborales_horario) ){
                /** SI NO es un dia feriado **/
                if( !isDiaFeriado($fechas_no_marcadas) ){
                    /** SI NO esta autorizado **/
                    if( !checkIfAutorized(null,$id_trabajador,'A',$tipoMarcadoTarjeta,$fechas_no_marcadas) ){
                        if( fnCheckAusencia( $relojcontrol_id, $fechas_no_marcadas ) ){
                            if( ( empresaUsaRelojControl() ) && ( relojControlSync() ) && ( marcaTarjeta($id_trabajador) ) ){                                                                
                                if( !estaFiniquitado($id_trabajador, $fechas_no_marcadas) ){
                                    /* 
                                    consultar si hay algun registro en t_atrasohoraestra
                                    Para determinar si se justifico elguna entrada o salida
                                    Como es una ausencia, si tiene 1 justifiacion, entonces 
                                    se le descuenta 4 horas, si tiene las 2, entonces no es un ausencia
                                    */
                                    $db->where('trabajador_id',$id_trabajador);
                                    $db->where('fecha',$fechas_no_marcadas);
                                    $count_to_discount = $db->getValue ("t_atrasohoraextra", "count(*)");
                                    
                                    $horas_descuento_no_marcar = getHorasDescontarNoMarcado();
                                    $minutos_descuento = ( $horas_descuento_no_marcar * 60 );
                                    $total_horas_atraso = ( $total_horas_atraso + $minutos_descuento );

                                    agregarAusencia($fechas_no_marcadas, $id_trabajador);
                                }
                            }
                        } else { 
                            $horas_descuento_no_marcar = getHorasDescontarNoMarcado();
                            $minutos_descuento = ( $horas_descuento_no_marcar * 60 );
                            $total_horas_atraso = ( $total_horas_atraso + $minutos_descuento );
                            $arr_no_marco_NO_autorizado[$tipoMarcadoTarjeta][] = $fechas_no_marcadas;
                        }                        
                    }
                }
            }
        }
    }                     
    
    
    $arr_return = array(
        'total_atraso' => $total_horas_atraso,
        'fechas_ausencia' => $arr_no_marco_NO_autorizado
    );

    return $arr_return;            
      
}


/**
 * Agrega un registro a la tabla t_ausencia, si es que no existe en la tabla   
 * @param (date) $fecha Fecha a consultar/ingresar
 * @param (int) $trabajador_id ID del trabajador
 * @return (boolean) True si agrego, False si no 
 */
function agregarAusencia($fecha, $trabajador_id){
    global $db;
        
    $db->where('fecha_inicio', $fecha, '<=');
    $db->where('fecha_fin', $fecha, '>= ');
    $db->where('trabajador_id', $trabajador_id);
    $res_check = $db->get( 't_ausencia' );

    if( ! $res_check ){
                
        $db->where('trabajador_id',$trabajador_id);
        $db->where('fecha',$fecha);
        $count = $db->getValue ("t_atrasohoraextra", "count(*)");

        if( $count == 0 ){        
            $data_insert_ausencia = array(
                'fecha_inicio' => $fecha,
                'fecha_fin' => $fecha,
                'trabajador_id' => $trabajador_id,
                'ausencia_id' => ID_AUSENCIA_SIN_JUSTIFICAR,
                'usuario_id' => $_SESSION[PREFIX.'login_uid']
            );
            $insert = $db->insert('t_ausencia',$data_insert_ausencia);
        }
    }        
    
    if( isset($insert) ){
        return true;
    } else {
        return false;
    }
}



/**
 * Checkea si la fecha enviada por parametros es una ausencia (No esta registrada en RelojControl)
 * Si el resultdo de la Query es 0, entonces es una ausencia y retorna TRUE   
 * @param (int) $user_id_reloj_control ID del usuario en RelojControls
 * @param (date) $fecha Fecha a consultar
 * @return (boolean) True si es ausencia, False si no lo es 
 */
function fnCheckAusencia($user_id_reloj_control, $fecha ){
    global $db;
    $sql = "
    SELECT count(`id`) AS total FROM `m_relojcontrol` 
    WHERE DATE_FORMAT(checktime,'%Y-%m-%d') = '$fecha'
    AND `userid` = $user_id_reloj_control
    ";
    $result = $db->rawQuery( $sql );
    $result = $result[0];
    
    if( $result['total'] == 0 ){
        return true;
    } else {
        return false;
    }
}


/**
 * Retorna total de atrasos
 * donde 1 ausencia = NO marco entrada AND NO marco salda   
 * @param (int) $atrasos_entrada Total de atrasoas en la entrada en Minutos
 * @param (int) $atrasos_salida Total de atrasoas en la salida en Minutos
 * @return (int) $total_atrasos Suma total de atrasos en Horas 
 */
function obtenerTotalAtrasos($atrasos_entrada, $atrasos_salida, $total_ausencias){
    $total_atrasos = ( ( $atrasos_entrada / 60 ) + ( $atrasos_salida / 60 ) );    
    $total_atrasos = $total_atrasos - ( $total_ausencias * 6 );
    $total_atrasos = round($total_atrasos, 2);
    
    return $total_atrasos;
}


/**
 * Determina si una ausencia es de tipo LICENCIA    
 * @param (int) $ausencia_id ID de la ausencia
 * @return (boolean)  
 */
function isLicencia($ausencia_id){
    global $db;
    $db->where('id',$ausencia_id);
    $db->where('licencia',1);
    $db->get('m_ausencia');
    
    if($db->count > 0){
        return true;
    } else {
        return false;
    }
}




function obtenerLicencias($trabajador_id){

    global $db;

    /** Ahora Se Recorren Las LICENCIAS **/
    $dias_licencia = 0;
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
    

    if( esAnoBisiesto(getAnoMostrarCorte()) ){
        $limiteFeb = 29;
    } else {
        $limiteFeb = 28;
    }
    

    if( ( getMesMostrarCorte() == 2 ) && ( $dias_licencia == $limiteFeb ) ){
        $dias_licencia += ( 30 - $limiteFeb );
    }


    return $dias_licencia;
}





/**
 * Retorna arreglo con las fechas de ausencia
 * donde 1 ausencia = NO marco entrada AND NO marco salda   
 * @param (Array) $arr_no_IN arreglo con fechas que NO marco entrada
 * @param (Array) $arr_no_OUT arreglo con fechas que NO marco salida
 * @return (Array) Arreglo con las fechas de ausencias  
 */
function obtenerAusencias($trabajador_id,$mes=0,$year=0){

    global $db;

    $periodo = getPeriodoCorte();

    if( $mes == 0 ){
        $mes = getMesMostrarCorte();
    }
    if( $year == 0 ){
        $year = getAnoMostrarCorte();
    }

    


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


    if( esAnoBisiesto(getAnoMostrarCorte()) ){
        $limiteFeb = 29;
    } else {
        $limiteFeb = 28;
    }
    

    if( ( getMesMostrarCorte() == 2 ) && ( $dias_licencia == $limiteFeb ) ){
        $dias_licencia += ( 30 - $limiteFeb );
    }

    

    /*********************************************/
    /**************** EXCEPCIONES ****************/
    /*********************************************/

    if( ( $trabajador_id == 643 ) && ($mes == 2) && ( getAnoMostrarCorte() == 2018 ) ){
        $dias_licencia = 30;
    }
    if( ( $trabajador_id == 358 ) && ($mes == 2) && ( getAnoMostrarCorte() == 2018 ) ){
        $dias_licencia = 29;
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
        $fechaFinCorte=strtotime( $ano.'-'.$mes.'-30' );
        if( $mes == 2 ){
            $fechaFinCorte=strtotime( $ano.'-'.$mes.'-28' );
        }

        if( $fecha_fin_contrato < $fechaFinCorte ){
            if( ( date('m',$fechaFinCorte) == date('m',$fecha_fin_contrato) ) ){
                $datetime1 = new DateTime( $ano.'-'.$mes.'-01' );
                $datetime2 = new DateTime( $fecha_fin_contrato_plano );
                $interval = $datetime1->diff($datetime2);


                $diasAlcanzoATrabajar = $interval->days;
                $diasAlcanzoATrabajar++;
                if($diasAlcanzoATrabajar > 30){
                    $diasAlcanzoATrabajar = 0;
                }
            } else {
                $diasAlcanzoATrabajar = 0;
            }

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



/**
 * Retorna cantidad de horas extras efectivas del trabajador   
 * @param (int) $id_trabajador ID del Trabajador
 * @return (decimal) Cantidad de horas extras justificadas  
 */
function obtenerHoraExtraTrabajador($id_trabajador){
    global $db;
    
    $periodo = getPeriodoCorte();
    $desde = $periodo['desde'].' 00:00:00';
    $hasta = $periodo['hasta'].' 23:59:59';
    
    $total_horas_extras = 0;
    $total_horas_extras_especiales = 0;
    
    
    if( marcaTarjeta($id_trabajador) ){
        $db->where('trabajador_id',$id_trabajador);
        $db->where('horas','0','>');
        $db->where('fecha', Array ($desde, $hasta), 'BETWEEN');
        $hh = $db->get('t_atrasohoraextra');
         
        foreach( $hh as $h ){
            if( translateDia( date( 'D', strtotime( $h['fecha'] ) ) ) == 'Dom' ){
                $total_horas_extras_especiales += $h['horas'];    
            } elseif( trabajoDiaFeriado( $h['fecha'] ) ) {
                $total_horas_extras_especiales += $h['horas'];
            } else {
                $total_horas_extras += $h['horas'];    
            }
            
        }   
    } else {        
        $ano = getAnoMostrarCorte();        
        $mes = getMesMostrarCorte();
                
        $db->where('trabajador_id',$id_trabajador);
        $db->where('mes',$mes);
        $db->where('ano',$ano);
        $currentValor = $db->getOne('t_relojcontrol');            
        
        if( $currentValor ){
            $total_horas_extras = $currentValor['hrExtra']; 
            $total_horas_extras_especiales = $currentValor['hrExtraFestivo'];
        } else {
            $total_horas_extras = 0; 
            $total_horas_extras_especiales = 0;
        }
    } 

    
    $arr_horas_extras = array(
        'normal' => $total_horas_extras,
        'festivo' => $total_horas_extras_especiales
    );
    
    return  $arr_horas_extras;
}

?>
