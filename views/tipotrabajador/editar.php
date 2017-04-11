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
        <form role="form" id="frmCrear" method="post">
        <input type="hidden" name="tipotrabajador_id" value="<?php echo $tipotrabajador['id'] ?>" />
        <input type="hidden" name="action" value="edit" />
        
          <div class="row">
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">                
                <div class="box-header">
                  <h3 class="box-title">Datos del Registro</h3>
                </div><!-- /.box-header -->
                <!-- form start -->                
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreTipotrabajador">Nombre</label>
                          <input type="text" class="form-control required" value="<?php echo $tipotrabajador['nombre'] ?>" id="nombreTipotrabajador" name="nombreTipotrabajador" placeholder="Nombre Tipotrabajador" />
                        </div>  
                        <div class="form-group">
                          <label for="estadoTipotrabajador">Estado</label>
                          <select class="form-control" name="estadoTipotrabajador" id="estadoTipotrabajador">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                          </select>
                          <script> $("#estadoTipotrabajador").val('<?php echo $tipotrabajador['activo'] ?>') </script>
                        </div>                                                                      
                      </div><!-- /.box-body -->                                                    
                </div><!-- /.box -->
            </div>
            
            
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="box box-primary">
                <!-- form start -->
                      <div class="box-body">
                        <div class="form-group">
                            <strong> Prevision </strong>
                            <div class="checkbox">
                                <label>
                                <input type="checkbox" class="chk_prev" name="previsionTipoTrabajador[afp]"  >
                                AFP
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                <input type="checkbox" class="chk_prev" name="previsionTipoTrabajador[salud]">
                                SALUD
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                <input type="checkbox" class="chk_prev" name="previsionTipoTrabajador[afc]">
                                AFC
                                </label>
                            </div>                          
                        </div>                                                                                                
                      </div><!-- /.box-body -->
                                              
              </div><!-- /.box -->              
            </div>          
          </div>   <!-- /.row -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Enviar</button>                        
          </div>
          </form>
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
      
      <?php if( $tipotrabajador['afp'] == 1 ){ ?>
      $(".chk_prev[name='previsionTipoTrabajador[afp]']").prop('checked',true);
      <?php } ?> 
      <?php if( $tipotrabajador['salud'] == 1 ){ ?>
      $(".chk_prev[name='previsionTipoTrabajador[salud]']").prop('checked',true);
      <?php } ?> 
      <?php if( $tipotrabajador['afc'] == 1 ){ ?>
      $(".chk_prev[name='previsionTipoTrabajador[afc]']").prop('checked',true);
      <?php } ?> 
                  
      </script>
      