<!-- Content Wrapper. Contains page content -->    
 <style>
.input-group{
    margin: 5px auto;
}
</style>    
      <div class="content-wrapper">
        
        <section class="content-header">
        <h1> Editar <?php echo strtolower($entity) ?> </h1>
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
          <div class="row">
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">                
                <div class="box-header">
                  <h3 class="box-title">Datos del Registro</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frmCrear" method="post">
                    <input type="hidden" name="semanacorrida_id" value="<?php echo $semanacorrida['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                      <div class="box-body">
                        <div class="form-group">
                          <label for="mesSemanacorrida">Mes</label>
                          <select class="form-control required" name="mesSemanacorrida" id="mesSemanacorrida">
                            <?php for( $i=1; $i<=12; $i++ ){ ?>
                            <option value="<?php echo $i; ?>"> <?php echo getNombreMes($i); ?> </option>
                            <?php } ?>                            
                          </select>
                          <script> $("#mesSemanacorrida").val('<?php echo $semanacorrida['mes'] ?>') </script>
                        </div>
                        
                        <div class="form-group">
                          <label for="anoSemanacorrida">Año</label>
                          <input value="<?php echo $semanacorrida['ano'] ?>" type="text" class="form-control required" name="anoSemanacorrida" id="anoSemanacorrida" />
                        </div>
                        
                        <div class="form-group">
                          <label for="diasHabilesSemanacorrida">Días Hábiles</label>
                          <input value="<?php echo $semanacorrida['diasHabiles'] ?>" type="text" class="form-control required" name="diasHabilesSemanacorrida" id="diasHabilesSemanacorrida" />
                        </div>
                        
                        <div class="form-group">
                          <label for="festivosSemanacorrida">Domingos y Festivos</label>
                          <input value="<?php echo $semanacorrida['domingosFestivos'] ?>" type="text" class="form-control required" name="festivosSemanacorrida" id="festivosSemanacorrida" />
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
  $("#frmCrear").submit(function(e){
    e.preventDefault();
    var error = 0;
    $(".required").each(function(){
        if( $(this).val() == "" ){
            $(this).parent().addClass('has-error');
            $(this).parent().find('label').append(' &nbsp; <small>(Este campo es requerido)</small>');
            error++;
        }
    })
    
    if( error == 0 ){
        $(".overlayer").show();
        $("#frmCrear")[0].submit();
    }
    
  })   
})         
</script>
      