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
                        <input type="hidden" name="cargoEmpresa" value="<?php echo $_SESSION[ PREFIX . 'login_eid'] ?>" />
                                                
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreCargo">Nombre</label>
                          <input type="text" class="form-control required" value="" id="nombreCargo" name="nombreCargo" placeholder="Nombre Cargo" />
                        </div>  
                        <div class="form-group">
                          <label for="descipcionCargo">Descripción</label>
                          <input type="text" class="form-control required" value="" id="descipcionCargo" name="descipcionCargo" placeholder="Descripcion" />
                        </div>                                                                      
                        <div class="form-group">
                          <label for="cargoPadre">Cargo depende de</label>
                          <select class="form-control" id="cargoPadre" name="cargoPadre">
                            <option value="">Ninguno</option>
                            <?php foreach( $cargos as $cargo ){ ?>
                            <option value="<?php echo $cargo['id'] ?>"><?php echo $cargo['nombre'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="cargoActivo">Activo</label>
                          <div class="radio">
                            <label>
                              <input type="radio" name="cargoActivo[]" value="1" id="cargoActivoSi" checked="checked" />
                              SI
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" name="cargoActivo[]" value="0" id="cargoActivoNo" />
                              NO
                            </label>
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
      
      $("#rutCargo").blur(function(){
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
      