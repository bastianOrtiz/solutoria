<!-- Content Wrapper. Contains page content -->    
<style>
input.form-control.loading{
    background: url(<?php echo BASE_URL; ?>/public/img/loading_negro.gif) no-repeat 99% center;
}
</style>    
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> INGRESAR <?php echo strtoupper($entity) ?> </h1>
          <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
          
            <?php 
            /*
            if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
            $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
            */
            if( @$_POST['response'] ){
            $array_reponse = @$_POST['response'];
            ?>
            <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4>	<i class="icon fa fa-check"></i> Mensaje:</h4>
                <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
            </div>
            <?php }?> 
            
        </section>
                
        <section class="content">
            <form role="form" id="frmCrear" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="new" />
            
            <ul class="nav nav-tabs">
                <li class="active"><a  onclick="javascript: return void(0); window.location.hash = '#tab_1'" href="#tab_1" data-toggle="tab">Información Personal</a></li>
                <li><a href="#tab_2" onclick="javascript: return void(0); window.location.hash = '#tab_2'" data-toggle="tab">Información Contractual</a></li>                            
                
                <!-- Inactivos mientras no se ingrese el trabajador -->
                <li><a class="inactive" href="javascript: void(0)" data-toggle="tooltip" title="Debe ingresar la información básica del trabajador primero, antes de editar esta sección">Informacion Previsional</a></li>
                <li><a class="inactive" href="javascript: void(0)" data-toggle="tooltip" title="Debe ingresar la información básica del trabajador primero, antes de editar esta sección">Debes y Haberes</a></li>
                <li><a class="inactive" href="javascript: void(0)" data-toggle="tooltip" title="Debe ingresar la información básica del trabajador primero, antes de editar esta sección">Ausencias y Atrasos</a></li>
            
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                          <div class="col-md-12">                        
                              <!-- general form elements -->
                              <div class="box box-primary">                
                                <div class="box-header">
                                  <h3 class="box-title">Informacion Personal</h3>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body">                                   
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">                                
                                                    <label for="fotoTrabajador">Foto</label>
                                                    <br class="clear" />
                                                    <img class="round" id="previewFotoTrabajador" src="<?php echo NO_IMG_PERFIL ?>"/>
                                                
                                                    <div class="input_file">
                                                        <span></span>
                                                        <input type="file" accept="image/*" id="fotoAlumno" name="fotoAlumno" onchange="loadFile(event)" />
                                                    </div>                                                                        
                                                    <p class="help-block" style="font-size: 12px;">(Archivo en JPG o PNG, máximo 500Kb ó 300x300 pixeles)</p>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                      <label for="nombreTrabajador">Nombres</label>
                                                      <input type="text" class="form-control required" id="nombreTrabajador" name="nombreTrabajador" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label for="apellidoPaternoTrabajador">Apellido Paterno</label>
                                                      <input type="text" class="form-control required" id="apellidoPaternoTrabajador" name="apellidoPaternoTrabajador" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label for="apellidoMaternoTrabajador">Apellido Materno</label>
                                                      <input type="text" class="form-control required" id="apellidoMaternoTrabajador" name="apellidoMaternoTrabajador" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rutTrabajador">Rut</label>
                                                        <input type="text" class="form-control required" id="rutTrabajador" name="rutTrabajador" placeholder="(SIN puntos, CON guión)" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label class="top">Sexo</label>
                                                      <div class="radio">                            
                                                        <label>
                                                          <input type="radio" class="rbtSexo" name="sexoTrabajador[]" id="sexoTrabajadorM" value="1" checked="checked" />
                                                          <i class="fa fa-male"></i> Masculino
                                                        </label>
                                                        &nbsp; &nbsp; &nbsp; 
                                                        <label>
                                                          <input type="radio" class="rbtSexo" name="sexoTrabajador[]" id="sexoTrabajadorF" value="0" />
                                                          <i class="fa fa-female"></i> Femenino
                                                        </label>
                                                      </div>
                                                      
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fechaNacimientoTrabajador">Fecha Nacimiento</label>
                                                    <input type="text" class="form-control required selector_fecha" id="fechaNacimientoTrabajador" name="fechaNacimientoTrabajador" placeholder="YYYY-mm-dd" readonly="" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="emailTrabajador">Email</label>
                                                    <input type="email" class="form-control" name="emailTrabajador" id="emailTrabajador" />                                
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="telefonoTrabajador">Teléfono Fijo / Celular</label>
                                                    <input type="text" class="form-control required" name="telefonoTrabajador" id="telefonoTrabajador" />                                
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="top">Extranjero</label>
                                                      <div class="radio">                            
                                                        <label>
                                                          <input type="radio" class="rbtExtranjero" name="extranjeroTrabajador[]" id="extranjeroTrabajadorSI" value="1" />
                                                          SI
                                                        </label>
                                                        &nbsp; &nbsp; &nbsp; 
                                                        <label>
                                                          <input type="radio" class="rbtExtranjero" name="extranjeroTrabajador[]" id="extranjeroTrabajadorNO" value="0" checked="" />
                                                          NO
                                                        </label>
                                                      </div>
                                                      
                                                </div>
                                                
                                                <div id="extranjeria_trabajador" class="collapse">
                                                    <div class="form-group">
                                                        <label for="nacionalidadTrabajador">Nacionalidad</label>
                                                        <select class="form-control" name="nacionalidadTrabajador" id="nacionalidadTrabajador">
                                                            <?php foreach( $paises as $p ){ ?>
                                                            <option value="<?php echo $p['id'] ?>"><?php echo $p['nombre'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="pasaporteTrabajador">Pasaporte</label>
                                                      <input type="text" class="form-control" id="pasaporteTrabajador" name="pasaporteTrabajador" />
                                                    </div>
                                                </div>                                                                                                                                            
                                            </div>
                                        
                                            <div class="col-md-6">
                                                
                                                <div class="form-group">
                                                    <label for="direccionTrabajador">Dirección</label>
                                                    <input type="text" class="form-control required" name="direccionTrabajador" id="direccionTrabajador" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="regionTrabajador">Región</label>
                                                    <select class="form-control required" name="regionTrabajador" id="regionTrabajador">
                                                        <option value="">Seleccione Región</option>
                                                        <?php foreach($regiones as $r){ ?>
                                                        <option value="<?php echo $r['id'] ?>"><?php echo $r['nombre'] ?></option>
                                                        <?php } ?>
                                                    </select>                                                    
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="comunaTrabajador">Comuna</label>
                                                    <select disabled="disabled" class="form-control required" name="comunaTrabajador" id="comunaTrabajador">
                                                        <option value="">Seleccione Comuna</option>
                                                        <?php foreach($comunas as $c){ ?>
                                                        <option data-region="<?php echo $c['region_id'] ?>" value="<?php echo $c['id'] ?>"><?php echo $c['nombre'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="emergenciaTrabajador">En caso de emergencia</label>
                                                    <textarea class="form-control required" placeholder="Información relevante en caso de emergencias" name="emergenciaTrabajador" id="emergenciaTrabajador" style="height: 100px;"></textarea>
                                                </div>

                                                 <div class="form-group">
                                                    <label for="comunaTrabajador">Estado Civil</label>
                                                    <select class="form-control required" name="estadoCivil" id="estadoCivil">
                                                        <option value="">Seleccione Estado Civil</option>
                                                        <option value="Soltero">Soltero(a)</option>
                                                        <option value="Casado">Casado(a)</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                
                                                                                                      
                                </div>
                              </div><!-- /.box -->
                            </div>                        
                    </div>                
              </div><!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                    <div class="row">
                          <div class="col-md-12">                        
                              <div class="box box-primary">                
                                <div class="box-header">
                                  <h3 class="box-title">Informacion Contractual</h3>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sucursalTrabajador">Sucursal</label>                                                                                        
                                            <select class="form-control required" name="sucursalTrabajador" id="sucursalTrabajador">
                                            <option value="">Seleccione Sucursal</option>
                                            <?php foreach( $sucursales as $d ){ ?>
                                            <option value="<?php echo $d['id'] ?>"><?php echo $d['nombre'] ?></option>
                                            <?php } ?>
                                            </select>                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="departamentoTrabajador">Departamento</label>
                                            <select class="form-control required" name="departamentoTrabajador" id="departamentoTrabajador">
                                            <option value="">Seleccione Departamento</option>
                                            <?php foreach( $deptos as $d ){ ?>
                                            <option value="<?php echo $d['id'] ?>"><?php echo $d['nombre'] ?></option>
                                            <?php } ?>
                                            </select>                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="cargoTrabajador">Cargo</label>
                                            <select class="form-control required" name="cargoTrabajador" id="cargoTrabajador">
                                            <option value="">Seleccione Cargo</option>
                                            <?php foreach( $cargos as $cargo ){ ?>
                                            <option value="<?php echo $cargo['id'] ?>"><?php echo $cargo['nombre'] ?></option>
                                            <?php } ?>
                                            </select>                                            
                                        </div>                                        
                                        <div class="form-group">
                                            <label for="centroCostoTrabajador">Centro Costo</label>
                                            <select class="form-control required" name="centroCostoTrabajador" id="centroCostoTrabajador">
                                            <option value="">Seleccione Centro Costo</option>
                                            <?php foreach( $ccostos as $costo ){ ?>
                                            <option value="<?php echo $costo['id'] ?>"><?php echo $costo['nombre'] ?></option>
                                            <?php } ?>
                                            </select>                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="horarioTrabajador">Horario</label>
                                            <select class="form-control required" name="horarioTrabajador" id="horarioTrabajador">
                                                <option value="">Seleccione Horario</option>
                                                <?php foreach( $horario as $h ){ ?>
                                                <option value="<?php echo $h['id'] ?>"><?php echo $h['nombre'] ?></option>
                                                <?php } ?>
                                            </select>                                                                                        
                                        </div>
                                        
                                        <?php if( relojControlSync() ){ ?>
                                        <div class="form-group">
                                            <label for="relojControlIdTrabajador">ID Relojcontrol</label>
                                            <input type="number" class="form-control required" name="relojControlIdTrabajador" id="relojControlIdTrabajador" value="<?php echo $max_id_relojcontrol; ?>" />                                                                                        
                                        </div>
                                        <?php } else { ?>
                                        <input type="hidden" name="relojControlIdTrabajador" id="relojControlIdTrabajador" value="0" />
                                        <?php } ?>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="diasVacacionesTrabajador">Dias vacaciones/Año</label>
                                                    <input name="diasVacacionesTrabajador" id="diasVacacionesTrabajador" class="form-control required" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="vacacionesProgresivasTrabajador">Vacaciones Progresivas</label>
                                                    <input name="vacacionesProgresivasTrabajador" id="vacacionesProgresivasTrabajador" class="form-control required" />
                                                </div>
                                            </div>
                                        </div>                                                                                
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sueldoBaseTrabajador">Sueldo Base</label>
                                                    <input name="sueldoBaseTrabajador" id="sueldoBaseTrabajador" class="form-control required" />                                                                                          
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="top"> Gratificación </label>
                                                      <div class="radio">                            
                                                        <label>
                                                          <input type="radio" class="rbtGratificacion" name="gratificacionTrabajador[]" id="gratificacionTrabajadorSI" value="1" checked />
                                                          SI
                                                        </label>
                                                        &nbsp; &nbsp; &nbsp; 
                                                        <label>
                                                          <input type="radio" class="rbtGratificacion" name="gratificacionTrabajador[]" id="gratificacionTrabajadorNO" value="0" />
                                                          NO
                                                        </label>
                                                      </div>                                                                                
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="top"> Salario Estable</label>
                                                      <div class="radio">                            
                                                        <label>
                                                          <input type="radio" class="rbtSalarioEstable" name="salarioEstableTrabajador[]" id="salarioEstableTrabajadorSI" value="1" />
                                                          SI
                                                        </label>
                                                        &nbsp; &nbsp; &nbsp; 
                                                        <label>
                                                          <input type="radio" class="rbtSalarioEstable" name="salarioEstableTrabajador[]" id="salarioEstableTrabajadorNO" value="0" checked="" />
                                                          NO
                                                        </label>
                                                      </div> 
                                                                               
                                                </div>
                                        
                                                <div class="form-group">
                                                    <label class="top"> Marca Tarjeta </label>
                                                      <div class="radio">                            
                                                        <label>
                                                          <input type="radio" class="rbtMarcaTarjeta" name="marcaTarjetaTrabajador[]" id="marcaTarjetaTrabajadorSI" value="1" />
                                                          SI
                                                        </label>
                                                        &nbsp; &nbsp; &nbsp; 
                                                        <label>
                                                          <input type="radio" class="rbtMarcaTarjeta" name="marcaTarjetaTrabajador[]" id="marcaTarjetaTrabajadorNO" value="0" checked="" />
                                                          NO
                                                        </label>
                                                      </div>    
                                                                            
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="top">Es Accionista</label>
                                                  <div class="radio">                            
                                                    <label>
                                                      <input type="radio" class="rbtAccionista" name="accionistaTrabajador[]" id="accionistaTrabajadorSI" value="1" />
                                                      SI
                                                    </label>
                                                    &nbsp; &nbsp; &nbsp; 
                                                    <label>
                                                      <input type="radio" class="rbtAccionista" name="accionistaTrabajador[]" id="accionistaTrabajadorNO" value="0" checked="" />
                                                      NO
                                                    </label>
                                                  </div>
                                                                            
                                                </div>
                                            
                                                <div class="form-group">
                                                <label class="top">Trabajador Agricola</label>
                                                  <div class="radio">                            
                                                    <label>
                                                      <input type="radio" class="rbtAgricola" name="agricolaTrabajador[]" id="agricolaTrabajadorSI" value="1" />
                                                      SI
                                                    </label>
                                                    &nbsp; &nbsp; &nbsp; 
                                                    <label>
                                                      <input type="radio" class="rbtAgricola" name="agricolaTrabajador[]" id="agricolaTrabajadorNO" value="0" checked="" />
                                                      NO
                                                    </label>
                                                  </div>    
                                                                        
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="top"> Es jefe y puede revisar Reloj Control</label>
                                                      <div class="radio">                            
                                                        <label>
                                                          <input type="radio" class="rbtRevisaReloj" name="revisaRelojTrabajador[]" id="revisaRelojTrabajadorSI" value="1" />
                                                          SI
                                                        </label>
                                                        &nbsp; &nbsp; &nbsp; 
                                                        <label>
                                                          <input type="radio" class="rbtRevisaReloj" name="revisaRelojTrabajador[]" id="revisaRelojTrabajadorNO" value="0" checked="" />
                                                          NO
                                                        </label>
                                                      </div>    
                                                                            
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="top"> Puede ver Full Jerarquia </label>
                                                  <div class="radio">
                                                    <label>
                                                      <input type="radio" class="rbtFullJerarquia" name="fullJerarquiaTrabajador[]" id="fullJerarquiaTrabajadorSI" value="1" />
                                                      SI
                                                    </label>
                                                    &nbsp; &nbsp; &nbsp; 
                                                    <label>
                                                      <input type="radio" class="rbtFullJerarquia" name="fullJerarquiaTrabajador[]" id="fullJerarquiaTrabajadorNO" value="0" checked="" />
                                                      NO
                                                    </label>
                                                  </div>    
                                                                        
                                                </div>
                                            </div>
                                        </div>
                                        
                                         
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipoContratoTrabajador">Tipo Contrato</label>
                                            <select class="form-control required" name="tipoContratoTrabajador" id="tipoContratoTrabajador">
                                                <option value="">Seleccione Tipo Contrato</option>
                                                <option value="1">A Plazo Fijo</option>
                                                <option value="2">Indefinido</option>
                                            </select>                                                                                        
                                        </div>
                                        <div class="form-group">
                                            <label for="inicioContratoTrabajador">Inicio Contrato</label>
                                            <input type="text" class="form-control required selector_fecha" id="inicioContratoTrabajador" name="inicioContratoTrabajador" placeholder="YYYY-mm-dd" readonly="" />
                                        </div>
                                        <div class="form-group" id="fin_contrato_group" style="display: none;">
                                            <label for="finContratoTrabajador">FIN Contrato</label>
                                            <input type="text" class="form-control selector_fecha" id="finContratoTrabajador" name="finContratoTrabajador" placeholder="YYYY-mm-dd" readonly="" />
                                        </div>
                                        
                                        <div class="box" id="box_contratos">
                                            <div class="col-md-10 nopadding">
                                                <div class="form-group">
                                                    <label for="contratosTrabajador">Contratos</label>
                                                    <select disabled="disabled" class="form-control" name="contratosTrabajador" id="contratosTrabajador">
                                                        <option>Debe ingresar al trabajador primero</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 nopadding">
                                                <button disabled="disabled" class="btn btn-default btn-add-contrato" type="button"><i class="fa fa-plus-circle"></i></button>
                                            </div>
                                            <div class="form-group">
                                                <table class="table table-striped table-bordered table-curved" id="table_contratos_trabajador">                                                                                                        
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="factorHoraExtraTrabajador">Factor Hora Extra</label>
                                            <input type="text" class="form-control required" id="factorHoraExtraTrabajador" name="factorHoraExtraTrabajador" />
                                        </div>
                                        <div class="form-group">
                                            <label for="factorHoraExtraEspecial">Factor Hora Extra Especial</label>
                                            <input type="text" class="form-control required" id="factorHoraExtraEspecial" name="factorHoraExtraEspecial" />
                                        </div>
                                        <div class="form-group">
                                            <label for="tipoPagoTrabajador">Tipo de pago</label>
                                            <select name="tipoPagoTrabajador" id="tipoPagoTrabajador" class="form-control required">
                                                <option value="">Seleccione</option>
                                                <?php foreach( $tipopago as $tp ){ ?>
                                                <option value="<?php echo $tp['id'] ?>"><?php echo $tp['nombre'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="row" id="custom_fields"></div>
                                        
                                    </div>
                                                               
                                </div>                                
            
                              </div><!-- /.box -->
                            </div>                        
                    </div>
              </div><!-- /.tab-pane -->
                                
            </div>
            
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Guardar Datos Trabajador</button>                            
            </div>
            
            </form>
        </section>
        
      </div><!-- /.content-wrapper -->
      
<script>

$("#relojControlIdTrabajador").blur(function(){    
    $.ajax({
    	type: "POST",
    	url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    	data:"relojid="+$(this).val()+"&action=valida_relojcontrol_id",
        dataType: 'json',
        beforeSend: function(){
            $("#relojControlIdTrabajador").addClass('loading');
        },
        success: function (json) {
            $("#relojControlIdTrabajador").removeClass('loading');
            if( json.exist == 'TRUE' ){
                $("#relojControlIdTrabajador").parent().addClass('has-error');
                $("#relojControlIdTrabajador").parent().find('label').append(' <small>(El ID relojcontrol ya existe)</small>');
            } else {
                $("#relojControlIdTrabajador").parent().removeClass('has-error');
                $("#relojControlIdTrabajador").parent().find('label').find('small').remove();
            }
        }
    })    
})

$("#rutTrabajador").blur(function(){    
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

$("#tipoContratoTrabajador").change(function(){
    if( $(this).val() == 1 ){
        $("#finContratoTrabajador").addClass('requiered');
    }
})



$("#frmCrear").submit(function(e){
    e.preventDefault();
    error = 0;        
    found_first_empty = 0;
    $("#tab_1 .required, #tab_2 .required").each(function(){
        if( $(this).val() == "" ){
            if( found_first_empty == 0 ){
                tab_id = $(this).closest('.tab-pane').attr('id');
                $(".nav-tabs a[href='#"+tab_id+"']").click();
                found_first_empty = 1;
            }
            
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

$(document).ready(function(){
    
    $("#tipoPagoTrabajador").change(function(){    
        var id_tipopago = $(this).val();
        $(".row#custom_fields").empty();
        cargaCamposPersonalizados(id_tipopago);
    })
    
    if( window.location.hash.length > 0 ){
        hash = window.location.hash;
        hash = hash.replace("#","");
        $(".nav-tabs a[href=#" + hash + "]").click();
    }
    
    $(".input_file input").change(function(){
        $(this).parent().find('span').text( $(this).val() );
    })
    
    $(".selector_fecha").datepicker({
        startView : 'decade',
        autoclose : true,
        format : 'yyyy-mm-dd'
    });
    
    $("#regionTrabajador").change(function(){
        idRegion = $(this).val();
        $("#comunaTrabajador").val('');
        $("#comunaTrabajador").empty();
        if( idRegion != "" ){
            cargaComuna(idRegion);  
        } else {
            $("#comunaTrabajador").attr('disabled','disabled');
        }            
    })
    
    if( $("#regionTrabajador").val() != "" ){
        cargaComuna($("#regionTrabajador").val());
    }
    
    $(".rbtExtranjero").click(function(){
        if( $(this).val() == 1 ){
            $("#extranjeria_trabajador").slideDown(200); 
            $("#nacionalidadTrabajador, #pasaporteTrabajador").addClass('required');   
        } else {
            $("#extranjeria_trabajador").slideUp(200);
            $("#nacionalidadTrabajador, #pasaporteTrabajador").removeClass('required');
        }
    })
    
    $("#tipoContratoTrabajador").change(function(){
        if( $(this).val() == 1 ){
            $("#fin_contrato_group").slideDown(300)
            $("#finContratoTrabajador").val('<?php echo date('Y-m-d'); ?>');
        } else {
            $("#fin_contrato_group").slideUp(300);
            $("#finContratoTrabajador").val('0000-00-00');
        }
    })
    
             
})


function cargaCamposPersonalizados(id_tipopago){
    if( id_tipopago != "" ){
        $.ajax({
        	type: "POST",
        	url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
        	data:"id_tipopago="+id_tipopago+"&action=get_tipopagos_fields",
            dataType: 'json',
            beforeSend: function(){
                $(".row#custom_fields").html('<i class="fa fa-refresh fa-spin" style="margin:0px 0px 0px 20px"></i>');
            },
            success: function (json) {
                $(".row#custom_fields").empty();
                $.each(json.registros, function(key,valor) {                    
                    html = '<div class="col-md-6">';
                    html += '   <div class="form-group">';
                    html += '       <label>'+valor.name+'</label>';
                    html += '       <input type="text" class="form-control required" id="'+valor.key+'" value="" name="camposPersonalizadosTipoPago['+valor.key+']" />';
                    html += '   </div>';
                    html += '</div>';
                    $(".row#custom_fields").append(html);
                })                
            }
        })
    }
}
      

function cargaComuna(idRegion){
    $.post("<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>", {
        regid: idRegion,
        action: 'get_comuna'
    }, function (json) {
        html_options = "<option value=''>Seleccione Comuna</option>";
        $.each(json.registros, function(key,valor) {                    
            html_options += '<option value="' + valor.id + '">' + valor.nombre + '</option>';
        })
        $("#comunaTrabajador").html( html_options );
        $("#comunaTrabajador").removeAttr('disabled');
    },'json')  
}


function loadFile(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('previewFotoTrabajador');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};
         
</script>
      