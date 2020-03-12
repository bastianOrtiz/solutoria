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
                    <input type="hidden" name="cargo_id" value="<?php echo $cargo['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                    <input type="hidden" name="cargoEmpresa" value="<?php echo $_SESSION[ PREFIX . 'login_eid'] ?>" />
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreCargo">Nombre</label>
                          <input type="text" class="form-control required" value="<?php echo $cargo['nombre'] ?>" id="nombreCargo" name="nombreCargo" placeholder="Nombre Cargo" />
                        </div>
                        <div class="form-group">
                          <label for="descipcionCargo">Descripción</label>
                          <input type="text" class="form-control required" value="<?php echo $cargo['descripcion'] ?>" id="descipcionCargo" name="descipcionCargo" placeholder="Descripcion" />
                        </div>                                                                        
                        <div class="form-group">
                          <label for="cargoPadre">Cargo depende de</label>
                          <select class="form-control" id="cargoPadre" name="cargoPadre">
                            <option value="">Ninguno</option>
                            <?php foreach( $cargos as $c ){ ?>
                            <option value="<?php echo $c['id'] ?>"><?php echo $c['nombre'] ?></option>
                            <?php } ?>
                          </select>
                          <script>
                          $("#cargoPadre").val('<?php echo $cargo['cargoPadreId'] ?>');
                          </script>
                        </div>
                        <div class="form-group">
                          <label for="cargoActivo">Activo</label>
                          <div class="radio">
                            <label>
                              <input class="rbtCargoActivo" type="radio" name="cargoActivo[]" value="1" id="cargoActivoSi" checked="checked" />
                              SI
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input class="rbtCargoActivo" type="radio" name="cargoActivo[]" value="0" id="cargoActivoNo" />
                              NO
                            </label>
                          </div>                          
                        </div>
                        <script>
                          $(".rbtCargoActivo[value=<?php echo $cargo['activo'] ?>]").attr('checked','checked')
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
      