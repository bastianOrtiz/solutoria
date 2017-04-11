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
        <form role="form" id="frmCrear" method="post">
        <input type="hidden" name="action" value="new" />
        <input type="hidden" name="tipotrabajadorEmpresa" value="<?php echo $_SESSION[ PREFIX . 'login_eid'] ?>" />
     
     
          <div class="row">
              <div class="col-md-6">
                  <!-- general form elements -->
                  <div class="box box-primary">                
                    <div class="box-header">
                      <h3 class="box-title">Datos del registro</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                                               
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreTipotrabajador">Nombre</label>
                          <input type="text" class="form-control required" value="" id="nombreTipotrabajador" name="nombreTipotrabajador" placeholder="Nombre Tipotrabajador" />
                        </div>
                        <div class="form-group">
                          <label for="estadoTipotrabajador">Estado</label>
                          <select class="form-control" name="estadoTipotrabajador" id="estadoTipotrabajador">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                          </select>
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
      
      $("#rutTipotrabajador").blur(function(){
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
      