<!-- Content Wrapper. Contains page content -->    
 <style>
.input-group{
    margin: 5px auto;
}
</style>    
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
                    <input type="hidden" name="tipopago_id" value="<?php echo $tipopago['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                      <div class="box-body">
                        <div class="form-group">
                          <label for="nombreTipopago">Nombre</label>
                          <input type="text" class="form-control required" value="<?php echo $tipopago['nombre'] ?>" id="nombreTipopago" name="nombreTipopago" placeholder="Nombre Tipopago" />
                        </div>
                        <div class="form-group" id="multicampos_group">
                          <label for="multicampoTipopago">Campos personalizados</label>
                          <?php 
                            $arr_fields = json_decode($tipopago['multicampo']);                        
                            foreach( $arr_fields as $field ){
                            ?>
                            <div class="input-group">
                            	<input value="<?php echo $field->name ?>" class="form-control required" name="multicampoTipopago[]" placeholder="Nombre del campo">
                            	<div class="input-group-btn">
                            		<button type="button" class="btn btn-default btn_remove_milticampo">
                            			<i class="fa fa-minus"></i>
                            		</button>
                            	</div>
                            </div>
                            <?php } ?>                                                  
                        </div>
                        
                                                
                        
                        <div class="form-group">
                            <button type="button" id="btn_new_field" class="btn btn-primary pull-right" data-toggle="tooltip" title="Agregar nuevo campo"><i class="fa fa-plus"></i></button>
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
        
            $("#btn_new_field").click(function(){
                html = '<div class="input-group">';
                html += '   <input class="form-control required" name="multicampoTipopago[]" placeholder="Nombre del campo">';
                html += '   <div class="input-group-btn">';
                html += '       <button type="button" class="btn btn-default btn_remove_milticampo"><i class="fa fa-minus"></i></button>';
                html += '   </div>';
                html += '</div>';
                $("#multicampos_group").append(html);
            })
            
            $(document).on('click','.btn_remove_milticampo',function(){    
                $(this).closest('.input-group').fadeOut(300).remove();
            })        
        
      })         
     </script>
      