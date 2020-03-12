<?php
if( ! isset($tipomoneda)  ){
    redirect(BASE_URL.'/tipomoneda/listar');
    exit();
}
?>
      <div class="content-wrapper">
        
        <section class="content-header">            
          <h1> INGRESAR VALOR A TIPO "<?php echo $tipomoneda['nombre'] ?>"</h1>
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
                          <label>Tipo Moneda</label>
                          <input type="text" class="form-control" value="<?php echo $tipomoneda['nombre'] ?>" readonly="readonly" />
                          <input type="hidden" name="id_tipomoneda" id="id_tipomoneda" value="<?php echo $parametros[1]; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="valorTipomonedavalor">Valor</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <input type="number" step="any" class="form-control required" name="valorTipomonedavalor" id="valorTipomonedavalor" />                                
                            </div>
                        </div>                                                                                                
                        <div class="form-group">
                          <label for="mesTipomonedavalor">Mes</label>
                          <select class="form-control required" name="mesTipomonedavalor" id="mesTipomonedavalor">
                            <?php for( $i=1; $i<=12; $i++ ){ ?>
                            <option value="<?php echo $i; ?>" <?php echo (date('n')==$i) ? ' selected ' : ''; ?> > <?php echo getNombreMes($i); ?> </option>
                            <?php } ?>                            
                          </select>
                        </div>                                         
                        <div class="form-group">
                          <label for="anoTipomonedavalor">Año</label>
                          <input type="text" class="form-control required" name="anoTipomonedavalor" id="anoTipomonedavalor" value="<?php echo date('Y') ?>" />
                        </div>
                        
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                      </div>
                    </form>
                  </div><!-- /.box -->
                </div>
                                
                
                <div class="col-md-6">
                  <!-- general form elements -->
                    <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">Lista de valores</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body no-padding table-responsive">
                          <table class="table table-striped">
                            <tbody><tr>
                              <th style="width: 10px">#</th>
                              <th>Valor</th>
                              <th>Mes</th>
                              <th style="width: 40px">Año</th>
                            </tr>
                            <?php 
                            $i=1;                            
                            foreach( $tipomonedavalor as $v ){
                            ?>
                            <tr>
                              <td><?php echo $i; ?>.</td>
                              <td><?php echo $v['valor'] ?></td>
                              <td> <?php echo getNombreMes($v['mes']) ?> </td>
                              <td><?php echo $v['ano'] ?></td>
                            </tr>
                            <?php
                            $i++; 
                            }
                            ?>
                          </tbody></table>
                        </div><!-- /.box-body -->
                      </div><!-- /.box -->
    
    
                </div>
                                
          </div>   <!-- /.row -->
        </section>
        
      </div><!-- /.content-wrapper -->
      
      <script>
      
      $("#rutTipomonedavalor").blur(function(){
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
      