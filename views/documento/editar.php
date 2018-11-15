<!-- Content Wrapper. Contains page content -->    
<style>
#myModal td:first-child{
    white-space: nowrap;
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
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">                
                <div class="box-header">
                  <h3 class="box-title">Datos del Registro</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frmCrear" method="post">
                    <input type="hidden" name="documento_id" value="<?php echo $documento['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                      
                      <div class="box-body">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombreDocumento">Nombre</label>
                                    <input type="text" class="form-control required" value="<?php echo $documento['nombre'] ?>" id="nombreDocumento" name="nombreDocumento" placeholder="Nombre Documento" />
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="radio">
                                    <label> <strong>Imprimir</strong> </label>
                                    <br />                            
                                    <label>
                                      <input type="radio" class="docImprimir" name="docImprimir[]" id="docImprimirSI" value="1" />
                                      SI
                                    </label>
                                    &nbsp; &nbsp; &nbsp; 
                                    <label>
                                      <input type="radio" class="docImprimir" name="docImprimir[]" id="docImprimirNO" value="0" />
                                      NO
                                    </label>
                                  </div>
                                  <script> $("input.docImprimir[value=<?php echo $documento['imprimir'] ?>]").prop('checked',true) </script>
                                </div>
                                
                                <div class="form-group">
                                    <div class="radio">
                                    <label> <strong>Guardar</strong> </label>
                                    <br />                            
                                    <label>
                                      <input type="radio" class="docGuardar" name="docGuardar[]" id="docGuardarSI" value="1" />
                                      SI
                                    </label>
                                    &nbsp; &nbsp; &nbsp; 
                                    <label>
                                      <input type="radio" class="docGuardar" name="docGuardar[]" id="docGuardarNO" value="0" />
                                      NO
                                    </label>
                                  </div>
                                  <script> $("input.docGuardar[value=<?php echo $documento['guardar'] ?>]").prop('checked',true) </script>
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="form-group">
                                    <label for="textoDocumento">Texto del Documento</label>
                                    <div class="pull-right">
                                      <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal"> <i class="fa fa-question-circle"></i> &nbsp; Ayuda Etiquetas</a>
                                    </div>
                                    <br class="clearfix">
                                    <br class="clearfix">
                                    <textarea class="form-control required wys_editor" id="textoDocumento" name="textoDocumento"><?php echo html_entity_decode($documento['texto']) ?></textarea>
                                </div>
                            </div>
                        </div>
                      </div>
                      
    
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Enviar</button>                        
                      </div>
                    </form>
              </div><!-- /.box -->

            </div>
          </div>   <!-- /.row -->
        </section>
        
      </div><!-- /.content-wrapper -->

    <?php include 'modal_tags.php'; ?>

      
<script>
$("#frmCrear").submit(function(e){
    $('#textoDocumento').text( $('#textoDocumento').Editor("getText") );
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

$(window).load(function(){
    $('#textoDocumento').Editor("setText", $("#textoDocumento").val() );    
})
         
</script>
      