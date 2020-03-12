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
                    <input type="hidden" name="sucursal_id" value="<?php echo $sucursal['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />                    
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreSucursal">Nombre</label>
                          <input type="text" class="form-control required" value="<?php echo $sucursal['nombre'] ?>" id="nombreSucursal" name="nombreSucursal" placeholder="Nombre Sucursal" />
                        </div>                                                                        
                        <div class="form-group">
                          <label for="sucursalDireccion">Dirección</label>
                          <input type="text" class="form-control required" value="<?php echo $sucursal['direccion'] ?>" id="sucursalDireccion" name="sucursalDireccion" />
                        </div>
                        
                        <div class="form-group">
                            <label for="sucursalRegion">Región</label>
                            <select class="form-control required" name="sucursalRegion" id="sucursalRegion">
                                <option value="">Seleccione Región</option>
                                <?php foreach($regiones as $r){ ?>
                                <option value="<?php echo $r['id'] ?>"><?php echo $r['nombre'] ?></option>
                                <?php } ?>
                            </select>
                            <script>
                            $("#sucursalRegion").val('<?php echo fnGetRegionSucursal($sucursal['comuna_id']) ?>')
                            </script>
                        </div>
                        
                        <div class="form-group">
                            <label for="sucursalComuna">Comuna</label>
                            <select class="form-control required" name="sucursalComuna" id="sucursalComuna">
                                <option value="">Seleccione Comuna</option>
                                <?php foreach($comunas as $c){ ?>
                                <option data-region="<?php echo $c['region_id'] ?>" value="<?php echo $c['id'] ?>"><?php echo $c['nombre'] ?></option>
                                <?php } ?>
                            </select>
                            <script>
                            $("#sucursalComuna").val('<?php echo $sucursal['comuna_id'] ?>')
                            </script>
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
      
      $(document).ready(function(){         
        $("#sucursalRegion").change(function(){
            idRegion = $(this).val();
            $("#sucursalComuna").val('');
            $("#sucursalComuna").empty();
            if( idRegion != "" ){
                $.post("<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>", {
                    regid: idRegion,
                    action: 'get_comuna'
                }, function (json) {
                    html_options = "";
                    $.each(json.registros, function(key,valor) {                    
                        html_options += '<option value="' + valor.id + '">' + valor.nombre + '</option>';
                    })                
                    $("#sucursalComuna").html( html_options );
                    $("#sucursalComuna").removeAttr('disabled');
                },'json')    
            } else {
                $("#sucursalComuna").attr('disabled','disabled');
            }            
        })
        $("#sucursalComuna option[data-region!=<?php echo fnGetRegionSucursal($sucursal['comuna_id']) ?>]").remove();        
      })       
      </script>
      