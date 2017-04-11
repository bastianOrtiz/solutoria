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
                      <h3 class="box-title"> Informe de impuestos a pagar </h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="frmCrear" method="post" target="_blank">
                    <input type="hidden" name="action" value="impuesto" />
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="tipoTrabajadorImpuesto">Tipo de impuesto a obtener</label>
                                        <select name="tipoTrabajadorImpuesto" id="tipoTrabajadorImpuesto" class="form-control form-control">
                                            <option value="administrativos">Trabajadores Administrativos</option>
                                            <option value="agricolas">Trabajadores Agricolas</option>  
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="checkbox" name="mostrarZero" id="mostrarZero" />
                                        <label for="mostrarZero">Mostrar trabajadores con impuesto 0</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select name="mesImpuesto" id="mesImpuesto" class="form-control sticked">
                                        <?php for( $i=1; $i<=12; $i++ ){ ?>
                                        <option value="<?php echo $i ?>"><?php echo getNombreMes($i) ?></option>
                                        <?php } ?>
                                    </select>                                                          
                                </div>
                                <div class="col-md-4">
                                    <select name="anoImpuesto" id="anoImpuesto" class="form-control sticked">
                                        <?php for( $i=(int)date('Y'); $i>=2015; $i-- ){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Generar Documento</button>
                        </div>
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
      