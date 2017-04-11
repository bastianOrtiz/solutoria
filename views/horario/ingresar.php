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
          <div class="row">
              <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">                
                    <div class="box-header">
                      <h3 class="box-title">Datos del registro</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->                                                                    
                    <div class="box-body">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="nombreHorario">Nombre</label>
                              <input type="text" class="form-control required" value="" id="nombreHorario" name="nombreHorario" placeholder="Nombre Horario" />
                            </div>
                            
                            <div class="form-group">
                              <label for="descripcionHorario">Descripcion</label>
                              <textarea class="form-control required" id="descripcionHorario" name="descripcionHorario" style="resize: none;"></textarea>                          
                            </div>
                            
                            <div class="form-group">
                              <label for="activoHorario">Estado</label>
                              <select class="form-control required" name="activoHorario" id="activoHorario">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>                            
                              </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="entradaTrabajoHorario">Entrada Trabajo</label>
                                        <select class="form-control required" id="entradaTrabajoHorario" name="entradaTrabajoHorario">
                                            <option value="">HH:MM</option>
                                            <?php for($i=0;$i<=23;$i++){ ?>
                                            <option value="<?php echo leadZero($i).':00:00' ?>"><?php echo leadZero($i).':00' ?></option>
                                            <option value="<?php echo leadZero($i).':15:00' ?>"><?php echo leadZero($i).':15' ?></option>
                                            <option value="<?php echo leadZero($i).':30:00' ?>"><?php echo leadZero($i).':30' ?></option>
                                            <option value="<?php echo leadZero($i).':45:00' ?>"><?php echo leadZero($i).':45' ?></option>
                                            <?php } ?>
                                        </select>                                                    
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="salidaTrabajoHorario">Salida Trabajo</label>
                                        <select class="form-control required" id="salidaTrabajoHorario" name="salidaTrabajoHorario">
                                            <option value="">HH:MM</option>
                                            <?php for($i=0;$i<=23;$i++){ ?>
                                            <option value="<?php echo leadZero($i).':00:00' ?>"><?php echo leadZero($i).':00' ?></option>
                                            <option value="<?php echo leadZero($i).':15:00' ?>"><?php echo leadZero($i).':15' ?></option>
                                            <option value="<?php echo leadZero($i).':30:00' ?>"><?php echo leadZero($i).':30' ?></option>
                                            <option value="<?php echo leadZero($i).':45:00' ?>"><?php echo leadZero($i).':45' ?></option>
                                            <?php } ?>
                                        </select>                                                    
                                    </div>                                                                        
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="entradaColacionHorario">Entrada Colacion</label>
                                        <select class="form-control required" id="entradaColacionHorario" name="entradaColacionHorario">
                                            <option value="">HH:MM</option>
                                            <?php for($i=0;$i<=23;$i++){ ?>
                                            <option value="<?php echo leadZero($i).':00:00' ?>"><?php echo leadZero($i).':00' ?></option>
                                            <option value="<?php echo leadZero($i).':15:00' ?>"><?php echo leadZero($i).':15' ?></option>
                                            <option value="<?php echo leadZero($i).':30:00' ?>"><?php echo leadZero($i).':30' ?></option>
                                            <option value="<?php echo leadZero($i).':45:00' ?>"><?php echo leadZero($i).':45' ?></option>
                                            <?php } ?>
                                        </select>                                                    
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label for="salidaColacionHorario">Salida Colacion</label>
                                        <select class="form-control required" id="salidaColacionHorario" name="salidaColacionHorario">
                                            <option value="">HH:MM</option>
                                            <?php for($i=0;$i<=23;$i++){ ?>
                                            <option value="<?php echo leadZero($i).':00:00' ?>"><?php echo leadZero($i).':00' ?></option>
                                            <option value="<?php echo leadZero($i).':15:00' ?>"><?php echo leadZero($i).':15' ?></option>
                                            <option value="<?php echo leadZero($i).':30:00' ?>"><?php echo leadZero($i).':30' ?></option>
                                            <option value="<?php echo leadZero($i).':45:00' ?>"><?php echo leadZero($i).':45' ?></option>
                                            <?php } ?>
                                        </select>                                                    
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">                            
                                        <label>Dias que trabaja</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[lun]" checked> Lun
                                                      </label>
                                                    </div>
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[mar]" checked> Mar
                                                      </label>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[mie]" checked> Mie
                                                      </label>
                                                    </div>
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[jue]" checked> Jue
                                                      </label>
                                                    </div>                                                                                                
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[vie]" checked> Vie
                                                      </label>
                                                    </div>
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[sab]"> Sab
                                                      </label>
                                                    </div>                                                                                                
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[dom]"> Dom
                                                      </label>
                                                    </div>                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                      </div><!-- /.box-body -->                    
                    </div><!-- /.box -->
                  
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
          </div>
        </form>
        </section>
        
      </div><!-- /.content-wrapper -->
      
<script>

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
      