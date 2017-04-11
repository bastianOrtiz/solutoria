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
                          <label for="nombreHaber">Nombre</label>
                          <input type="text" class="form-control required" value="" id="nombreHaber" name="nombreHaber" placeholder="Nombre Haber" />
                        </div>                                                                                                
                        <div class="form-group">
                          <label for="fijoHaber">Fijo</label>
                          <div class="radio">
                            <label>
                              <input type="radio" name="fijoHaber[]" value="1" id="fijoHaberSi" checked="checked" />
                              SI
                            </label>
                             &nbsp; 
                            <label>
                              <input type="radio" name="fijoHaber[]" value="0" id="fijoHaberNo" />
                              NO
                            </label>
                          </div>                                                    
                        </div>
                        
                        <div class="form-group">
                          <label for="predeterminadoHaber">Valor Predeterminado</label>
                          <div class="radio">
                            <label>
                              <input type="radio" class="rbtPredeterminado" name="predeterminadoHaber[]" value="1" id="predeterminadoHaberSi" />
                              SI
                            </label>
                            &nbsp; 
                            <label>
                              <input type="radio" class="rbtPredeterminado" name="predeterminadoHaber[]" value="0" id="predeterminadoHaberNo" checked="checked" />
                              NO
                            </label>
                          </div>                                                    
                        </div>  
                        
                        <div id="predeterminadoToogle" class="collapse">
                            <div class="form-group">
                              <label for="tipoMonedaHaber">Tipo Moneda</label>
                              <select class="form-control" name="tipoMonedaHaber" id="tipoMonedaHaber">
                                <option value="">Seleccione...</option>
                                <?php foreach($tipomoneda as $t){ ?>
                                <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                <?php } ?>
                              </select>
                            </div>                                         
                        
                            <div class="form-group">
                              <label for="valorHaber">Valor</label>
                              <input type="text" class="form-control" value="" id="valorHaber" name="valorHaber" />
                            </div>
                        </div>
                                                
                        <div class="form-group">
                          <label for="imponibleHaber">Es Imponible</label>
                          <div class="radio">
                            <label>
                              <input type="radio" name="imponibleHaber[]" value="1" id="imponibleHaberSi" checked="checked" />
                              SI
                            </label>
                            &nbsp; 
                            <label>
                              <input type="radio" name="imponibleHaber[]" value="0" id="imponibleHaberNo" />
                              NO
                            </label>
                          </div>                                                    
                        </div>
                        
                        <div class="form-group">
                          <label for="comisionHaber">Es Comisión</label>
                          <div class="radio">
                            <label>
                              <input type="radio" name="comisionHaber[]" value="1" id="comisionHaberSi" />
                              SI
                            </label>
                            &nbsp; 
                            <label>
                              <input type="radio" name="comisionHaber[]" value="0" id="comisionHaberNo" checked="checked" />
                              NO
                            </label>
                          </div>                                                    
                        </div>
                        
                        <div class="form-group">
                          <label for="activoHaber">Estado</label>
                          <select class="form-control required" name="activoHaber" id="activoHaber">
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
  
  $(".rbtPredeterminado").click(function(){
    switch( $(this).val() ){
        case '1' : 
                $("#predeterminadoToogle").slideDown(); 
                $("#valorHaber, #tipoMonedaHaber").addClass('required');
                break;
                                
        case '0' : 
                $("#predeterminadoToogle").slideUp();
                $("#valorHaber, #tipoMonedaHaber").removeClass('required'); 
                break;
    }
})
  
  $("#rutHaber").blur(function(){
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
      