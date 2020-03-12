
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
                <!-- /.box-header -->
                <div class="box-body">
                    <form role="form" id="frmCrear" method="post">
                        <input type="hidden" name="action" value="edit_profile" />                    
                        <div class="col-md-6">                            
                            <div class="box-body">                                                                     
                              <div class="form-group">
                                <label for="emailUsuario">Email Usuario</label>
                                <input type="text" class="form-control required" value="<?php echo $perfil['email'] ?>" id="emailUsuario" name="emailUsuario" placeholder="usuario@dominio.cl" />
                              </div>
                              
                              <div class="form-group">
                                <label for="passwordUsuario">Password</label>
                                <input type="password" class="form-control required" value="**********" id="passwordUsuario" name="passwordUsuario" placeholder="Elija contraseña" />
                              </div>
                              <div class="form-group">
                                <label for="rePasswordUsuario">Reingrese Password</label>
                                <input type="password" class="form-control required" value="**********" id="rePasswordUsuario" name="rePasswordUsuario" placeholder="Reescriba la contraseña elejida" />
                              </div>
                              
                            </div><!-- /.box-body -->                            
                        </div>
                        <div class="col-md-6">  
                          <div class="box box-success">
                            <div class="box-header">
                                <strong>Datos adicionales</strong>
                            </div>
                            <div class="box-body">  
                              <div class="form-group">
                                <label for="telefonoUsuario">Teléfono</label>
                                <input type="text" name="telefonoUsuario" id="telefonoUsuario" class="form-control" value="<?php echo $perfil['telefono'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="direccionUsuario">Dirección</label>
                                <input type="text" name="direccionUsuario" id="direccionUsuario" class="form-control" value="<?php echo $perfil['direccion'] ?>">
                              </div>
                              <div class="form-group">
                                <label for="emergenciaUsuario">En caso de emergencia comunicarse con:</label>
                                <textarea name="emergenciaUsuario" id="emergenciaUsuario" class="form-control"><?php echo $perfil['emergencia'] ?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                    <div class="clearfix"></div>
                    <div class="box-footer">
                      <button type="submit" class="btn btn-primary">Guardar</button>
                      <a href="<?php echo BASE_URL . '/' . $entity ?>/listar" class="btn btn-default">Cancelar</a>
                    </div>
                </div>
                </form>
              </div><!-- /.box -->
            
            </div>
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
        if( $("#passwordUsuario").val() != $("#rePasswordUsuario").val() ){
            $("#passwordUsuario, #rePasswordUsuario").parent().addClass('has-error');
            $("#passwordUsuario, #rePasswordUsuario").parent().find('label').append(' <small>(Las password no coinciden)</small>');
        } else {
            $(".overlayer").show();
            $("#frmCrear")[0].submit();
        }
    }
    
  })   
           
</script>
      