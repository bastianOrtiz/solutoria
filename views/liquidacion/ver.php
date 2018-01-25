<!-- Content Wrapper. Contains page content -->
<style>
td.total{
    text-align: right;
}
.subtotal td{
    background: #FFFFB0;
}
</style>
      <div class="content-wrapper">        
        <section class="content-header">
          <h1> <strong>Previsualizar liquidacion <i class="fa fa-eye"></i> </strong> </h1>
          <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        </section>
        
        <section class="content" id="liquidacion_de_sueldo">
            <div class="box">
                <div class="box-header with-border">                    
                    <table>
                        <tr>
                            <td style="padding: 0 20px;"> 
                                <img src="<?php echo BASE_URL ?>/private/imagen.php?f=<?php echo base64_encode(base64_encode(date('Ymd')) . $_SESSION[PREFIX.'login_eid']) ?>&t=<?php echo base64_encode('m_empresa') ?>" class="round" /> 
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td> <?php echo $empresa['razonSocial'] ?> </td>
                                    </tr>
                                    <tr>
                                        <td> RUT: <?php echo $empresa['rut'] ?> </td>
                                    </tr>
                                    <tr>
                                        <td> <?php echo $empresa['direccion'] ?> </td>
                                    </tr>
                                    <tr>
                                        <td> <?php echo $empresa['razonSocial'] ?> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>                    
                    <br /><br />
                    
                    <h3 class="box-title" style="display: block;">Nombre: <?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?> 
                        <span style="float: right; font-size: 14px;">(Última liquidacion procesada: <strong><?php echo $ultima_liquidacion ?></strong>)</span>
                    </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered" id="tabla_liquidacion">
                        <tbody>
                            <tr>
                                <th style="width: 80%;">Item</th>
                                <th style="width: 20%;">Valor</th>                                
                            </tr>
                            <tr>
                                <td> 
                                    <strong>Sueldo Base de <?php echo getNombreMes(getMesMostrarCorte()) ?></strong> 
                                    (<?php echo ( 30 - $ausencias ) ?> días trabajados) </td>
                                <td class="total"> $ <?php echo number_format($sueldo, 0, '', '.'); ?> </td>
                            </tr>
                            <tr>
                                <td> <strong>Gratificación</strong> </td>
                                <td class="total"> $ <?php echo number_format($gratificacion, 0, '', '.'); ?> </td>
                            </tr>                            
                            <tr>
                                <td><strong>Horas Extra Normal (<?php echo $horas_extra['normal'] ?>) :</strong></td>
                                <td class="total"> $ <?php echo number_format($hora_extra_normal , 0, ',', '.') ?> </td>
                            </tr>
                            
                            <tr>
                                <td> <strong>Hora Extra Domingos / Festivos (<?php echo $horas_extra['festivo'] ?>):</strong> </td>
                                <td class="total"> $ <?php echo number_format($hora_extra_festivo, 0, ',', '.') ?> </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <strong> Bonos y Comisiones Imponibles</strong><br />
                                    <table style="margin: 10px; width: 85%;" class="table table-striped table-bordered" id="table_haber_trabajador">                              		
                                        <tbody>
                                            <?php 
                                            $total_haberes_imponibles = 0;
                                            foreach( $haberes_imponibles as $dt ){ 
                                            ?>
                                            <tr>  
                                                <td> 
                                                    <?php echo $dt['nombre'] ?> 
                                                    <?php 
                                                    if( $dt['glosa'] ){
                                                        echo "(" . $dt['glosa'] . ")";
                                                    }
                                                    ?>
                                                </td>
                                                <td> 
                                                $ <?php
                                                $valor_tipo_moneda = getValorMoneda(getMesMostrarCorte(),getAnoMostrarCorte(),$dt['tipomoneda_id']);
                                                $valor_subtotal = ( $valor_tipo_moneda * $dt['valor'] );                                                 
                                                echo number_format($valor_subtotal,0,',','.'); 
                                                ?>  
                                                </td>                                                                                        
                                            </tr>
                                            <?php 
                                            $total_haberes_imponibles += $valor_subtotal;
                                            } 
                                            ?>
                                            <?php if( $semana_corrida != 0 ){ ?>
                                            <tr>
                                                <td> <strong>Semana Corrida</strong> </td>
                                                <td> $ <?php echo number_format($semana_corrida,0,',','.'); ?> </td>                                
                                            </tr>
                                            <?php } ?>
                                		</tbody>
                                	</table>
                                </td>
                                <td class="total" style="vertical-align: bottom;">
                                    <?php $total_haberes_imponibles += $semana_corrida ?>
                                    $ <?php echo number_format($total_haberes_imponibles,0,',','.'); ?>
                                </td>
                            </tr>                            
                            <tr class="subtotal">
                                <td> <strong>Total Imponible</strong> </td>
                                <td class="total"> 
                                 <strong><?php echo "$ " . number_format($total_imponible,0,',','.'); ?></strong>                                  
                                </td>
                            </tr>
                            <tr>
                                <td> <strong>Remuneracion Tributable: </strong> </td>
                                <td class="total"> <?php echo "$ " . number_format($remuneracion_tributable,0,',','.'); ?> </td>
                            </tr>
                            
                            
                            <tr>
                                <td>
                                    <strong> Haberes NO Imponibles</strong><br />
                                    <table style="margin: 10px; width: 85%;" class="table table-striped table-bordered" id="table_haber_trabajador">                              		
                                        <tbody>
                                            <?php 
                                            $total_haberes_no_imponibles = 0;
                                            foreach( $haberes_no_imponibles as $dt ){ 
                                            ?>
                                            <tr>  
                                                <td> 
                                                    <?php echo $dt['nombre'] ?> 
                                                    <?php 
                                                    if( $dt['glosa'] ){
                                                        echo "(" . $dt['glosa'] . ")";
                                                    }
                                                    ?>
                                                </td>
                                                <td> $ <?php echo number_format($dt['valor'],0,',','.'); ?>  </td>                                                                                        
                                            </tr>
                                            <?php 
                                            $total_haberes_no_imponibles += $dt['valor'];
                                            } 
                                            ?>
                                		</tbody>
                                	</table>
                                </td>
                                <td class="total" style="vertical-align: bottom;">
                                    $ <?php echo number_format($total_haberes_no_imponibles,0,',','.'); ?>
                                </td>
                            </tr>
                            
                            <tr class="subtotal"> 
                                <td>  
                                    <strong>TOTAL HABERES</strong>
                                </td> 
                                <td class="total"> 
                                    <?php 
                                    $total_haberes = ($remuneracion_tributable + $total_haberes_no_imponibles );
                                    echo "<strong>$ " . number_format($total_haberes,0,',','.')."</strong>"; 
                                    ?> 
                                </td>
                            </tr>                                                       
                            
                            <?php if( tipoTrabajador('afp',$trabajador_id) ): ?>
                            <tr>
                                <td> <strong>AFP <?php echo $afp_trabajador['nombre']; ?> &nbsp; (<?php echo $afp_trabajador['valor']; ?>%)</strong> </td>
                                <td class="total"> 
                                    <?php
                                    $afpPorcentaje = $afp_trabajador['valor']; 
                                    $total_afp = ( ( $total_imponible * $afp_trabajador['valor'] ) / 100 );
                                    echo '$ ' . number_format($total_afp,0,',','.');  
                                    ?> 
                                </td>
                            </tr>
                            <?php 
                            else:
                                $afpPorcentaje = 0; 
                                $total_afp = 0;
                            ?>
                            <tr>
                                <td> <strong>AFP</strong> (No cotiza) </td>
                                <td class="total"> $ 0 </td>
                            </tr>
                            <?php endif; ?>
                            
                            <?php if( tipoTrabajador('salud',$trabajador_id) ): ?>
                            <tr>
                                <td> 
                                    <strong>Salud </strong> 
                                    <?php                                     
                                    if( trabajadorEstaEnFonasa($trabajador_id) ){
                                        echo "Fonasa";
                                        $isapre_id = 0;
                                        $isaprePactado = 0;
                                    } else {                                        
                                        echo fnGetNombre($prevision_trabajador['isapre_id'],'m_isapre',0);
                                        $isapre_id = $prevision_trabajador['isapre_id'];
                                        $isaprePactado = $prevision_trabajador['montoPlan'];
                                    }                                    
                                    ?>
                                    <br />
                                    
                                    <?php if( !trabajadorEstaEnFonasa($trabajador_id) ){ ?>
                                    Pactado: <?php echo number_format($prevision_trabajador['montoPlan'],3,',','.'); ?> <?php echo fnGetNombre($prevision_trabajador['tipomoneda_id'],'m_tipomoneda',0) ?>
                                    <?php } ?>
                                    <span style="padding-right: 200px;"></span>  
                                                                        
                                    7% Legal: $ <?php echo number_format($total_salud_legal,0,',','.'); ?>                                    
                                    <br /><br />
                                    
                                    <?php 
                                    echo "Dias Licencia: " . $dias_licencia."<br />";
                                    if($dias_licencia){
                                    if( $dias_licencia > 0 ){ ?>
                                    Proporcional x licencia: <?php echo round($proporcional_pactado_licencia,3); ?> <?php echo fnGetNombre($prevision_trabajador['tipomoneda_id'],'m_tipomoneda',0) ?>
                                    <br /><br />
                                    $ <?php echo number_format($proporcional_pactado_licencia_en_pesos,0,',','.'); ?>
                                    <br /><br />
                                    <?php } ?>
                                    
                                    <?php
                                     if( $diferencia_isapre > 0 ){ ?>
                                    Diferencia Isapre: $ <?php echo number_format($diferencia_isapre,0,',','.'); ?>
                                    <?php } } else { $dias_licencia = 0; } ?>
                                    <span style="padding-right: 300px;"></span>
                                    $ <?php echo number_format( ( $total_salud_legal + $diferencia_isapre ) - $total_salud_legal,0,',','.' ); ?>
                                </td>
                                <td class="total" style="vertical-align: bottom;">
                                    <?php                                    
                                    $total_salud = ( $total_salud_legal + $diferencia_isapre );
                                    echo "$ " . number_format($total_salud,0,',','.')."<br />";
                                    /*
                                    echo "$ " . number_format($total_pactado_isapre,0,',','.')."<br />";
                                    echo (@$diferencia_isapre) ? "($ " . number_format($diferencia_isapre,0,',','.').')' : '';
                                    */
                                    ?>
                                </td>
                            </tr>
                            <?php 
                            else:
                            $total_salud = 0;
                            $total_pactado_isapre = 0;
                            $diferencia_isapre = 0;
                            ?>
                            <tr>
                                <td> <strong>Salud</strong> (No cotiza) </td>
                                <td class="total"> $ 0 </td>
                            </tr>
                            <?php endif; ?>
                            
                            <?php   
                            $topeAfc = topeAfc($remuneracion_tributable, $total_imponible, $ausencias,$dias_licencia, $trabajador['tipocontrato_id'] );

                            if( tipoTrabajador('afc',$trabajador_id) ):                                                                                     
                            ?>
                            <tr>
                                <td> <strong>AFC</strong> &nbsp; (0.6% &nbsp; de &nbsp; $ <?php echo number_format($topeAfc,0,',','.'); ?>) </td>
                                <td class="total"> $  
                                    <?php                                                               
                                    //$total_afc = obtenerTotalAfc( $remuneracion_tributable, $total_imponible, $ausencias,$dias_licencia );
                                    $total_afc = obtenerTotalAfc2( $topeAfc,$trabajador_id );
                                    echo number_format($total_afc,0,',','.');
                                    ?>
                                </td>
                            </tr>
                            <?php 
                            else: 
                                $total_afc = 0;                                
                            ?>
                            <tr>
                                <td> <strong>AFC</strong> (No cotiza) </td>
                                <td class="total"> $ 0 </td>
                            </tr>
                            <?php endif; ?>
                            
                            <?php
                            $apv_trabajador = apvTrabajador($trabajador_id);
                            $total_apv = 0;
                            $total_apv_A = 0; // Tipo A NO rebaja tributaria
                            $total_apv_B = 0;
                            
                            if( $apv_trabajador ){                                
                                foreach( $apv_trabajador as $apv ){
                                $total_apv += $apv['monto'];
                                if( $apv['tipo'] == 'A' ){
                                    $total_apv_A += $apv['monto'];
                                } else {
                                    $total_apv_B += $apv['monto'];
                                }
                                
                                    if( $total_apv_B > 0 ){
                                    ?>
                                    <tr>
                                        <td> <strong><?php echo $apv['nombre']; ?></strong> </td>
                                        <td class="total"> $ <?php echo number_format($total_apv_B,0,',','.') ?> </td>
                                    </tr>
                                    <?php
                                    }
                                }
                            } else { 
                                $total_apv = 0; 
                            } 
                            ?>
                            
                            <?php 
                            $cuenta2 = obtenerPrevisionTrabajador($trabajador_id);
                            if($cuenta2){ 
                                $cuenta2id = $cuenta2['id'];
                                $cuenta2monto = $cuenta2['monto'];
                            ?>
                            <tr>
                                <td> <strong>Cuenta 2</strong> <?php echo $cuenta2['nombre']; ?> </td>
                                <td class="total"> $ <?php echo number_format($cuenta2['monto'],0,',','.') ?> </td>
                            </tr>
                            <?php } else {
                                $cuenta2id = 0;
                                $cuenta2monto = 0;                                
                            } 
                            
                            $total_rebaja_impuesto = obtenerTotalRebajaImpuesto( round($total_afp),round($total_salud_legal),round($total_salud),round($total_afc),round($total_apv_B));
                            $total_rebaja_impuesto = $total_rebaja_impuesto;
                            ?>
                            
                            <tr class="subtotal">
                                <td> <strong>TOTAL DESCUENTOS PREVISIONALES</strong> </td>
                                <?php 
                                $total_descuentos_previsionales = round($total_afp) + round($total_salud) + round($total_afc) + round($total_apv) + round($cuenta2['monto']);
                                ?>
                                <td class="total"> <strong><?php echo "$ " . number_format($total_descuentos_previsionales,0,',','.'); ?></strong> </td>
                            </tr>
                            
                            <?php $total_tributable = ( $remuneracion_tributable - $total_rebaja_impuesto ); ?>
                            
                            <!-- Si NO es trabajador agricola -->
                            <?php 
                            if( $trabajador['agricola'] == 0 ){ 
                            $impuesto_agricola = 0;    
                            ?>                      
                            <tr>
                                <td colspan="2" style="text-align: left !important;">
                                    <div style="float: left;"><strong>Cálculo de Impuesto Unico</strong></div>
                                    <br class="clear" />
                                    <div class="col-md-10 pull-left">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td> Remuneración Tributable </td>
                                                    <td style="text-align: right; padding-right: 200px;"> <?php echo "$ " . number_format($remuneracion_tributable,0,',','.'); ?> </td>
                                                </tr>
                                                <tr>
                                                    <td> Descuentos Previsionales a rebajar </td>
                                                    <td style="text-align: right; padding-right: 200px;"> 
                                                        <?php echo "$ " . number_format($total_rebaja_impuesto,0,',','.'); ?> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> Total Tributable </td>                                                    
                                                    <td style="text-align: right; padding-right: 200px;"> <?php echo "$ " . number_format($total_tributable,0,',','.'); ?> </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align: right;"> 
                                                        Total Impuesto<br /> 
                                                        Cantidad rebajar<br />
                                                        Impuesto a Pagar
                                                    </td>
                                                    <td class="total">  
                                                    <?php 
                                                    $info_impuesto = calcularImpuesto($total_tributable);
                                                    echo "$ " . number_format($info_impuesto['total_impuesto'],0,',','.')."<br />";
                                                    echo "$ " . number_format($info_impuesto['cantidad_rebajar'],0,',','.')."<br />";
                                                    echo "$ " . number_format($info_impuesto['impuesto_pagar'],0,',','.')."<br />";
                                                    ?>
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- SI es trabajador agricola -->
                            <?php } else { ?>
                            
                            <tr>
                                <td colspan="2" style="text-align: left !important;">                                                                        
                                    <div class="col-md-10 pull-left">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td> <strong>Impuesto al Trabajador Agricola</strong> </td>                                                    
                                                    <td style="text-align: right; padding-right: 200px;"> 
                                                    <?php 
                                                    $impuesto_agricola = calcularImpuestoAgricola($remuneracion_tributable); 
                                                    echo "$ " . number_format($impuesto_agricola,0,',','.'); 
                                                    //Si es trabajador agricola, solo se calcula el impuesto al trabajdor Agricola 
                                                    //y el otro impuesto queda en 0
                                                    $info_impuesto = array(
                                                        'total_impuesto' => 0,
                                                        'cantidad_rebajar' => 0,
                                                        'impuesto_pagar' => 0
                                                    )
                                                    ?> 
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                            <?php } ?>
                            
                            <tr>
                                <td> 
                                    <strong>Descuentos</strong> <br /> 
                                    <?php 
                                    $total_otros_descuentos = 0;
                                    if( ( $debes_trabajador ) || ( $total_apv_A > 0 ) ){ 
                                    ?>
                                    <table style="margin: 10px; width: 85%;" class="table table-striped table-bordered">
                            			<thead>
                                        	<tr>
                            					<th> Cuota Actual </th>
                                                <th> Total Cuotas</th>
                                                <th> Descuento </th>
                                                <th> Valor </th>                                                
                            				</tr>
                                        </thead>
                                        
                                        <tbody>
                                            <?php                                             
                                            foreach( $debes_trabajador as $dt ){ 
                                            ?>
                                            <tr id="tr_<?php echo $dt['id'] ?>">  
                                                <td> 
                                                    <?php 
                                                    if( existeLiquidacion($trabajador_id) ){
                                                        if( ( $dt['fechaFinalizacion'] == leadZero($mes)."-".$year ) && ( $dt['activo'] == 1 ) ){
                                                            echo ( $dt['cuotaActual'] - 1 < 0 ) ? 0 : $dt['cuotaActual'] - 1; ;    
                                                        } else {
                                                            echo $dt['cuotaActual'];    
                                                        }                                                       
                                                    } else {
                                                        echo $dt['cuotaActual'];
                                                    }
                                                     
                                                    ?> 
                                                </td>
                                                <td> <?php echo $dt['cuotaTotal'] ?> </td>
                                                <td> 
                                                    <?php echo fnGetNombre($dt['descuento_id'],'m_descuento',false) ?> 
                                                    <?php 
                                                    if( $dt['glosa'] ){
                                                        echo "(" . $dt['glosa'] . ")";
                                                    }
                                                    ?>
                                                </td>
                                                <td> 
                                                $ 
                                                    <?php                                                    
                                                    $valor_tipo_moneda = getValorMoneda(getMesMostrarCorte(),getAnoMostrarCorte(),$dt['tipomoneda_id']);                                                    
                                                    if( !$valor_tipo_moneda ){
                                                        redirect(BASE_URL.'/tipomoneda/listar','',true,'No ha definido el valor de este mes para algunos tipos de moneda');
                                                        exit();
                                                    }
                                                    
                                                    $valor_subtotal = ( $valor_tipo_moneda * $dt['valor'] );
                                                    echo number_format($valor_subtotal,0,',','.'); 
                                                    ?> 
                                       
                                                </td>                                            
                                            </tr>
                                            <?php 
                                            $total_otros_descuentos += $valor_subtotal;                                             
                                            } 
                                            ?>
                                            
                                            <?php                                            
                                            if( $total_apv_A > 0 ){
                                            ?>
                                            <tr>  
                                                <td> 
                                                    1 
                                                </td>
                                                <td> 1 </td>
                                                <td>  <?php echo $apv['nombre']; ?> </td>
                                                <td> $ <?php echo number_format($total_apv_A,0,',','.') ?> </td>                                            
                                            </tr>
                                            <?php } ?>
                                        </tbody>


                            		</table>
                                    <?php } ?>
                                </td>
                                <td class="total" style="vertical-align: bottom;">
                                    $ <?php echo number_format($total_otros_descuentos,0,',','.')  ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <td> <strong> Atrasos </strong> ( <?php echo ($total_descuento_atrasos['total_horas_atraso'] * 60 ) ?> minutos ) </td>
                                <td class="total"> $ <?php echo number_format($total_descuento_atrasos['total_descontar_atrasos'],0,',','.') ?> </td>
                            </tr>
                            <tr class="subtotal">
                                <td><strong>TOTAL OTROS DESCUENTOS</strong></td>
                                <td class="total"> 
                                    <strong><?php echo "$ " . number_format(($total_descuento_atrasos['total_descontar_atrasos'] + $total_otros_descuentos ),0,',','.') ?></strong> 
                                </td>
                            </tr>
                            <tr>
                                <td> 
                                    <table align="right" style="width: 20%;">
                                        <tr>  
                                            <td style="text-align: left;"> TOTAL DESCUENTOS </td>
                                        </tr>
                                        <tr>  
                                            <td style="text-align: left;"> REMUNERACIÓN LIQUIDA </td>
                                        </tr>
                                        <tr>  
                                            <td style="text-align: left;"> ANTICIPOS </td>
                                        </tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr>  
                                            <td style="text-align: left;"> <strong>LIQUIDO A PAGAR</strong> </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table style="width: 100%;">
                                        <tr>  
                                            <td class="total">
                                            $ 
                                            <?php
                                            $total_descuentos = ( $total_descuentos_previsionales + $info_impuesto['impuesto_pagar'] + $total_descuento_atrasos['total_descontar_atrasos'] + $total_otros_descuentos + $impuesto_agricola );
                                            echo number_format($total_descuentos, 0, ',', '.'); 
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>  
                                            <td class="total">
                                            $  
                                            <?php                              
                                            $alcance_liquido = ( $total_haberes - $total_descuentos );
                                            echo number_format($alcance_liquido, 0, ',', '.'); 
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>  
                                            <td class="total"> $ <?php echo number_format($anticipo, 0, ',', '.'); ?> </td>
                                        </tr>
                                        <tr><td>&nbsp;</td></tr>
                                        <tr>  
                                            <td class="total">
                                                <strong>
                                                $
                                                <?php 
                                                $liquido_pagar = ( $alcance_liquido - $anticipo );                                            
                                                echo number_format($liquido_pagar, 0, ',', '.'); 
                                                ?>
                                                </strong>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->                
            </div>
            
            <div class="box-footer">
                <form action="" method="post">                                                                    
                    <?php                     
                    $_SESSION[PREFIX.'totales_liquidar'] = array(
                        'trabajador_id' => $trabajador_id,
                        'ano' => date('Y'),
                        'sueldoMaestro' => 'FROM DB',
                        'diaAusencia' => $ausencias,
                        'diaLicencia' => $dias_licencia,
                        'sueldoBase' => $sueldo,
                        'gratificacion' => $gratificacion,
                        'horaExtra' => $horas_extra['normal'],
                        'horaExtraMonto' => $hora_extra_normal,
                        'horaExtraFestivo' => $horas_extra['festivo'],
                        'horaExtraFestivoMonto' => $hora_extra_festivo,
                        'horaAtraso' => $total_descuento_atrasos['total_horas_atraso'],
                        'horaAtrasoMonto' => $total_descuento_atrasos['total_descontar_atrasos'],
                        'semanaCorrida' => $semana_corrida,
                        'totalImponible' => $total_imponible,
                        'totalNoImponible' => $total_haberes_no_imponibles,
                        'remuneracionTributable' => $remuneracion_tributable,
                        'afp_id' => $afp_id,
                        'afpMonto' => $total_afp,
                        'afpPorcentaje' => $afpPorcentaje,
                        'isapre_id' => $isapre_id,
                        'saludMonto' => $total_salud,
                        'isaprePactado' => $isaprePactado,
                        'monedaIsaprePactado' => $prevision_trabajador['tipomoneda_id'],
                        'afcMonto' => $total_afc,
                        'topeAfc' => $topeAfc,
                        'apvMonto' => $total_apv,
                        'cuenta2Id' => $cuenta2id,
                        'cuenta2Monto' => $cuenta2monto,
                        'descuentoPrevisional' => $total_rebaja_impuesto,
                        'totalTributable' => $total_tributable,
                        'impuestoTotal' => $info_impuesto['total_impuesto'],
                        'impuestoRebajar' => $info_impuesto['cantidad_rebajar'],
                        'impuestoPagar' => $info_impuesto['impuesto_pagar'],
                        'impuestoAgricola' => $impuesto_agricola,
                        'totalDescuento' => $total_descuentos,
                        'alcanceLiquido' => $alcance_liquido,
                        'anticipo' => $anticipo,
                        'totalPagar' => $liquido_pagar,
                        'empresa_id' => $_SESSION[PREFIX.'login_eid'],
                        'departamento_id' => $trabajador['departamento_id'],
                        'centrocosto_id' => $trabajador['centrocosto_id']
                    );
                    ?>
                                        
                    <button type="submit" name="action" value="liquidar" class="btn btn-primary">Liquidar</button>
                    <button type="button" name="action" value="" class="btn btn-warning" onclick="location.href='<?php echo BASE_URL ?>/trabajador/editar/<?php echo $trabajador_id; ?>'">Modificar Trabajador</button>
                    
                    <?php if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){ ?>
                        <a target="_blank" href="<?php echo BASE_URL ?>/private/pdfgen.php?id=<?php echo encrypt($liquidacion_id) ?>" class="btn btn-primary pull-right"> <i class="fa fa-file-pdf-o"></i> EXPORTAR A PDF</a>
                    <?php } else { ?>
                        <a href="#" class="btn btn-primary pull-right disabled"> DEBE LIQUIDAR ANTES DE PODER EXPORTAR</a>
                    <?php } ?>
                     
                </form>
            </div>                    
            
        </section>
        
      </div><!-- /.content-wrapper -->
      
<script>
$(document).ready(function(){
    $("#tabla_liquidacion tr").each(function(){
        //$(this).find('td:last').css('text-align','right');
    })
})
</script>
