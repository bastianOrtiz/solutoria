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
                    <input type="hidden" name="action" value="edit" />
                    <input type="hidden" name="descuento_id" value="<?php echo $descuento['id'] ?>" />                        
                                                
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreDescuento">Nombre</label>
                          <input type="text" class="form-control required" value="<?php echo $descuento['nombre'] ?>" id="nombreDescuento" name="nombreDescuento" placeholder="Nombre Descuento" />
                        </div>                                                                                                
                        <div class="form-group">
                          <label for="fijoDescuento">Fijo</label>
                          <div class="radio">
                            <label>
                              <input class="rbtDescuentoFijo" type="radio" name="fijoDescuento[]" value="1" id="fijoDescuentoSi" checked="checked" />
                              SI
                            </label>
                             &nbsp; 
                            <label>
                              <input class="rbtDescuentoFijo" type="radio" name="fijoDescuento[]" value="0" id="fijoDescuentoNo" />
                              NO
                            </label>
                          </div>
                          <script> $(".rbtDescuentoFijo[value=<?php echo $descuento['fijo'] ?>]").attr('checked','checked') </script>
                        </div>
                        
                        <div class="form-group">
                          <label for="predeterminadoDescuento">Valor Predeterminado</label>
                          <div class="radio">
                            <label>
                              <input class="rbtPredeterminado" type="radio" name="predeterminadoDescuento[]" value="1" id="predeterminadoDescuentoSi" />
                              SI
                            </label>
                            &nbsp; 
                            <label>
                              <input class="rbtPredeterminado" type="radio" name="predeterminadoDescuento[]" value="0" id="predeterminadoDescuentoNo" checked="checked" />
                              NO
                            </label>
                          </div>
                          <script> $(".rbtPredeterminado[value=<?php echo $descuento['valorPredeterminado'] ?>]").attr('checked','checked') </script>                                                    
                        </div>  
                        
                        <div id="predeterminadoToogle" class="<?php echo ($descuento['valorPredeterminado']==0) ? 'collapse' : ''; ?>">
                            <div class="form-group">
                              <label for="tipoMonedaDescuento">Tipo Moneda</label>
                              <select class="form-control required" name="tipoMonedaDescuento" id="tipoMonedaDescuento">
                                <option value="">Seleccione...</option>
                                <?php foreach($tipomoneda as $t){ ?>
                                <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                <?php } ?>
                              </select>
                              <script> $("#tipoMonedaDescuento").val('<?php echo $descuento['tipomoneda_id'] ?>'); </script>
                            </div>                                         
                        
                            <div class="form-group">
                              <label for="valorDescuento">Valor</label>
                              <input type="text" class="form-control required" value="<?php echo $descuento['valor'] ?>" id="valorDescuento" name="valorDescuento" />
                            </div>                                                
                        </div>
                        
                        <div class="form-group">
                          <label for="activoDescuento">Estado</label>
                          <select class="form-control required" name="activoDescuento" id="activoDescuento">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>                            
                          </select>
                          <script> $("#activoDescuento").val('<?php echo $descuento['activo'] ?>'); </script>
                        </div>  

                        <br>
                        <br>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="mostrarAbajoDescuento">¿Es Anticipo? (Mostrar abajo de la liquidación)</label>
                                    <select class="form-control required" name="mostrarAbajoDescuento" id="mostrarAbajoDescuento">
                                        <option value="0">NO</option>
                                        <option value="1">SI</option>                            
                                    </select>
                                    <script> $("#mostrarAbajoDescuento").val('<?php echo $descuento['mostrarAbajo'] ?>'); </script>
                                </div>
                                <div class="col-lg-6">
                                    <a href="<?php echo BASE_URL ?>/public/img/anticipo.png" target="_blank">
                                        <img src="<?php echo BASE_URL ?>/public/img/anticipo.png" class="img-responsive">
                                    </a>
                                </div>
                            </div>
                        </div>  

                        <div class="form-group">
                          <label for="cajaDescuento">¿Crédito Asociado a una caja de compensación?</label>
                          <select class="form-control" name="cajaDescuento" id="cajaDescuento">
                            <option value="">No es un crédito Caja Compensación</option>
                            <?php foreach( $cajas as $caja ){ ?>
                            <option value="<?php echo $caja['id'] ?>"><?php echo $caja['nombre'] ?></option>
                            <?php } ?>
                          </select>
                          <script> $("#cajaDescuento").val('<?php echo $descuento['ccaf_id'] ?>'); </script>
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
$(".rbtPredeterminado").click(function(){
    switch( $(this).val() ){
        case '1' : $("#predeterminadoToogle").slideDown(); break;
        case '0' : $("#predeterminadoToogle").slideUp(); break;
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
      