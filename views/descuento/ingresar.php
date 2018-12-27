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
                                                
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreDescuento">Nombre</label>
                          <input type="text" class="form-control required" value="" id="nombreDescuento" name="nombreDescuento" placeholder="Nombre Descuento" />
                        </div>                                                                                                
                        <div class="form-group">
                          <label for="fijoDescuento">Fijo</label>
                          <div class="radio">
                            <label>
                              <input type="radio" name="fijoDescuento[]" value="1" id="fijoDescuentoSi" checked="checked" />
                              SI
                            </label>
                             &nbsp; 
                            <label>
                              <input type="radio" name="fijoDescuento[]" value="0" id="fijoDescuentoNo" />
                              NO
                            </label>
                          </div>                                                    
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
                        </div>  
                        
                        <div id="predeterminadoToogle" class="collapse">
                            <div class="form-group">
                              <label for="tipoMonedaDescuento">Tipo Moneda</label>
                              <select class="form-control" name="tipoMonedaDescuento" id="tipoMonedaDescuento">
                                <option value="">Seleccione...</option>
                                <?php foreach($tipomoneda as $t){ ?>
                                <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                <?php } ?>
                              </select>
                            </div>                                         
                        
                            <div class="form-group">
                              <label for="valorDescuento">Valor</label>
                              <input type="text" class="form-control" value="" id="valorDescuento" name="valorDescuento" />
                            </div>                                                
                        </div>
                        
                        <div class="form-group">
                          <label for="activoDescuento">Estado</label>
                          <select class="form-control required" name="activoDescuento" id="activoDescuento">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>                            
                          </select>
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
                                </div>
                                <div class="col-lg-6">
                                    <a href="<?php echo BASE_URL ?>/public/img/anticipo.png" target="_blank">
                                        <img src="<?php echo BASE_URL ?>/public/img/anticipo.png" class="img-responsive">
                                    </a>
                                </div>
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

$(".rbtPredeterminado").click(function(){
    switch( $(this).val() ){
        case '1' : 
            $("#predeterminadoToogle").slideDown();
            $("#tipoMonedaDescuento, #valorDescuento").addClass('required'); 
            break;
        case '0' : 
            $("#predeterminadoToogle").slideUp();
            $("#tipoMonedaDescuento, #valorDescuento").removeClass('required'); 
            break;
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
    $("#frmCrear .required").each(function(){
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
      