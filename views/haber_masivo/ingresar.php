<!-- Content Wrapper. Contains page content -->    
<style>
.checkbox{
    margin-left: 50px;
    display: none;
}

.checkbox.parent{
    margin-left: 0;
    display: block;
}
#seleccionTrabajadores label{
    font-weight: normal;
    cursor: pointer;
}

</style>    
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> INGRESAR HABERES / DESCUENTOS MASIVAMENTE </h1>
          <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
          
            <?php 
            if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
            $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
            ?>
            <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4>	<i class="icon fa fa-check"></i> Mensaje:</h4>
                <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
            </div>
            <?php } ?> 
        </section>
                
    <section class="content">
        <ul class="nav nav-tabs">
          <li class="active"><a  onclick="javascript: window.location.hash = '#tab_1'" href="#tab_1" data-toggle="tab">Haberes</a></li>
          <li><a href="#tab_2" onclick="javascript: window.location.hash = '#tab_2'" data-toggle="tab">Descuentos</a></li>
          <li><a href="#tab_3" onclick="javascript: window.location.hash = '#tab_3'" data-toggle="tab">Anticipos</a></li>
        </ul>
        
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">          
            <form role="form" id="frmCrearHaber" method="post">
                    
              <div class="row">
                  <div class="col-md-12">
                      <!-- general form elements -->
                      <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Haberes </h3>
                        </div>
                        
                        <div class="box-body" id="form_haber_trabajador">
                            <div class="col-md-6">                                                  
                                <div class="row">
                                    <div class="col-md-6">                                          
                                        <div class="form-group">
                                          <label for="mesHaberTrabajador">Mes</label>
                                          <select class="form-control required" name="mesHaberTrabajador" id="mesHaberTrabajador">
                                            <?php for( $i=1; $i<=12; $i++ ){ ?>
                                            <option value="<?php echo $i; ?>" <?php echo (date('n')==$i) ? ' selected ' : ''; ?> > <?php echo getNombreMes($i); ?> </option>
                                            <?php } ?>                            
                                          </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">                                         
                                        <div class="form-group">
                                          <label for="anoHaberTrabajador">Año</label>
                                          <input type="number" class="form-control required" name="anoHaberTrabajador" id="anoHaberTrabajador" value="<?php echo date('Y') ?>" />
                                        </div>
                                    </div> 
                                </div>
                                                                                    
                                
                                <div class="row">
                                    <div class="col-md-12">                                         
                                        <div class="form-group">
                                          <label for="haberTrabajador">Haber</label>
                                          <select  class="form-control required" name="haberTrabajador" id="haberTrabajador">
                                            <option value="">Seleccione</option>
                                            <?php foreach( $haberes as $hab ){ ?>
                                            <option data-fijo="<?php echo $hab['fijo'] ?>" data-predet="<?php echo $hab['valorPredeterminado'] ?>" data-valor="<?php echo ($hab['valorPredeterminado']==1) ? $hab['valor'] : '' ?>"  data-tipo_moneda="<?php echo ($hab['valorPredeterminado']==1) ? $hab['tipomoneda_id'] : '' ?>" value="<?php echo $hab['id'] ?>"><?php echo $hab['nombre'] ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">                                         
                                        <div class="form-group">
                                          <label for="glosaHaberTrabajador">Glosa adicional</label>
                                          <textarea class="form-control" name="glosaHaberTrabajador" id="glosaHaberTrabajador"></textarea>                                                                
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row collapse" id="haber_cuotas">
                                    <div class="col-md-6">                                         
                                        <div class="form-group">
                                          <label for="cuotaActualHaberTrabajador">Cuota Actual</label>
                                          <input type="number" class="form-control" name="cuotaActualHaberTrabajador" id="cuotaActualHaberTrabajador" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">                                          
                                        <div class="form-group">
                                          <label for="totalCuotasHaberTrabajador">Total de Cuotas</label>
                                          <input type="number" class="form-control" name="totalCuotasHaberTrabajador" id="totalCuotasHaberTrabajador" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">                                          
                                        <div class="form-group">
                                          <label for="valorHaberTrabajador">Valor</label>
                                          <input type="number" class="form-control required" name="valorHaberTrabajador" id="valorHaberTrabajador" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="tipoMonedaHaber">Tipo Moneda</label>
                                          <select class="form-control required" name="tipoMonedaHaber" id="tipoMonedaHaber">
                                            <option value="">Seleccione...</option>
                                            <?php foreach($tipomoneda as $t){ ?>
                                            <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>Seleccione Trabajadores</label>                              
                                </div>
                                
                                <div class="input-group">
                                    <?php
                                    $depa = 0;                            
                                    foreach( $trabajdores as $trabajador ){ 
                                    if( $trabajador['departamento_id'] == $depa ){
                                    ?>
                                    <div class="checkbox hijos_<?php echo $trabajador['departamento_id'] ?>">
                                      <label>
                                        <input type="checkbox" name="trabajadorCargamasiva[<?php echo $trabajador['id'] ?>]"> <?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?>
                                      </label>
                                    </div>
                                    <?php } else { ?>
                                    <div class="checkbox parent">
                                      <label>
                                        <input type="checkbox" name="chkParent" rel="<?php echo $trabajador['departamento_id'] ?>" /> <?php echo fnGetNombre($trabajador['departamento_id'],'m_departamento') ?>
                                      </label>
                                    </div>
                                    <div class="checkbox hijos_<?php echo $trabajador['departamento_id'] ?>">
                                      <label>
                                        <input type="checkbox" name="trabajadorCargamasiva[<?php echo $trabajador['id'] ?>]"> <?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?>
                                      </label>
                                    </div>
                                    <?php 
                                        $depa = $trabajador['departamento_id'];
                                        }
                                    } 
                                    ?>
                                                                                                                                        
                                </div>
                                                           
                            </div>
                                                                            
                        </div>
                                            
                    </div><!-- /.box -->
                      
                        <div class="box-footer">
                            <button type="submit" name="action" value="new_haber" class="btn btn-primary">Agregar Haber</button>
                        </div>
                    </div>
              </div>
            </form>
        </div>
        
        <div class="tab-pane" id="tab_2">
            <form role="form" id="frmCrearDescuento" method="post">                    
              <div class="row">
                  <div class="col-md-12">
                      <!-- general form elements -->
                      <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Descuento </h3>
                        </div>
                        
                        <div class="box-body" id="form_descuento_trabajador">
                            <div class="col-md-6">                                                  
                                <div class="row">
                                    <div class="col-md-6">                                          
                                        <div class="form-group">
                                          <label for="mesDescuentoTrabajador">Mes</label>
                                          <select class="form-control required" name="mesDescuentoTrabajador" id="mesDescuentoTrabajador">
                                            <?php for( $i=1; $i<=12; $i++ ){ ?>
                                            <option value="<?php echo $i; ?>" <?php echo (date('n')==$i) ? ' selected ' : ''; ?> > <?php echo getNombreMes($i); ?> </option>
                                            <?php } ?>                            
                                          </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">                                         
                                        <div class="form-group">
                                          <label for="anoDescuentoTrabajador">Año</label>
                                          <input type="number" class="form-control required" name="anoDescuentoTrabajador" id="anoDescuentoTrabajador" value="<?php echo date('Y') ?>" />
                                        </div>
                                    </div> 
                                </div>
                                                                                    
                                
                                <div class="row">
                                    <div class="col-md-12">                                         
                                        <div class="form-group">
                                          <label for="descuentoTrabajador">Descuento</label>
                                          <select  class="form-control required" name="descuentoTrabajador" id="descuentoTrabajador">
                                            <option value="">Seleccione</option>
                                            <?php foreach( $descuentos as $hab ){ ?>
                                            <option data-fijo="<?php echo $hab['fijo'] ?>" data-predet="<?php echo $hab['valorPredeterminado'] ?>" data-valor="<?php echo ($hab['valorPredeterminado']==1) ? $hab['valor'] : '' ?>"  data-tipo_moneda="<?php echo ($hab['valorPredeterminado']==1) ? $hab['tipomoneda_id'] : '' ?>" value="<?php echo $hab['id'] ?>"><?php echo $hab['nombre'] ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">                                         
                                        <div class="form-group">
                                          <label for="glosaDescuentoTrabajador">Glosa adicional</label>
                                          <textarea class="form-control" name="glosaDescuentoTrabajador" id="glosaDescuentoTrabajador"></textarea>                                                                
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row collapse" id="descuento_cuotas">
                                    <div class="col-md-6">                                         
                                        <div class="form-group">
                                          <label for="cuotaActualDescuentoTrabajador">Cuota Actual</label>
                                          <input type="number" class="form-control" name="cuotaActualDescuentoTrabajador" id="cuotaActualDescuentoTrabajador" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">                                          
                                        <div class="form-group">
                                          <label for="totalCuotasDescuentoTrabajador">Total de Cuotas</label>
                                          <input type="number" class="form-control" name="totalCuotasDescuentoTrabajador" id="totalCuotasDescuentoTrabajador" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">                                          
                                        <div class="form-group">
                                          <label for="valorDescuentoTrabajador">Valor</label>
                                          <input type="number" class="form-control required" name="valorDescuentoTrabajador" id="valorDescuentoTrabajador" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="tipoMonedaDescuento">Tipo Moneda</label>
                                          <select class="form-control required" name="tipoMonedaDescuento" id="tipoMonedaDescuento">
                                            <option value="">Seleccione...</option>
                                            <?php foreach($tipomoneda as $t){ ?>
                                            <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                            <?php } ?>
                                          </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label>Seleccione Trabajadores</label>                              
                                </div>
                                
                                <div class="input-group">
                                    <?php
                                    $depa = 0;
                                    foreach( $trabajdores as $trabajador ){ 
                                    if( $trabajador['departamento_id'] == $depa ){
                                    ?>
                                    <div class="checkbox hijos_<?php echo $trabajador['departamento_id'] ?>">
                                      <label>
                                        <input type="checkbox" name="trabajadorCargamasiva[<?php echo $trabajador['id'] ?>]"> <?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?>
                                      </label>
                                    </div>
                                    <?php } else { ?>
                                    <div class="checkbox parent">
                                      <label>
                                        <input type="checkbox" name="chkParent" rel="<?php echo $trabajador['departamento_id'] ?>" /> <?php echo fnGetNombre($trabajador['departamento_id'],'m_departamento') ?>
                                      </label>
                                    </div>
                                    <div class="checkbox hijos_<?php echo $trabajador['departamento_id'] ?>">
                                      <label>
                                        <input type="checkbox" name="trabajadorCargamasiva[<?php echo $trabajador['id'] ?>]"> <?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?>
                                      </label>
                                    </div>
                                    <?php 
                                        $depa = $trabajador['departamento_id'];
                                        }
                                    } 
                                    ?>
                                                                                                                                        
                                </div>
                                                           
                            </div>
                                                                            
                        </div>
                                            
                    </div><!-- /.box -->
                      
                        <div class="box-footer">
                            <button type="submit" name="action" value="new_descuento" class="btn btn-primary">Agregar Descuento</button>
                        </div>
                    </div>
              </div>
            </form>
        </div>
        
        
        <div class="tab-pane" id="tab_3">
            <form role="form" id="frmCrearAnticipo" method="post">
                <input type="hidden" name="action" value="new_anticipo" />                    
              <div class="row">
                    <div class="col-md-12">
                          <!-- general form elements -->
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"> Anticipos Masivo </h3>
                            </div>
                            
                            <div class="box-body">                        
                                <div class="col-md-6">
                                    
                                    <div class="form-group">
                                      <label>Seleccione Trabajadores</label>                              
                                    </div>                                                              
                                    <table id="seleccionTrabajadores" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nombre Trabajador</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            foreach( $trabajdores_todos as $trabajador ){ 
                                            $nombre_completo = $trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno'].' '.$trabajador['nombres'];
                                            ?>
                                            <tr>
                                                <td>
                                                  <label>
                                                    <input type="checkbox" name="trabajadorAnticipoMasivo[<?php echo $trabajador['id'] ?>]" /> 
                                                    <span style="text-transform: uppercase;">
                                                        <?php echo $nombre_completo; ?> <span style="font-size: 12px;">(<?php echo getNombre($trabajador['departamento_id'],'m_departamento',0); ?>)</span>
                                                    </span>
                                                  </label>
                                              </td>
                                            </tr>
                                            <?php } ?>                                                                                                                                        
                                        </tbody>
                                        <tfoot>
                                          <tr>                                                                                        
                                            <th>Nombre Trabajador</th>
                                          </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                
                                <div class="col-md-5">
                                    <div class="box-header">
                                        <h3 class="box-title"> Monto del Anticipo </h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                            <input type="text" class="form-control required" name="montoAnticipoMasivo" id="montoAnticipoMasivo" />
                                            <span class="input-group-btn">
                                              <button type="button" class="btn btn-primary btn-flat btnIngresarAnticipo">Ingresar</button>
                                            </span>
                                          </div>
                                          
                                          <br /><br />
                                          <p style="font-size: 18px;">( Correspondiente a <strong><?php echo getNombreMes(getMesMostrarCorte()) ?></strong> de <strong><?php echo getAnoMostrarCorte() ?></strong> )</p>                                          
                                    </div>                                    
                                </div> 
                            </div>                                            
                        </div>                      
                    
                    </div>
                </div>
            </form>
        </div>
        
    </section>
        
</div><!-- /.content-wrapper -->
      
<script>

$("input").keydown(function(){
    $(this).parent().removeClass('has-error');
    $(this).parent().find('label').find('small').remove();
})
$("select").change(function(){
    $(this).parent().removeClass('has-error');
    $(this).parent().find('label').find('small').remove();
})

$("#frmCrearHaber").submit(function(e){
    e.preventDefault();
    error = 0;
    $("#frmCrearHaber .required").each(function(){
        if( $(this).val() == "" ){
            if( !$(this).parent().hasClass('has-error') ){
                $(this).parent().addClass('has-error');
                $(this).parent().find('label').append(' <small>(Este campo es requerido)</small>');
            }
            error++;
        }
    })    
    if( error == 0 ){
        $(".overlayer").show();
        $("#frmCrearHaber")[0].submit();
    }
})

$("#frmCrearDescuento").submit(function(e){
    e.preventDefault();
    error = 0;
    $("#frmCrearDescuento .required").each(function(){
        if( $(this).val() == "" ){
            if( !$(this).parent().hasClass('has-error') ){
                $(this).parent().addClass('has-error');
                $(this).parent().find('label').append(' <small>(Este campo es requerido)</small>');
            }
            error++;
        }
    })    
    if( error == 0 ){
        $(".overlayer").show();
        $("#frmCrearDescuento")[0].submit();
    }
})

$(".checkbox.parent input[type=checkbox]").click(function(){
    var rel = $(this).attr('rel');
    if( $(this).prop('checked') == true ){
        $(".checkbox.hijos_" + rel).slideDown();
        $(".checkbox.hijos_" + rel + " input[type=checkbox]").prop('checked',true);
    } else {
        $(".checkbox.hijos_" + rel).slideUp();
        $(".checkbox.hijos_" + rel + " input[type=checkbox]").prop('checked',false);
    }
})
       
$("#haberTrabajador").change(function(){
    var opt_data =  $('option:selected', this).data() ;        
    if( ( opt_data.fijo == 1 ) || ( $(this).val() == "" ) ){
        $("#haber_cuotas").slideUp(200);
        $("#cuotaActualHaberTrabajador").removeClass('required');
        $("#totalCuotasHaberTrabajador").removeClass('required');
    } else {
        $("#haber_cuotas").slideDown(200);
        $("#cuotaActualHaberTrabajador").addClass('required');
        $("#totalCuotasHaberTrabajador").addClass('required');
    }
    
    if( opt_data.predet == 1 ){
        $("#valorHaberTrabajador").val( opt_data.valor );
        $("#tipoMonedaHaber").val( opt_data.tipo_moneda )
    } else {
        $("#valorHaberTrabajador").val('');
        $("#tipoMonedaHaber").val('');
    }
})

       
$("#descuentoTrabajador").change(function(){
    var opt_data =  $('option:selected', this).data() ;
    console.log( opt_data );        
    if( ( opt_data.fijo == 1 ) || ( $(this).val() == "" ) ){
        $("#descuento_cuotas").slideUp(200);
        $("#cuotaActualDescuentoTrabajador").removeClass('required');
        $("#totalCuotasDescuentoTrabajador").removeClass('required');
    } else {
        $("#descuento_cuotas").slideDown(200);
        $("#cuotaActualDescuentoTrabajador").addClass('required');
        $("#totalCuotasDescuentoTrabajador").addClass('required');
    }
    
    if( opt_data.predet == 1 ){
        $("#valorDescuentoTrabajador").val( opt_data.valor );
        $("#tipoMonedaDescuento").val( opt_data.tipo_moneda )
    } else {
        $("#valorDescuentoTrabajador").val('');
        $("#tipoMonedaDescuento").val('');
    }
})       

$(document).ready(function(){
    
    $(".btnIngresarAnticipo").click(function(){
        if( ( $("#montoAnticipoMasivo").val() == "" ) || ( isNaN($("#montoAnticipoMasivo").val()) ) ){
            alert("Debe ingresar un valor numerico en el monto");
            return false;
        } else {
            oTable.fnFilter('');
            $("#frmCrearAnticipo")[0].submit();    
        }
    })
    
    $(function () {        
        oTable = $('#seleccionTrabajadores').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": false,
            "bInfo": false,
            "bAutoWidth": false,
            "pageLength": 999
        });
    });  
    
    if( window.location.hash.length > 0 ){
        hash = window.location.hash;
        hash = hash.replace("#","");
        $(".nav-tabs a[href=#" + hash + "]").click();
    }
})

            
</script>
      