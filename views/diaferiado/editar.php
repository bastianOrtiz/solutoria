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
                    <input type="hidden" name="diaferiado_id" value="<?php echo $diaferiado['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreDiaferiado">Nombre</label>
                          <input type="text" class="form-control required" value="<?php echo $diaferiado['nombre'] ?>" id="nombreDiaferiado" name="nombreDiaferiado" placeholder="Nombre Diaferiado" />
                        </div>
                        <div class="form-group">
                            <label for="fechaDiaferiado">Fecha</label>
                            <input type="text" class="form-control required datepicker" value="<?php echo $diaferiado['fecha'] ?>" id="fechaDiaferiado" name="fechaDiaferiado" placeholder="YYYY-mm-dd" readonly="" />                            
                        </div>
                        <div class="form-group">
                            <label for="anualDiaferiado">Se repite anualmente?</label>
                            <div class="radio">                            
                                <label>
                                  <input type="radio" class="rbtAnualDiaferiado" name="anualDiaferiado[]" id="anualDiaferiadoSI" value="1" />SI
                                </label>
                                &nbsp; &nbsp; &nbsp; 
                                <label>
                                  <input type="radio" class="rbtAnualDiaferiado" name="anualDiaferiado[]" id="anualDiaferiadoNO" value="0" />NO
                                </label>
                            </div>
                            <script> $("input.rbtAnualDiaferiado[value=<?php echo $diaferiado['anual'] ?>]").prop('checked',true) </script>                         
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
      $(document).ready(function(){
            $(".datepicker").datepicker({
                viewMode: "days",                
                autoclose : true,
                format : 'yyyy-mm-dd'
            });
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
      