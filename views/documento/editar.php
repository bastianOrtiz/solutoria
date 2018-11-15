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
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">                
                <div class="box-header">
                  <h3 class="box-title">Datos del Registro</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frmCrear" method="post">
                    <input type="hidden" name="documento_id" value="<?php echo $documento['id'] ?>" />
                    <input type="hidden" name="action" value="edit" />
                      
                      <div class="box-body">
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombreDocumento">Nombre</label>
                                    <input type="text" class="form-control required" value="<?php echo $documento['nombre'] ?>" id="nombreDocumento" name="nombreDocumento" placeholder="Nombre Documento" />
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="radio">
                                    <label> <strong>Imprimir</strong> </label>
                                    <br />                            
                                    <label>
                                      <input type="radio" class="docImprimir" name="docImprimir[]" id="docImprimirSI" value="1" />
                                      SI
                                    </label>
                                    &nbsp; &nbsp; &nbsp; 
                                    <label>
                                      <input type="radio" class="docImprimir" name="docImprimir[]" id="docImprimirNO" value="0" />
                                      NO
                                    </label>
                                  </div>
                                  <script> $("input.docImprimir[value=<?php echo $documento['imprimir'] ?>]").prop('checked',true) </script>
                                </div>
                                
                                <div class="form-group">
                                    <div class="radio">
                                    <label> <strong>Guardar</strong> </label>
                                    <br />                            
                                    <label>
                                      <input type="radio" class="docGuardar" name="docGuardar[]" id="docGuardarSI" value="1" />
                                      SI
                                    </label>
                                    &nbsp; &nbsp; &nbsp; 
                                    <label>
                                      <input type="radio" class="docGuardar" name="docGuardar[]" id="docGuardarNO" value="0" />
                                      NO
                                    </label>
                                  </div>
                                  <script> $("input.docGuardar[value=<?php echo $documento['guardar'] ?>]").prop('checked',true) </script>
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">                                
                                <div class="form-group">
                                    <label for="textoDocumento">Texto del Documento</label>
                                    <div class="pull-right">
                                      <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal"> <i class="fa fa-question-circle"></i> &nbsp; Ayuda Etiquetas</a>
                                    </div>
                                    <br class="clearfix">
                                    <br class="clearfix">
                                    <textarea class="form-control required wys_editor" id="textoDocumento" name="textoDocumento"><?php echo html_entity_decode($documento['texto']) ?></textarea>
                                </div>
                            </div>
                        </div>
                      </div>
                      
    
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Enviar</button>                        
                      </div>
                    </form>
              </div><!-- /.box -->

            </div>
          </div>   <!-- /.row -->
        </section>
        
      </div><!-- /.content-wrapper -->


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Lista de etiquetas de autocompletado</h4>
      </div>
      <div class="modal-body">
        

          <div>
              <div><strong>DATOS DE LA EMPRESA</strong>.</div>
              <table class="table table-stripped">
                  <tbody>
                      <tr>
                          <td>
                              <div>ETIQUETA</div>
                          </td>
                          <td>
                              <div>DESCRIPCION</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;empresaRazonSocial&gt;</div>
                          </td>
                          <td>
                              <div>Razon social de la empresa en que pertenece el trabajador.</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;empresaRut&gt;</div>
                          </td>
                          <td>
                              <div>Rut de la empresa en que pertenece el trabajador.</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;empresaDireccion&gt;</div>
                          </td>
                          <td>
                              <div>Direccion de la empresa</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;empresaCiudad&gt;</div>
                          </td>
                          <td>
                              <div>Ciudad de la empresa.</div>
                          </td>
                      </tr>
                  </tbody>
              </table>
              <div>&nbsp;</div>
              <div>&nbsp;</div>
              <div><strong>DATOS DEL TRABAJADOR</strong></div>
              <table class="table table-stripped">
                  <tbody>
                      <tr>
                          <td>
                              <div>ETIQUETA</div>
                          </td>
                          <td>
                              <div>DESCRIPCION</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorNombre&gt;</div>
                          </td>
                          <td>
                              <div>Razon social de la empresa en que pertenece el trabajador.</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorRut&gt;</div>
                          </td>
                          <td>
                              <div>Rut de la empresa en que pertenece el trabajador.</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorDireccion&gt;</div>
                          </td>
                          <td>
                              <div>Dirección del trabajador.</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorCiudad&gt;</div>
                          </td>
                          <td>
                              <div>Ciudad del trabajador.</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorNacionalidad&gt;</div>
                          </td>
                          <td>
                              <div>Nacionalidad del trabajador</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorNacimiento&gt;</div>
                          </td>
                          <td>
                              <div>Fecha de nacimiento del trabajador en formato ej: 6 de Julio de 1990</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorFiniquito&gt;</div>
                          </td>
                          <td>
                              <div>Monto de finiquito del trabajador en formato $ ##.### (miles y pesos)</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorEstadoCivil&gt;</div>
                          </td>
                          <td>
                              <div>Estado civil del trabajador</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorHorario&gt;</div>
                          </td>
                          <td>
                              <div>Texto de titulo del horario del trabajador (para la impresión en contratos)</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorSueldoBase&gt;</div>
                          </td>
                          <td>
                              <div>Monto de sueldo base del trabajador en formato $ ##.### (miles y pesos)</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;trabajadorGratificacion&gt;</div>
                          </td>
                          <td>
                              <div>Monto de la gratificación del trabajador en formato $ ##.### (miles y pesos)</div>
                          </td>
                      </tr>
                  </tbody>
              </table>
              <div>&nbsp;</div>
              <div><strong>OTROS DATOS&nbsp;</strong></div>
              <table class="table table-stripped">
                  <tbody>
                      <tr>
                          <td>
                              <div>ETIQUETA</div>
                          </td>
                          <td>
                              <div>DESCRIPCION</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;fecha1&gt;</div>
                          </td>
                          <td>
                              <div>Fecha del dia con formato dd-mm-yyyy EJ: 01-01-2018.</div>
                          </td>
                      </tr>
                      <tr>
                          <td>
                              <div>&lt;fecha2&gt;</div>
                          </td>
                          <td>
                              <div>Fecha del día con formato “18 de Septiembre de 2018"&nbsp;</div>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>

      
<script>
$("#frmCrear").submit(function(e){
    $('#textoDocumento').text( $('#textoDocumento').Editor("getText") );
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

$(window).load(function(){
    $('#textoDocumento').Editor("setText", $("#textoDocumento").val() );    
})
         
</script>
      