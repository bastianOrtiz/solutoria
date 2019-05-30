<?php include ROOT . '/models/liquidacion.php'; ?>
<?php 
$total_descuento_atrasos    = obtenerTotalDescuentoXAtrasos($trabajador_id,false);
$total_atrasos              = ( $total_descuento_atrasos['total_horas_atraso'] * 60 );
$minutos_gracia             = $db->getValue("m_empresa",'minutoGracia');
$horas_extra                = obtenerHoraExtraTrabajador($trabajador_id);

if( $total_atrasos > $minutos_gracia ){
    $total_atrasos_descontar = ($total_atrasos - $minutos_gracia);
} else{
    $total_atrasos_descontar = 0;
}


?>
<style>
td{
    font-size: 12px;
}
.chk_autorize{
    visibility: hidden;
    position: absolute;
    top: -9999999px;
    left: -9999999px;
}
.bg-red{
    border: 1px solid red;
}

#tab_5 table th{
    text-align: center;
}
#tab_5 table tbody td{
    text-align: center;
    height: auto !important;
}

.box_datos_reloj{
    background: #ecf0f5;
}
.box_datos_reloj.collapsed-box{
    background: #F9F9FF;
}
.bg-transp{
    background: #fff;
    color: #333;
}
.input-group-addon{
    width: 40px;
    height: 34px;
}

.no_laboral{
    background: #F4F4F4;
}
.ausente{
    background: #FF9595;
}
.input-group-addon{
    cursor: pointer;
}

.main-sidebar, 
.left-side,
.main-header,
.main-footer,
.content-header,
.nav-tabs,
.box-header,
.box-footer{
    display: none;
}

.box-body,
.col-md-12,
.row,
.box,
table td,
table th,
#tab_5 table tbody td{
    padding: 0;
    margin: 0;
}

.content-wrapper{
    width: 100%;
    margin: 0 !important;
}
</style>


<div class="tab-pane" id="tab_5">
    <div class="row">
          <div class="col-md-12">                        
              <div class="box box-primary">
                <div class="box-body">
                    <?php if( ( empresaUsaRelojControl() ) && ( relojControlSync() ) && ( marcaTarjeta($trabajador['id']) ) ){ ?>
                        <div class="col-md-12" id="relojcontrol_list">                                                                        
                            <h4 class="box-title"><strong><?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?></strong></h4>
                            <h4 class="box-title"> Horario del trabajador: de <strong><?php echo $m_horario_entrada ?></strong> a <strong><?php echo $m_horario_salida ?></strong> </h4>
                            <div class="box box-solid box_datos_reloj">
                                <div class="box-header">                                                    
                                    <h3 class="box-title"> Ausencias, Atrasos y Horas Extras </h3>
                                </div>
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="table-responsive">                                                            
                                            <table class="table table-bordered" style="background: #fff;" id="table_reloj_control">
                                            	<tbody>
                                            		<tr>
                                            			<th style="width: 130px">
                                            				Día
                                            			</th>
                                            			<th>
                                            				Hora entrada
                                            			</th>
                                            			<th>
                                            				Autorizado
                                            			</th> 
                                                        <th>
                                            				Hora Salida
                                            			</th>
                                            			<th>
                                            				Autorizado
                                            			</th>                                                   			
                                            		</tr>
                                                    <?php                                                                     
                                                    $arr_no_IN = array();
                                                    $arr_no_OUT = array();                        
                                                    $arr_ausencias = array();
                                                    $hora_marcada_ini_fds = '';
                                                    $hora_marcada_out_fds = '';
                                                    $tiene_impuntualidad = false;
                                                    $total_impuntualidad = 0;
                                                                                            
                                                    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                                                    $fecha_iterar = date("Y-m-d", $i);
                                                    $es_ausencia = comprobarAusencia($fecha_iterar, $trabajador['id']);
                                                    
                                                    $fecha_iterar_int = str_replace("-","",$fecha_iterar);
                                                    $fecha_iterar_int = (int)$fecha_iterar_int;                                                                        
                                                    ?>
                                                    <tr>
                                                    <?php 
                                                    $dia_semana = date('N', strtotime($fecha_iterar));
                                                    $dia_semana--;
                                                    if( !in_array($dia_semana,$dias_laborales_horario) ){ // Si es un dia NO laboral, se pueden agregar horas extras en caso que se trabaje                                                                    
                                                    
                                                    foreach( $entradas as $I ){
                                                        $datereg = explode(" ",$I['checktime']);                                                                            
                                                        $fecha_comparar = date_create($I['checktime']);
                                                        $fecha_comparar = date_format($fecha_comparar,"Y-m-d");
                                                        
                                                        if($fecha_iterar == $fecha_comparar){
                                                            $hora_marcada_ini_fds = $datereg[1];                                                                                
                                                        }
                                                    }
                                                    
                                                    
                                                    foreach( $salidas as $O ){
                                                        $datereg = explode(" ",$O['checktime']);                                                                            
                                                        $fecha_comparar = date_create($O['checktime']);
                                                        $fecha_comparar = date_format($fecha_comparar,"Y-m-d");
                                                        
                                                        if($fecha_iterar == $fecha_comparar){
                                                            $hora_marcada_out_fds = $datereg[1];                                                                                
                                                        }
                                                    }
                                                    ?>
                                    
                                                        <td class="no_laboral"><?php echo $fecha_iterar; ?></td>
                                                        <td class="no_laboral" colspan="2" style="text-align: left;">                                                                            
                                                            <?php                                                                                     
                                                            $arr_marcajes = getMarcajeFDS($fecha_iterar, $trabajador_id);
                                                            if( $arr_marcajes['entrada'] != "" ){
                                                                $time = strtotime($arr_marcajes['entrada']['checktime']);
                                                                ?>
                                                                <span class="badge">
                                                                <?php echo date('H:i:s',$time); ?>
                                                                </span>
                                                                <?php
                                                            } 
                                                            ?>
                                                        </td>
                                                        <td class="no_laboral">
                                                            <?php                                                                                     
                                                                $arr_marcajes = getMarcajeFDS($fecha_iterar, $trabajador_id);                                                                                    
                                                                if( $arr_marcajes['salida'] != "" ){
                                                                    $time = strtotime($arr_marcajes['salida']['checktime']);
                                                                    ?>
                                                                    <span class="badge">
                                                                    <?php echo date('H:i:s',$time); ?>
                                                                    </span>
                                                                    <?php
                                                                } 
                                                            ?>
                                                        </td>
                                                        <td class="no_laboral">
                                                            <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                            <span id="span_<?php echo $fecha_iterar ?>"></span>                                                                
                                                        </td>                                                        
                                                                                                                                                    
                                                        
                                                    <?php } elseif( isDiaFeriado($fecha_iterar) ){ ?> 
                                                        <td class="no_laboral"><?php echo  $fecha_iterar; ?></td>
                                                        <td colspan="4" class="no_laboral">
                                                                    <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                    <span id="span_<?php echo $fecha_iterar ?>"></span>                                                            
                                                        </td>
                                                    <?php } elseif( $es_ausencia['es_ausencia'] ){ ?>
                                                        <td class="ausente es_ausencia"><?php echo $fecha_iterar; ?></td>
                                                        <td class="ausente es_ausencia" colspan="4" style="text-align: left;"><strong><?php echo $es_ausencia['motivo'] ?></strong></td>    
                                                    <?php } else {  ?>
                                                        
                                                    <?php 
                                                        $flag = 0;
                                                        foreach( $entradas as $IN ){
                                                            
                                                            
                                                            $datereg = explode(" ",$IN['checktime']);
                                                            $fechareg = explode("-",$datereg[0]);
                                                            $hora_entrada = strtotime( $datereg[1] );                                                                            
                                                                
                                                            $fecha_comparar = date_create($IN['checktime']);
                                                            $fecha_comparar = date_format($fecha_comparar,"Y-m-d");
                                                            
                                                            if($fecha_iterar == $fecha_comparar){
                                                                $dia_semana = date('N', strtotime($fecha_iterar));
                                                                $dia_semana--;
                                                                
                                                                if( !in_array($dia_semana,$dias_laborales_horario) ){
                                                                    $cls_no_trabaja = 'no_laboral';
                                                                } else {
                                                                    $cls_no_trabaja = '';
                                                                }                                                                                                                                                                     
                                                        ?>
                                                    	<td class="<?php echo $cls_no_trabaja; ?>">                                                                       
                                                            <?php echo $fecha_iterar; ?> 
                                                        </td>
                                                        <!-- Badeclass: bg-red Ó bg-transp-->
                                                        <?php
                                                        /** SI es un dia laboral **/
                                                        if( in_array($dia_semana,$dias_laborales_horario) ){
                                                            /** SI llego atrasado, muestra en rojo **/                                                            
                                                            if( $hora_entrada > strtotime( $m_horario_entrada ) ) {
                                                                $cls='bg-red';
                                                                $tipo_j = 'A';                                                                                                                                                                                                                
                                                            } elseif( $hora_entrada == strtotime( $m_horario_entrada ) ) {                                                                                
                                                                $cls='bg-transp';
                                                                $tipo_j = '';                                                                                
                                                            } else{                                                                                
                                                                $cls='bg-green';
                                                                $tipo_j = 'H';                                                                                
                                                            }
                                                        
                                                            ?>
                                                        <td>
                                                            <span class="badge <?php echo $cls; ?>">                                                                                
                                                                <?php echo $datereg[1]; ?>
                                                            </span>
                                                        </td>
                                                        <?php 
                                                        } else {
                                                        $tipo_j = 'H';
                                                        ?>
                                                        <td colspan="4" class="<?php echo $cls_no_trabaja; ?>">
                                                                    <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                    <span id="span_<?php echo $fecha_iterar ?>"></span>
                                                            
                                                        </td>
                                                        <?php    
                                                        }
                                                        ?>                                                                
                                                        
                                            			    <?php 
                                                            /** SI llego atrasado, muestra ticket para autorizar **/                                                                    
                                                            if( in_array($dia_semana,$dias_laborales_horario) ){
                                                            ?>
                                                            <td style="width: 350px;" class="<?php echo $cls_no_trabaja; ?>">
                                                            <?php
                                                                if( $hora_entrada != strtotime( $m_horario_entrada ) ) {                                                                        
                                                                ?>
                                                                        <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                        <span id="span_<?php echo $fecha_iterar ?>"></span>
                                                                
                                                                <?php 
                                                                }
                                                            ?>
                                                            </td>
                                                            <?php 
                                                            } 
                                                                $flag++;                    
                                                                break;
                                                            }
                                                        }
                                                        if( $flag == 0 ){
                                                        $arr_no_IN[] = $fecha_iterar;
                                                    ?>
                                                    
                                            			<td class="ausente"> <?php echo $fecha_iterar ?> </td>
                                            			<td class="ausente no_mark no_marco_no_justif no_marco_in" colspan="2"> 
                                                            <small>No Marcó</small>
                                                            <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][justificado]" />
                                                            <span id="span_<?php echo $fecha_iterar ?>"></span>
                                                        </td>                                                            			                                                    			                                                                
                                            		    
                                                    <?php } ?>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    <?php                                                                    
                                                    $flag_out = 0;
                                                    foreach( $salidas as $OUT ){
                                                        
                                                        $datereg = explode(" ",$OUT['checktime']);                                                                        
                                                        $hora_salida = strtotime( $datereg[1] );                                                                            
                                                            
                                                        $fecha_comparar = date_create($OUT['checktime']);
                                                        $fecha_comparar = date_format($fecha_comparar,"Y-m-d");
                                                        
                                                        if($fecha_iterar == $fecha_comparar){
                                                            $dia_semana = date('N', strtotime($fecha_iterar));
                                                            $dia_semana--;                       
                                                            
                                                            if( !in_array($dia_semana,$dias_laborales_horario) ){
                                                                $cls_no_trabaja = 'no_laboral';
                                                            } else {
                                                                $cls_no_trabaja = '';
                                                            }                                                                                                                                                                     
                                                        ?>                                                                   	 
                                            			    <!-- Badeclass: bg-red Ó bg-transp-->
                                                            <?php
                                                            /** SI llego atrasado, muestra en rojo **/
                                                            if( in_array($dia_semana,$dias_laborales_horario) ){
                                                                if( $hora_salida > strtotime( $m_horario_salida ) ) {
                                                                    $cls='bg-green';
                                                                    $tipo_j = 'H';
                                                                } elseif( $hora_salida == strtotime( $m_horario_salida ) ) {
                                                                    $cls='bg-transp';
                                                                    $tipo_j = '';
                                                                } else{
                                                                    $cls='bg-red';
                                                                    $tipo_j = 'A';
                                                                    $tiene_impuntualidad = true;
                                                                }
                                                                ?>
                                                            <td class="<?php echo $cls_no_trabaja; ?>">
                                                                <span class="badge <?php echo $cls; ?>">
                                                                    <?php echo $datereg[1]; ?>
                                                                </span>
                                                            </td>
                                                                <?php 
                                                            } 
                                                            ?>                                                                
                                                        
                                            			    <?php 
                                                            /** SI llego atrasado, muestra ticket para autorizar **/                                                                    
                                                            if( in_array($dia_semana,$dias_laborales_horario) ){
                                                            ?>
                                                            <td style="width: 350px;" class="<?php echo $cls_no_trabaja; ?>">
                                                            <?php
                                                                if( $hora_salida != strtotime( $m_horario_salida ) ) {                                                                        
                                                                ?>
                                                                <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][justificado]" />
                                                                <span id="span_<?php echo $fecha_iterar ?>"></span>
                                                                
                                                                <?php 
                                                                } 
                                                                ?>
                                                            </td>
                                                            <?php
                                                            } 
                                                                $flag_out++;                    
                                                                break;
                                                            }
                                                        }
                                                        if( $flag_out == 0 ){
                                                        $arr_no_OUT[] = $fecha_iterar;
                                                                                                                            
                                                        ?>
                                                    
                                            			<td class="ausente no_mark no_marco_no_justif no_marco_out"><small>No Marcó</small> </td>
                                            			<td class="ausente" colspan="2"> 
                                                            <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][justificado]" />
                                                            <span id="span_<?php echo $fecha_iterar ?>"></span>                                                            
                                                        </td>                                                            			                                                    			                                                                
                                            		    
                                                    <?php 
                                                            } 
                                                        } 
                                                    ?>
                                                    
                                                    </tr>
                                                    <?php 
                                                        if( ( in_array($fecha_iterar,$arr_no_IN) ) && ( in_array($fecha_iterar,$arr_no_OUT) )  ){
                                                            $arr_ausencias[] = $fecha_iterar;
                                                        }
                                                        
                                                        if( $tiene_impuntualidad ){
                                                            $total_impuntualidad++;
                                                        }
                                                    
                                                    
                                                    } 
                                                    ?>
                                            	
                                                    
                                            	</tbody>
                                            </table>                                                            
                                        </div>
                                    </div>                                                
                                </div>                                            
                            </div>
                            <input type="hidden" name="fI" value="<?php echo $fechaInicio; ?>" />
                            <input type="hidden" name="fF" value="<?php echo $fechaFin; ?>" />
                            <?php  
                            /*                                          
                            show_array($arr_no_IN,0);
                            show_array($arr_no_OUT,0);
                            show_array($arr_ausencias,0);
                            */
                            ?>
                        </div>
                        <?php } ?>
                    
                        <div class="row">                              
                              Días ausente: <span id="total_dias_ausente"></span><br />
                              Total de Impuntualidades: <span id="tota_impuntualidades"></span> <span style="padding-right: 100px;"></span>                    
                              Minutos Atraso: <?php echo $total_atrasos ?><span style="padding-right: 100px;"></span>
                              Minutos a Descontar: <?php echo $total_atrasos_descontar; ?><br /><span style="padding-right: 100px;"></span>
                                <div style="width: 45%; float: left;">
                                  Hora Extra Normal: <?php echo $horas_extra['normal'] ?><br />
                                  Hora Extra Domingos y Festivos: <?php echo $horas_extra['festivos'] ?>                                                            
                              </div>
                              <div style="text-align: right; float: right; width: 45%;">
                              _______________________________________<br />
                              <strong><?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?></strong>                                            
                              </div>
                        </div>                                                                          
                    </div>                                                           
                </div>                                

              </div><!-- /.box -->
            </div>                        
    </div>
    
<script>
arr_justificativos = new Array();
<?php foreach( $justificativos as $j ){ ?>
arr_justificativos[<?php echo $j['id'] ?>] = '<?php echo $j['nombre'] ?>';
<?php } ?>

$(document).ready(function(){
    
    
    $(".chk_autorize").click(function(){
        if($(this).is(':checked')){            
            $(this).closest('.input-group').find('.form-control').show();
            $(this).closest('.input-group').find('select.form-control').addClass('required');
        } else {
            $(this).closest('.input-group').find('select.form-control').removeClass('required');
            $(this).closest('.input-group').find('.form-control').hide();            
        }
    })
    
    <?php 
    
    foreach( $t_atrasohoraextra as $ahe ){
        $ahe['horas'] = procesarDecimal($ahe['horas']);
        $fecha_int = str_replace("-","",$ahe['fecha']);
        $lowerIO = strtolower($ahe['io']);
        
        if( $ahe['horas'] > 0 ){
            $h_ex_efectiva = ' (' . $ahe['horas'] . ' hrs.)';
        } else {
            $h_ex_efectiva = '';
        }

        $justificativo_no_marco = 'justificativo';

    ?>
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").css({ visibility : 'visible' });
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").prop('checked',true);
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").next('span').html( '<strong> ' + arr_justificativos[<?php echo $ahe['justificativo_id'] ?>] + '<?php echo $h_ex_efectiva ?></strong>' );
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('tr').find('small').empty();
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('tr').find('td.no_mark').removeClass('no_marco_no_justif');
    
    <?php
    } 
    ?>
    
    
    
    total_imp = ($("#table_reloj_control .badge.bg-red").length + $('.no_marco_no_justif').length );
    $("#tota_impuntualidades").text( total_imp );    
    $("#total_dias_ausente").text( ( $(".es_ausencia").length / 2 ) )
    
})

$(window).load(function(){
    //window.print();
    //window.onfocus=function(){ window.close();}
})

</script>    