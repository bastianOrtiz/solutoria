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
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">                
                <div class="box-header">
                  <h3 class="box-title">Datos del Registro</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frmCrear" method="post">
                    <input type="hidden" name="haber_id" value="<?php echo $haber['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreHaber">Nombre</label>
                          <input type="text" class="form-control required" value="<?php echo $haber['nombre'] ?>" id="nombreHaber" name="nombreHaber" placeholder="Nombre Haber" />
                        </div>                                                                                                
                        <div class="form-group">
                          <label for="fijoHaber">Fijo</label>
                          <div class="radio">
                            <label>
                              <input class="fijoHaber" type="radio" name="fijoHaber[]" value="1" id="fijoHaberSi" checked="checked" />
                              SI
                            </label>
                             &nbsp; 
                            <label>
                              <input class="fijoHaber" type="radio" name="fijoHaber[]" value="0" id="fijoHaberNo" />
                              NO
                            </label>
                          </div>
                          <script> $(".fijoHaber[value=<?php echo $haber['fijo'] ?>]").attr('checked','checked') </script>                                                    
                        </div>
                        
                        <div class="form-group">
                          <label for="predeterminadoHaber">Valor Predeterminado</label>
                          <div class="radio">
                            <label>
                              <input class="predeterminadoHaber" type="radio" name="predeterminadoHaber[]" value="1" id="predeterminadoHaberSi" checked="checked" />
                              SI
                            </label>
                            &nbsp; 
                            <label>
                              <input class="predeterminadoHaber" type="radio" name="predeterminadoHaber[]" value="0" id="predeterminadoHaberNo" />
                              NO
                            </label>
                          </div>
                          <script> $(".predeterminadoHaber[value=<?php echo $haber['valorPredeterminado'] ?>]").attr('checked','checked') </script>                                                    
                        </div>  
                        
                        <div id="predeterminadoToogle" class="<?php echo ($haber['valorPredeterminado']==0) ? 'collapse' : ''; ?>">
                            <div class="form-group">
                              <label for="tipoMonedaHaber">Tipo Moneda</label>
                              <select class="form-control" name="tipoMonedaHaber" id="tipoMonedaHaber">
                                <option value="">Seleccione...</option>
                                <?php foreach($tipomoneda as $t){ ?>
                                <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                <?php } ?>
                              </select>
                              <script> $("#tipoMonedaHaber").val('<?php echo $haber['tipomoneda_id'] ?>') </script>
                            </div>                                         
                        
                            <div class="form-group">
                              <label for="valorHaber">Valor</label>
                              <input type="text" class="form-control" value="<?php echo $haber['valor'] ?>" id="valorHaber" name="valorHaber" />
                            </div>
                        </div>
                                                
                        <div class="form-group">
                          <label for="imponibleHaber">Es Imponible</label>
                          <div class="radio">
                            <label>
                              <input class="imponibleHaber" type="radio" name="imponibleHaber[]" value="1" id="imponibleHaberSi" />
                              SI
                            </label>
                            &nbsp; 
                            <label>
                              <input class="imponibleHaber" type="radio" name="imponibleHaber[]" value="0" id="imponibleHaberNo" />
                              NO
                            </label>
                          </div>
                          <script> $(".imponibleHaber[value=<?php echo $haber['imponible'] ?>]").prop('checked',true) </script>                                                    
                        </div>
                        
                        <div class="form-group">
                          <label for="comisionHaber">Es Comisión</label>
                          <div class="radio">
                            <label>
                              <input type="radio" class="comisionHaber" name="comisionHaber[]" value="1" id="comisionHaberSi" />
                              SI
                            </label>
                            &nbsp; 
                            <label>
                              <input type="radio" class="comisionHaber" name="comisionHaber[]" value="0" id="comisionHaberNo" />
                              NO
                            </label>
                          </div>
                            <script> $(".comisionHaber[value=<?php echo $haber['comision'] ?>]").prop('checked',true) </script>                                              
                        </div>
                        
                        <div class="form-group">
                          <label for="activoHaber">Estado</label>
                          <select class="form-control required" name="activoHaber" id="activoHaber">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>                            
                          </select>
                          <script> $("#activoHaber").val('<?php echo $haber['activo'] ?>') </script>
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

$(".predeterminadoHaber").click(function(){
    switch( $(this).val() ){
        case '1' : 
                $("#predeterminadoToogle").slideDown(); 
                $("#valorHaber, #tipoMonedaHaber").addClass('required');
                break;
                                
        case '0' : 
                $("#predeterminadoToogle").slideUp();
                $("#valorHaber, #tipoMonedaHaber").removeClass('required'); 
                break;
    }
})

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
</script>
      