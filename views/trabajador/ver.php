<!-- Content Wrapper. Contains page content -->    
<div id="trabajador_detail">                          
      <div class="content-wrapper">
        
        <section class="content-header">
        <h1> Editar <?php echo strtolower($entity) ?>: <strong><?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?></strong> </h1>
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
            
            <ul class="nav nav-tabs">
              <li class="active"><a  onclick="javascript: window.location.hash = '#tab_1'" href="#tab_1" data-toggle="tab">Información Personal</a></li>
              <li><a href="#tab_2" onclick="javascript: window.location.hash = '#tab_2'" data-toggle="tab">Información Contractual</a></li>
              <li><a href="#tab_3" onclick="javascript: window.location.hash = '#tab_3'" data-toggle="tab">Informacion Previsional</a></li>
              <li><a href="#tab_4" onclick="javascript: window.location.hash = '#tab_4'" data-toggle="tab">Debes y Haberes</a></li>
              <li><a href="#tab_5" onclick="javascript: window.location.hash = '#tab_5'" data-toggle="tab">Ausencias y Atrasos</a></li>              
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
                                                    <img class="round" id="previewFotoTrabajador" src="<?php echo BASE_URL ?>/private/imagen.php?f=<?php echo base64_encode(base64_encode(date('Ymd')) . $trabajador['id']) ?>&t=<?php echo base64_encode('m_trabajador') ?>" />                                                                                                                                                                            
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                      <label for="nombreTrabajador">Nombres</label>
                                                      <input type="text" class="form-control required" value="<?php echo $trabajador['nombres'] ?>" id="nombreTrabajador" name="nombreTrabajador" disabled />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label for="apellidoPaternoTrabajador">Apellido Paterno</label>
                                                      <input type="text" class="form-control required" value="<?php echo $trabajador['apellidoPaterno'] ?>" id="apellidoPaternoTrabajador" name="apellidoPaternoTrabajador"  disabled />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                      <label for="apellidoMaternoTrabajador">Apellido Materno</label>
                                                      <input type="text" class="form-control required" value="<?php echo $trabajador['apellidoMaterno'] ?>" id="apellidoMaternoTrabajador" name="apellidoMaternoTrabajador" disabled />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rutTrabajador">Rut</label>
                                                        <input type="text" class="form-control required" value="<?php echo $trabajador['rut'] ?>" id="rutTrabajador" name="rutTrabajador" placeholder="(SIN puntos, CON guión)" disabled />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label class="top">Sexo</label>
                                                      <div class="radio radio_sex">                            
                                                        <label>
                                                          <input type="radio" class="rbtSexo" name="sexoTrabajador[]" id="sexoTrabajadorM" value="1" disabled />
                                                          <i class="fa fa-male"></i> Masculino
                                                        </label>
                                                        &nbsp; &nbsp; &nbsp; 
                                                        <label>
                                                          <input type="radio" class="rbtSexo" name="sexoTrabajador[]" id="sexoTrabajadorF" value="0" disabled />
                                                          <i class="fa fa-female"></i> Femenino
                                                        </label>
                                                      </div>
                                                      <script>
                                                        $(".radio_sex label").hide();
                                                        $("input.rbtSexo[value=<?php echo $trabajador['sexo'] ?>]").parent('label').show();
                                                        $("input.rbtSexo[value=<?php echo $trabajador['sexo'] ?>]").prop('checked',true) 
                                                    </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fechaNacimientoTrabajador">Fecha Nacimiento</label>
                                                    <input type="text" class="form-control required datepicker" value="<?php echo $trabajador['fechaNacimiento'] ?>" id="fechaNacimientoTrabajador" name="fechaNacimientoTrabajador" placeholder="YYYY-mm-dd" readonly="" />
                                                </div>
                                                <div class="form-group">
                                                    <label for="emailTrabajador">Email</label>
                                                    <input type="email" class="form-control required" value="<?php echo $trabajador['email'] ?>" name="emailTrabajador" id="emailTrabajador" disabled />                                
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="telefonoTrabajador">Teléfono</label>
                                                    <input type="text" class="form-control required" value="<?php echo $trabajador['telefono'] ?>" name="telefonoTrabajador" id="telefonoTrabajador" disabled />
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="top">Extranjero</label>
                                                      <div class="radio radio_extranjero">                            
                                                        <label>
                                                          <input type="radio" class="rbtExtranjero" name="extranjeroTrabajador[]" id="extranjeroTrabajadorSI" value="1" disabled />
                                                          SI
                                                        </label>
                                                        &nbsp; &nbsp; &nbsp; 
                                                        <label>
                                                          <input type="radio" class="rbtExtranjero" name="extranjeroTrabajador[]" id="extranjeroTrabajadorNO" value="0" disabled />
                                                          NO
                                                        </label>
                                                      </div>
                                                      <script> 
                                                      $(".radio_extranjero label").hide();
                                                      $("input.rbtExtranjero[value=<?php echo $trabajador['extranjero'] ?>]").parent('label').show();
                                                      $("input.rbtExtranjero[value=<?php echo $trabajador['extranjero'] ?>]").prop('checked',true) 
                                                      </script>
                                                </div>
                                                
                                                <div id="extranjeria_trabajador" class="collapse">
                                                    <div class="form-group">
                                                        <label for="nacionalidadTrabajador">Nacionalidad</label>
                                                        <input type="text" value="<?php echo fnGetNombre($trabajador['idNacionalidad'],'m_pais',false); ?>" class="form-control" disabled />                                                                                                                
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="pasaporteTrabajador">Pasaporte</label>
                                                      <input type="text" class="form-control" value="<?php echo $trabajador['pasaporte'] ?>" id="pasaporteTrabajador" name="pasaporteTrabajador" disabled />
                                                    </div>
                                                </div>
                                                <?php if( $trabajador['extranjero'] == 1): ?>
                                                <script> 
                                                    $("#extranjeria_trabajador").show();
                                                    $("#extranjeria_trabajador select, #extranjeria_trabajador input").addClass('required'); 
                                                </script>
                                                <?php endif; ?>                                                                                            
                                            </div>
                                        
                                            <div class="col-md-6">
                                                
                                                <div class="form-group">
                                                    <label for="direccionTrabajador">Dirección</label>
                                                    <input type="text" class="form-control required" value="<?php echo $trabajador['direccion'] ?>" name="direccionTrabajador" id="direccionTrabajador" disabled />
                                                </div>
                                                <div class="form-group">
                                                    <label for="regionTrabajador">Región</label>
                                                    <input type="text" value="<?php echo fnGetNombre(fnGetRegion($trabajador['comuna_id']), 'm_region', false) ?>" class="form-control" disabled />
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="comunaTrabajador">Comuna</label>
                                                    <input type="text" value="<?php echo fnGetNombre($trabajador['comuna_id'], 'm_comuna', false) ?>" class="form-control" disabled />
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="emergenciaTrabajador">En caso de emergencia</label>
                                                    <textarea class="form-control required" placeholder="Información relevante en caso de emergencias" name="emergenciaTrabajador" id="emergenciaTrabajador" style="height: 100px;" disabled><?php echo $trabajador['emergencia'] ?></textarea>
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
                                            <input type="text" value="<?php echo fnGetNombre($trabajador['sucursal_id'],'m_sucursal',false) ?>" class="form-control" disabled />
                                        </div>
                                        <div class="form-group">
                                            <label for="departamentoTrabajador">Departamento</label>
                                            <input type="text" value="<?php echo fnGetNombre($trabajador['departamento_id'],'m_departamento',false) ?>" class="form-control" disabled />                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="cargoTrabajador">Cargo</label>
                                            <input type="text" value="<?php echo fnGetNombre($trabajador['cargo_id'],'m_cargo',false) ?>" class="form-control" disabled />                                            
                                        </div>                                        
                                        <div class="form-group">
                                            <label for="centroCostoTrabajador">Centro Costo</label>
                                            <input type="text" value="<?php echo fnGetNombre($trabajador['centrocosto_id'],'m_centrocosto',false) ?>" class="form-control" disabled />                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="horarioTrabajador">Horario</label>
                                            <input type="text" value="<?php echo fnGetNombre($trabajador['horario_id'],'m_horario',false) ?>" class="form-control" disabled />
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="relojControlIdTrabajador">ID Relojcontrol</label>
                                            <input type="text" value="<?php echo $trabajador['relojcontrol_id']; ?>" class="form-control" disabled /> 
                                                                                                                                   
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="diasVacacionesTrabajador">Dias vacaciones/Año</label>
                                                    <input name="diasVacacionesTrabajador" id="diasVacacionesTrabajador" value="<?php echo $trabajador['diasVacaciones'] ?>" class="form-control required" disabled />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="vacacionesProgresivasTrabajador">Vacaciones Progresivas</label>
                                                    <input name="vacacionesProgresivasTrabajador" id="vacacionesProgresivasTrabajador" value="<?php echo $trabajador['diasVacacionesProgresivas'] ?>" class="form-control required" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="sueldoBaseTrabajador">Sueldo Base</label>                                            
                                            <div class="input-group" style="width: 100%;">
                                                <input type="password" name="sueldoBaseTrabajador" id="sueldoBaseTrabajador" value="<?php echo $trabajador['sueldoBase'] ?>" class="form-control" disabled />
                                                <span class="input-group-addon">
                                                    <a href="#" id="view_sueldo" class="fa fa-eye"></a>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="top"> Salario Estable</label>
                                                      <div class="radio radio_salario">                            
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
                                                      <script>
                                                        $(".radio_salario label").hide(); 
                                                        $("input.rbtSalarioEstable[value=<?php echo $trabajador['salarioEstable'] ?>]").parent('label').show();
                                                        $("input.rbtSalarioEstable[value=<?php echo $trabajador['salarioEstable'] ?>]").prop('checked',true) 
                                                      </script>                         
                                                </div>
                                        
                                                <div class="form-group">
                                                    <label class="top"> Marca Tarjeta </label>
                                                      <div class="radio radio_marca">                            
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
                                                      <script> 
                                                      $(".radio_marca label").hide();
                                                      $("input.rbtMarcaTarjeta[value=<?php echo $trabajador['marcaTarjeta'] ?>]").parent('label').show();
                                                      $("input.rbtMarcaTarjeta[value=<?php echo $trabajador['marcaTarjeta'] ?>]").prop('checked',true) 
                                                      </script>                      
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label class="top">Es Accionista</label>
                                                  <div class="radio radio_accionista">                            
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
                                                  <script> 
                                                  $(".radio_accionista label").hide();
                                                  $("input.rbtAccionista[value=<?php echo $trabajador['accionista'] ?>]").parent('label').show();
                                                  $("input.rbtAccionista[value=<?php echo $trabajador['accionista'] ?>]").prop('checked',true)
                                                  </script>                          
                                                </div>
                                            
                                                <div class="form-group">
                                                <label class="top">Trabajador Agricola</label>
                                                  <div class="radio radio_agricola">                            
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
                                                  <script> 
                                                  $(".radio_agricola label").hide();
                                                  $("input.rbtAgricola[value=<?php echo $trabajador['agricola'] ?>]").parent('label').show();
                                                  $("input.rbtAgricola[value=<?php echo $trabajador['agricola'] ?>]").prop('checked',true)                                                  </script>                      
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipoContratoTrabajador">Tipo Contrato</label>
                                            <input type="text" value="<?php echo ($trabajador['tipocontrato_id']==1) ? 'A Plazo Fijo' : 'Indefinido';  ?>" class="form-control" disabled />
                                                                              
                                        </div>
                                        <div class="form-group">
                                            <label for="inicioContratoTrabajador">Inicio Contrato</label>
                                            <input type="text" class="form-control required" value="<?php echo $trabajador['fechaContratoInicio'] ?>" id="inicioContratoTrabajador" name="inicioContratoTrabajador" placeholder="YYYY-mm-dd" disabled />
                                        </div>
                                        <div class="form-group">
                                            <label for="finContratoTrabajador">FIN Contrato</label>
                                            <input type="text" class="form-control" value="<?php echo $trabajador['fechaContratoFin'] ?>" id="finContratoTrabajador" name="finContratoTrabajador" placeholder="YYYY-mm-dd" disabled />
                                        </div>
                                        
                                        <div class="box" id="box_contratos">
                                            <div class="form-group">
                                                <table class="table table-striped table-bordered table-curved" id="table_contratos_trabajador">
                                                    <thead>
                                                        <tr>
                                                        	<th> Contrato / Anexo </th>                                                   	
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach( $contratos_asignados as $ca ): ?>
                                                        <tr>  
                                                            <td> <?php echo fnGetNombre($ca['contrato_id'], 'm_contrato') ?> </td>
                                                            <td class="botones"> 
                                                                <button data-id="<?php echo $ca['id'] ?>" type="button" class="btn-view-contrato"><i class="fa fa-search"></i></button>                                                                 
                                                            </td>                                                            
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="factorHoraExtraTrabajador">Factor Hora Extra</label>
                                            <input type="text" class="form-control required" value="<?php echo $trabajador['factorHoraExtra'] ?>" id="factorHoraExtraTrabajador" name="factorHoraExtraTrabajador" disabled />
                                        </div>
                                        <div class="form-group">
                                            <label for="factorHoraExtraEspecial">Factor Hora Extra Especial</label>
                                            <input type="text" class="form-control required" value="<?php echo $trabajador['factorHoraExtraEspecial'] ?>" id="factorHoraExtraEspecial" name="factorHoraExtraEspecial" disabled />
                                        </div>
                                        <div class="form-group">
                                            <label for="tipoPagoTrabajador">Tipo de pago</label>
                                            <input type="text" class="form-control" value="<?php echo fnGetNombre($trabajador['tipopago_id'],'m_tipopago', false) ?>" disabled />                                        
                                        </div>
                                        
                                        <div class="row" id="custom_fields"></div>
                                        
                                    </div>
                                                               
                                </div>                                
            
                              </div><!-- /.box -->
                            </div>                        
                    </div>
              </div><!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">              
                <div class="row">
                  <div class="col-md-12">                        
                      <div class="box box-primary">                
                        <div class="box-header">
                          <h3 class="box-title">Informacion Previsional</h3>
                        </div><!-- /.box-header -->
                        
                        <div class="box-body">                                                                                                                                                     
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="datos_previsionales">   
                                        <div class="form-group">
                                            <label for="tipoTrabajadorPrev">Tipo trabajador</label>
                                            <input type="text" class="form-control" value="<?php echo fnGetNombre($trabajador['tipotrabajador_id'], 'm_tipotrabajador',0) ?>" disabled />
                                        </div>
                                        <div class="form-group">
                                            <label for="afpTrabajadorPrev">AFP</label>
                                            <input type="text" class="form-control" value="<?php echo fnGetNombre($datos_prev['afp_id'],'m_afp',0) ?>" disabled />
                                        </div>
                                        <div class="form-group">
                                            <label for="cargasSimplesTrabajadorPrev">Cargas Simples</label>
                                            <input name="cargasSimplesTrabajadorPrev" id="cargasSimplesTrabajadorPrev" value="<?php echo $datos_prev['cargasSimples'] ?>" class="form-control required" disabled />
                                        </div>
                                        <div class="form-group">
                                            <label for="cargasMaternalesTrabajadorPrev">Cargas Maternales</label>
                                            <input name="cargasMaternalesTrabajadorPrev" id="cargasMaternalesTrabajadorPrev" value="<?php echo $datos_prev['cargasMaternales'] ?>" class="form-control required" disabled />
                                        </div>
                                        <div class="form-group">
                                            <label for="cargasInvalidezTrabajadorPrev">Cargas Invalidez</label>
                                            <input name="cargasInvalidezTrabajadorPrev" id="cargasInvalidezTrabajadorPrev" value="<?php echo $datos_prev['cargasInvalidez'] ?>" class="form-control required" disabled />
                                        </div>
                                    </div>
                                    
                                    <h4> Ingresar APV </h4>
                                    <div class="box" id="box_apvs" style="padding: 5px 10px;">
                                        <div class="form-group">
                                            <table class="table table-striped table-bordered table-curved" id="table_apv_trabajador">
                                                <thead>
                                                    <tr>
                                                    	<th> Institución </th>                                                   	
                                                        <th> Tipo Moneda </th>
                                                        <th> Monto </th>                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach( $apv as $a){ ?>
                                                    <tr>  
                                                        <td> <?php echo fnGetNombre($a['institucion_id'],'m_institucion', false) ?> </td>
                                                        <td> <?php echo fnGetNombre($a['tipomoneda_id'],'m_tipomoneda') ?> </td>
                                                        <td> <?php echo (number_format($a['monto'],0,'','.')) ?> </td>                                                                                                                    
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>                                      
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="datos_previsionales">       
                                        <h4 class="h4Salud"> Salud </h4>                                
                                        
                                        <?php if( $datos_prev['fonosa'] == 0 ){ ?>
                                        <div class="form-group">
                                            <div class="radio">
                                                <label>
                                                <input type="radio" name="optionsRadios[]" class="rbtSaludTrabajador" id="optionsRadios1" value="isapre" checked disabled />
                                                Isapre
                                                </label>
                                            </div>
                                        </div>                                        
                                        <div id="datosIsapre" class="collapse datosSalud">
                                            <div class="form-group">
                                                <input value="<?php echo fnGetNombre($datos_prev['isapre_id'],'m_isapre',0) ?>" class="form-control" disabled />                                                
                                            </div>
                                            <div class="form-group">
                                                <label for="tipoMonedaIsapreTrabajador">Tipo Moneda</label>
                                                <input value="<?php echo fnGetNombre($datos_prev['tipomoneda_id'],'m_tipomoneda',0) ?>" class="form-control" disabled />                                                                                                
                                            </div>
                                            <div class="form-group">
                                                <label for="planPesoTrabajadorSalud">Plan $</label>
                                                <input type="text" class="form-control" name="planPesoTrabajadorSalud" id="planPesoTrabajadorSalud" value="<?php echo $datos_prev['montoPlan'] ?>" disabled />
                                            </div>
                                        </div>
                                        
                                        
                                        <?php } else { ?>                                                                                
                                        <div class="form-group">
                                            <div class="radio">
                                                <label>
                                                <input type="radio" name="optionsRadios[]" class="rbtSaludTrabajador" id="optionsRadios1" value="fonasa" checked disabled />
                                                Fonasa
                                                </label>
                                            </div>
                                        </div>
                                        <div id="datosFonasa" class="collapse datosSalud">
                                            <div class="form-group">
                                                <label for="fonasaTramoTrabajadorFonasa">Tramo</label>
                                                <?php 
                                                $arr_fonasa_tramo = array(1 => 'A',2 => 'B',3 => 'C',4 => 'D'); 
                                                ?>
                                                <input type="text" value="<?php echo $arr_fonasa_tramo[$datos_prev['tramo_id']] ?>" class="form-control" disabled />                                                                                                
                                            </div>
                                        </div>
                                        <?php } ?>                                                                                                                        
                                        
                                        <div class="row">
                                            <h4> Cuenta 2 </h4>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="tipoMonedaCuenta2Trabajador">Tipo Moneda</label>
                                                    <input value="<?php echo fnGetNombre($datos_prev['tipomoneda2_id'],'m_tipomoneda',0) ?>" class="form-control" disabled />                                                                                                                                                         
                                                </div>                                            
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="montoCuenta2Trabajador">Monto</label>
                                                    <input name="montoCuenta2Trabajador" id="montoCuenta2Trabajador" value="<?php echo $datos_prev['montoCta2'] ?>" class="form-control" type="text" disabled />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="afpCuenta2TrabajadorPrev">AFP</label>
                                                    <input type="text" value="<?php echo fnGetNombre($datos_prev['cuenta2_id'],'m_afp',0) ?>" class="form-control" disabled />                                                                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>          
                        </div>                                
                
                      </div><!-- /.box -->
                    </div>                        
                </div>
              </div>
              <div class="tab-pane" id="tab_4">              
                    <div class="row">
                          <div class="col-md-12">                        
                              <div class="box box-primary">                
                                <div class="box-header">
                                  <h3 class="box-title">Debes y Haberes</h3>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body">
                                
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3 class="box-title"> Debes </h3>
                                            </div>
                                            
                                            <div class="box-body table-responsive">                                                
                                                <table class="table table-striped table-bordered" id="table_debe_trabajador">
                                        			<thead>
                                                    	<tr>
                                        					<th> Mes </th>
                                        					<th style="width: 40px"> Año </th>
                                                            <th> Cuota Actual </th>
                                                            <th> Total Cuotas</th>
                                                            <th> Descuento </th>
                                                            <th> Valor </th>                                                            
                                        				</tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach( $debes_trabajador as $dt ){ ?>
                                                        <tr id="tr_<?php echo $dt['id'] ?>">  
                                                            <td> <?php echo getNombreMes($dt['mesInicio']) ?> </td>
                                                            <td> <?php echo $dt['anoInicio'] ?> </td>
                                                            <td> <?php echo $dt['cuotaActual'] ?> </td>
                                                            <td> <?php echo $dt['cuotaTotal'] ?> </td>
                                                            <td> <?php echo fnGetNombre($dt['descuento_id'],'m_descuento') ?> </td>
                                                            <td> <?php echo $dt['valor'] ?> </td>                                                                                                                        
                                                        </tr>
                                                        <?php } ?>
                                        			</tbody>
                                        		</table>                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="box">
                                            <div class="box-header">
                                                <h3 class="box-title"> Haberes </h3>
                                            </div>
                                            
                                            <div class="box-body table-responsive">                                                
                                                <table class="table table-striped table-bordered" id="table_haber_trabajador">
                                        			<thead>
                                                    	<tr>
                                        					<th> Mes </th>
                                        					<th style="width: 40px"> Año </th>
                                                            <th> Cuota Actual </th>
                                                            <th> Total Cuotas</th>
                                                            <th> Haber </th>
                                                            <th> Valor </th>                                                            
                                        				</tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach( $haberes_trabajador as $dt ){ ?>
                                                        <tr id="tr_<?php echo $dt['id'] ?>">  
                                                            <td> <?php echo getNombreMes($dt['mesInicio']) ?> </td>
                                                            <td> <?php echo $dt['anoInicio'] ?> </td>
                                                            <td> <?php echo $dt['cuotaActual'] ?> </td>
                                                            <td> <?php echo $dt['cuotaTotal'] ?> </td>
                                                            <td> <?php echo fnGetNombre($dt['haber_id'],'m_haber') ?> </td>
                                                            <td> <?php echo $dt['valor'] ?> </td>                                                                                                                        
                                                        </tr>
                                                        <?php } ?>
                                        			</tbody>
                                        		</table>                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>                                    
                                                                                                      
                                </div>                                
            
                              </div><!-- /.box -->
                            </div>                        
                    </div>
              </div>
              
              <div class="tab-pane" id="tab_5">
                    <div class="row">
                          <div class="col-md-12">                        
                              <div class="box box-primary">                
                                <div class="box-header">
                                  <h3 class="box-title">Ausencias y Atrasos </h3>
                                </div><!-- /.box-header -->
                                
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <?php if( !relojControlSync() ){ ?>
                                        <div class="col-md-6" id="trabajadorMinutos">
                                            <input type="hidden" name="regid_ausencias" id="regid_ausencias" value="<?php echo $trabajador['id']; ?>" />
                                              
                                            <div class="row">
                                                <div class="col-md-6">                                          
                                                    <div class="form-group">
                                                      <label for="mesAusenciaAtraso">Mes<br />
                                                      
                                                        <?php                                                        
                                                        $fecha_actual = date('Y-m-j');
                                                        $nuevafecha = strtotime ( '-1 month' , strtotime ( $fecha_actual ) ) ;
                                                        $nombre_nuevafecha = getNombreMes(date ( 'n' , $nuevafecha ));
                                                        $numero_nuevafecha = date ( 'n' , $nuevafecha );
                                                        ?>
                                                      
                                                      </label>
                                                      <select class="form-control required" name="mesAusenciaAtraso" id="mesAusenciaAtraso">
                                                        <option value="<?php echo date('n'); ?>"> <?php echo getNombreMes(date('n')); ?> </option>
                                                        <option value="<?php echo $numero_nuevafecha; ?>"> <?php echo $nombre_nuevafecha; ?> </option>                                                                                    
                                                      </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">                                         
                                                    <div class="form-group">
                                                      <label for="anoAusenciaAtraso">Año</label>
                                                      <input type="number" class="form-control required" name="anoAusenciaAtraso" id="anoAusenciaAtraso" value="<?php echo date('Y') ?>" />
                                                    </div>
                                                </div> 
                                            </div>
                                            
                                            <div class="row">                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">                                                        
                                                      <label for="minutosAtraso">Horas Antrasos</label>
                                                      <input value="<?php echo $minutos_trabajador['hrRetraso'] ?>" type="number" min="0" class="form-control required" name="minutosAtraso" id="minutosAtraso" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                      <label for="minutosExtraNormal">Horas Extra Normal</label>
                                                      <input value="<?php echo $minutos_trabajador['hrExtra'] ?>" type="number" min="0" class="form-control required" name="minutosExtraNormal" id="minutosExtraNormal" value="" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">                                         
                                                    <div class="form-group">
                                                      <label for="minutosExtraFestivo">Horas Extra Festivo</label>
                                                      <input value="<?php echo $minutos_trabajador['hrExtraFestivo'] ?>" type="number" min="0" class="form-control required" name="minutosExtraFestivo" id="minutosExtraFestivo" value="" />
                                                    </div>
                                                </div> 
                                            </div>
                                            
                                            <div class="row"> 
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <button type="button" id="add_minutos" class="btn btn-default btn-sm">Guardar</button>
                                                    </div>
                                                </div>
                                            </div>                      
                                        </div>
                                        
                                        <div class="col-md-6" id="trabajadorAusencias">
                                            <input type="hidden" name="regid_ausencias" id="regid_ausencias" value="<?php echo $trabajador['id']; ?>" />
                                            
                                            <div class="box">
                                            	<div class="box-header">
                                            		<h3 class="box-title">
                                            			Ingreso de Días de Ausencias
                                            		</h3>
                                            	</div>
                                            	<div class="box-body no-padding">
                                                
                                                    <div class="row margin">                                                         
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="fechaAusenciaInicio">Desde</label>
                                                                <input type="text" class="form-control required datepicker" value="" id="fechaAusenciaInicio" name="fechaAusenciaInicio" placeholder="YYYY-mm-dd" readonly="" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="fechaAusenciaFin">Hasta</label>
                                                                <input type="text" class="form-control required datepicker" value="" id="fechaAusenciaFin" name="fechaAusenciaFin" placeholder="YYYY-mm-dd" readonly="" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row margin">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="motivoAusencia">Motivo</label>
                                                                <select name="motivoAusencia" id="motivoAusencia" class="required form-control">
                                                                    <option value="">Seleccione</option>
                                                                    <?php foreach( $ausencias as $aus ){ ?>
                                                                    <option value="<?php echo $aus['id'] ?>"><?php echo $aus['nombre'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <br />
                                                                <button type="button" id="add_ausencia" class="btn btn-default btn-sm">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="table-responsive">                                                    
                                                		<table class="table table-striped table-bordered" id="table_ausencias_atrasos">
                                                			<thead>
                                                            	<tr>
                                                					<th> Desde </th>
                                                					<th> Hasta </th>
                                                                    <th> Días </th>
                                                                    <th> Motivo </th>
                                                                    <th> Opc. </th>                                                                
                                                				</tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                if( $ausencias_trabajador ){
                                                                    foreach( $ausencias_trabajador as $at ){ 
                                                                ?>
                                                                <tr id="tr_<?php echo $at['id'] ?>">
                                                                    <td> <?php echo $at['fecha_inicio'] ?> </td>
                                                                    <td> <?php echo $at['fecha_fin'] ?> </td>
                                                                    <td>
                                                                    <?php 
                                                                    $datetime1 = date_create($at['fecha_inicio']);
                                                                    $datetime2 = date_create($at['fecha_fin']);
                                                                    $interval = date_diff($datetime1, $datetime2);
                                                                    echo $interval->format('%a');
                                                                    ?>
                                                                    </td>
                                                                    <td> <?php echo fnGetNombre($at['ausencia_id'],'m_ausencia') ?> </td>
                                                                    <td> <button class="delete_ausencia_trabajador" data-id="<?php echo $at['id'] ?>" type="button" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>
                                                                </tr>
                                                                <?php
                                                                    } 
                                                                }
                                                                ?>
                                                			</tbody>
                                                		</table>
                                                    </div>
                                            	</div>
                                            </div>
                                                                                                                            
                                        </div>
                                        <?php } else { ?>
                                        <div class="col-md-12">
                                            (Datos obtenidos de la base de datos del Reloj Control)
                                            <h4 class="box-title"> Horario del trabajador: de <strong><?php echo $m_horario_entrada ?></strong> a <strong><?php echo $m_horario_salida ?></strong> </h4>
                                            <div class="box box-solid collapsed-box box_datos_reloj">
                                                <div class="box-header">
                                                    <div class="pull-right box-tools">                                                    
                                                        <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <h3 class="box-title"> Atrasos y Horas Extras </h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" style="background: #fff;">
                                                            	<tbody>
                                                            		<tr>
                                                            			<th style="width: 130px">
                                                            				Día
                                                            			</th>
                                                            			<th>
                                                            				Hora entrada
                                                            			</th>
                                                            			<th>
                                                            				Autorizado
                                                            			</th> 
                                                                        <th>
                                                            				Hora Salida
                                                            			</th>
                                                            			<th>
                                                            				Autorizado
                                                            			</th>                                                   			
                                                            		</tr>
                                                                    <?php                                                                     
                                                                    $arr_no_IN = array();
                                                                    $arr_no_OUT = array();                        
                                                                    $arr_ausencias = array();
                                                                                                                
                                                                    for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){ 
                                                                    ?>
                                                                    <tr>
                                                                    <?php
                                                                    
                                                                        $flag = 0;
                                                                        foreach( $entradas as $IN ){
                                                                            
                                                                            $fecha_iterar = date("Y-m-d", $i);
                                                                            $datereg = explode(" ",$IN['checktime']);
                                                                            $fechareg = explode("-",$datereg[0]);
                                                                            $hora_entrada = strtotime( $datereg[1] );                                                                            
                                                                                
                                                                            $fecha_comparar = date_create($IN['checktime']);
                                                                            $fecha_comparar = date_format($fecha_comparar,"Y-m-d");
                                                                            
                                                                            if($fecha_iterar == $fecha_comparar){
                                                                                $dia_semana = date('N', strtotime($fecha_iterar));
                                                                                $dia_semana--;                       
                                                                                
                                                                                if( !in_array($dia_semana,$dias_laborales_horario) ){
                                                                                    $cls_no_trabaja = 'no_laboral';
                                                                                } else {
                                                                                    $cls_no_trabaja = '';
                                                                                }                                                                                                                                                                     
                                                                        ?>
                                                                    	<td class="<?php echo $cls_no_trabaja; ?>"> <?php echo translateDia( date('D', strtotime($fecha_iterar)) ) . ": " . $fecha_iterar; ?> </td>
                                                                            <!-- Badeclass: bg-red Ó bg-transp-->
                                                                        <?php
                                                                        /** SI es un dia laboral **/
                                                                        if( in_array($dia_semana,$dias_laborales_horario) ){
                                                                            /** SI llego atrasado, muestra en rojo **/
                                                                            if( $hora_entrada > strtotime( $m_horario_entrada ) ) {
                                                                                $justificativos = $justificativos_atrasos;
                                                                                $cls='bg-red';
                                                                                $tipo_j = 'A';                                                                                
                                                                            } elseif( $hora_entrada == strtotime( $m_horario_entrada ) ) {
                                                                                $justificativos = array();
                                                                                $cls='bg-transp';
                                                                                $tipo_j = '';                                                                                
                                                                            } else{
                                                                                $justificativos = $justificativos_horaextra;
                                                                                $cls='bg-green';
                                                                                $tipo_j = 'H';                                                                                
                                                                            }
                                                                        
                                                                            ?>
                                                                        <td>
                                                                            <span class="badge <?php echo $cls; ?>">
                                                                                <?php echo $datereg[1]; ?>
                                                                            </span>
                                                                        </td>
                                                                        <?php 
                                                                        } else {
                                                                        $tipo_j = 'H';
                                                                        ?>
                                                                        <td colspan="4" class="<?php echo $cls_no_trabaja; ?>">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                    <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $IN['logid'] ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $IN['logid'] ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos_horaextra as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>                                                                                    
                                                                                <input type="text" name="justificativo[<?php echo $IN['logid'] ?>][hora_extra_efectiva]" value="0" class="form-control" style="width: 45px; display: none" maxlength="3" />
                                                                                <input type="hidden" name="justificativo[<?php echo $IN['logid'] ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $IN['logid'] ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                            </div>
                                                                        </td>
                                                                        <?php    
                                                                        }
                                                                        ?>                                                                
                                                                        
                                                            			    <?php 
                                                                            /** SI llego atrasado, muestra ticket para autorizar **/                                                                    
                                                                            if( in_array($dia_semana,$dias_laborales_horario) ){
                                                                            ?>
                                                                            <td style="width: 350px;" class="<?php echo $cls_no_trabaja; ?>">
                                                                            <?php
                                                                                if( $hora_entrada != strtotime( $m_horario_entrada ) ) {                                                                        
                                                                                ?>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                        <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $IN['logid'] ?>][justificado]" />
                                                                                    </span>
                                                                                    <select class="form-control" name="justificativo[<?php echo $IN['logid'] ?>][justificativo]" style="width: 200px; display: none;">
                                                                                        <option value="">Seleccione</option>
                                                                                        <?php foreach( $justificativos as $j ){ ?>
                                                                                        <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>                                                                                    
                                                                                    <input type="text" name="justificativo[<?php echo $IN['logid'] ?>][hora_extra_efectiva]" value="0" class="form-control" style="width: 45px; display: none" maxlength="3" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $IN['logid'] ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $IN['logid'] ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                </div>
                                                                                <?php 
                                                                                }
                                                                            ?>
                                                                            </td>
                                                                            <?php 
                                                                            } 
                                                                            
                                                                            
                                                                                $flag++;                    
                                                                                break;
                                                                            }
                                                                        }
                                                                        if( $flag == 0 ){
                                                                        $arr_no_IN[] = $fecha_iterar;
                                                                    ?>
                                                                    
                                                            			<td class="ausente"> <?php echo $fecha_iterar ?> </td>
                                                            			<td class="ausente" colspan="2"> 
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                    <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $IN['logid'] ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $IN['logid'] ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>                                                                                    
                                                                                <input type="text" name="justificativo[<?php echo $IN['logid'] ?>][hora_extra_efectiva]" class="form-control" style="width: 45px; display: none" maxlength="3" />
                                                                                <input type="hidden" name="justificativo[<?php echo $IN['logid'] ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $IN['logid'] ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                            </div>
                                                                        </td>                                                            			                                                    			                                                                
                                                            		    
                                                                    <?php } ?>
                                                                    
                                                                    
                                                                    
                                                                    
                                                                    
                                                                    <?php                                                                    
                                                                    $flag_out = 0;
                                                                    foreach( $salidas as $OUT ){
                                                                        
                                                                        $datereg = explode(" ",$OUT['checktime']);                                                                        
                                                                        $hora_salida = strtotime( $datereg[1] );                                                                            
                                                                            
                                                                        $fecha_comparar = date_create($OUT['checktime']);
                                                                        $fecha_comparar = date_format($fecha_comparar,"Y-m-d");
                                                                        
                                                                        if($fecha_iterar == $fecha_comparar){
                                                                            $dia_semana = date('N', strtotime($fecha_iterar));
                                                                            $dia_semana--;                       
                                                                            
                                                                            if( !in_array($dia_semana,$dias_laborales_horario) ){
                                                                                $cls_no_trabaja = 'no_laboral';
                                                                            } else {
                                                                                $cls_no_trabaja = '';
                                                                            }                                                                                                                                                                     
                                                                        ?>                                                                   	 
                                                            			    <!-- Badeclass: bg-red Ó bg-transp-->
                                                                            <?php
                                                                            /** SI llego atrasado, muestra en rojo **/
                                                                            if( in_array($dia_semana,$dias_laborales_horario) ){
                                                                                if( $hora_salida > strtotime( $m_horario_salida ) ) {
                                                                                    $justificativos = $justificativos_horaextra;
                                                                                    $cls='bg-green';
                                                                                    $tipo_j = 'H';
                                                                                } elseif( $hora_salida == strtotime( $m_horario_salida ) ) {
                                                                                    $justificativos = array();
                                                                                    $cls='bg-transp';
                                                                                    $tipo_j = '';
                                                                                } else{
                                                                                    $justificativos = $justificativos_atrasos;
                                                                                    $cls='bg-red';
                                                                                    $tipo_j = 'A';
                                                                                }
                                                                                ?>
                                                                            <td class="<?php echo $cls_no_trabaja; ?>">
                                                                                <span class="badge <?php echo $cls; ?>">
                                                                                    <?php echo $datereg[1]; ?>
                                                                                </span>
                                                                            </td>
                                                                                <?php 
                                                                            } 
                                                                            ?>                                                                
                                                                        
                                                            			    <?php 
                                                                            /** SI llego atrasado, muestra ticket para autorizar **/                                                                    
                                                                            if( in_array($dia_semana,$dias_laborales_horario) ){
                                                                            ?>
                                                                            <td style="width: 350px;" class="<?php echo $cls_no_trabaja; ?>">
                                                                            <?php
                                                                                if( $hora_salida != strtotime( $m_horario_salida ) ) {                                                                        
                                                                                ?>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                        <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $OUT['logid'] ?>][justificado]" />
                                                                                    </span>
                                                                                    <select class="form-control" name="justificativo[<?php echo $OUT['logid'] ?>][justificativo]" style="width: 200px; display: none;">
                                                                                        <option value="">Seleccione</option>
                                                                                        <?php foreach( $justificativos as $j ){ ?>
                                                                                        <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                        <?php } ?>
                                                                                    </select>                                                                                    
                                                                                    <input type="text" name="justificativo[<?php echo $OUT['logid'] ?>][hora_extra_efectiva]" value="0" class="form-control" style="width: 45px; display: none" maxlength="3" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $OUT['logid'] ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                    <input type="hidden" name="justificativo[<?php echo $OUT['logid'] ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                </div>
                                                                                <?php 
                                                                                } 
                                                                                ?>
                                                                            </td>
                                                                            <?php
                                                                            } 
                                                                                $flag_out++;                    
                                                                                break;
                                                                            }
                                                                        }
                                                                        if( $flag_out == 0 ){
                                                                        $arr_no_OUT[] = $fecha_iterar;
                                                                    
                                                                        if( in_array($dia_semana,$dias_laborales_horario) ){
                                                                        ?>
                                                                    
                                                            			<td class="ausente"> <?php echo $fecha_iterar ?> </td>
                                                            			<td class="ausente" colspan="2"> 
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                    <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $OUT['logid'] ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $OUT['logid'] ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>                                                                                    
                                                                                <input type="text" name="justificativo[<?php echo $OUT['logid'] ?>][hora_extra_efectiva]" class="form-control" style="width: 45px; display: none" maxlength="3" />
                                                                                <input type="hidden" name="justificativo[<?php echo $OUT['logid'] ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $OUT['logid'] ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />                                                                                
                                                                            </div>
                                                                        </td>                                                            			                                                    			                                                                
                                                            		    
                                                                    <?php } } ?>
                                                                    
                                                                    </tr>
                                                                    <?php 
                                                                    if( ( in_array($fecha_iterar,$arr_no_IN) ) && ( in_array($fecha_iterar,$arr_no_OUT) )  ){
                                                                        $arr_ausencias[] = $fecha_iterar;
                                                                    }
                                                                    
                                                                    } 
                                                                    ?>
                                                            	
                                                                    
                                                            	</tbody>
                                                            </table>
                                                        </div>
                                                    </div>                                                
                                                </div>                                            
                                            </div>
                                            <input type="hidden" name="fI" value="<?php echo $fechaInicio; ?>" />
                                            <input type="hidden" name="fF" value="<?php echo $fechaFin; ?>" />
                                            <?php  
                                            /*                                          
                                            show_array($arr_no_IN,0);
                                            show_array($arr_no_OUT,0);
                                            show_array($arr_ausencias,0);
                                            */
                                            ?>
                                            <div class="box box-solid collapsed-box box_datos_reloj">
                                                <div class="box-header">
                                                    <div class="pull-right box-tools">                                                    
                                                        <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <h3 class="box-title"> Ausencias </h3>
                                                </div>
                                                <div class="box-body table-responsive">                                                
                                                    <table class="table table-bordered" style="background: #fff;">
                                                    	<tbody>
                                                    		<tr>
                                                    			<th style="width: 10px">
                                                    				#
                                                    			</th>
                                                    			<th style="width: 200px;">
                                                    				Fecha
                                                    			</th>
                                                    			<th>
                                                    				Justificado
                                                    			</th>                                                    			                                                                
                                                    		</tr>
                                                            <?php 
                                                            $i=1;
                                                            foreach( $arr_ausencias as $ausencia ){ 
                                                            ?>
                                                    		<tr>
                                                    			<td> <?php echo $i ?>. </td>
                                                    			<td> 
                                                                    <?php echo $ausencia; ?>                                                                
                                                                </td>
                                                    			<td>                                                                     
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                            <input type="checkbox" class="chk_autorize" />
                                                                        </span>
                                                                        <select class="form-control" style="width: 200px; display: none;">
                                                                            <option value="">Seleccione</option>                                                                            
                                                                        </select>                                                                                    
                                                                        <input type="text" value="0" class="form-control" style="width: 45px; display: none" maxlength="3" />                                                                        
                                                                    </div>                                                                   
                                                                </td>
                                                    		</tr>
                                                            <?php 
                                                            $i++;
                                                            } 
                                                            ?>
                                                    	</tbody>
                                                    </table>
                                                
                                                </div>                                            
                                            </div>                                                                                        
                                          
                                        </div>
                                        <div class="col-md-6">
                                            
                                        </div>
                                        <?php } ?>
                                    </div>                                                           
                                </div>                                
            
                              </div><!-- /.box -->
                            </div>                        
                    </div>
              </div>                                              
            </div>

        </section>
        
      </div><!-- /.content-wrapper -->
</div>
      
<script>
$(document).ready(function(){
    
    $(".chk_autorize").click(function(){
        if($(this).is(':checked')){            
            $(this).closest('.input-group').find('.form-control').show();
        } else {
            $(this).closest('.input-group').find('.form-control').hide();
        }
    })
    
    <?php 
    foreach( $t_atrasohoraextra as $ahe ){ 
    $ahe['horas'] = procesarDecimal($ahe['horas']);
    ?>
    $("input[name='justificativo[<?php echo $ahe['logid'] ?>][justificado]']").prop('checked',true);
    $("input[name='justificativo[<?php echo $ahe['logid'] ?>][hora_extra_efectiva]']").val('<?php echo $ahe['horas'] ?>');
    $("select[name='justificativo[<?php echo $ahe['logid'] ?>][justificativo]']").val('<?php echo $ahe['justificativo_id'] ?>');
    $("input[name='justificativo[<?php echo $ahe['logid'] ?>][justificado]']").closest('.input-group').find('.form-control').show();
    
    <?php } ?>
    
    $(document).on('click','.delete_reg_debe', function(){
        var obs = prompt('¿Quitar el descuento seleccionado?\n\n(Debe ingresar motivo para eliminar el registro)');        
        if( obs != null ){
            if( ( obs == "" ) ){
                alert("Debe ingresar un motivo para quitar el registro");
            } else {
                var id = $(this).data('id');
                $.ajax({
        			type: "POST",
        			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
        			data: "id="+id+"&obs="+encodeURI(obs)+"&action=delete_debe",
                    dataType: 'json',
                    beforeSend: function(){
                        $(".overlayer").show();
                    },
        			success: function (json) {
        			     if( json.status == 'OK' ){
        			         $("#table_debe_trabajador tr#tr_" + json.id).fadeOut(300);                                                  
        			         $(".overlayer").hide();
        			     }
                    }
        		})            
            }
        }
    })
    
    $(document).on('click','.delete_ausencia_trabajador', function(){
        var conf = confirm('¿Quitar el registro seleccionado?');        
        if( conf ){            
            var id = $(this).data('id');
            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: "id="+id+"&action=delete_ausencia_trabajador",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     if( json.status == 'OK' ){
    			         $("#table_ausencias_atrasos tr#tr_" + json.id).fadeOut(300);                                                  
    			         $(".overlayer").hide();
    			     }
                }
    		})        
        }
    })
    
    
    $(document).on('click','.delete_reg_haber', function(){
        var obs = prompt('¿Quitar el Haber seleccionado?\n\n(Debe ingresar motivo para eliminar el registro)');        
        if( obs != null ){
            if( ( obs == "" ) ){
                alert("Debe ingresar un motivo para quitar el registro");
            } else {
                var id = $(this).data('id');
                $.ajax({
        			type: "POST",
        			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
        			data: "id="+id+"&obs="+encodeURI(obs)+"&action=delete_haber",
                    dataType: 'json',
                    beforeSend: function(){
                        $(".overlayer").show();
                    },
        			success: function (json) {
        			     if( json.status == 'OK' ){
        			         $("#table_haber_trabajador tr#tr_" + json.id).fadeOut(300);                                                  
        			         $(".overlayer").hide();
        			     }
                    }
        		})            
            }
        }
    })
    
    
    
    $("#descuentoDebeTrabajador").change(function(){
        var opt_data =  $('option:selected', this).data() ;        
        if( ( opt_data.fijo == 1 ) || ( $(this).val() == "" ) ){
            $("#debe_cuotas").slideUp(200);
            $("#cuotaActualDebeTrabajador").removeClass('required');
            $("#totalCuotasDebeTrabajador").removeClass('required');
        } else {
            $("#debe_cuotas").slideDown(200);
            $("#cuotaActualDebeTrabajador").addClass('required');
            $("#totalCuotasDebeTrabajador").addClass('required');
        }
        
        if( opt_data.predet == 1 ){
            $("#valorDebeTrabajador").val( opt_data.valor );
            $("#tipoMonedaDescuento").val( opt_data.tipo_moneda )
        } else {
            $("#valorDebeTrabajador").val('');
            $("#tipoMonedaDescuento").val('');
        }
        
    })
    
    $("#descuentoHaberTrabajador").change(function(){
        var opt_data =  $('option:selected', this).data() ;        
        if( ( opt_data.fijo == 1 ) || ( $(this).val() == "" ) ){
            $("#haber_cuotas").slideUp(200);
            $("#cuotaActualHaberTrabajador").removeClass('required');
            $("#totalCuotasHaberTrabajador").removeClass('required');
        } else {
            $("#haber_cuotas").slideDown(200);
            $("#cuotaActualHaberTrabajador").addClass('required');
            $("#totalCuotasHaberTrabajador").addClass('required');
        }
        
        if( opt_data.predet == 1 ){
            $("#valorHaberTrabajador").val( opt_data.valor );
            $("#tipoMonedaHaber").val( opt_data.tipo_moneda )
        } else {
            $("#valorHaberTrabajador").val('');
            $("#tipoMonedaHaber").val('');
        }
        
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
    
    $("#frmCrear").submit(function(e){
        e.preventDefault();
        error = 0;
        found_first_empty = 0;
        $("#tab_1 .required, #tab_2 .required, .datos_previsionales .required").each(function(){
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
        
        if( $("input.rbtSaludTrabajador:checked").length == 0 ){
            $('h4.h4Salud').append(' <small>(Este campo es requerido)</small>').addClass('has-error');            
            error++;
        }
        
        if( error == 0 ){
            $(".overlayer").show();
            $("#frmCrear")[0].submit();
        }
    
    }) 


    
    $("#add_minutos").click(function(e){
        e.preventDefault();
        err=0;
        $("#trabajadorMinutos .required").each(function(){
            if( $(this).val() == "" ){
                $(this).parent().addClass('has-error');                
                err++;
            } else {
                $(this).parent().removeClass('has-error');                
            }
        })
        
        if( err == 0 ){
            var dat = '';
            $('#trabajadorMinutos input, #trabajadorMinutos select').each(function(){
                dat += $(this).attr('id') + "=" + $(this).val() + "&";
            });

            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: dat + "action=add_minutos",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     if( json.status == 'OK' ){
    			         $("#minutosAtraso").val(json.minutosAtraso);
                         $("#minutosExtraNormal").val(json.minutosExtraNormal);
                         $("#minutosExtraFestivo").val(json.minutosExtraFestivo);                     
    			         $(".overlayer").hide();    
    			     }
                }
    		})
        }                
    })
    
    $("#add_ausencia").click(function(e){
        e.preventDefault();
        err=0;
        $("#trabajadorAusencias .required").each(function(){
            if( $(this).val() == "" ){
                $(this).parent().addClass('has-error');                
                err++;
            } else {
                $(this).parent().removeClass('has-error');                
            }
        })
        
        if( err == 0 ){
            var dat = '';
            $('#trabajadorAusencias input, #trabajadorAusencias select').each(function(){
                dat += $(this).attr('id') + "=" + $(this).val() + "&";
            });

            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: dat + "action=add_ausencia",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     if( json.status == 'OK' ){
    			         row = '';
    			         $.each(json.registro, function(k,v){
    			             row += '<td>'+v+'</td>';
    			         })        
                         row += '<br /><td> <button class="delete_ausencia_trabajador" data-id="'+json.tr_id+'" type="button" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>';
                         $("#table_ausencias_atrasos tbody").prepend('<tr id="tr_'+json.tr_id+'">'+row+'</tr>');
    			         $(".overlayer").hide();    
    			     }
                }
    		})
        }                
    })
    
    
    $("#add_debe").click(function(e){    
        e.preventDefault();
        err=0;
        $("#form_debe_trabajador .required").each(function(){
            if( $(this).val() == "" ){
                $(this).parent().addClass('has-error');                
                err++;
            } else {
                $(this).parent().removeClass('has-error');                
            }
        })
        
        if( err == 0 ){
            var dat = '';
            $('#form_debe_trabajador input, #form_debe_trabajador select, #form_debe_trabajador textarea').each(function(){
                dat += $(this).attr('id') + "=" + $(this).val() + "&";
            });

            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: dat + "action=add_debe",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     if( json.status == 'OK' ){
    			         row = '';
    			         $.each(json.registro, function(k,v){
    			             row += '<td>'+v+'</td>';
    			         })    
                         row += '<td> <button class="delete_reg_debe" data-id="'+json.tr_id+'" type="button" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>';
                         if( json.update == 'TRUE' ){
                            $("#table_debe_trabajador tbody tr#tr_" + json.tr_id).replaceWith('<tr id="tr_'+json.tr_id+'">'+row+'</tr>');
                         } else {
                            $("#table_debe_trabajador tbody").prepend('<tr id="tr_'+json.tr_id+'">'+row+'</tr>');   
                         }           
                                              
    			         $(".overlayer").hide();    
    			     }
                }
    		})
        }                
    })
    
    
    $("#add_haber").click(function(e){    
        e.preventDefault();
        err=0;
        $("#form_haber_trabajador .required").each(function(){
            if( $(this).val() == "" ){
                $(this).parent().addClass('has-error');                
                err++;
            } else {
                $(this).parent().removeClass('has-error');                
            }
        })
        
        if( err == 0 ){
            var dat = '';
            $('#form_haber_trabajador input, #form_haber_trabajador select, #form_haber_trabajador textarea').each(function(){
                dat += $(this).attr('id') + "=" + $(this).val() + "&";
            });

            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: dat + "action=add_haber",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     if( json.status == 'OK' ){
    			         row = '';
    			         $.each(json.registro, function(k,v){
    			             row += '<td>'+v+'</td>';
    			         })  
                         row += '<td><button class="delete_reg_haber" data-id="'+json.tr_id+'" type="button" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button></td>';      
                         if( json.update == 'TRUE' ){
                            $("#table_haber_trabajador tbody tr#tr_" + json.tr_id).replaceWith('<tr id="tr_'+json.tr_id+'">'+row+'</tr>');
                         } else {
                            $("#table_haber_trabajador tbody").prepend('<tr id="tr_'+json.tr_id+'">'+row+'</tr>');   
                         }           
                                              
    			         $(".overlayer").hide();    
    			     }
                }
    		})
        }                
    })
    
    
    
    if( window.location.hash.length > 0 ){
        hash = window.location.hash;
        hash = hash.replace("#","");
        $(".nav-tabs a[href=#" + hash + "]").click();
    }
    
    $(".input_file input").change(function(){
        $(this).parent().find('span').text( $(this).val() );
    })
    
    
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

    $("input.rbtSaludTrabajador").click(function(){
        $(".h4Salud").removeClass('has-error');
        $(".datosSalud").slideUp(200);
        $(".datosSalud input, .datosSalud select").removeClass('required');
        if( $(this).val() == 'fonasa' ){
            $("#datosFonasa").slideDown(200);
            $("#datosFonasa input, #datosFonasa select").addClass('required');
        } else {
            $("#datosIsapre").slideDown(200);
            $("#datosIsapre input, #datosIsapre select").addClass('required');
        }
    })
    
    $(".rbtExtranjero").click(function(){
        if( $(this).val() == 1 ){
            $("#extranjeria_trabajador").slideDown(200); 
            $("#nacionalidadTrabajador, #pasaporteTrabajador").addClass('required');   
        } else {
            $("#extranjeria_trabajador").slideUp(200);
            $("#nacionalidadTrabajador, #pasaporteTrabajador").removeClass('required');
        }
    })
    
    $(".btn-add-contrato").click(function(){
        var id_contrato = $("#contratosTrabajador").val();
        if( id_contrato != "" ){
            $("#contratosTrabajador").closest('.form-group').removeClass('has-error');
            $.ajax({
            	type: "POST",
            	url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
            	data:"id_contrato="+id_contrato+"&id_trabajador=<?php echo $parametros[1] ?>&action=add_contrato",
                dataType: 'json',
                beforeSend: function(){
                    $(".box#box_contratos").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
            	success: function (json) {
            	     if( json.status == 'OK' ){
                        $(".box#box_contratos .overlay").remove();
                        ht = '<tr>';  
                        ht += '    <td> '+json.contrato+' </td>';
                        ht += '    <td class="botones">';
                        ht += '        <button data-id="'+json.id+'" type="button"><i class="fa fa-search"></i></button>';
                        ht += '        <button data-id="'+json.id+'" type="button"><i class="fa fa-trash"></i></button>';
                        ht += '    </td>';
                        ht += '</tr>';
                        
                        $("#table_contratos_trabajador tbody").prepend(ht);
                        $("#contratosTrabajador").val('');
            	     }
                }
            })
        } else {
            $("#contratosTrabajador").closest('.form-group').addClass('has-error');
        }
    })
    
        
    $(document).on('click','#table_contratos_trabajador .btn-delete-contrato', function(){
        var id_contrato = $(this).data('id');
        var TR = $(this).closest('tr');
        if( confirm('Quitar registro?') ){
            $.ajax({
            	type: "POST",
            	url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
            	data:"id_contrato="+id_contrato+"&id_trabajador=<?php echo $parametros[1] ?>&action=delete_contrato",
                dataType: 'json',
                beforeSend: function(){
                    $(".box#box_contratos").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
            	success: function (json) {            	   
            	     if( json.status == 'OK' ){
                        TR.fadeOut(300).remove();
                        $(".box#box_contratos .overlay").remove();
            	     }
                }
            })
        }
    })
    
    $(".btn-add-apv").click(function(){
        error = 0;
        $("#box_apvs .required").each(function(){
            if( $(this).val() == "" ){
                if( !$(this).parent().hasClass('has-error') ){
                    $(this).parent().addClass('has-error');                    
                }
                error++;
            }
        })
                
        if( error == 0 ){
            $.ajax({
            	type: "POST",
            	url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
            	data:{ 
            	   trabajador_id: '<?php echo $parametros[1] ?>', 
                   institucion_id: $("#institucionApvTrabajador").val(),
                   tipomoneda_id: $("#tipoMonedaApvTrabajador").val(),
                   monto: $("#montoApvTrabajador").val(),                                      
                   action: 'add_apv' 
                },
                dataType: 'json',
                beforeSend: function(){
                    $(".box#box_apvs").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
            	success: function (json) {                    
                    if( json.status == 'OK' ){
                        $(".box#box_apvs .overlay").remove();
                        ht = '<tr>';  
                        ht += '    <td> '+json.institucion+' </td>';
                        ht += '    <td> '+json.moneda+' </td>';
                        ht += '    <td> '+json.monto+' </td>';
                        ht += '    <td class="botones">';                        
                        ht += '        <button data-id="'+json.id+'" type="button" class="btn-delete-apv"><i class="fa fa-trash"></i></button>';
                        ht += '    </td>';
                        ht += '</tr>';
                        
                        $("#table_apv_trabajador tbody").append(ht);
                        $("#contratosTrabajador").val('');
                    }
                }
            })
        }
    })
    
    $("#tipoPagoTrabajador").change(function(){    
        var id_tipopago = $(this).val();
        $(".row#custom_fields").empty();
        cargaCamposPersonalizados(id_tipopago);
    })
    <?php if( $parametros[1] ): ?>
        cargaCamposPersonalizados(<?php echo $trabajador['tipopago_id'] ?>);                
    <?php endif; ?>
        
    $(document).on('click','#table_apv_trabajador .btn-delete-apv', function(){
        var id_apv = $(this).data('id');
        var TR = $(this).closest('tr');
        if( confirm('Quitar registro?') ){
            $.ajax({
            	type: "POST",
            	url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
            	data:"id_apv="+id_apv+"&id_trabajador=<?php echo $parametros[1] ?>&action=delete_apv",
                dataType: 'json',
                beforeSend: function(){
                    $(".box#box_apvs").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                },
            	success: function (json) {            	   
            	     if( json.status == 'OK' ){
                        TR.fadeOut(300).remove();
                        $(".box#box_apvs .overlay").remove();
            	     }
                }
            })
        }
    })
        
              
    hideFieldValue('#sueldoBaseTrabajador','#view_sueldo');
            
})
      
$(window).load(function(){
    cargaComuna('<?php echo fnGetRegion($trabajador['comuna_id']) ?>');        
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
                    html += '       <input type="text" class="form-control required" id="'+valor.key+'" value="" name="camposPersonalizadosTipoPago['+valor.key+']" disabled />';
                    html += '   </div>';
                    html += '</div>';
                    $(".row#custom_fields").append(html);
                })
                    
                
                jFields = JSON.parse('<?php echo $trabajador['tipopagodato'] ?>');
                $.each(jFields.fields, function(k,v){
                    $("#custom_fields #" + v.key).val(v.value);
                });
                                    
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
        $("#comunaTrabajador").val('<?php echo $trabajador['comuna_id'] ?>');
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
      