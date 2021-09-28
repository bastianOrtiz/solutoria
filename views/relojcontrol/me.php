<style>
.chk_autorize{
    visibility: hidden;
    position: absolute;
    top: -9999999px;
    left: -9999999px;
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
</style>

<div class="content-wrapper">
        
<section class="content-header">
  <h1> Reloj Control </h1>
  <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
</section>

<section class="content"> 
        
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
                                        

                                        <div class="box box-solid box_datos_reloj">
                                                <div class="box-header">                                                    
                                                    <h3 class="box-title"> Seleccione rango de fechas </h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="col-md-6">
                                                        <label for="fechaInicioRevision"> Fecha inicio </label>
                                                        <input type="text" class="form-control required datepicker" value="" id="fechaInicioRevision" name="fechaInicioRevision" placeholder="YYYY-mm-dd" readonly="">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="fechaFinRevision">Fecha Fin</label>
                                                        <input type="text" class="form-control required datepicker" value="" id="fechaFinRevision" name="fechaFinRevision" placeholder="YYYY-mm-dd" readonly="">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-sm btn-primary" id="btn_revisar_reloj"> Revisar </button>
                                                    </div>                                                
                                                </div>                                                                                                                            
                                            </div>



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
                                                      
                                                        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                                                        $fecha_iterar = date("Y-m-d", $i);
                                                        $es_ausencia = comprobarAusencia($fecha_iterar, $trabajador['id']);
                                                        $ausencia_motivo = $es_ausencia['motivo'];
                                                        $es_ausencia = $es_ausencia['es_ausencia'];

                                                        
                                                        $fecha_iterar_int = str_replace("-","",$fecha_iterar)."1";
                                                        $fecha_iterar_int = (int)$fecha_iterar_int;                                                                        
                                                        ?>
                                                        <tr>
                                                            <?php 
                                                            $dia_semana = date('N', strtotime($fecha_iterar));
                                                            $dia_semana--;
                                                            if( !in_array($dia_semana,$dias_laborales_horario) ){ // Si es un dia NO laboral, se pueden agregar horas extras en caso que se trabaje                                                                    
                                                            ?>
                                                                
                                                                <td class="no_laboral"><?php echo $fecha_iterar; ?></td>
                                                                <td class="no_laboral">
                                                                    <?php                                                                                     
                                                                    $arr_marcajes = getMarcajeFDS($fecha_iterar, $trabajador['id']);
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
                                                                <td class="no_laboral">&nbsp;</td>
                                                                <td class="no_laboral">
                                                                    <?php                                                                                     
                                                                    $arr_marcajes = getMarcajeFDS($fecha_iterar, $trabajador['id']);                                                                                    
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
                                                                <td class="no_laboral">&nbsp;</td>
                                                                
                                                            <?php } elseif( isDiaFeriado($fecha_iterar) ){ ?> 
                                                                <td class="no_laboral"><?php echo  $fecha_iterar; ?></td>
                                                                <td colspan="4" class="no_laboral">
                                                                                                                                        
                                                                </td>
                                                            <?php } elseif( $es_ausencia ){ ?>
                                                                <td class="ausente es_ausencia"><?php echo $fecha_iterar; ?></td>
                                                                <td class="ausente es_ausencia" colspan="4" style="text-align: left;"><?php echo $ausencia_motivo; ?></td>    
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
                                                                            
                                                                    
                                                                </td>
                                                                <?php    
                                                                }
                                                                ?>                                                                
                                                                
                                                    			    <?php 
                                                                    /** SI llego atrasado, muestra ticket para autorizar **/                                                                    
                                                                    if( in_array($dia_semana,$dias_laborales_horario) ){
                                                                    ?>
                                                                    <td style="width: 350px;" id="td_auth_in_<?php echo $fecha_iterar ?>" class="<?php echo $cls_no_trabaja; ?>">
                                                                    <?php
                                                                        if( $hora_entrada != strtotime( $m_horario_entrada ) ) {                                                                        
                                                                        ?>
                                                                                
                                                                        
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
                                                    			<td class="ausente" colspan="2" id="td_no_marco_entrada_<?php echo $fecha_iterar; ?>"> 
                                                                    <small>Buscando Justificativo <i class="fa fa-refresh fa-spin"></i></small>
                                                                    <input type="checkbox" class="chk_autorize" name="justificativo_no_marco_entrada[<?php echo $fecha_iterar; ?>][justificado]" />
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
                                                                    <td style="width: 350px;" id="td_auth_out_<?php echo $fecha_iterar ?>" class="<?php echo $cls_no_trabaja; ?>">
                                                                    <?php
                                                                        if( $hora_salida != strtotime( $m_horario_salida ) ) {                                                                        
                                                                        ?>
                                                                        
                                                                        
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
                                                            
                                                    			<td class="ausente" colspan="3" id="td_no_marco_salida_<?php echo $fecha_iterar; ?>"> 
                                                                    <small>Buscando Justificativo <i class="fa fa-refresh fa-spin"></i></small>
                                                                    <input type="checkbox" class="chk_autorize" name="justificativo_no_marco_salida[<?php echo $fecha_iterar; ?>][justificado]" />
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
                            <?php } else { ?>
                            
                            <h4 class="box-title"> Trabajador no marca tarjeta </h4>
                            
                            <?php } ?>
                                                                                                    
                        </div>                                                           
                    </div>                                
    
                  </div><!-- /.box -->
                </div>                        
        </div>
    </section>
</div>

<script>
$(document).ready(function(){
    arr_justificativos = new Array();
    <?php foreach( $justificativos as $j ){ ?>
    arr_justificativos[<?php echo $j['id'] ?>] = '<?php echo $j['nombre'] ?>';
    <?php } ?>

    $(".datepicker").datepicker({
        startView : 'year',
        autoclose : true,
        format : 'yyyy-mm-dd'
    });

    $("#btn_revisar_reloj").click(function(){
        inicio = $("#fechaInicioRevision").val();
        fin = $("#fechaFinRevision").val();
        location.href = '<?php echo BASE_URL . '/' . $entity . '/' . $parametros[0]. '/' . $parametros[1] . '/' ?>' + inicio + '/' + fin;
    })


    <?php 

    foreach( $t_atrasohoraextra as $ahe ){
        $ahe['horas'] = procesarDecimal($ahe['horas']);
        if( $ahe['horas'] > 0 ){
            $h_ex_efectiva = ' (' . $ahe['horas'] . ' hrs.)';
        } else {
            $h_ex_efectiva = '';
        }
        
        if( $ahe['logid'] ){            
        ?>
        $("input[name='justificativo[<?php echo $ahe['logid'] ?>][justificado]']").css({ visibility : 'visible' });
        $("input[name='justificativo[<?php echo $ahe['logid'] ?>][justificado]']").prop('checked',true);
        $("input[name='justificativo[<?php echo $ahe['logid'] ?>][justificado]']").next('span').html( '<strong> ' + arr_justificativos[<?php echo $ahe['justificativo_id'] ?>] + '<?php echo $h_ex_efectiva ?> </strong>' );        
    <?php 
        } else { 
            if( $ahe['io'] == 'I' )
                $justificativo_no_marco = 'justificativo_no_marco_entrada';
            else 
                $justificativo_no_marco = 'justificativo_no_marco_salida';
    ?>
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $ahe['fecha'] ?>][justificado]']").css({ visibility : 'visible' });
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $ahe['fecha'] ?>][justificado]']").prop('checked',true);
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $ahe['fecha'] ?>][justificado]']").next('span').html( '<strong> ' + arr_justificativos[<?php echo $ahe['justificativo_id'] ?>] + '<?php echo $h_ex_efectiva ?></strong>' );
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $ahe['fecha'] ?>][justificado]']").closest('tr').find('small').empty();
    
    <?php
        }

        if( $ahe['io'] == 'I' ){
            ?>
            $("#td_no_marco_entrada_<?php echo $ahe['fecha'] ?>").html(arr_justificativos[<?php echo $ahe['justificativo_id'] ?>]);
            $("#td_auth_in_<?php echo $ahe['fecha'] ?>").html(arr_justificativos[<?php echo $ahe['justificativo_id'] ?>]);
            <?php 
        } else {
            ?>
            $("#td_no_marco_salida_<?php echo $ahe['fecha'] ?>").html(arr_justificativos[<?php echo $ahe['justificativo_id'] ?>]);
            $("#td_auth_out_<?php echo $ahe['fecha'] ?>").html(arr_justificativos[<?php echo $ahe['justificativo_id'] ?>]);
            <?php
        }

    } 
    ?>




})
</script>

    