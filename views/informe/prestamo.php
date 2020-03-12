<!-- Content Wrapper. Contains page content -->    
<style>
.datepicker{
    padding: 10px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow{
    top: 8px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
	line-height: 38px;
	height: 45px;
}
.select2-container--default .select2-selection--single {
	border: 1px solid #d2d6de;
	border-radius: 0;
	height: 45px;
}
</style>    
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> GENERAR INFORME </h1>
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
          <div class="row">
              <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">                
                    <div class="box-header">
                      <h3 class="box-title"> Solicitud de Préstamo </h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="frmCrear" method="post" target="_blank">
                    <input type="hidden" name="action" value="prestamo" />                    
                      <div class="box-body">
                        <div class="row" style="padding: 10px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trabajador</label>                                
                                <select id="trabajador_id" name="anticipoNombreTrabajador" class="form-control required input-lg">
                                    <option> Seleccione Trabajador </option>
                                    <?php foreach( $trabajadores_todos as $t ){ ?>
                                    <option value="<?php echo $t['apellidoPaterno'] ?> <?php echo $t['apellidoMaterno'] ?> <?php echo $t['nombres'] ?> ">
                                    <?php echo $t['apellidoPaterno'] ?> <?php echo $t['apellidoMaterno'] ?> <?php echo $t['nombres'] ?> 
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input name="anticipoFecha" value="<?php echo date('Y-m-d'); ?>" type="text" class="form-control required input-lg datepicker" readonly />
                                </div>                              
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Fecha Otorgamiento</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input name="prestamoOtorgamientoFecha" value="<?php echo date('Y-m-d'); ?>" type="text" class="form-control required input-lg datepicker" readonly />
                                </div>                              
                            </div>
                        </div>
                                                                        
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Monto</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon">$</span>
                                    <input name="anticipoMonto" type="text" class="form-control required">                                    
                                </div>                              
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>A pagar en</label>
                                <div class="input-group input-group-lg">
                                    <input name="cuotasPrestamo" type="text" class="form-control required">
                                    <span class="input-group-addon"><strong>Cuotas</strong></span>                                    
                                </div>                              
                            </div>
                        </div>
                        
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                      </div>
                    </form>
                  </div><!-- /.box -->
    
    
                </div>
          </div>   <!-- /.row -->
        </section>
        
      </div><!-- /.content-wrapper -->
      
<script>

$(document).ready(function(){
    
    $("#trabajador_id").select2();
    
    $(".datepicker").datepicker({
        startView : 'year',
        autoclose : true,
        format : 'yyyy-mm-dd'
    });
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
    $(".required").each(function(){
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
        $("#frmCrear")[0].submit();
        $(".overlayer").hide();
    }

})            
</script>
      