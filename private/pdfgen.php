<?php
@session_start();
include '../libs/config.php';
include '../libs/constantes.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

if(!$_SESSION){
    redirect(BASE_URL);
    exit();
}

$liquidacion_id = decrypt($_GET['id']);

$db->where('id',$_SESSION[PREFIX.'login_eid']);
$empresa = $db->getOne('m_empresa');

$db->where('id',$liquidacion_id);
$liquidacion = $db->getOne('liquidacion');


extract($empresa);
extract($liquidacion);

$a_date = $liquidacion['mes'] . "-" . $liquidacion['ano'] . "-01";

//haberes no imponibles
$sql_haberes_no_imp = "
SELECT H.nombre, LH.monto, H.comision AS es_comision, LH.glosa        
FROM m_haber H, l_haber LH 
WHERE liquidacion_id = $liquidacion_id
AND H.imponible = 0
AND H.id = LH.haber_id 
ORDER BY LH.id DESC ";
$haberes_no_imponibles = $db->rawQuery($sql_haberes_no_imp);


//haberes imponibles
$sql_haberes = "
SELECT H.nombre, LH.monto, H.comision AS es_comision, LH.glosa        
FROM m_haber H, l_haber LH 
WHERE liquidacion_id = $liquidacion_id
AND H.imponible = 1
AND H.id = LH.haber_id  
ORDER BY LH.id ASC ";
$haberes_imponibles = $db->rawQuery($sql_haberes);


//Descuentos 
$query_desc = "
SELECT D.nombre, LD.monto, LD.glosa, LD.descuento_id, LD.cuotaActual, LD.cuotaTotal        
FROM m_descuento D, l_descuento LD 
WHERE liquidacion_id = $liquidacion_id
AND D.id = LD.descuento_id  
ORDER BY LD.id ASC ";
$debes_trabajador = $db->rawQuery( $query_desc );

//nombre trabajador
$db->where('id',$trabajador_id);
$trabajador = $db->getOne('m_trabajador');

$nombre_trabajador = $trabajador['apellidoPaterno'] . " " . $trabajador['apellidoMaterno'] . ' ' . $trabajador['nombres'];
$nombre_trabajador_slug = slugify($nombre_trabajador);

$dias_trabajados = ( 30 - $diaAusencia );


$total_salud_legal = round($totalImponible * 0.07,0);


$content = '
<style type="text/css">
<!--
    table{ font-size: 12px; }
    table.table_header{ width: 100%; }
    table.table_header td{ width: 50%; } 
    table.table_header td.left{ text-align:left; }
    table.table_header td.right{ text-align:right; }
    
	table.page_header { width: 100%; border: 1px solid #333; border-collapse:collapse; }
    table.page_header td{ border-bottom: 1px solid #333; padding: 2px 10px}     
    
    table.page_header td table.no-border td{ border-bottom: 0;}
    
    table.page_header td.first{ width: 40% }
    table.page_header td.last{ width: 20%; text-align: right; }
    table.subtable{ border: 0px }    
    table.subtable td{padding: 0 10mm; border-top: 0px; border-bottom: 0px; border-left: 0px; border-right: 0px}    
    table#table_descuentos td{ padding:0px 0 0 40px; }
    
    table.table_footer{ width: 100%; }
    table.table_footer td{ width: 50%; } 
    table.table_footer td.left{ text-align:left; }
    table.table_footer td.right{ text-align:right; }    
-->
</style>
<page backtop="1mm" backbottom="0mm" backleft="10mm" backright="10mm" style="font-size: 10pt">
<table width="100%" style="width: 100%">
    <tbody>
        <tr>
            <td style="padding: 0 20px;"> 
            <img class="round" src="'. ROOT .'/private/uploads/images/'. $empresa['foto'] .'" />
            </td>
            <td>
                <table>
                    <tr>
                        <td>' . $nombre . '</td>
                    </tr>
                    <tr>
                        <td>' . $rut . '</td>                
                    </tr>
                    <tr>
                        <td>' . $direccion . '</td>                    
                    </tr>
                    <tr>
                        <td>' . $razonSocial . '</td>                    
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<p style="text-align:center">LIQUIDACIÓN DE SUELDOS Y REMUNERACIÓN MENSUAL</p>

<table class="table_footer">
    <tr>
        <td class="left"> <strong>Nombre:</strong>' . $nombre_trabajador . ' </td>
        <td class="right">'. $trabajador['rut'] .'</td>
    </tr>
</table>

<table class="page_header" border="1">
    <tbody>
        <tr>
            <td>
                Sueldo Base de '.getNombreMes( $liquidacion['mes'] ).' de '. $liquidacion['ano'] .' ('. $dias_trabajados .' días trabajados)';
                if( $gratificacion > 0 ){            
$content .= '<br />Gratificación<br /><br />';
                }
$content .= '</td>
            <td style="text-align: right"> $ '. number_format($sueldoBase,0,',','.');
                if( $gratificacion > 0 ){
$content .= '<br />$ '. number_format($gratificacion,0,',','.') .'<br /><br />';
                }            
$content .= '</td>
        </tr>';                            
        
        
        if( $horaExtraMonto > 0 ){
        $content .= '
        <tr>
            <td class="first"><strong>Horas Extra Normal ('.$horaExtra.') :</strong></td>
            <td class="last"> $ '. number_format($horaExtraMonto,0,',','.') .' </td>
        </tr>';
        }
        
        if( $horaExtraFestivoMonto > 0 ){
        $content .= '
        <tr>
            <td class="first"> <strong>Hora Extra Domingos / Festivos ('.$horaExtraFestivo.'):</strong></td>
            <td class="last"> $ '. number_format($horaExtraFestivoMonto,0,',','.') .' </td>
        </tr>';
        }
        
        if( count($haberes_imponibles) > 0 ){
        $content .= '
        <tr>
            <td>
                <strong> Bonos y Comisiones Imponibles</strong><br />
                <table class="subtable" style="margin: 10px; width: 85%;">                              		
                    <tbody>';
                    
                        $total_haberes_imponibles = 0;
                        foreach( $haberes_imponibles as $dt ){ 
                            $content .= '
                            <tr>  
                                <td> ' . $dt['nombre'] . ' </td>
                                <td> $ ';                                 
                                $valor_subtotal = $dt['monto'] ;                                                
                                $content .= number_format($valor_subtotal,0,',','.') . ' </td>                                                                                        
                            </tr>';                         
                            $total_haberes_imponibles += $valor_subtotal;
                        } 
                        if( $semanaCorrida > 0 ){
                            $total_haberes_imponibles += $semanaCorrida;
            $content .= '
                        <tr>
                            <td> <strong>Semana Corrida</strong> </td>
                            <td> $ '. number_format($semanaCorrida,0,',','.') .' </td>
                        </tr>';
                        }
                        
        $content .= '</tbody>
            	</table>
            </td>
            <td class="total last" style="vertical-align: bottom;"> $ ' . number_format($total_haberes_imponibles,0,',','.') . ' </td>
        </tr>';
        }
        
        $content .= '
        <tr>
            <td class="first"> <strong>Total Imponible</strong> </td>
            <td class="last"> $ '. number_format($totalImponible,0,',','.') .' </td>              
        </tr>
        ';
        
        
        $total_haberes_no_imponibles = 0;
        if( count($haberes_no_imponibles) > 0 ){
        $content .= '
        <tr>
            <td class="first">
                <strong> Haberes NO Imponibles</strong><br />
                <table style="margin: 10px;" class="subtable no-border">                              		
                    <tbody>';
                    
                    foreach( $haberes_no_imponibles as $dt ){ 
                    $content .= '
                    <tr>  
                        <td> '.$dt['nombre'].'</td>
                        <td> $ '.number_format($dt['monto'],0,',','.').' </td>                                                                                        
                    </tr>
                    ';             
                    $total_haberes_no_imponibles += $dt['monto'];
                    }
                      
                        
                    $content .= '       
                    </tbody>
            	</table>
            </td>
            <td class="last" style="vertical-align: bottom;">  $ '.number_format($total_haberes_no_imponibles,0,',','.').' </td>
        </tr>';
        }
        
        $content .= '
        <tr> 
            <td class="first">
                <strong>TOTAL HABERES</strong>
            </td> 
            <td class="last"> 
                <strong>$ ' . number_format(($remuneracionTributable + $total_haberes_no_imponibles ),0,',','.') . '</strong> 
            </td>
        </tr>                                                       
        <tr>
            <td class="first"> 
                <table style="width:100%" class="subtable">
                    <tr>
                        <td style="padding:0; text-align: left; width:70%"> <strong>AFP '. fnGetNombre($afp_id,'m_afp',false) .' &nbsp; ('.$afpPorcentaje.'%)</strong>  </td>
                        <td style="padding:0; text-align: right; width:30%">
                            $ '. number_format($afpMonto,0,',','.') .'
                        </td>
                    </tr>
                </table>
            </td>
            <td class="last"> 
                &nbsp;  
            </td>
        </tr>
        <tr>
            <td class="first"> 
                <table style="width:100%" class="subtable">
                    <tr>
                        <td style="padding:0; text-align: left; width:70%"> 
                            <strong>Salud </strong>';
                            if( $isapre_id == 0 ){ 
                            $content .= 'Fonasa';
                            } else {
                            $content .= fnGetNombre($isapre_id,'m_isapre',0) . '<br />
                            Pactado: ' . number_format($isaprePactado,3,',','.') . ' ' . fnGetNombre($monedaIsaprePactado,'m_tipomoneda',0) . '                                   
                            
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
                            }
                            
                            $content .= '7% Legal: $ ' .number_format($total_salud_legal,0,',','.').'                               
                            <br />
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            ';
             
                            
                            if( round($saludMonto - $total_salud_legal) > 0 ){
                                $content .= '$ ' . number_format( ($saludMonto - $total_salud_legal),0,',','.' );
                            }                            
                            $content .= '
                        </td>
                        <td style="padding:0; text-align: right; width:30%">
                            $ '. number_format($saludMonto,0,',','.') .'                        
                        </td>
                    </tr>
                </table>
            </td>
            <td class="last" style="vertical-align: bottom;">
                &nbsp;                                
            </td>
        </tr>
        <tr>
            <td class="first">
                <table style="width:100%" class="subtable">
                    <tr>
                        <td style="padding:0; text-align: left; width:85%">'; 
            if( $afcMonto == 0 ){
                $content .= '<strong>AFC</strong> (No cotiza)';
            } else {
                $content .= '<strong>AFC</strong> (0.6% &nbsp; de '. number_format($topeAfc,0,',','.') .')';
            }
            
            $content .= '</td>
                        <td style="padding:0; text-align: right; width:15%">
                            $ '. number_format($afcMonto,0,',','.') .'
                        </td>
                    </tr>
                </table>                  
            </td>
            <td class="last"> &nbsp; </td>
        </tr>';
        
        if( $apvMonto != 0 ){
        $content .= '
        <tr>
            <td class="first"> 
                <table style="width:100%" class="subtable">
                    <tr>
                        <td style="padding:0; text-align: left; width:85%"> 
                            <strong>APV</strong> .
                        </td>
                        <td style="padding:0; text-align: right; width:15%">
                            $ '. number_format($apvMonto,0,',','.') .'
                        </td>
                    </tr>
                </table> 
            </td>
            <td class="last"> &nbsp; </td>
        </tr>';
        }
        
        if( $cuenta2Id != 0 ){
        $content .= '
        <tr>
            <td class="first"> 
                <table style="width:100%" class="subtable">
                    <tr>
                        <td style="padding:0; text-align: left; width:85%"> 
                            <strong>Cuenta 2</strong> '.fnGetNombre($cuenta2Id,'m_afp',false).'
                        </td>
                        <td style="padding:0; text-align: right; width:15%">
                            $ '. number_format($cuenta2Monto,0,',','.') .'
                        </td>
                    </tr>
                </table> 
            </td>
            <td class="last"> &nbsp; </td>
        </tr>';
        }
        $content .= '
        <tr>
            <td colspan="2" style="text-align: left !important;">
                <div style="float: left;"><strong>Cálculo de Impuesto Unico</strong></div>                
                <table class="subtable">
                    <tbody>
                        <tr>
                            <td> Remuneración Tributable </td>
                            <td style="text-align: right; padding-right: 200px;"> $ '. number_format($remuneracionTributable,0,',','.') .' </td>
                        </tr>
                        <tr>
                            <td> Descuentos Previsionales a rebajar </td>
                            <td style="text-align: right; padding-right: 200px;"> 
                                $ '. number_format($descuentoPrevisional,0,',','.') .'
                            </td>
                        </tr>
                        <tr>
                            <td> Total Tributable </td>
                            <td style="text-align: right; padding-right: 200px;"> $ '. number_format($totalTributable,0,',','.') .' </td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"> 
                                Total Impuesto<br /> 
                                Cantidad rebajar<br />
                                Impuesto a Pagar
                            </td>
                            <td style="text-align: right;">  
                                $ '. number_format($impuestoTotal,0,',','.') .' <br />
                                $ '. number_format($impuestoRebajar,0,',','.') .' <br />
                                $ '. number_format($impuestoPagar,0,',','.') .' <br />                                     
                            </td>
                        </tr>';
                        if( $trabajador['agricola'] == 1 ){
                        $content .= '
                        <tr>
                            <td style="text-align: right;"> 
                                Impuesto único al Trabajador Agrícola
                            </td>
                            <td style="text-align: right;">  
                                $ '. number_format($impuestoAgricola,0,',','.') .'                                     
                            </td>
                        </tr>';                            
                        }
                        
        $content .= '</tbody>
                </table>                            
            </td>
        </tr>';
        
        
        $total_otros_descuentos = 0;
        $anticipo = 0;        
        if( count($debes_trabajador) > 0 ){
        $content .= '
        <tr>
            <td class="first"> 
                <strong>Descuentos</strong> <br /> 
                <table style="margin: 10px;" class="subtable" id="table_descuentos">                
                    <thead>
                    	<tr>
        					<th align="center"> Cuota <br />Actual </th>
                            <th align="center"> Total <br />Cuotas</th>
                            <th align="center"> Descuento </th>
                            <th align="right"> Valor </th>                                                
        				</tr>
                    </thead>
                    <tbody>';
                                                            
                    foreach( $debes_trabajador as $dt ){ 
                        if( $dt['descuento_id'] != ID_ANTICIPO ){
                            if( $dt['cuotaTotal'] != 0 ){
                                $cuotaActual = ( $dt['cuotaActual'] + 1 );
                            } else {
                                $cuotaActual = $dt['cuotaActual'];
                            }
                    
            $content .= '<tr>  
                            <td> ' . $cuotaActual . ' </td>
                            <td> '.$dt['cuotaTotal'].' </td>
                            <td> ';
                                
                                $content .= fnGetNombre($dt['descuento_id'],'m_descuento',false);
                                if( $dt['glosa'] ){
                                    $content .= "<br />(" . $dt['glosa'] . ")";
                                }
                                                                    
                $content .=' </td>
                            <td align="right"> $ ';
                            $valor_subtotal = $dt['monto'];
                            $content .= number_format($valor_subtotal,0,',','.');                             
                            
                            
                $content .= '</td>                                            
                        </tr>';
                    
                        $total_otros_descuentos += $valor_subtotal; 
                        } else {
                            $anticipo += $dt['monto'];
                        } 
                    }
                  
        $content .= '</tbody>
        		</table>
            </td>
            <td class="last" style="vertical-align: bottom;"> $ '. number_format($total_otros_descuentos,0,',','.') .' </td>
        </tr>';
        }
        $content .= '
        <tr>
            <td class="first"> <strong>Atrasos</strong> ( '.$horaAtraso.' horas ) </td>
            <td class="last"> $ '. number_format($horaAtrasoMonto,0,',','.') .' </td>
        </tr>
        <tr>
            <td class="first"><strong>TOTAL OTROS DESCUENTOS</strong></td>
            <td class="last"> 
                <strong>$ '. number_format(($horaAtrasoMonto + $total_otros_descuentos ),0,',','.') .'</strong> 
            </td>
        </tr>
        <tr>
            <td class="first"> 
                <table class="subtable" align="right">
                    <tbody>
                        <tr>  
                            <td style="text-align: left;"> TOTAL DESCUENTOS </td>
                        </tr>
                        <tr>  
                            <td style="text-align: left;"> REMUNERACIÓN LIQUIDA </td>
                        </tr>
                        <tr>  
                            <td style="text-align: left;"> ANTICIPOS </td>
                        </tr>                    
                        <tr>  
                            <td style="text-align: left;"> <strong>LIQUIDO A PAGAR</strong> </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td class="last">
                <table class="subtable" align="right">
                    <tbody>
                        <tr>  
                            <td style="text-align: right; padding: 0px"> $ '.number_format($totalDescuento,0,',','.').' </td>
                        </tr>
                        <tr>  
                            <td style="text-align: right; padding: 0px"> $ '.number_format($alcanceLiquido,0,',','.').' </td>
                        </tr>
                        <tr>  
                            <td style="text-align: right; padding: 0px"> $ '. number_format($anticipo,0,',','.') .' </td>
                        </tr>                    
                        <tr>  
                            <td style="text-align: right; padding: 0px">
                                <strong> $ '.number_format($totalPagar,0,',','.').' </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>'; 
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($totalPagar,"pesos")); 
$content .= "SON " . $con_letra; 
$content .= '<br /><br />
<p style="font-size: 9pt">
Certifico que he recibido de '.$razonSocial.' a mi entera satisfacción el saldo liquido liquidado en la presente 
liquidación y no tengo ni cargo ni cobro alguno posterior que hacer por ninguno de los conceptos comprendidos en ella.
</p>
<br />
<table class="table_footer">
    <tr>
        <td class="left"> Santiago, '. cal_days_in_month(CAL_GREGORIAN, $liquidacion['mes'],$liquidacion['ano']) .' de ' . getNombreMes( $liquidacion['mes'] ) . ' de '. $liquidacion['ano'] .' </td>
        <td class="right"> 
        _______________________________________<br />
        '.$nombre_trabajador.'        
        </td>
    </tr>
</table>

</page>';


/*
echo $content;
die();
*/


require_once('../libs/html2pdf/html2pdf.class.php');
$html2pdf = new HTML2PDF('P','LETTER','es');
$html2pdf->WriteHTML($content);    
//$html2pdf->Output('liquidacion_' . $nombre_trabajador_slug . '_' .  date("Y-m-t", strtotime($a_date)) .'.pdf');
$html2pdf->Output( strtoupper($trabajador['apellidoPaterno']) . ' ' . strtoupper($trabajador['nombres']) . '.pdf');


?>
