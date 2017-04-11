<!-- Content Wrapper. Contains page content -->    
    
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> INGRESAR <?php echo strtoupper($entity) ?> </h1>
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
              <div class="col-md-6">
                  <!-- general form elements -->
                  <div class="box box-primary">                
                    <div class="box-header">
                      <h3 class="box-title">Datos del registro</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="frmCrear" method="post">
                        <input type="hidden" name="action" value="new" />
                        <input type="hidden" name="institucionEmpresa" value="<?php echo $_SESSION[ PREFIX . 'login_eid'] ?>" />
                                                
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreInstitucion">Nombre</label>
                          <input type="text" class="form-control required" value="" id="nombreInstitucion" name="nombreInstitucion" placeholder="Nombre Institucion" />
                        </div>
                        <div class="form-group">
                          <label for="tipoInstitucion">Nombre</label>
                          <select class="form-control required" id="tipoInstitucion" name="tipoInstitucion">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                          </select>                          
                        </div>
                        <div class="form-group">
                          <label for="estadoInstitucion">Estado</label>
                          <select class="form-control" name="estadoInstitucion" id="estadoInstitucion">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                          </select>
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
      
      $("#rutInstitucion").blur(function(){
        if( !formateaRut( $(this) ) ){
            if( !$(this).parent().hasClass('has-error') ){
                $(this).parent().addClass('has-error');
                $(this).parent().find('label').append(' <small>(El RUT esta mal escrito)</small>');
            }
        } else {
            $(this).parent().removeClass('has-error');
            $(this).parent().find('label').find('small').remove();
        }
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
        }
        
      })            
      </script>
      