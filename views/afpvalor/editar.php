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
                    <input type="hidden" name="afpvalor_id" value="<?php echo $afpvalor['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreAfpvalor">Nombre</label>
                          <input type="text" class="form-control required" value="<?php echo $afpvalor['nombre'] ?>" id="nombreAfpvalor" name="nombreAfpvalor" placeholder="Nombre Afpvalor" />
                        </div>                                                                                                
                        <div class="form-group">
                          <label for="afpvalorDescuenta">Descuenta</label>
                          <div class="radio">
                            <label>
                              <input class="rbtAfpvalorDescuenta" type="radio" name="afpvalorDescuenta[]" value="1" id="afpvalorDescuentaSi" checked="checked" />
                              SI
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input class="rbtAfpvalorDescuenta" type="radio" name="afpvalorDescuenta[]" value="0" id="afpvalorDescuentaNo" />
                              NO
                            </label>
                          </div>                          
                        </div>
                        <script>
                          $(".rbtAfpvalorDescuenta[value=<?php echo $afpvalor['descuenta'] ?>]").attr('checked','checked')
                          </script>
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
      