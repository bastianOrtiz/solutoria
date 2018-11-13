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
    <form method="post">
        <input type="hidden" name="action" value="generar_documento">
        <section class="content-header">
            <h1> Gestión de documentos Masivo </h1>
            <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>

            <?php 
            if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
            $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
            ?>
            <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4> <i class="icon fa fa-check"></i> Mensaje:</h4>
                <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
            </div>
            <?php } ?> 
        </section>
                    
        <section class="content">
            
            <div class="tab-pane" id="tab_3">
                  <div class="row">
                        <div class="col-md-12">
                              <!-- general form elements -->
                            <div class="box">
                                
                                <div class="box-body">                        
                                    <div class="col-md-8">
                                        <div class="form-group" style="margin-bottom: 50px">
                                            <label>Seleccione documento</label>
                                            <select class="form-control" name="documento" required>
                                                <option value="">Seleccione</option>
                                                <?php foreach ($documents as $doc) { ?>
                                                <option value="<?php echo $doc['id'] ?>"><?php echo $doc['nombre'] ?></option>
                                                <?php } ?>
                                            </select>
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
                                                        <input type="checkbox" name="trabajadorDocumentoMasivo[<?php echo $trabajador['id'] ?>]" /> 
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
                                    
                                    <div class="col-md-4">
                                        <div class="box-body">
                                            <button type="submit" class="btn btn-primary btn-lg">Generar documentos</button>
                                        </div>                                    
                                    </div> 
                                </div>                                            
                            </div>                      
                        
                        </div>
                    </div>
                </form>
            </div>
            
        </section>
    </form>   
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

$(window).load(function(){
    $("#seleccionTrabajadores_filter").closest('.row').find('.col-sm-6:first').html('<strong>Seleccione trabajadores</strong>');
})

            
</script>
      