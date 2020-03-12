<!-- Content Wrapper. Contains page content -->    
    
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
                    <input type="hidden" name="contrato_id" value="<?php echo $contrato['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                      
                      <div class="box-body">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombreContrato">Nombre</label>
                                    <input type="text" class="form-control required" value="<?php echo $contrato['nombre'] ?>" id="nombreContrato" name="nombreContrato" placeholder="Nombre Contrato" />
                                </div>
                                <div class="form-group">
                                  <label for="estadoContrato">Estado</label>
                                  <select class="form-control required" name="estadoContrato" id="estadoContrato">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>                            
                                  </select>
                                  <script> $("#estadoContrato").val('<?php echo $contrato['activo'] ?>') </script>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="descripcionContrato">Descripción</label>
                                    <textarea class="form-control required" style="height: 107px;" id="descripcionContrato" name="descripcionContrato"><?php echo $contrato['descripcion'] ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="form-group">
                                    <label for="textoContrato">Texto del Contrato</label>
                                    <textarea class="form-control required wys_editor" id="textoContrato" name="textoContrato"><?php echo html_entity_decode($contrato['texto']) ?></textarea>
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
      
<script>
$("#frmCrear").submit(function(e){
    $('#textoContrato').text( $('#textoContrato').Editor("getText") );
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
    $('#textoContrato').Editor("setText", $("#textoContrato").val() );    
})
         
</script>
      