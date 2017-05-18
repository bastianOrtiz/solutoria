<?php
@extract($_POST);
$db->orderBy('apellidoPaterno','ASC');
$db->where('empresa_id',$_SESSION[PREFIX.'login_eid']);
@$trabajadores_todos = $db->get('m_trabajador');

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



        $sql = "
        SELECT  $str_cols
        FROM m_trabajador T
        WHERE  tipocontrato_id NOT IN (3,4)  
        AND empresa_id = '". $_SESSION[ PREFIX . 'login_eid' ] ."'
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
        $mostrarZero = $mostrarZero[0];
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
        AND L.mes = $mes 
        AND L.ano = $ano
        AND T.empresa_id = $empresa_id";
        

        if( !@$mostrarZero )
            $sql_impuesto .= " AND L.$tipoImpuesto > 0 ";
                
        $sql_impuesto .= " ORDER BY T.apellidoPaterno ASC ";
        
        
        $impuestos_list = $db->rawQuery( $sql_impuesto );        
        
        
        $html = '<style type="text/css">';
        $html .= 'td{ border: 1px solid #000; padding: 2px 5px; }';
        $html .= '</style>';
        $html .= '<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">';
        $html .= '<img class="round" src="'. ROOT .'/private/uploads/images/'. fotoEmpresa( $_SESSION[PREFIX.'login_eid'] ) .'">';
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
            }
        }
        $html .= '</tbody>';
                
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
    
    $array_informes_NOT_pdf = array('atrasos_view','remuneraciones-ccosto','ausencias_trabajador','ausencias','certificado_sueldos'); // Informes que NO se imprimen en PDF
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
    $licencias = $db->rawQuery( $sql ); 

    
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
    group by trabajador_id HAVING SUM(activo)>1  
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

