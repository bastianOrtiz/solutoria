<?php
if( ! isset($afp)  ){
    redirect(BASE_URL.'/afp/listar');
    exit();
}
?>
      <div class="content-wrapper">
        
        <section class="content-header">            
          <h1> INGRESAR VALOR A TIPO "<?php echo $afp['nombre'] ?>"</h1>
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
                          <input type="text" class="form-control" value="<?php echo $afp['nombre'] ?>" readonly="readonly" />
                          <input type="hidden" name="id_afp" id="id_afp" value="<?php echo $parametros[1]; ?>" />
                        </div>
                                                                                                                        
                        <div class="form-group col-md-4">
                          <label for="mesAfpvalor">Mes</label>
                          <select class="form-control required" name="mesAfpvalor" id="mesAfpvalor">
                            <?php for( $i=1; $i<=12; $i++ ){ ?>
                            <option value="<?php echo $i; ?>" <?php echo (date('n')==$i) ? ' selected ' : ''; ?> > <?php echo getNombreMes($i); ?> </option>
                            <?php } ?>                            
                          </select>
                        </div>                                         
                        <div class="form-group col-md-4">
                          <label for="anoAfpvalor">Año</label>
                          <input type="text" class="form-control required" name="anoAfpvalor" id="anoAfpvalor" value="<?php echo date('Y') ?>" />
                        </div>
                        
                        
                        <div class="form-group col-md-4">
                            <label for="porcentajePensionAfpvalor">Porcentaje Pension</label>                            
                            <div class="input-group">
                                <input type="number" step="any" class="form-control required" name="porcentajePensionAfpvalor" id="porcentajePensionAfpvalor" />
                                <span class="input-group-addon"><strong>%</strong></span>                                
                            </div>
                        </div>                                                                                                
                        <div class="form-group col-md-4">
                            <label for="porcentajeSeguroAfpvalor">Porcentaje Seguro</label>                            
                            <div class="input-group">
                                <input type="number" step="any" class="form-control required" name="porcentajeSeguroAfpvalor" id="porcentajeSeguroAfpvalor" />
                                <span class="input-group-addon"><strong>%</strong></span>                                
                            </div>
                        </div>                                         
                        <div class="form-group col-md-4">
                            <label for="porcentajeSisAfpvalor">Porcentaje Sis</label>                            
                            <div class="input-group">
                                <input type="number" step="any" class="form-control required" name="porcentajeSisAfpvalor" id="porcentajeSisAfpvalor" />
                                <span class="input-group-addon"><strong>%</strong></span>                                
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="porcentajePensionadoAfpvalor">Porcent. Pensionado</label>                            
                            <div class="input-group">
                                <input type="number" step="any" class="form-control required" name="porcentajePensionadoAfpvalor" id="porcentajePensionadoAfpvalor" />
                                <span class="input-group-addon"><strong>%</strong></span>                                
                            </div>
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
                              <th>% Pension</th>
                              <th>% Seguro</th>
                              <th>% Sis</th>
                              <th>% Pensionado</th>
                              <th>Mes</th>
                              <th style="width: 40px">Año</th>
                            </tr>
                            <?php 
                            $i=1;                            
                            foreach( $afpvalor as $v ){
                            ?>
                            <tr>
                              <td><?php echo $i; ?>.</td>
                              <td><?php echo $v['porCientoPension'] ?></td>
                              <td><?php echo $v['porCientoSeguro'] ?></td>
                              <td><?php echo $v['porCientoSis'] ?></td>
                              <td><?php echo $v['porCientoPencionado'] ?></td>
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
      
      $("#rutAfpvalor").blur(function(){
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
      