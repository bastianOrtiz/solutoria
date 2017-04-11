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
            <form role="form" id="frmCrear" method="post">
            <input type="hidden" name="action" value="edit" />
            <input type="hidden" name="horario_id" value="<?php echo $horario['id'] ?>" />
                <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">                
                    <div class="box-header">
                        <h3 class="box-title">Datos del Registro</h3>
                    </div><!-- /.box-header -->
                      <div class="box-body">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="nombreHorario">Nombre</label>
                              <input type="text" class="form-control required" value="<?php echo $horario['nombre'] ?>" id="nombreHorario" name="nombreHorario" placeholder="Nombre Horario" />
                            </div>
                            
                            <div class="form-group">
                              <label for="descripcionHorario">Descripcion</label>
                              <textarea class="form-control required" id="descripcionHorario" name="descripcionHorario" style="resize: none;"><?php echo $horario['descripcion'] ?></textarea>                          
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
                                            <script> $("#entradaTrabajoHorario").val('<?php echo $horario['entradaTrabajo'] ?>') </script>                                                
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
                                            <script> $("#salidaTrabajoHorario").val('<?php echo $horario['salidaTrabajo'] ?>') </script>                                                 
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
                                            <script> $("#entradaColacionHorario").val('<?php echo $horario['entradaColacion'] ?>') </script>                                                   
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
                                            <script> $("#salidaColacionHorario").val('<?php echo $horario['salidaColacion'] ?>') </script>                                                
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
                                                        <input type="checkbox" name="diasHorario[lun]" > Lun
                                                      </label>
                                                    </div>
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[mar]" > Mar
                                                      </label>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[mie]" > Mie
                                                      </label>
                                                    </div>
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[jue]" > Jue
                                                      </label>
                                                    </div>                                                                                                
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <div class="checkbox">
                                                      <label>
                                                        <input type="checkbox" name="diasHorario[vie]" > Vie
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
            </form>
          </div>
        </section>
        
      </div><!-- /.content-wrapper -->
      
<script>
$(document).ready(function(){
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
    
})

<?php 
$dias = array('lun','mar','mie','jue','vie','sab','dom');
foreach( $dias as $d ){
    if( @$horario[$d] == 1 ){            
    echo '$("input[name=\'diasHorario[' . $d . ']\']").attr(\'checked\',\'checked\');'."\n";        
    } 
}
?>
</script>
      