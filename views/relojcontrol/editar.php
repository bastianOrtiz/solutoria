<!-- Content Wrapper. Contains page content -->    
<style>
#tab_5 table th{
    text-align: center;
}
#tab_5 table tbody td{
    text-align: center;
    height: 51px;
}
#btn_delete_ausencia_batch{ 
    margin: 10px; 
    display: none; 
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

.pinit{
    font-size: 18px;    
    margin: 5px;
    display: none;    
}

.pin_comment{
    position: fixed;
    top: 130px;
    left: 50%;
    margin-left: -300px;  
    z-index: 9999;      
}

.pin_comment textarea{
    width: 100%;
	border: 0;
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

<div id="trabajador_detail">
<form role="form" id="frmCrear" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="edit" />
    <input type="hidden" name="idTrabajador" value="<?php echo $trabajador['id'] ?>" />
                          
      <div class="content-wrapper">
        
        <section class="content-header">
        <h1> Editar <?php echo strtolower($entity) ?>: <strong><?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?></strong> </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
          
        <?php         
        if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
        $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
        ?>
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
            <h4><i class="icon fa fa-check"></i> Mensaje:</h4>
        <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "<br />ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
        </section>
                
        <section class="content">
        <div class="overlayer" style="display: block;"><i class="fa fa-refresh fa-spin"></i></div>
            
            <div class="row">
                  <div class="col-md-12">                        
                      <div class="box box-primary">                
                        <div class="box-header">
                          <h3 class="box-title">Ausencias y Atrasos </h3>
                        </div><!-- /.box-header -->
                        
                        <div class="box-body">
                            <?php if( ( empresaUsaRelojControl() ) && ( relojControlSync() ) && ( marcaTarjeta($trabajador['id']) ) ){ ?>
                                <div class="col-md-12" id="relojcontrol_list">                                            
                                    (Datos obtenidos de la base de datos del Reloj Control)
                                    <button type="button" class="btn btn-default pull-right" onclick="location.href='<?php echo BASE_URL . '/' . $entity . '/' . $parametros[0]. '/' . $parametros[1] . '/' ?>'"> <i class="fa fa-chevron-left"></i> &nbsp; Volver</button>
                                    <h4 class="box-title"> Horario del trabajador: de <strong><?php echo $m_horario_entrada ?></strong> a <strong><?php echo $m_horario_salida ?></strong> </h4>
                                    
                                    
                                    <?php 
                                    $trabajador_id = $parametros[1];
                                    if( $parametros[2] && $parametros[3] ){
                                    ?>
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
                                                                    
                                                                    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                                                                   
                                                                    $fecha_iterar = date("Y-m-d", $i);
                                                                    $es_ausencia = comprobarAusencia($fecha_iterar, $trabajador['id']);
                                                                    
                                                                    if( estaFiniquitado($trabajador['id'],$fecha_iterar) ){
                                                                        break;
                                                                    }
                                                                    
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
                                                                            
                                                                            <td class="no_laboral"><?php echo translateDia( date('D', strtotime($fecha_iterar)) ) . ": " . $fecha_iterar; ?></td>
                                                                            <td class="no_laboral" style="text-align: left;">                                                                                                                                             
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
                                                                            <td class="no_laboral">&nbsp;</td>
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
                                                                                <div class="input-group">                                                                                
                                                                                    <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                        <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                                    </span>
                                                                                    <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                        <option value="">Seleccione</option>
                                                                                        <?php foreach( $justificativos_horaextra as $j ){ ?>
                                                                                        <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>                                                                                    
                                                                                    <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][io]" value="I" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_marcada]" value="<?php echo date('H:i:s',$time); ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][comentario]" class="hd_comm_ahe" value="" />
                                                                                    <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                                </div>
                                                                            </td>
                                                                            
                                                                        <?php } elseif( isDiaFeriado($fecha_iterar) ){ ?> 
                                                                            <td class="no_laboral"><?php echo  translateDia( date('D', strtotime($fecha_iterar)) ) . ": " . $fecha_iterar; ?></td>
                                                                            <td class="no_laboral">
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
                                                                            <td class="no_laboral">&nbsp;</td>
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
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                        <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                                    </span>
                                                                                    <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                        <option value="">Seleccione</option>
                                                                                        <?php foreach( $justificativos_horaextra as $j ){ ?>
                                                                                        <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>                                                                                    
                                                                                    <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][io]" value="I" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_marcada]" value="<?php echo date('H:i:s',$time); ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][comentario]" class="hd_comm_ahe" value="" />
                                                                                    <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                                </div>
                                                                            </td>
                                                                        <?php } elseif( $es_ausencia['es_ausencia'] ){ ?>
                                                                            <td class="ausente es_ausencia"><?php echo $fecha_iterar; ?></td>
                                                                            <td class="ausente es_ausencia" colspan="4" style="text-align: left;"><?php echo $es_ausencia['motivo'] ?> </td>    
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
                                                                                <?php echo  translateDia( date('D', strtotime($fecha_iterar)) ) . ": " . $fecha_iterar; ?> 
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
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                        <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                                    </span>
                                                                                    <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                        <option value="">Seleccione</option>
                                                                                        <?php foreach( $justificativos as $j ){ ?>
                                                                                        <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>                                                                                    
                                                                                    <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][io]" value="I" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_marcada]" value="<?php echo $datereg[1]; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][comentario]" class="hd_comm_ahe" value="<?php echo $IN['comentario'] ?>" />
                                                                                    <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                                </div>
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
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                            <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                                        </span>
                                                                                        <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                            <option value="">Seleccione</option>
                                                                                            <?php foreach( $justificativos as $j ){ ?>
                                                                                            <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                            <?php } ?>
                                                                                        </select>                                                                                    
                                                                                        <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][io]" value="I" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_marcada]" value="<?php echo $datereg[1]; ?>" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][comentario]" class="hd_comm_ahe" value="<?php echo $IN['comentario'] ?>" />
                                                                                        <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                                    </div>
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
                                                                        
                                                                			<td class="ausente"> <?php echo  translateDia( date('D', strtotime($fecha_iterar)) ) ?> <?php echo $fecha_iterar ?> </td>
                                                                			<td class="ausente" colspan="2">                                                                            
                                                                                <div class="input-group" title="No marcó">
                                                                                    <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                        <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][justificado]" />
                                                                                    </span>
                                                                                    <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][justificativo]" style="width: 200px; display: none;">
                                                                                        <option value="">Seleccione</option>
                                                                                        <?php foreach( $justificativos as $j ){ ?>
                                                                                        <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>                                                                                    
                                                                                    <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][io]" value="I" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][comentario]" class="hd_comm_ahe" value="" />                                                                                
                                                                                    <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                                </div>
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
                                                                                <td style="width: 350px;" class="<?php echo $cls_no_trabaja; ?>">
                                                                                <?php
                                                                                    if( $hora_salida != strtotime( $m_horario_salida ) ) {                                                                        
                                                                                    ?>
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                            <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][justificado]" />
                                                                                        </span>
                                                                                        <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                            <option value="">Seleccione</option>
                                                                                            <?php foreach( $justificativos as $j ){ ?>
                                                                                            <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                            <?php } ?>
                                                                                        </select>                                                                                    
                                                                                        <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][io]" value="O" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][hora_marcada]" value="<?php echo $datereg[1]; ?>" />
                                                                                        <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][comentario]" class="hd_comm_ahe" value="<?php echo $OUT['comentario'] ?>" />                                                                                    
                                                                                        <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'o' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                                    </div>
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
                                                                        
                                                                			<td class="ausente"> <small><strong>NO MARCÓ</strong></small> </td>
                                                                			<td class="ausente" colspan="2"> 
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                        <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][justificado]" />
                                                                                    </span>
                                                                                    <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][justificativo]" style="width: 200px; display: none;">
                                                                                        <option value="">Seleccione</option>
                                                                                        <?php foreach( $justificativos as $j ){ ?>
                                                                                        <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>                                                                                    
                                                                                    <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][io]" value="O" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][comentario]" class="hd_comm_ahe" value="" />
                                                                                    <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'o' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                                </div>
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
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-sm btn-primary" id="btn_frm_crear"> <i class="fa fa-check-square-o"></i> Guardar Justificaciones</button>
                                        </div>                                            
                                    </div>
                                    <?php } else { ?>
                                    <div class="box box-solid box_datos_reloj">
                                        <div class="box-header">                                                    
                                            <h3 class="box-title"> Seleccione rango de fechas </h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-md-6">
                                                <label for="fechaInicioRevision"> Fecha inicio </label>
                                                <input type="text" class="form-control required datepicker" value="" id="fechaInicioRevision" name="fechaInicioRevision" placeholder="YYYY-mm-dd" readonly="" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="fechaFinRevision">Fecha Fin</label>
                                                <input type="text" class="form-control required datepicker" value="" id="fechaFinRevision" name="fechaFinRevision" placeholder="YYYY-mm-dd" readonly="" />
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-sm btn-primary" id="btn_revisar_reloj"> Revisar </button>
                                            </div>                                                
                                        </div>                                                                                                                            
                                    </div>
                                    
                                    <?php } ?>
                                    
                                    
                                    
                                    <input type="hidden" name="fI" value="<?php echo $fechaInicio; ?>" />
                                    <input type="hidden" name="fF" value="<?php echo $fechaFin; ?>" />
                                    <?php  
                                    /*                                          
                                    show_array($arr_no_IN,0);
                                    show_array($arr_no_OUT,0);
                                    show_array($arr_ausencias,0);
                                    */
                                    ?>
                                    <div class="box box-solid box_datos_reloj">
                                        <div class="box-header">                                                    
                                            <h3 class="box-title"> Ausencias </h3>
                                        </div>
                                        <div class="box-body table-responsive">                                                
                                            <div class="box" id="box_add_ausencias_sync">
                                            	<div class="box-header">
                                            		<h3 class="box-title">
                                            			Ingreso de Días de Ausencias <small>(Con reloj Sync)</small>
                                            		</h3>
                                            	</div>
                                            	<div class="box-body no-padding">
                                                
                                                    <div class="row margin">                                                         
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="fechaAusenciaInicio">Desde</label>
                                                                <input type="text" class="form-control required datepicker" value="" id="fechaAusenciaInicio" name="fechaAusenciaInicio" placeholder="YYYY-mm-dd" readonly="" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="fechaAusenciaFin">Hasta</label>
                                                                <input type="text" class="form-control required datepicker" value="" id="fechaAusenciaFin" name="fechaAusenciaFin" placeholder="YYYY-mm-dd" readonly="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row margin">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="motivoAusencia">Motivo</label>
                                                                <select name="motivoAusencia" id="motivoAusencia" class="required form-control">
                                                                    <option value="">Seleccione</option>
                                                                    <?php foreach( $ausencias as $aus ){ ?>
                                                                    <option value="<?php echo $aus['id'] ?>"><?php echo $aus['nombre'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <br />
                                                                <button type="button" id="add_ausencia_sync" class="btn btn-default btn-sm">Ingresar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="table-responsive">                                                    
                                                        		<table class="table table-striped table-bordered" id="table_ausencias_atrasos">
                                                        			<thead>
                                                                    	<tr>
                                                                            <th> 
                                                                            <?php if( $ausencias_trabajador ){ ?>
                                                                                <input data-toggle="tooltip" title="Seleccionar todas las ausencias" data-placement="right" type="checkbox" id="check_all_ausencias" /> 
                                                                            <?php } ?>
                                                                            </th>                                                                            
                                                        					<th> _Desde </th>
                                                        					<th> Hasta </th>
                                                                            <th> Días </th>
                                                                            <th> Motivo </th>
                                                                            <th> Opc. </th>                                                                
                                                        				</tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                        /** AUSENCIAS SIN INC. LICENCIAS **/
                                                                        if( $ausencias_trabajador ){
                                                                            foreach( $ausencias_trabajador as $at ){ 
                                                                        ?>
                                                                        <tr id="tr_<?php echo $at['id'] ?>">
                                                                            <td> <input type="checkbox" class="check_ausencia" data-id="<?php echo $at['id'] ?>" /> </td>
                                                                            <td> <?php echo $at['fecha_inicio'] ?> </td>
                                                                            <td> <?php echo $at['fecha_fin'] ?> </td>
                                                                            <td>
                                                                                <?php echo $at['dias']; ?>
                                                                                &nbsp; 
                                                                                <i class="fa fa-info-circle info_ausencias" data-toggle="tooltip" title="Se cuenta el total de dias, independiente del corte"></i>
                                                                            </td>
                                                                            <td> 
                                                                                <select class="form-control cbo_justificativo_" id="cbo_justificativo_<?php echo $at['id'] ?>" data-id-ausencia-trabajador="<?php echo $at['id'] ?>">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $ausencias as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <script>$("#cbo_justificativo_<?php echo $at['id'] ?>").val('<?php echo $at['ausencia_id'] ?>');</script>
                                                                            </td>
                                                                            <td> <button data-id="<?php echo $at['id'] ?>" type="button" id="delete_from_list" class="delete_ausencia_trabajador btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>
                                                                        </tr>
                                                                        <?php
                                                                            } 
                                                                        }
                                                                        ?>
                                                                        
                                                                        
                                                                        <?php
                                                                        /** AHORA SE RECORREN LAS LICENCIAS **/ 
                                                                        if( $licencias_trabajador ){
                                                                            foreach( $licencias_trabajador as $lic ){ 
                                                                        ?>
                                                                        <tr id="tr_<?php echo $lic['id'] ?>">
                                                                            <td> <input type="checkbox" class="check_ausencia" data-id="<?php echo $lic['id'] ?>" /> </td>
                                                                            <td> <?php echo $lic['fecha_inicio'] ?> </td>
                                                                            <td> <?php echo $lic['fecha_fin'] ?> </td>
                                                                            <td>
                                                                                <?php echo $lic['dias']; ?>
                                                                                &nbsp; 
                                                                                <i class="fa fa-info-circle info_ausencias" data-toggle="tooltip" title="Se cuenta el total de dias, independiente del corte"></i>
                                                                            </td>
                                                                            <td> 
                                                                                <select class="form-control cbo_justificativo_" id="cbo_justificativo_<?php echo $lic['id'] ?>" data-id-ausencia-trabajador="<?php echo $lic['id'] ?>">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $ausencias as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <script>$("#cbo_justificativo_<?php echo $lic['id'] ?>").val('<?php echo $lic['ausencia_id'] ?>');</script>
                                                                            </td>
                                                                            <td> <button data-id="<?php echo $lic['id'] ?>" type="button" id="delete_from_list" class="delete_ausencia_trabajador btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>
                                                                        </tr>
                                                                        <?php
                                                                            } 
                                                                        }
                                                                        ?>
                                                        			</tbody>
                                                        		</table>
                                                                <button id="btn_delete_ausencia_batch" data-toggle="tooltip" title="Borrar todas las ausencias seleccionadas" class="btn btn-warning btn-sm pull-left" type="button"><i class="fa fa-trash"></i> Borrar Ausencias</button>
                                                            </div>
                                            	</div>
                                            </div>
                                        
                                        </div>                                            
                                    </div>
                                </div>
                                
                                <?php } else { ?>
                                
                                <div class="col-md-12" id="relojcontrol_inputs">
                                    <div class="col-md-6" id="trabajadorMinutos">
                                        <input type="hidden" name="regid_ausencias" id="regid_ausencias" value="<?php echo $trabajador['id']; ?>" />
                                          
                                        <div class="row">
                                            <div class="col-md-6">                                          
                                                <div class="form-group">
                                                  <label for="mesAusenciaAtraso">Mes<br />
                                                  
                                                    <?php                                                        
                                                    $fecha_actual = date('Y-m-j');
                                                    $nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha_actual ) ) ;
                                                    $nombre_nuevafecha = getNombreMes(date ( 'n' , $nuevafecha ));
                                                    $numero_nuevafecha = date ( 'n' , $nuevafecha );
                                                    ?>
                                                  
                                                  </label>
                                                  <select class="form-control required" name="mesAusenciaAtraso" id="mesAusenciaAtraso">
                                                    <option value="<?php echo date('n'); ?>"> <?php echo getNombreMes(date('n')); ?> </option>
                                                    <option value="<?php echo $numero_nuevafecha; ?>"> <?php echo $nombre_nuevafecha; ?> </option>                                                                                    
                                                  </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">                                         
                                                <div class="form-group">
                                                  <label for="anoAusenciaAtraso">Año</label>
                                                  <input type="number" class="form-control required" name="anoAusenciaAtraso" id="anoAusenciaAtraso" value="<?php echo date('Y') ?>" />
                                                </div>
                                            </div> 
                                        </div>
                                        
                                        <div class="row">                                                
                                            <div class="col-md-4">
                                                <div class="form-group">                                                        
                                                  <label for="minutosAtraso">Horas Antrasos</label>
                                                  <input value="<?php echo $minutos_trabajador['hrRetraso'] ?>" type="number" min="0" class="form-control required" name="minutosAtraso" id="minutosAtraso" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label for="minutosExtraNormal">Horas Extra Normal</label>
                                                  <input value="<?php echo $minutos_trabajador['hrExtra'] ?>" type="number" min="0" class="form-control required" name="minutosExtraNormal" id="minutosExtraNormal" value="" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">                                         
                                                <div class="form-group">
                                                  <label for="minutosExtraFestivo">Horas Extra Festivo</label>
                                                  <input value="<?php echo $minutos_trabajador['hrExtraFestivo'] ?>" type="number" min="0" class="form-control required" name="minutosExtraFestivo" id="minutosExtraFestivo" value="" />
                                                </div>
                                            </div> 
                                        </div>
                                        
                                        <div class="row"> 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <button type="button" id="add_minutos" class="btn btn-default btn-sm">Guardar</button>
                                                </div>
                                            </div>
                                        </div>                      
                                    </div>
                                
                                    <div class="col-md-6" id="trabajadorAusencias">
                                        <input type="hidden" name="regid_ausencias" id="regid_ausencias" value="<?php echo $trabajador['id']; ?>" />
                                        
                                        <div class="box">
                                        	<div class="box-header">
                                        		<h3 class="box-title">
                                        			Ingreso de Días de Ausencias 
                                        		</h3>
                                        	</div>
                                        	<div class="box-body no-padding">
                                            
                                                <div class="row margin">                                                         
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="fechaAusenciaInicio">Desde</label>
                                                            <input type="text" class="form-control required datepicker" value="" id="fechaAusenciaInicio" name="fechaAusenciaInicio" placeholder="YYYY-mm-dd" readonly="" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="fechaAusenciaFin">Hasta</label>
                                                            <input type="text" class="form-control required datepicker" value="" id="fechaAusenciaFin" name="fechaAusenciaFin" placeholder="YYYY-mm-dd" readonly="" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row margin">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="motivoAusencia">Motivo</label>
                                                            <select name="motivoAusencia" id="motivoAusencia" class="required form-control">
                                                                <option value="">Seleccione</option>
                                                                <?php foreach( $ausencias as $aus ){ ?>
                                                                <option value="<?php echo $aus['id'] ?>"><?php echo $aus['nombre'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <br />
                                                            <button type="button" id="add_ausencia" class="btn btn-default btn-sm">Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="table-responsive">                                                    
                                            		<table class="table table-striped table-bordered" id="table_ausencias_atrasos">
                                            			<thead>
                                                        	<tr>
                                            					<th> Desde </th>
                                            					<th> Hasta </th>
                                                                <th> Días </th>
                                                                <th> Motivo </th>
                                                                <th> Opc. </th>                                                                
                                            				</tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            if( $ausencias_trabajador ){
                                                                foreach( $ausencias_trabajador as $at ){ 
                                                            ?>
                                                            <tr id="tr_<?php echo $at['id'] ?>">
                                                                <td> <?php echo $at['fecha_inicio'] ?> </td>
                                                                <td> <?php echo $at['fecha_fin'] ?> </td>
                                                                <td>
                                                                <?php 
                                                                $datetime1 = date_create($at['fecha_inicio']);
                                                                $datetime2 = date_create($at['fecha_fin']);
                                                                $interval = date_diff($datetime1, $datetime2);
                                                                $days_diff = $interval->format('%a');
                                                                $days_diff++;
                                                                echo $days_diff;
                                                                ?>
                                                                </td>
                                                                <td> <?php echo fnGetNombre($at['ausencia_id'],'m_ausencia', false) ?> </td>
                                                                <td> <button class="delete_ausencia_trabajador" data-id="<?php echo $at['id'] ?>" type="button" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>
                                                            </tr>
                                                            <?php
                                                                } 
                                                            }
                                                            ?>
                                            			</tbody>
                                            		</table>
                                                </div>                                                                                                                                                                        
                                        	</div>
                                        </div>
                                                                                                                        
                                    </div>
                                </div>                                        
                                <?php } ?>
                            </div>                                                                                                            
                                                                                       
                        </div>                                
    
                    </div><!-- /.box -->
                </div>
                
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="btn_frm_crear">Guardar Datos Relojcontrol</button>                            
                </div>            

        </section>
        
      </div><!-- /.content-wrapper -->
</form>

</div>    
<script>

$(document).ready(function(){
    $("#btn_revisar_reloj").click(function(){
        inicio = $("#fechaInicioRevision").val();
        fin = $("#fechaFinRevision").val();
        location.href = '<?php echo BASE_URL . '/' . $entity . '/' . $parametros[0]. '/' . $parametros[1] . '/' ?>' + inicio + '/' + fin;
    })
    
    $(document).on('click','#btn_delete_ausencia_batch', function(e){
        e.preventDefault();
        var array_id = '';            
        $(".check_ausencia:checked").each(function(){
             array_id += $(this).data('id') + ',';
        });        
        
        var conf = confirm('¿Eliminar los registros seleccionados?');        
        if( conf ){
            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: "ids="+array_id+"&action=delete_ausencia_trabajador_batch",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     //if( json.status == 'OK' ){
    			         //window.location.reload();
                         $("#frmCrear")[0].submit();
    			     //}
                }
    		})
        }
    })
    
    $("#check_all_ausencias, .check_ausencia").click(function(){
        if( $(".check_ausencia:checked").length > 0 ){
            $("#btn_delete_ausencia_batch").show();
        } else {
            $("#btn_delete_ausencia_batch").hide();
        }
    })
    
    $("#check_all_ausencias").click(function(){
        if( $(this).prop('checked') == true ){
            $(".check_ausencia").prop('checked',true);
            $("#btn_delete_ausencia_batch").show();
        } else {
            $(".check_ausencia").prop('checked',false);
            $("#btn_delete_ausencia_batch").hide();
        }
    })
    
    $(".he_efectiva").blur(function(){
        val = $(this).val();
        val = val.toLowerCase();
        if( ( val.charAt(0) == 'm' ) || ( val.charAt(0) == 'M' ) ){
            arr_val = val.split("m");
            int_minutos = arr_val[1];
            en_horas = ( int_minutos / 60 );
            en_horas = (Math.round( en_horas * 100) / 100);
            
            $(this).val( en_horas );
        }
    })
    



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
        
        if( $ahe['io'] == 'I' )
            $justificativo_no_marco = 'justificativo';
        else 
            $justificativo_no_marco = 'justificativo';
    ?>
    
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").prop('checked',true);
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][hora_extra_efectiva]']").val('<?php echo $ahe['horas'] ?>');
        $("select[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificativo]']").val('<?php echo $ahe['justificativo_id'] ?>');
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.form-control').show();
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.pinit').show();
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.pinit').attr('data-toggle','tooltip');
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.pinit').attr('title','<?php echo $ahe['comentario'] ?>');
        $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][comentario]']").val('<?php echo $ahe['comentario'] ?>');        
    
    <?php
    } 
    ?>
    
    pinit_clicked = false;
    $(".pinit").click(function(e){
        pinit_clicked = $(this);
        logid = $(this).data('logid');
        val = $(this).data('original-title');        
        e.preventDefault();
        
        html = '<div class="modal-dialog pin_comment">';
        html += '    <div class="modal-content">';
        html += '      <div class="modal-header">';
        html += '        <button type="button" class="close closeModal" aria-label="Close"><span aria-hidden="true">×</span></button>';
        html += '        <h4 class="modal-title">Agregar comentario a la justificación</h4>';
        html += '      </div>';
        html += '      <div class="modal-body">';
        html += '        <input type="text" value="'+val+'" placeholder="Ingrese comentario..." class="form-control" id="ahe_comment" maxlength="100" />';
        html += '      </div>';
        html += '      <div class="modal-footer">';
        html += '        <button type="button" class="btn btn-default pull-left closeModal">Cerrar</button>';
        html += '        <button type="button" data-logid="'+logid+'" class="btn btn-primary" id="save_ahe_comment">Guardar</button>';
        html += '      </div>';
        html += '    </div>';
        html += '  </div>';
        
        $(".overlayer:first").css('opacity','0.9').show();
        $("body").append( html );
    })
    
    $(document).on('click', '.closeModal', function(){
        $(".overlayer:first").hide();
        $(".pin_comment").remove();
    })
    
    $(document).on('click', '#save_ahe_comment', function(){
        logid = $(this).data('logid');
        comment = $(this).closest('.pin_comment').find("#ahe_comment").val();
        
        $.ajax({
			type: "POST",
			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
			data: "logid="+logid+"&comment="+comment+"&trabajador_id=<?php echo $trabajador_id ?>&action=add_ahe_comment",
            dataType: 'json',
            beforeSend: function(){                
            },
			success: function (json) {
                pinit_clicked.attr('data-toggle','tooltip');
                pinit_clicked.attr('data-original-title',comment);
                pinit_clicked.closest('.input-group').find('.hd_comm_ahe').val(comment);
                $(".overlayer:first").hide();
                $(".pin_comment").remove();                
                //$("#frmCrear")[0].submit();
            }
		})
    })
    
    
    
    $(document).on('click','.delete_ausencia_trabajador', function(){
        var conf = confirm('¿Quitar el registro seleccionado?');        
        if( conf ){            
            var id = $(this).data('id');
            var element_id = $(this).attr('id');
            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: "id="+id+"&action=delete_ausencia_trabajador",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     if( json.status == 'OK' ){
    			         $("#table_ausencias_atrasos tr#tr_" + json.id).fadeOut(300);                                                  
    			         $(".overlayer").hide();
    			     }
                     if( element_id == 'delete_from_list' ){
                        window.location.reload();
                     }
                }
    		})        
        }
    })
            
                    
    
    $("input").keydown(function(){
        $(this).parent().removeClass('has-error');
        $(this).parent().find('label').find('small').remove();
    })
    $("select").change(function(){
        $(this).parent().removeClass('has-error');
        $(this).parent().find('label').find('small').remove();
    })
    
    $("#frmCrear").submit(function(e){
        e.preventDefault();
        error = 0;
        found_first_empty = 0;
        $("#table_reloj_control .required").each(function(){
            if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
                if( found_first_empty == 0 ){
                    tab_id = $(this).closest('.tab-pane').attr('id');
                    $(".nav-tabs a[href='#"+tab_id+"']").click();
                    found_first_empty = 1;
                }
                
                if( !$(this).parent().hasClass('has-error') ){
                    $(this).parent().addClass('has-error');
                    $(this).parent().find('label').append(' <small>(Este campo es requerido)</small>');
                }
                error++;
            }
        })
        
        if( error == 0 ){
            $(".overlayer").show();
            $("#frmCrear")[0].submit();
        } else {
            $("#frmCrear #btn_frm_crear").attr('data-toggle','tooltip');
            $("#frmCrear #btn_frm_crear").attr('data-original-title','Tiene campos requeridos sin completar');
            $("#frmCrear #btn_frm_crear").tooltip('show')                       
        }
    
    }) 


    
    $("#add_minutos").click(function(e){
        e.preventDefault();
        err=0;
        $("#trabajadorMinutos .required").each(function(){
            if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
                $(this).parent().addClass('has-error');                
                err++;
            } else {
                $(this).parent().removeClass('has-error');                
            }
        })
        
        if( err == 0 ){
            var dat = '';
            $('#trabajadorMinutos input, #trabajadorMinutos select').each(function(){
                dat += $(this).attr('id') + "=" + $(this).val() + "&";
            });

            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: dat + "action=add_minutos",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     if( json.status == 'OK' ){
    			         $("#minutosAtraso").val(json.minutosAtraso);
                         $("#minutosExtraNormal").val(json.minutosExtraNormal);
                         $("#minutosExtraFestivo").val(json.minutosExtraFestivo);                     
    			         $(".overlayer").hide();    
    			     }
                }
    		})
        }                
    })
    
    $("#add_ausencia").click(function(e){
        e.preventDefault();
        err=0;
        $("#trabajadorAusencias .required").each(function(){
            if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
                $(this).parent().addClass('has-error');                
                err++;
            } else {
                $(this).parent().removeClass('has-error');                
            }
        })
        
        if( err == 0 ){
            var dat = '';
            $('#trabajadorAusencias input, #trabajadorAusencias select').each(function(){
                dat += $(this).attr('id') + "=" + $(this).val() + "&";
            });

            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: dat + "action=add_ausencia",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     if( json.status == 'OK' ){
    			         row = '';
    			         $.each(json.registro, function(k,v){
    			             row += '<td>'+v+'</td>';
    			         })        
                         row += '<br /><td> <button class="delete_ausencia_trabajador" data-id="'+json.tr_id+'" type="button" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>';
                         $("#table_ausencias_atrasos tbody").prepend('<tr id="tr_'+json.tr_id+'">'+row+'</tr>');
    			         $(".overlayer").hide();    
    			     }
                }
    		})
        }                
    })
    
    
    
    $("#add_ausencia_sync").click(function(e){
        e.preventDefault();        
        err=0;
        $("#box_add_ausencias_sync .required").each(function(){
            if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
                $(this).parent().addClass('has-error');                
                err++;
            } else {
                $(this).parent().removeClass('has-error');                
            }
        })
        
        if( err == 0 ){
            var dat = '';
            $('#box_add_ausencias_sync input, #box_add_ausencias_sync select').each(function(){
                dat += $(this).attr('id') + "=" + $(this).val() + "&";
            });
            dat += 'regid_ausencias=<?php echo $trabajador['id'] ?>&';
            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: dat + "action=check_ausencia_reloj",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     if( json.exist == 'TRUE' ){
    			         if( confirm('Existen registros en el reloj control que coinciden con la Ausencia ingresada\n\nEste registro sera borrado del reloj control\n\n¿Proceder?') ){
                            var dat = '';
                            $('#box_add_ausencias_sync input, #box_add_ausencias_sync select').each(function(){
                                dat += $(this).attr('id') + "=" + $(this).val() + "&";
                            });
                            dat += 'regid_ausencias=<?php echo $trabajador['id'] ?>&';
                             $.ajax({
                    			type: "POST",
                    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                    			data: dat + "action=add_ausencia",
                                dataType: 'json',
                                beforeSend: function(){
                                    $(".overlayer").show();
                                },
                    			success: function (json) {
                    			     window.location.reload();                                     
                                }
                    		})
    			         } else {
    			             $(".overlayer").hide();   
    			         }
    			     } else {
                        var dat = '';
                        $('#box_add_ausencias_sync input, #box_add_ausencias_sync select').each(function(){
                            dat += $(this).attr('id') + "=" + $(this).val() + "&";
                        });
                        dat += 'regid_ausencias=<?php echo $trabajador['id'] ?>&';
    			         $.ajax({
                			type: "POST",
                			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                			data: dat + "action=add_ausencia",
                            dataType: 'json',
                            beforeSend: function(){
                                $(".overlayer").show();
                            },
                			success: function (json) {
                			     window.location.reload();                                 
                            }
                		})
    			     }
                }
    		})
        }                
    })                    
    
    
    if( window.location.hash.length > 0 ){
        hash = window.location.hash;
        hash = hash.replace("#","");
        $(".nav-tabs a[href=#" + hash + "]").click();
    }
    
    $(".input_file input").change(function(){
        $(this).parent().find('span').text( $(this).val() );
    })
    
    $(".datepicker").datepicker({
        startView : 'year',
        autoclose : true,
        format : 'yyyy-mm-dd'
    });
    
    
    <?php if( $parametros[4] == 'OK' ){ ?>
    alert("Datos guardados correctamente");
    <?php } ?>
})


$(window).load(function(){
    $(".overlayer").fadeOut('fast');
})
         
</script>
      