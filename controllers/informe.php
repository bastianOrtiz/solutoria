<?php
@extract($_POST);

$db->orderBy('apellidoPaterno','ASC');
$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$db->where('tipocontrato_id',array(3,4),'NOT IN');
$db->where('marcaTarjeta',1);
@$trabajadores_todos = $db->get('m_trabajador');



$db->orderBy('apellidoPaterno','ASC');
$db->where('tipocontrato_id',array(3,4),'NOT IN');
$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
$trabajadores_todos_cert_sueldos = $db->get('m_trabajador');

if( $_POST ){
        
    logit( $_SESSION[PREFIX.'login_name'],'generar informe',$_POST['action'],0,$db->getLastQuery() );
    
    if( $action == 'certificado_sueldos' ){

        $totales = array(
            'col1' => 0,
            'col2' => 0,
            'col3' => 0,
            'col4' => 0,
            'col5' => 0,
            'col6' => 0,
            'col7' => 0,
            'col8' => 0,
            'col9' => 0
        );   
                 
    }

    if( $action == 'certificado_sueldos_print' ){


        $totales = array('col1' => 0,'col2' => 0,'col3' => 0,'col4' => 0,'col5' => 0,'col6' => 0,'col7' => 0,'col8' => 0,'col9' => 0);
        $orientation = 'L';

        $arr_indice_trabajadores = array();
        $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
        $db->orderBy('apellidoPaterno','ASC');
        $trabajadores = $db->get('m_trabajador');

        foreach ($trabajadores as $key => $trabajador) {
            $arr_fecha_contrato_fin = explode("-",$trabajador['fechaContratoFin']);
            $ano_contrato_fin = $arr_fecha_contrato_fin[0];
            
            if( ( $ano_contrato_fin >= $_POST['ano_certificado'] ) || $ano_contrato_fin == '0000' ){
                $arr_indice_trabajadores[$trabajador['id']] = array(
                    'indice' => $key,
                    'nombre' => $trabajador['nombres'] . " " . $trabajador['apellidoPaterno']
                );
            }
            
        };


        
        $db->where('id',$_SESSION[PREFIX.'login_eid']);
        $empresa = $db->getOne('m_empresa');

        $db->where('id',$trabajador_id);
        $trabajador = $db->getOne('m_trabajador');
        $presentacion_genero = ' el Sr. ';
        if( $trabajador['sexo'] != 1){
            $presentacion_genero = ' la Srta. ';
        }
        
        $representante = getRepresentante( $_SESSION[PREFIX.'login_eid'] );


        $html = '<style type="text/css">';
        $html .= 'p, table{ font-size: 10px; }';
        $html .= 'table.tabla{ border-collapse: collapse }';
        $html .= 'table th{ font-size: 9px; text-align: center }';
        $html .= 'table.tabla td{ text-align: right }';
        $html .= 'table.tabla td, table.tabla th{ border: 1px solid #333; padding: 3px 2px; }';
        $html .= 'table tfoot th{ text-align: right; font-weight: bold }';
        $html .= '</style>';
        $html .= '<page backtop="1mm" backbottom="0mm" backleft="1mm" backright="5mm" style="font-size: 10pt">';
        
        $html .= '<table><tr><td style="width: 800px;">' .
        '<p>EMPLEADOR: ' . $empresa['razonSocial'] . '<br>' .
        'RUT: ' . $empresa['rut'] .  '<br>' .
        'DIRECCIÓN: ' . $empresa['direccion'] .  '<br>' .
        'GIRO: ' . $empresa['giro'] .  '<br>' .
        '</p>' . 
        '</td><td>Certificado Nº ' . $_POST['correlativo'] . '<br> Santiago, ' . date('d') . ' de ' . getNombreMes(date('n')) .' de ' . date('Y') . '</td>' . 
        '</tr></table>' . 

        '<br><br><p> <strong> CERTIFICADO Nº' . $arr_indice_trabajadores[$trabajador_id]['indice'] . ' SOBRE SUELDOS Y OTRAS RENTAS SIMILARES </strong> </p><br><br>' . 
        ' <p>El empleador, <strong>' . $empresa['razonSocial'] . '</strong> certifica que ' . $presentacion_genero . getNombreTrabajador($trabajador_id, true) . 
        ' RUT ' . $trabajador['rut'] . 
        ' en su calidad de empleado dependiente <br> durante el año ' . $ano_certificado . ' se le han pagado las rentas que se indican y sobre las cuales se le practicaron las retenciones de 
        s que se señalan: ' . 
        ' </p> ' . 
        ' <p>Situación Tributaria: </p> ';

        $html .= '<table class="tabla">  '  . 
        '       <thead>  '  . 
        '           <tr>    '  . 
        '               <th colspan="10">  </th>  '  . 
        '               <th colspan="6"> MONTOS ACTUALIZADOS </th>  '  . 
        '           </tr>  '  . 
        '           <tr>  '  . 
        '               <th> PERIODOS </th>  '  . 
        '               <th> SUELDO <BR>BRUTO </th>  '  . 
        '               <th style="width: 70px"> COTIZACIÓN PREVISIONAL O DE SALUD DE CARGO DEL TRABAJADOR </th>  '  . 
        '               <th style="width: 70px"> RENTA  IMPONIBLE AFECTA AL IMPTO. ÚNICO DE  2° CAT.  </th>  '  . 
        '               <th style="width: 45px"> IMPTO ÚNICO RETENIDO</th>  '  . 
        '               <th style="width: 60px"> MAYOR  RETENCION DE IMPTO. SOLICITADA  ART. 88 LIR  </th>  '  . 
        '               <th style="width: 30px"> RENTA TOTAL EXENTA </th>  '  . 
        '               <th style="width: 40px"> RENTA <BR> TOTAL <br> NO <br> GRAVADA </th>  '  . 
        '               <th style="width: 60px"> REBAJA POR ZONAS EXTREMAS (Franquicia  D.L. 889) </th>  '  . 
        '               <th style="width: 70px"> FACTOR<br> ACTUALIZACIÓN</th>  '  . 
        '               <th style="width: 60px"> RENTA AFECTA AL IMPTO.  ÚNICO DE 2° CAT.  </th>  '  . 
        '               <th style="width: 45px"> IMPTO. ÚNICO  RETENIDO </th>  '  . 
        '               <th style="width: 60px"> MAYOR RETENCIÓN DE IMPTO. SOLICITADA ART. 88 LIR </th>  '  . 
        '               <th style="width: 30px"> RENTA TOTAL EXENTA  </th>  '  . 
        '               <th style="width: 50px"> RENTA TOTAL NO GRAVADA  </th>  '  . 
        '               <th style="width: 60px"> REBAJA POR ZONAS EXTREMAS (Franquicia D.L.889)  </th>  '  . 
        '                 '  . 
        '           </tr>  '  . 
        '       </thead>  '  . 
        '       <tbody>  ';


        for( $mes=1; $mes<=12; $mes++ ){
            $data = getInfoSueldos($ano_certificado, $mes, $trabajador_id);
            $txtRentaNoGravada[$mes] = (int) str_replace(array(',','.'), "", $txtRentaNoGravada[$mes]);
            $totales['col1'] += $data['col1'];
            $totales['col2'] += $data['col2'];
            $totales['col3'] += $data['col3'];
            $totales['col4'] += $data['col4'];
            $totales['col5'] += $txtRentaNoGravada[$mes];
            $totales['col6'] += $data['col6'];
            $totales['col7'] += $data['col7'];
            $totales['col8'] += $data['col8'];
            $totales['col9'] += ( $txtRentaNoGravada[$mes] * $data['col6'] );

            $html .='        <tr>  '  . 
            '                   <td class="dataCol0" style="text-align: left;"> ' . getNombreMes($mes) . ' </td>  '  . 
            '                   <td class="dataCol1"> ' . number_format($data['col1'],0,',','.') . ' </td>  '  . 
            '                   <td class="dataCol2">' . number_format($data['col2'],0,',','.') . ' </td>  '  . 
            '                   <td class="dataCol3">' . number_format($data['col3'],0,',','.') . ' </td>  '  . 
            '                   <td class="dataCol4">' . number_format($data['col4'],0,',','.') . ' </td>  '  . 
            '                   <td style="background: #ffe"> - </td>  '  . 
            '                   <td style="background: #ffe"> - </td>  '  . 
            '                   <td class="dataCol5">' . number_format($txtRentaNoGravada[$mes],0,',','.') . ' </td>  '  . 
            '                   <td style="background: #ffe"> - </td>  '  . 
            '                   <td class="dataCol6">' . $data['col6'] . ' </td>  '  . 
            '                   <td class="dataCol7">' . number_format($data['col7'],0,',','.') . ' </td>  '  . 
            '                   <td class="dataCol7">' . number_format($data['col8'],0,',','.') . ' </td>  '  . 
            '                   <td style="background: #ffe"> - </td>  '  . 
            '                   <td style="background: #ffe"> - </td>  '  . 
            '                   <td class="dataCol9">' . number_format(($txtRentaNoGravada[$mes] * $data['col6']),0,',','.') . ' </td>  '  . 
            '                   <td style="background: #ffe"> - </td>  '  .
            '               </tr>  ';
         }

         
        $html .= '       </tbody>  '  . 
        '       <tfoot>  '  . 
        '           <tr>  '  . 
        '               <th style="text-align: left;"> <strong>Totales</strong> </th>  '  . 
        '               <th>' . number_format($totales['col1'],0,',','.') . ' </th>  '  . 
        '               <th>' . number_format($totales['col2'],0,',','.') . ' </th>  '  . 
        '               <th>' . number_format($totales['col3'],0,',','.') . ' </th>  '  . 
        '               <th>' . number_format($totales['col4'],0,',','.') . ' </th>  '  . 
        '               <th style="background: #ffe"> - </th>  '  . 
        '               <th style="background: #ffe"> - </th>  '  . 
        '               <th class="totalRenta">' . number_format($totales['col5'],0,',','.') . ' </th>  '  . 
        '               <th style="background: #ffe"> - </th>  '  . 
        '               <th>  </th>  '  . 
        '               <th>' . number_format($totales['col7'],0,',','.') . ' </th>  '  . 
        '               <th>' . number_format($totales['col8'],0,',','.') . ' </th>  '  . 
        '               <th style="background: #ffe"> - </th>  '  . 
        '               <th style="background: #ffe"> - </th>  '  . 
        '               <th class="totalRentaNoGravada">' . number_format($totales['col9'],0,',','.') . ' </th>  '  . 
        '               <th style="background: #ffe"> - </th>  '  .
        '           </tr>  '  . 
        '       </tfoot>  '  . 
        '  </table>  ' . 
        '  <br><p> Se extiende el siguiente certificado en cumplimiento de lo dispuesto en la Resolución Ex. Nº6509, del Servicio de Impuestos Internos, publica en el Diario Oficial de fecha 20 Diciembre de 1993 <br> y sus modificaciones posteriores </p>' . 
        ' <p style="text-align: right; padding: 100px 100px 0px 0px"> '. $representante['nombre'] .' <br> R.U.T.: '. $representante['rut'] .' &nbsp;&nbsp;&nbsp; </p>';

        $html .= '</page>';

    }


    
    if( $action == "reporte_atrasos" ){
        //Obtener umbral

        $fechaInicio = strtotime($fechaTrabajadorAtraso.' 00:00:00');
        $fechaFin = strtotime($fechaTrabajadorAtrasoFin.' 23:59:59');

        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            $fecha_iterar = date("Y-m-d", $i);
            $dia_semana = date("N", $i);
            if( $dia_semana < 6 ){
                $arr_fechas[] = $fecha_iterar;
            }
        }

        if( count($arr_fechas) > 31 ){
            goBack('Evite seleccionar mas de 1 mes de rango');
            exit();
        }

        $str_IN = "";
        foreach($_POST['trabajadorAtraso'] as $key => $ch){
            $str_IN .= $key . ",";
        }
        $str_IN = trim($str_IN,",");

        $sql_trabajadores = "SELECT * FROM m_trabajador where id IN ($str_IN) ORDER BY apellidoPaterno ASC";
        $trabajadores = $db->rawQuery($sql_trabajadores);

        $arr_fechas_x_trab = array();
        foreach ($trabajadores as $key => $trabajador) {
            
            //Obtener horario de entrda del trabajador
            $db->where('id',$trabajador['horario_id']);
            $entrada = $db->getValue('m_horario','entradaTrabajo');
            $entrada = strtotime($entrada);
            
            $arr_fechas_x_trab[$trabajador['id']]['nombre'] = $trabajador['apellidoPaterno']." ".$trabajador['apellidoMaterno']." ".$trabajador['nombres'];
            foreach ($arr_fechas as $k => $f) {
                $subsql = "
                SELECT * FROM `m_relojcontrol` 
                WHERE userid = ". $trabajador['relojcontrol_id'] ." 
                AND checktime BETWEEN '$f 00:00:00' AND '$f 13:30:00'
                ORDER BY checktime ASC
                LIMIT 1
                ";
                $subresult = $db->rawQuery($subsql);
                if( $subresult ){
                    $subresult = $subresult[0];
                    $hora_bd = strtotime($subresult['checktime']);
                    $hora_marcada = date('H:i',$hora_bd);
                    $atraso = false;
                    
                    if( strtotime($hora_marcada) > $entrada ){
                        $atraso = true;
                    }
                } else {
                    $hora_marcada = "";
                    $atraso = true;
                }


                $arr_fechas_x_trab[$trabajador['id']]['fechas'][$f] = array(
                    'hora_marcada' => $hora_marcada,
                    'atraso' => $atraso
                );
            }
        }
        //show_array($arr_fechas_x_trab);
    }


    if( $action == "reporte_atrasos_mensual" ){
        //Obtener umbral
        $fechaInicio = strtotime('01-'. leadZero($mesAtraso) .'-' . $anoAtraso . ' 00:00:00');
        $fechaFin = strtotime( getLimiteMes($mesAtraso) . '-' . leadZero($mesAtraso) .'-' . $anoAtraso . ' 23:59:59');

        $tot_global_atrasos = 0;

        $db->where("id",$_SESSION[PREFIX.'login_eid']);
        $umbral = $db->getValue('m_empresa','umbralRelojControl');            
        
        $db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
        $db->where('tipocontrato_id',array(3,4),'NOT IN');
        $db->where('marcaTarjeta',1);
        $trabajadorAtraso = $db->get ("m_trabajador", null,'id');

        $arr_ids_trabajadores = "(";
        foreach( $trabajadorAtraso as $key => $t ){
            $arr_ids_trabajadores .= $t['id'].',';
        }
        $arr_ids_trabajadores = trim($arr_ids_trabajadores,",");
        $arr_ids_trabajadores .= ")";

        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400) {
            $fechaConsultar = date('Y-m-d',$i);
            $sql = "
            SELECT T.id, CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, T.horario_id, R.checktime, R.checktype 
            FROM m_trabajador T, m_relojcontrol R 
            WHERE T.relojcontrol_id = R.userid 
            AND R.checktime LIKE '$fechaConsultar%'        
            AND time( checktime ) < '$umbral'
            AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
            AND T.marcaTarjeta = 1
            AND T.id IN $arr_ids_trabajadores
            GROUP by T.id, nombre, T.horario_id, R.checktime, R.checktype
            ORDER BY T.apellidoPaterno ASC      
            ";      
            $res_IN = $db->rawQuery($sql);
            
            foreach( $res_IN as $row ){ 
                $db->where('id',$row['horario_id']);
                $horario_entrada_db = $db->getValue('m_horario','entradaTrabajo');
                
                $arr_checktime = explode(" ",$row['checktime']);    
                $horario_entrada_marcado = $arr_checktime[1]; 
                
                if( marcoAtrasado( $row['id'], $row['horario_id'], $row['checktime'] ) ){
                    $tot_global_atrasos++;
                }
            }
        }    
        
        $tot_global_atrasos;
    }


    if( $action == 'haberes_descuentos' ){
        
        $consolidado = $_POST['consolidado'][0];
        
        if( $_POST['hdnTipoMovimiento'] == 'Descuentos' ){
            $t='m_descuento';
            $sql = "
            SELECT 
                L.mes,
                L.ano,                
                T.rut,
                CONCAT(T.apellidoPaterno,' ',T.apellidoMaterno,' ',T.nombres) AS nombreCompleto,
                D.nombre,
                LD.monto
            FROM m_descuento D, l_descuento LD, m_trabajador T, liquidacion L
            WHERE LD.liquidacion_id = L.id
            AND L.trabajador_id = T.id
            AND LD.descuento_id = D.id
            AND D.id = ". $_POST['cboHaberesDescuentos'] ."
            ";  
        } else {
            $t='m_haber';
            $sql = "
            SELECT 
                L.mes,
                L.ano,            
                T.rut,
                CONCAT(T.apellidoPaterno,' ',T.apellidoMaterno,' ',T.nombres) AS nombreCompleto,
                H.nombre,
                LH.monto
            FROM m_haber H, l_haber LH, m_trabajador T, liquidacion L
            WHERE LH.liquidacion_id = L.id
            AND L.trabajador_id = T.id
            AND LH.haber_id = H.id
            AND H.id = ". $_POST['cboHaberesDescuentos'] ."
            ";
        }

        if( $_POST['mesIni'] && $_POST['anoIni'] && $_POST['mesFin'] && $_POST['anoFin'] ){
            $fecha_ini_proc = strtotime($_POST['fechaInicioInforme']);
            $fecha_end_proc = strtotime($_POST['fechaFinInforme']);
            
            $sql .= " AND L.mes BETWEEN ". $_POST['mesIni'] ." AND ". $_POST['mesFin'] ." \n";
            $sql .= " AND L.ano BETWEEN ". $_POST['anoIni'] ." AND ". $_POST['anoFin'] ." \n ";
        }
        
        
        if( $_POST['cboTrabajadores'] != "" ){
            $sql .= " AND L.trabajador_id = " . $_POST['cboTrabajadores'] . " \n";
        }
        
        
        $sql .= " AND T.empresa_id = ".$_SESSION[PREFIX.'login_eid'] . " \n";
        
        $sql .= "ORDER BY L.ano DESC, L.mes ASC, T.apellidoPaterno ASC";
        
        $results['registros'] = $db->rawQuery($sql);
        
        
        $arr_parametros = [];
        
        $arr_parametros[] = [
            'nombre' => 'Haber o Descuento',
            'valor' => $_POST['hdnTipoMovimiento']
        ];
        $arr_parametros[] = [
            'nombre' => 'Empresa',
            'valor' => $_SESSION[PREFIX.'login_empresa']
        ];
        $arr_parametros[] = [
            'nombre' => 'Nombre Haber/Descuento',
            'valor' => getNombre($_POST['cboHaberesDescuentos'],$t, false)
        ];
        if( $_POST['cboTrabajadores'] ){
            $arr_parametros[] = [
                'nombre' => 'Trabajador',
                'valor' => getNombreTrabajador($_POST['cboTrabajadores'])
            ];
        } else {
            $arr_parametros[] = [
                'nombre' => 'Trabajador',
                'valor' => 'Todos'
            ];
        }
        
        if( $_POST['fechaInicioInforme'] ){
            $arr_parametros[] = [
                'nombre' => 'Fecha Inicio',
                'valor' => $_POST['fechaInicioInforme']
            ];
        }
        
        if( $_POST['fechaFinInforme'] ){
            $arr_parametros[] = [
                'nombre' => 'Fecha Fin',
                'valor' => $_POST['fechaFinInforme']
            ];
        }
        
        
        $_SESSION['haberes_descuentos_data'] = [
            'registros' => $results['registros'],
            'consolidado' => $consolidado,
            'parametros' => $arr_parametros
        ];
            
    }
    
    
    if( $action == 'haberes_descuentos_pdf' || $action == 'haberes_descuentos_excel' ){
        
        $data = $_SESSION['haberes_descuentos_data'];
        $results = $data['registros'];
        $consolidado = $data['consolidado'];
        
        $style = '
        <style>
        #tableReporte{
            width: 100%;
            border: 1px solid #000;
            border-collapse: collapse;
        }
        #tableReporte td,
        #tableReporte th{
            border: 1px solid #000;
            padding: 5px 10px;
        }
        .tr_anual td{
            background-color: #c3ffc5;
        }
        .tr_mensual td{
            background-color: #fff4b0;
        }
        .text-right{
            text-align: right;
        }
        
        </style>';
        
        
        $html_pdf = '
        <table id="tableReporte">
            <thead>
                <tr>
                    <th colspan="6" style="width: 100%">
                        <p style="text-align: center">
                            REPORTE HABERES/DESCUENTOS
                        </p>
                        
                        <table style="width: 100%; border: 0px" border="0">
                            <tr>
                                <td style="width: 50%; border: 0px">';
                                    
                                foreach($data['parametros'] as $param){ 
                                    $html_pdf .= "<strong>".$param['nombre'].": </strong>" . $param['valor'] . "<br />";    
                                } 
                                
                                $html_pdf .= '
                                </td>
                                <td style="width: 50%; border: 0px" class="text-right">
                                    Fecha: ' . date('d') . " " . getNombreMes(date('n'),true) . ' ' . date('Y') . '<br>
                                    Hora: ' . date('H:i') . '
                                    
                                </td>
                            </tr>
                        </table>
                    
                    </th>
                </tr>
                <tr>
                    <th style="width: 31%"> Nombre de Haber o Descuento </th>
                    <th style="width: 6%"> Año </th>
                    <th style="width: 9%"> Mes </th>
                    <th style="width: 10%"> Rut </th>
                    <th style="width: 32%"> Nombre Completo </th>
                    <th style="width: 12%"> Monto </th>
                </tr>
            </thead>
            <tbody>';

                $i=0;
                $sumatoria = 0;
                $ano0 = $results[0]['ano'];
                $mes0 = $results[0]['mes'];
                $tot_anual = 0;
                $tot_mensual = 0;
                    
                foreach ($results as $key => $result) :
                    
                    if( $consolidado == 'M' ){
                        if( $result['mes'] != $mes0 ){
                        
                        
                        $html_pdf .= '
                        <tr class="tr_mensual">
                            <td colspan="4">&nbsp; </td>
                            <td><strong>Total Mes ' . getNombreMes($mes0) . '</strong></td>
                            <td style="text-align: right;"><strong>$ ' . number_format($tot_mensual,0,',','.') . '</strong></td>
                        </tr>';
                        
                        $tot_mensual = 0;
                        $mes0 = $result['mes'];
                        }
                    }
                    
                    
                    
                    if( $consolidado == 'A' ){    
                        if( $result['ano'] != $ano0 ){
                        
                        $html_pdf .= '
                        <tr class="tr_anual">
                            <td colspan="4">&nbsp; </td>
                            <td><strong>Total año ' . $ano0 . '</strong></td>
                            <td style="text-align: right;"><strong>$ ' . number_format($tot_anual,0,',','.') . '</strong></td>
                        </tr>';
                    }
                    
                    
                    $tot_anual = 0;
                    $ano0 = $result['ano'];
                    }
                    
                    $html_pdf .= '
                    <tr>
                        <td> ' . $result['nombre'] . ' </td>
                        <td> ' . $result['ano'] . ' </td>
                        <td> ' . getNombreMes($result['mes']) . ' </td>
                        <td> ' . $result['rut'] . ' </td>
                        <td> ' . $result['nombreCompleto'] . ' </td>
                        <td style="text-align: right;"> $ ' . number_format($result['monto'],0,',','.') .'</td>
                    </tr>';
                    
                    
                    $sumatoria += ($result['monto']);
                    
                    
                    
                    if( $consolidado == 'A' ){
                        $tot_anual += $result['monto'];
                    }
                    
                    if( $consolidado == 'M' ){
                        $tot_mensual += $result['monto'];
                    }
                    
                    
                    
        
                    if( $i == (count($results)-1) ){
                        
                        if( $consolidado == 'M' ){
                        
                            $html_pdf .= '
                            <tr class="tr_mensual">
                                <td colspan="4">&nbsp; </td>
                                <td><strong>Total mes ' . getNombreMes($mes0) . '</strong></td>
                                <td style="text-align: right;"><strong>$ ' . number_format($tot_mensual,0,',','.') . '</strong></td>
                            </tr>';
                        }
                            
                            
                        if( $consolidado == 'A' ){
                            
                            $html_pdf .= '
                            <tr class="tr_anual">
                                <td colspan="4">&nbsp; </td>
                                <td><strong>Total año ' . $ano0 . '</strong></td>
                                <td style="text-align: right;"><strong>$ ' . number_format($tot_anual,0,',','.') . '</strong></td>
                            </tr>';
                            
                        }
                            
                            
                        if( $consolidado == 'A' ){
                            $ano0 = $result['ano'];
                        }
                        
                        if( $consolidado == 'M' ){
                            $mes0 = $result['mes'];
                        }
                    }
                    
                    
                    
                    $i++;
                endforeach; 
                
                $html_pdf .= '
                    <tr>
                        <td colspan="4"> &nbsp; </td>
                        <td class="text-right"> <strong>TOTAL:</strong> </td>
                        <td class="text-right"><strong> $ ' . number_format($sumatoria,0,',','.') . '</strong> </td>
                    </tr>   
                </tbody>
            </table>';
           
           $orientation = 'L';
           
           $html = $style.$html_pdf;
            
    }
    
    if( $action == 'haberes_descuentos_excel' ){
        
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=reporte_haberes-descuentos_".date('Y-m-d').".xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        echo $html;
        exit();
        
    }
    
   

    if( $action == 'ausencias' ){
        
        $sql_ausencia = "
        SELECT DISTINCT R.userid 
        FROM m_relojcontrol R
        WHERE date(R.checktime) = '$fechaTrabajadorAusencia'
        AND R.userid IN ( 
            SELECT T.relojcontrol_id 
            FROM m_trabajador T 
            WHERE T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."            
        )
        ";                
        
        $res = $db->rawQuery($sql_ausencia);
        $array_ausencias = array();
        foreach( $res as $r ){
            $array_ausencias[] = $r['userid'];
        }
    }
    
    if( $action == 'ausencias_trabajador' ){
        if( $trabajador_id != "" ){
            
            $db->where('trabajador_id',$trabajador_id);
            $ausencias_all = $db->get('t_ausencia');
            
            
            $events = '';
            foreach( $ausencias_all as $aus ){
                
                $fecha_fin = date($aus['fecha_fin']);
                $nuevafecha_fin = strtotime ( '+1 day' , strtotime ( $fecha_fin ) ) ;
                $nuevafecha_fin = date ( 'Y-m-d' , $nuevafecha_fin );                                 
                
                $events .= "{
                  title: '". getNombre($aus['ausencia_id'],'m_ausencia') ."',
                  start: '". $aus['fecha_inicio'] ."',
                  end: '". $nuevafecha_fin ."',
                  backgroundColor: '#f56954',
                  borderColor: '#f56954'
                },";
            }
            $events = trim($events,',');
            
        } else {
            redirect(BASE_URL.'/informe/ausencias_trabajador');
            exit();
        }
    }
    
    if( $action == 'remuneraciones-ccosto' ){
        $tipo_ccosto = $rbtCcosto[0];                        
        
        $int_mes = getIntMes($mesRemuneracionCCosto);
        $int_ano = $anoRemuneracionCCosto;
        
        $int_mes_hasta = getIntMes($mesRemuneracionCCostoHasta);        
        
        if( $tipo_ccosto == 'departamento' ){
            $sql = "
            select T.id, T.nombres, T.apellidoPaterno, T.apellidoMaterno, D.nombre  
            from m_trabajador T, m_departamento D
            where T.empresa_id = ". $_SESSION[ PREFIX . 'login_eid' ];
            
            if( $cboDepartamentos != "*" ){
                $sql .= " AND D.id = $cboDepartamentos";
            }
            
            $sql .= " AND T.departamento_id = D.id
            order by D.nombre
            ";
        } else {
            $sql = "
            select T.id, T.nombres, T.apellidoPaterno, T.apellidoMaterno, CC.nombre  
            from m_trabajador T, m_centrocosto CC
            where T.empresa_id = ". $_SESSION[ PREFIX . 'login_eid' ];
            
            if( $cboCentroCostos != "*" ){
                $sql .= " AND CC.id = $cboCentroCostos ";
            }
            
            $sql .= " AND T.centrocosto_id = CC.id
            order by CC.nombre
            ";
        }                                
        
        $result = $db->rawQuery($sql);                        
        
    }
    
    if( $action == 'prestamo' ){
        
        $arrDate = explode("-",$anticipoFecha);
        $newDate = $arrDate[2].' / '.getNombreMes($arrDate[1]).' / '.$arrDate[0];
        
        $html = '<style type="text/css">';
        $html .= 'table{ font-size: 16px; }';
        $html .= '</style>';
        $html .= '<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">';        
        
        $html_iter = '';       
        $html_iter .= '<img class="round" src="'. ROOT .'/private/uploads/images/'. fotoEmpresa( $_SESSION[PREFIX.'login_eid'] ) .'">';
        $html_iter .= "<h1 style='text-align:center; text-decoration:underline; font-size: 16px'>SOLICITUD DE ". strtoupper($action) ."</h1>";
        $html_iter .= '<br /><br /><br />';
        $html_iter .= '<table style="width: 100%;">';
        $html_iter .= '    <td style="width: 50%;">Fecha: '.$newDate.'</td>';
        $html_iter .= '    <td style="width: 50%;">Monto <ins> &nbsp;  &nbsp;  $'. number_format($anticipoMonto,0,',','.') .'  &nbsp;  &nbsp;  </ins> </td>';
        $html_iter .= '</table>';
        $html_iter .= '<br /><br />';
                
        $arrDatePrestamo = explode("-",$prestamoOtorgamientoFecha);
        $newDatePrestamo = $arrDatePrestamo[2].' / '.getNombreMes($arrDatePrestamo[1]).' / '.$arrDatePrestamo[0];
        $html_iter .= '<br /><br />';
        $html_iter .= '<table style="width: 100%;">';
        $html_iter .= '    <td style="width: 50%;">Fecha Otorgamiento: '.$newDatePrestamo.'</td>';
        $html_iter .= '    <td style="width: 50%;">A pagar en  <ins> &nbsp; '.$cuotasPrestamo.' &nbsp; </ins> Cuotas </td>';
        $html_iter .= '</table>';
        
        $html_iter .= '<br /><br /><br /><br /><br /><br /><br />';
        $html_iter .= '<table style="width: 100%;">';
        $html_iter .= '    <td>Nombre:</td>';
        $html_iter .= '    <td> <ins>  &nbsp;  &nbsp;  &nbsp; '. $anticipoNombreTrabajador .' &nbsp;  &nbsp;  &nbsp; </ins> </td>';
        $html_iter .= '</table>';
        $html_iter .= '<br /><br /><br /><br /><br /><br /><br />';
                
        $html_iter .= '<table style="width: 100%;">';
        $html_iter .= '    <td style="width: 50%; text-align: center;">';
        $html_iter .= '        ___________________________________<br />';
        $html_iter .= '        FIRMA TRABAJADOR';
        $html_iter .= '    </td>';
        $html_iter .= '    <td style="width: 50%; text-align: center;">';
        $html_iter .= '        ____________________________________<br />';
        $html_iter .= '        AUTORIZADO';
        $html_iter .= '    </td>';
        $html_iter .= '</table>';

        $html .= '<br /><br /><br />';
        $html .= $html_iter;
        
        $html .= '</page>';                 
        

    }
    
    
    
    if( $action == 'anticipo' ){
        
        $html = '<style type="text/css">';
        $html .= 'table{ font-size: 16px; }';
        $html .= '</style>';
        $html .= '<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">';        
        
        $html_iter = '';       
        $html_iter .= '<img class="round" src="'. ROOT .'/private/uploads/images/'. fotoEmpresa( $_SESSION[PREFIX.'login_eid'] ) .'">';
        $html_iter .= "<h1 style='text-align:center; text-decoration:underline; font-size: 16px'>SOLICITUD DE ". strtoupper($action) ."</h1>";
        $html_iter .= '<br /><br /><br />';
        $html_iter .= '<table style="width: 100%;">';
        $html_iter .= '    <td style="width: 50%;">Fecha: '. getNombreMes(date('m')) .' / ' . date('Y') . '</td>';
        $html_iter .= '    <td style="width: 50%;">Monto: _____________________________</td>';
        $html_iter .= '</table>';
        $html_iter .= '<br /><br /><br /><br />';
        $html_iter .= '<table style="width: 100%;">';
        $html_iter .= '    <td>Nombre:</td>';
        $html_iter .= '    <td> ____________________________________________________________________</td>';
        $html_iter .= '</table>';
        $html_iter .= '<br /><br /><br /><br /><br /><br /><br /><br />';
        $html_iter .= '<table style="width: 100%;">';
        $html_iter .= '    <td style="width: 50%; text-align: center;">';
        $html_iter .= '        ___________________________________<br />';
        $html_iter .= '        FIRMA TRABAJADOR';
        $html_iter .= '    </td>';
        $html_iter .= '    <td style="width: 50%; text-align: center;">';
        $html_iter .= '        ___________________________________<br />';
        $html_iter .= '        AUTORIZADO';
        $html_iter .= '    </td>';
        $html_iter .= '</table>';

        $html .= $html_iter;
        $html .= '<br /><br /><br /><br /><br /><br /><br /><br />';
        
        for($i=0;$i<86;$i++){
            $html .= '- ';    
        }
        
        $html .= '<br /><br /><br />';
        $html .= $html_iter;
        
        $html .= '</page>';                 
        

    }
    
    
    if( $action == 'personalizado' ){
    
        $html = '<style type="text/css">';
        $html .= 'table{ font-size: 16px; }';
        $html .= '</style>';
        $html .= '<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">';        
        
        $html .= '<img class="round" src="'. ROOT .'/private/uploads/images/'. fotoEmpresa( $_SESSION[PREFIX.'login_eid'] ) .'">';
        $html .= "<h1 style='text-align:center; text-decoration:underline; font-size: 16px'>". strtoupper($tituloInforme) ."</h1>";
        $html .= '<br /><br /><br />';
        $html .= $textoContrato;
        
        $html .= '</page>';                 
    }


    if( @$action == 'listado_trabajadores' ){
        $array_cols = array();
        array_shift($cols_perso);
            
        $str_depa = "";
        if( @!$depaTodos ){
            foreach( $filtroDepartamento as $key => $depa ){
                $str_depa .= $key . ",";
            }    
            $str_depa = trim($str_depa,",");
            $include_depa = "AND departamento_id IN ($str_depa) ";
        } else {
            $include_depa = "";
        }
        


        if( $filtroCols ){
            foreach( $filtroCols as $key => $col ){
                $array_cols[] = $key;
            }
        } else {
            $array_cols[] = '*';
        }


        /*
        $db->where('tipocontrato_id',3,'!=');
        $db->having ('empresa_id', $_SESSION[ PREFIX . 'login_eid' ] );
        $db->orderBy($ordernarPor,'ASC');
        $trabajadores = $db->get('m_trabajador',999999,$array_cols);
        */
        $str_cols = "";
        foreach( $array_cols as $col ){
            $str_cols .= $col.",";
        }
        $str_cols = trim($str_cols,",");


        $str_order = "";
        foreach( $_POST['hdnOrderBy'] as $ord ){
            $str_order .= $ord.",";
        }
        $str_order = trim($str_order,",");

        if( $str_order ){
            $include_order = "ORDER BY ". $str_order;
        } else {
            $include_order = "";
        }

        $trabajadores_all = $trabajadores_all[0];

        $sql = "
        SELECT  $str_cols
        FROM m_trabajador T ";
        if( $trabajadores_all ){
            $sql .= "WHERE empresa_id = '". $_SESSION[ PREFIX . 'login_eid' ] ."'";
        } else {
            $sql .= "
                WHERE  tipocontrato_id NOT IN (3,4)  
                AND empresa_id = '". $_SESSION[ PREFIX . 'login_eid' ] ."'
            ";
        }
        $sql .= "
        $include_depa
        $include_order
        ";

        $trabajadores = $db->rawQuery($sql);

        $html = '<style type="text/css">';
        $html .= 'td{ border: 1px solid #000; padding: 2px; }';
        $html .= '</style>';
        $html .= '<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">';
        if( $output == "pdf" )
            $html .= '<img class="round" src="'. ROOT .'/private/uploads/images/'. fotoEmpresa( $_SESSION[PREFIX.'login_eid'] ) .'">';
        $html .= '<table style="border-collapse:collapse">';
        $html .= '<tr>';
        foreach( $filtroCols as $colname => $col_value ){
            $html .= '<td style="text-transform:uppercase"><strong>'. $col_value .'</strong></td>';
        }
        foreach( $cols_perso as $col_perso_name => $col_perso_value ){
            $html .= '<td style="text-transform:uppercase">'. $col_perso_value .'</td>';
        }
        $html .= '</tr>';
        
        foreach( $trabajadores as $t ){
            $html .= '<tr>';
            foreach( $filtroCols as $colname => $col_value ){
                $html .= '<td style="text-transform:uppercase">'. value($colname,$t[$colname]) .'</td>';
            }
            foreach( $cols_perso as $col_perso_name => $col_perso_value ){
                $html .= '<td style="text-transform:uppercase">&nbsp;</td>';
            }
            $html .= '</tr>';
        }
        
        $html .= '</table>';
        $html .= '</page>'; 
                
        
        if( $output == "excel" ){
            header("Content-Type: application/xls");    
            header("Content-Disposition: attachment; filename=listado_trabajadores.xls");  
            header("Pragma: no-cache"); 
            header("Expires: 0");
            echo $html;
            exit();
        }
              
    }


    
    if( @$action == 'impuesto' ){


        if( file_exists( ROOT . '/private/uploads/images/' . fotoEmpresa( $_SESSION[PREFIX.'login_eid'] ) ) ){
            $foto_empresa =  ROOT . '/private/uploads/images/' . fotoEmpresa( $_SESSION[PREFIX.'login_eid'] );
        } else {
            $foto_empresa = ROOT . '/public/img/no_img.jpg';
        }


        $mes = $mesImpuesto;
        $ano = $anoImpuesto;
        $empresa_id = $_SESSION[PREFIX.'login_eid'];
        $total_impuesto = 0;
                
        $tipoImpuesto = 'impuestoPagar';
        if( $tipoTrabajadorImpuesto == 'agricolas' )
            $tipoImpuesto = 'impuestoAgricola';
        
        
        $sql_impuesto = "
        SELECT T.rut, CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, L.$tipoImpuesto 
        FROM m_trabajador T, liquidacion L
        WHERE T.id = L.trabajador_id
        AND (T.fechaContratoFin >= '".$ano."-".leadZero($mes)."-01' OR T.fechaContratoFin = '0000-00-00')
        AND L.mes = $mes 
        AND L.ano = $ano
        AND T.empresa_id = $empresa_id
        ";


        if( !@$_POST['mostrarZero'] ){
            $sql_impuesto .= " AND L.$tipoImpuesto > 0" . PHP_EOL;
        }
                
        $sql_impuesto .= "ORDER BY T.apellidoPaterno ASC ";
        
        $impuestos_list = $db->rawQuery( $sql_impuesto );
    
    
        // Proceso para incluir a los vendedores que se le estan pagando comisiones pendientes.
        $db->where('comisiones_pendientes',1);
        $trabajadores_com_pend = $db->get('m_trabajador',null,['id']);

        
        if( $trabajadores_com_pend ){
            $comisiones_pend_IN = '';
            foreach ($trabajadores_com_pend as $value) {
                $comisiones_pend_IN .= $value['id'].',';
            }
            $comisiones_pend_IN = trim($comisiones_pend_IN,',');
            
            $sql_impuesto_comisiones_pendientes = "
            SELECT T.rut, CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, L.$tipoImpuesto 
            FROM m_trabajador T, liquidacion L
            WHERE T.id = L.trabajador_id
            AND L.mes = $mes 
            AND L.ano = $ano
            AND T.empresa_id = $empresa_id" . PHP_EOL;
            
            if( $trabajadores_com_pend ){
                $sql_impuesto_comisiones_pendientes .= "AND T.id IN ($comisiones_pend_IN)" . PHP_EOL;
            }
            $sql_impuesto_comisiones_pendientes .= "ORDER BY T.apellidoPaterno ASC" . PHP_EOL;
            
            $impuestos_comisiones_pendientes = $db->rawQuery( $sql_impuesto_comisiones_pendientes );
            foreach ($impuestos_comisiones_pendientes as $comisiones_pend) {
                $impuestos_list[] = $comisiones_pend;
            }
        }

        

        
        $html = '<style type="text/css">';
        $html .= 'td{ border: 1px solid #000; padding: 2px 5px; }';
        $html .= '</style>';
        $html .= '<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">';
        $html .= '<img class="round" src="'.$foto_empresa.'">';
        $html .= '<h2 style="text-align: center;"> Impuesto único del mes de ' . getNombreMes($mes) . ' de '. $ano .' </h2>';
        $html .= '<table style="border-collapse:collapse" align="center">';
        $html .= '<tr>';
        $html .= '  <td> <strong>RUT</strong> </td>';
        $html .= '  <td> <strong>NOMBRE</strong> </td>';
        $html .= '  <td> <strong>IMPUESTO A PAGAR</strong> </td>';
        $html .= '</tr>';
        
        foreach( $impuestos_list as $t ){
            $total_impuesto += $t[$tipoImpuesto];
            $html .= '<tr>';
            $html .= '  <td> '.$t['rut'].' </td>';
            $html .= '  <td> '.$t['nombre'].' </td>';
            $html .= '  <td style="text-align: right;"> $ '. number_format($t[$tipoImpuesto],0,',','.') .' </td>';
            $html .= '</tr>';
        }
        $html .= '<tr>';        
        $html .= '  <td colspan="2" style="padding: 10px 5px"> <strong> Total impuesto a pagar: </strong> </td>';
        $html .= '  <td style="text-align: right; padding: 10px 5px; font-size:16px"> <strong>$ '. number_format($total_impuesto,0,',','.') .'</strong> </td>';
        $html .= '</tr>';        
        
        $html .= '</table>';
        $html .= '</page>'; 


        $orientation = 'P';
                    
    }
    
    if( ( $action == 'atrasos' ) || ( $action == 'atrasos_view' ) || ( $action == 'atrasos_excel' ) ){
        if( ( $action == 'atrasos' ) || ( $action == 'atrasos_excel' ) ){
            $trabajadorAtraso = $_SESSION[PREFIX.'informe_atrasos_trabajadorAtraso'];
            $fechaTrabajadorAtraso = $_SESSION[PREFIX.'informe_atrasos_fechaTrabajadorAtraso'];
            $html = $_SESSION[PREFIX.'informe_atrasos_html'];
        }
        
        $friendly_date = explode("-",$fechaTrabajadorAtraso);
        $friendly_date = $friendly_date[2].' de '.getNombreMes($friendly_date[1]).' de '.$friendly_date[0];
        
        
        $db->where("id",$_SESSION[PREFIX.'login_eid']);
        $umbral = $db->getValue('m_empresa','umbralRelojControl');            
        

        $arr_ids_trabajadores = "(";
        foreach( $trabajadorAtraso as $key => $t ){
            $arr_ids_trabajadores .= $key.',';
        }
        $arr_ids_trabajadores = trim($arr_ids_trabajadores,",");
        $arr_ids_trabajadores .= ")";
        
        $sql = "
        SELECT T.id, CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, T.horario_id, R.checktime, R.checktype 
        FROM m_trabajador T, m_relojcontrol R 
        WHERE T.relojcontrol_id = R.userid 
        AND R.checktime LIKE '$fechaTrabajadorAtraso%'        
        AND time( checktime ) < '$umbral'
        AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
        AND T.marcaTarjeta = 1
        AND T.id IN $arr_ids_trabajadores
        GROUP BY T.id, nombre, T.horario_id, R.checktime, R.checktype
        ORDER BY T.apellidoPaterno ASC      
        ";  

        $res_IN = $db->rawQuery($sql);
        
        $html = '<style type="text/css">';
        $html .= 'td{ border: 1px solid #000; padding: 2px 5px; }';
        $html .= '</style>';
        $html .= '<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">';
        $base = ROOT;
        if( $action == "atrasos_view" ){
            $base = BASE_URL;
        }
        if( $action != 'atrasos_excel' ){
            $html .= '<img class="round" src="'. $base .'/private/uploads/images/'. fotoEmpresa( $_SESSION[PREFIX.'login_eid'] ) .'">';
        }
        $html .= '<h3 style="text-align: center;" class="box-title"> Registro de asistencia y Reloj Control dia '.$friendly_date.' </h3>';
        $html .= '<table style="border-collapse:collapse" align="center" class="table table-bordered" id="table_list_atrasos">';
        $html .= '<thead>';
        $html .= '  <tr>';
        $html .= '      <th> <strong>NOMBRE</strong> </th>';
        $html .= '      <th> <strong>Horario de entrada</strong> </th>';
        $html .= '      <th> <strong>Hora que marcó</strong> </th>';
        $html .= '      <th> <strong>Generar Carta</strong> </th>';    
        $html .= '  </tr>';
        $html .= '</thead>';
        
        $html .= '<tbody>';
        $total = 0;
        foreach( $res_IN as $row ){ 
            $db->where('id',$row['horario_id']);
            $horario_entrada_db = $db->getValue('m_horario','entradaTrabajo');
            
            $arr_checktime = explode(" ",$row['checktime']);    
            $horario_entrada_marcado = $arr_checktime[1]; 
            
            if( marcoAtrasado( $row['id'], $row['horario_id'], $row['checktime'] ) ){
                $html .= '<tr>';
                $html .= '  <td style="text-transform: uppercase;"> '. $row['nombre'] .' </td>';
                $html .= '  <td> '. $horario_entrada_db .' </td>';
                $html .= '  <td> '. $horario_entrada_marcado .' </td>';
                $html .= '  <td> <a href="#'. base64_encode(base64_encode($row['id'])) .'" class="btn btn-flat btn-default btn-xs btnCartaAmonestacion" title="Generar Carta de amonestación"> <i class="fa fa-file-text"></i> </a> </td>';
                $html .= '</tr>';
                $total++;
            }
        }
        $html .= '</tbody>';
        $html .= '<tfoot>';
        $html .= '  <tr><td colspan="4"><strong>Total: '.$total.'</strong></td></tr>';
        $html .= '</tfoot>';
                
        $html .= '</table>';
        $html .= '</page>'; 


        if( $_POST['action'] == 'atrasos_view' ){
            $_POST['html'] = $html;
        }                
                 
    }
    
    
    if( $_POST['action'] == 'atrasos_excel' ){
        header("Content-Type: application/xls");    
        header("Content-Disposition: attachment; filename=listado_atrasos.xls");  
        header("Pragma: no-cache"); 
        header("Expires: 0");
        echo $html;
        exit();
    }            
    
    $array_informes_NOT_pdf = array(
        'atrasos_view',
        'reporte_atrasos_mensual',
        'remuneraciones-ccosto',
        'ausencias_trabajador',
        'ausencias',
        'certificado_sueldos',
        'reporte_atrasos',
        'haberes_descuentos'

    ); // Informes que NO se imprimen en PDF
    
    if(!in_array($action,$array_informes_NOT_pdf)){
        require_once( ROOT . '/libs/html2pdf/html2pdf.class.php');
        $html2pdf = new HTML2PDF($orientation,'LETTER','es');
        $html2pdf->WriteHTML($html);        
        $html2pdf->Output( 'informe.pdf');
    } 

       
}


if( $parametros[0] == 'listar_trabajadores' ){
    $db->where('id',$_SESSION[PREFIX.'login_cid']);
    $comparte_cargo = $db->getOne('m_cuenta','compartirCargo');
    $comparte_cargo['compartirCargo'];
    
    if( $comparte_cargo['compartirCargo'] == 1 ){
        $departamentos = $db->rawQuery('SELECT * from m_departamento WHERE activo = 1 AND empresa_id IN ( SELECT id FROM m_empresa WHERE cuenta_id = '.$_SESSION[PREFIX.'login_cid'].') ');        
    } else {
        $departamentos = $db->rawQuery("SELECT * FROM m_departamento WHERE activo = 1 AND empresa_id = " . $_SESSION[PREFIX.'login_eid'] );
    }
}

if( $parametros[0] == 'reporte_atrasos' ){
    
    /** Proceso para determinar los trabajadores del jefe logueado **/
    // Cargo del jefe logeado
    $db->where('id',$_SESSION[PREFIX.'login_uid']);
    $cargo_id = $db->getValue('m_trabajador','cargo_id');
    
    $sql = "
        SELECT id from m_cargo where cargoPadreId in
            ( SELECT id FROM m_cargo where cargoPadreId IN
                ( SELECT id FROM `m_cargo` WHERE cargoPadreId = $cargo_id )
            )
        OR cargoPadreId = $cargo_id
        OR cargoPadreId IN
            (SELECT id FROM `m_cargo` WHERE cargoPadreId = $cargo_id
        )";
    
    $sql_hijos = "SELECT * FROM `m_cargo` WHERE `cargoPadreId` = $cargo_id ORDER BY `activo` DESC";
    $childs = $db->rawQuery( $sql );
    foreach($childs as $ch){
        $str_IN .= $ch['id'].",";
    }
    $str_IN = trim($str_IN,",");
    
    $sql_trabajadores_x_cargo = "SELECT * from m_trabajador T WHERE T.cargo_id IN (" . $str_IN . ")  AND T.empresa_id = " . $_SESSION[PREFIX.'login_eid'] . " AND marcaTarjeta = 1 ORDER BY apellidoPaterno ASC";
    $trabajadores_x_cargo = $db->rawQuery( $sql_trabajadores_x_cargo );
}



if( $parametros[0] == 'imposiciones' ){
    
    $mes = getMesMostrarCorte();
    $year = getAnoMostrarCorte();
    
    $sql = "
    SELECT CONCAT( T.apellidoPaterno, ' ', T.nombres ) as nombre, T.fechaContratoInicio, T.fechaContratoFin
    FROM m_trabajador T 
    WHERE month(T.fechaContratoInicio) = $mes
    AND year(T.fechaContratoInicio) = $year
    AND T.fechaContratoFin != '0000-00-00'
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    ORDER BY nombre ASC
    ";
    $inicio_plazo_fijo_mes = $db->rawQuery( $sql );        
       
    
    /* OLD
    $sql = "
    SELECT CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, A.trabajador_id, A.fecha_inicio, A.fecha_fin 
    FROM t_ausencia A, m_trabajador T
    WHERE ausencia_id IN ( SELECT id FROM m_ausencia M WHERE M.licencia = 1 )
    AND ( month(fecha_inicio) = $mes OR month(fecha_fin) = $mes )
    AND ( year(fecha_inicio) = $year OR year(fecha_fin) = $year )
    AND T.id = A.trabajador_id
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    ORDER BY nombre ASC
    ";
    */
    $licencias = [];
    $this_year = strtotime(date('Y-m-d'));
    $un_ano_atras = ($this_year - 31536000);
    $un_ano_atras = date('Y-m-d',$un_ano_atras);
    $sql = "
    SELECT 
    concat(T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres) AS nombre,
    TA.trabajador_id,
    TA.fecha_inicio,
    TA.fecha_fin
    FROM t_ausencia TA, m_trabajador T
    where TA.ausencia_id IN ( SELECT id FROM m_ausencia M WHERE M.licencia = 1 ) 
    AND T.empresa_id = 2
    AND T.id = TA.trabajador_id
    AND TA.fecha_fin > '$un_ano_atras'
    ";
    $all_licencias = $db->rawQuery( $sql ); 

    foreach ($all_licencias as $licencia) {
        
        $int_fecha_inicio_licencia = explode("-",$licencia['fecha_inicio']);
        $int_fecha_inicio_licencia = $int_fecha_inicio_licencia[0].$int_fecha_inicio_licencia[1].$int_fecha_inicio_licencia[2];
        
        $int_fecha_fin_licencia = explode("-",$licencia['fecha_fin']);
        $int_fecha_fin_licencia = $int_fecha_fin_licencia[0].$int_fecha_fin_licencia[1].$int_fecha_fin_licencia[2];
        
        $int_fecha_inicio_informe = getAnoMostrarCorte().leadZero(getMesMostrarCorte()).'01';
        
        $int_fecha_fin_informe = getAnoMostrarCorte().leadZero(getMesMostrarCorte()).getLimiteMes((int)getMesMostrarCorte());
        


        if( $int_fecha_fin_licencia < $int_fecha_inicio_informe ){
        } elseif ($int_fecha_inicio_licencia > $int_fecha_fin_informe) {
        } elseif ( $int_fecha_inicio_licencia >= $int_fecha_inicio_informe && $int_fecha_fin_licencia <= $int_fecha_fin_informe ) {
            $licencias[] = [
                'nombre' => $licencia['nombre'],
                'trabajador_id' => $licencia['trabajador_id'],
                'fecha_inicio' => $licencia['fecha_inicio'],
                'fecha_fin' => $licencia['fecha_fin']
            ];
        } elseif ( $int_fecha_fin_licencia >= $int_fecha_inicio_informe && $int_fecha_fin_licencia <= $int_fecha_fin_informe ) {
            $licencias[] = [
                'nombre' => $licencia['nombre'],
                'trabajador_id' => $licencia['trabajador_id'],
                'fecha_inicio' => $licencia['fecha_inicio'],
                'fecha_fin' => $licencia['fecha_fin']
            ];
        } elseif (  $int_fecha_inicio_licencia >= $int_fecha_inicio_informe && $int_fecha_inicio_licencia <= $int_fecha_fin_informe  ) {
            $licencias[] = [
                'nombre' => $licencia['nombre'],
                'trabajador_id' => $licencia['trabajador_id'],
                'fecha_inicio' => $licencia['fecha_inicio'],
                'fecha_fin' => $licencia['fecha_fin']
            ];
        } elseif ( $int_fecha_inicio_licencia < $int_fecha_inicio_informe && $int_fecha_fin_licencia > $int_fecha_fin_informe ) {
            $licencias[] = [
                'nombre' => $licencia['nombre'],
                'trabajador_id' => $licencia['trabajador_id'],
                'fecha_inicio' => $licencia['fecha_inicio'],
                'fecha_fin' => $licencia['fecha_fin']
            ];
        }


        
    }

    
    $db->where("id",$_SESSION[PREFIX.'login_eid']);
    $id_ausencia_vacaciones = $db->getValue('m_empresa','ausenciaVacaciones');
    $sql = "
    SELECT CONCAT( T.apellidoPaterno,' ', T.apellidoMaterno,' ', T.nombres ) AS nombre, A.trabajador_id, A.fecha_inicio, A.fecha_fin 
    FROM t_ausencia A, m_trabajador T
    WHERE A.ausencia_id IN ( SELECT id FROM m_ausencia M WHERE M.descuenta = 1 )
    AND A.ausencia_id NOT IN ( SELECT id FROM m_ausencia M WHERE M.licencia = 1 )
    AND ( month(fecha_inicio) = $mes OR month(fecha_fin) = $mes )
    AND ( year(fecha_inicio) = $year OR year(fecha_fin) = $year )
    AND T.id = A.trabajador_id
    AND T.empresa_id = ". $_SESSION[PREFIX.'login_eid'] ."
    ORDER BY nombre ASC
    ";
    $ausencias_no_justificadas = $db->rawQuery( $sql );
    
    
    $sql = "
    SELECT CONCAT( T.apellidoPaterno, ' ', T.nombres ) as nombre, T.fechaContratoInicio, T.fechaContratoFin
    FROM m_trabajador T 
    WHERE month(T.fechaContratoInicio) = $mes
    AND year(T.fechaContratoInicio) = $year
    AND T.fechaContratoFin = '0000-00-00'
    AND T.empresa_id = ".$_SESSION[PREFIX.'login_eid']."
    ORDER BY nombre ASC
    ";
    $indefinidos_mes = $db->rawQuery( $sql ); 
    
    $total_dias_mes = cal_days_in_month(CAL_GREGORIAN, $mes, $year);
    $sql = "
    SELECT CONCAT( T.apellidoPaterno, ' ', T.nombres ) as nombre, T.fechaContratoInicio, T.fechaContratoFin
    FROM m_trabajador T
    WHERE T.fechaContratoFin != '0000-00-00'
    AND T.fechaContratoInicio < '$year-".leadZero($mes)."-01'
    AND T.fechaContratoFin >= '$year-".leadZero($mes)."-01'
    AND T.empresa_ID = " . $_SESSION[PREFIX.'login_eid'] ."
    AND T.tipocontrato_id NOT IN (3,4)
    ORDER BY nombre ASC
    ";    
    $plazo_fijo_durante_mes = $db->rawQuery( $sql );
    
        
    
    $array_plazo_a_indefinido = array();   
    $arr_paso_a_indefinido = array();
    $sql1 = "
    SELECT C.trabajador_id
    FROM t_contrato C, m_trabajador T
    where C.trabajador_id IN ( SELECT id FROM m_trabajador 
    WHERE empresa_id = ". $_SESSION[PREFIX.'login_eid'] ." )
    AND T.id = C.trabajador_id
    group by trabajador_id HAVING SUM(T.activo)>1  
    ";
    $plazo_a_indefinido = $db->rawQuery( $sql1 );
    
    foreach( $plazo_a_indefinido as $p ){
        $sub_sql = "
        SELECT MAX(C.fechaInicio) as fechaContrato, concat(T.apellidoPaterno,' ', T.apellidoMaterno,' ' ,T.nombres) as nombre
        FROM t_contrato C, m_trabajador T
        WHERE C.trabajador_id = " . $p['trabajador_id']."
        AND C.activo = 1
        AND C.trabajador_id = T.id    
        ORDER BY nombre ASC    
        ";
        $subres = $db->rawQuery( $sub_sql );
        $array_plazo_a_indefinido[] = $subres[0];        
    }        

    
    foreach( $array_plazo_a_indefinido as $r ){        
        $time = strtotime( $r['fechaContrato'] );    
        if( ( date('n',$time) == $mes ) && ( date('Y',$time) == $year ) ){
            $arr_paso_a_indefinido[] = $r;
        }
    } 
    
    $sql = "
    SELECT concat(T.apellidoPaterno,' ', T.apellidoMaterno,' ' ,T.nombres) as nombre, T.fechaContratoFin
    FROM m_trabajador T
    WHERE empresa_id = ". $_SESSION[PREFIX.'login_eid'] ." 
    AND tipocontrato_id IN (3,4)
    AND month(fechaContratoFin) = $mes
    AND year(fechaContratoFin) = $year
    ORDER BY nombre ASC
    ";        
    $despedidos = $db->rawQuery( $sql );
    
}


if( $parametros[0] == 'remuneraciones-centrocosto' ){
    
    $db->where('id',$_SESSION[PREFIX.'login_cid']);
    $comparte = $db->getOne('m_cuenta');
        
    if( $comparte_cargo['compartirCargo'] == 1 ){
        $departamentos_todos = $db->rawQuery('SELECT * from m_departamento WHERE activo = 1 AND empresa_id IN ( SELECT id FROM m_empresa WHERE cuenta_id = '.$_SESSION[PREFIX.'login_cid'].') ');        
    } else {
        $departamentos_todos = $db->rawQuery("SELECT * FROM m_departamento WHERE activo = 1 AND empresa_id = " . $_SESSION[PREFIX.'login_eid'] );
    }
        
    
    if( $comparte_cargo['compartirCentroCosto'] == 1 ){
        $ccostos_todos = $db->rawQuery('SELECT * from m_centrocosto WHERE activo = 1 AND empresa_id IN ( SELECT id FROM m_empresa WHERE cuenta_id = '.$_SESSION[PREFIX.'login_cid'].') ');        
    } else {
        $ccostos_todos = $db->rawQuery("SELECT * FROM m_departamento WHERE activo = 1 AND empresa_id = " . $_SESSION[PREFIX.'login_eid'] );
    }
    
    $db->where("empresa_id",$_SESSION[PREFIX.'login_eid']);
    $ccostos_todos = $db->get('m_centrocosto');
      
}



if( $parametros[0] == 'ausencias' ){    
    $ausencias_todas = $db->get('m_ausencia');        
}

if( $parametros[0] == 'haberes_descuentos' ){    
    $haberes = getRegistrosCompartidos('Haber','m_haber');
    $descuentos = getRegistrosCompartidos('Descuento','m_descuento');
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

