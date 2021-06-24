<!-- Content Wrapper. Contains page content -->    
<style>
    .nomargin {
    padding: 0px 3px;
}

#btn_delete_ausencia_batch {
    margin: 10px;
    display: none;
}

#tab_5 table th {
    text-align: center;
}

#tab_5 table tbody td {
    text-align: center;
    height: 51px;
}

.box_datos_reloj {
    background: #ecf0f5;
}

.box_datos_reloj.collapsed-box {
    background: #F9F9FF;
}

.bg-transp {
    background: #fff;
    color: #333;
}

.input-group-addon {
    width: 40px;
    height: 34px;
}

.no_laboral {
    background: #F4F4F4;
}

.ausente {
    background: #FF9595;
}

.input-group-addon {
    cursor: pointer;
}

.pinit {
    font-size: 18px;
    margin: 5px;
    display: none;
}

.pin_comment {
    position: fixed;
    top: 130px;
    left: 50%;
    margin-left: -300px;
    z-index: 9999;
}

.pin_comment textarea {
    width: 100%;
    border: 0;
}

.info_ausencias {
    font-size: 18px;
    color: #3c8dbc;
    cursor: help;
}

.switcher {
    display: inline-block;
    border: 2px solid #00a65a;
    border-radius: 17px;
    width: 80px;
    height: 34px;
    background: #00a65a;
    margin-bottom: 10px;
}

.switcher.off {
    border: 2px solid #dd4b39;
    background: #dd4b39;
}

.switcher:before {
    content: 'ON';
    color: #00a65a;
    display: block;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #fff;
    font-weight: bold;
    text-align: center;
    line-height: 28px;
    float: left;
    -webkit-transition: all 0.3s ease 0s;
    -moz-transition: all 0.3s ease 0s;
    -ms-transition: all 0.3s ease 0s;
    -o-transition: all 0.3s ease 0s;
    transition: all 0.3s ease 0s;
    margin-left: 0px;
}

.switcher.off:before {
    margin-left: 46px;
    content: 'OFF';
    color: #dd4b39;
}


/* The switch - the box around the slider */

.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 25px;
}


/* Hide default HTML checkbox */

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}


/* The slider */

.switch .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.switch .slider:before {
    position: absolute;
    content: "";
    height: 19px;
    width: 19px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

.switch input:checked+.slider {
    background-color: #2196F3;
}

.switch input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

.switch input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}


/* Rounded sliders */

.switch .slider.round {
    border-radius: 34px;
}

.switch .slider.round:before {
    border-radius: 50%;
}
</style>
<div id="trabajador_detail">
    <form role="form" id="frmCrear" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="edit" />
        <input type="hidden" name="idTrabajador" value="<?php echo $trabajador['id'] ?>" />
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
                <div class="overlayer" style="display: block;"><i class="fa fa-refresh fa-spin"></i></div>
                <ul class="nav nav-tabs">
                    <li class="active"><a  onclick="javascript: return void(0);" href="#tab_1" data-toggle="tab">Información Personal</a></li>
                    <li><a href="#tab_2" onclick="javascript: return void(0);" data-toggle="tab">Información Contractual</a></li>
                    <li><a href="#tab_3" onclick="javascript: return void(0);" data-toggle="tab">Informacion Previsional</a></li>
                    <li><a href="#tab_4" onclick="javascript: return void(0);" data-toggle="tab">Debes y Haberes</a></li>
                    <li><a href="#tab_5" onclick="javascript: return void(0);" data-toggle="tab">Ausencias, Atrasos, H. Extras</a></li>
                    <li><a href="#tab_6" onclick="javascript: return void(0);" data-toggle="tab">Documentación</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- general form elements -->
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Informacion Personal</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="fotoTrabajador">Foto</label>
                                                        <br class="clear" />
                                                        <img class="round" id="previewFotoTrabajador" src="<?php echo BASE_URL ?>/private/imagen.php?f=<?php echo base64_encode(base64_encode(date('Ymd')) . $trabajador['id']) ?>&t=<?php echo base64_encode('m_trabajador') ?>" />
                                                        <div class="input_file">
                                                            <span></span>
                                                            <input type="file" accept="image/*" id="fotoTrabajador" name="fotoTrabajador" onchange="loadFile(event)" />
                                                        </div>
                                                        <p class="help-block" style="font-size: 12px;">(Archivo en JPG o PNG, máximo 500Kb ó 300x300 pixeles)</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="nombreTrabajador">Nombres</label>
                                                            <input type="text" class="form-control required" value="<?php echo $trabajador['nombres'] ?>" id="nombreTrabajador" name="nombreTrabajador" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="apellidoPaternoTrabajador">Apellido Paterno</label>
                                                            <input type="text" class="form-control required" value="<?php echo $trabajador['apellidoPaterno'] ?>" id="apellidoPaternoTrabajador" name="apellidoPaternoTrabajador" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="apellidoMaternoTrabajador">Apellido Materno</label>
                                                            <input type="text" class="form-control required" value="<?php echo $trabajador['apellidoMaterno'] ?>" id="apellidoMaternoTrabajador" name="apellidoMaternoTrabajador" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="rutTrabajador">Rut</label>
                                                            <input type="text" class="form-control required" value="<?php echo $trabajador['rut'] ?>" id="rutTrabajador" name="rutTrabajador" placeholder="(SIN puntos, CON guión)" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="top">Sexo</label>
                                                            <div class="radio">                            
                                                                <label>
                                                                <input type="radio" class="rbtSexo" name="sexoTrabajador[]" id="sexoTrabajadorM" value="1" />
                                                                <i class="fa fa-male"></i> Masculino
                                                                </label>
                                                                &nbsp; &nbsp; &nbsp; 
                                                                <label>
                                                                <input type="radio" class="rbtSexo" name="sexoTrabajador[]" id="sexoTrabajadorF" value="0" />
                                                                <i class="fa fa-female"></i> Femenino
                                                                </label>
                                                            </div>
                                                            <script> $("input.rbtSexo[value=<?php echo $trabajador['sexo'] ?>]").prop('checked',true) </script>
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
                                                        <input type="text" class="form-control" value="<?php echo $trabajador['email'] ?>" name="emailTrabajador" id="emailTrabajador" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="telefonoTrabajador">Teléfono</label>
                                                        <input type="text" class="form-control" value="<?php echo $trabajador['telefono'] ?>" name="telefonoTrabajador" id="telefonoTrabajador" />                                
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="celularTrabajador">Celular</label>
                                                        <input type="text" class="form-control" value="<?php echo $trabajador['celular'] ?>" name="celularTrabajador" id="celularTrabajador" />                                
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
                                                            <input type="radio" class="rbtExtranjero" name="extranjeroTrabajador[]" id="extranjeroTrabajadorNO" value="0" />
                                                            NO
                                                            </label>
                                                        </div>
                                                        <script> $("input.rbtExtranjero[value=<?php echo $trabajador['extranjero'] ?>]").prop('checked',true) </script>
                                                    </div>
                                                    <div id="extranjeria_trabajador" class="collapse">
                                                        <div class="form-group">
                                                            <label for="nacionalidadTrabajador">Nacionalidad</label>
                                                            <select class="form-control" name="nacionalidadTrabajador" id="nacionalidadTrabajador">
                                                                <?php foreach( $paises as $p ){ ?>
                                                                <option value="<?php echo $p['id'] ?>"><?php echo $p['nombre'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <script> $("#nacionalidadTrabajador").val('<?php echo $trabajador['idNacionalidad'] ?>') </script>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pasaporteTrabajador">Pasaporte</label>
                                                            <input type="text" class="form-control" value="<?php echo $trabajador['pasaporte'] ?>" id="pasaporteTrabajador" name="pasaporteTrabajador" />
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
                                                        <input type="text" class="form-control required" value="<?php echo $trabajador['direccion'] ?>" name="direccionTrabajador" id="direccionTrabajador" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="regionTrabajador">Región</label>
                                                        <select class="form-control required" name="regionTrabajador" id="regionTrabajador">
                                                            <option value="">Seleccione Región</option>
                                                            <?php foreach($regiones as $r){ ?>
                                                            <option value="<?php echo $r['id'] ?>"><?php echo $r['nombre'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <script>$("#regionTrabajador").val('<?php echo fnGetRegion($trabajador['comuna_id']) ?>') </script>
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
                                                        <textarea class="form-control required" placeholder="Información relevante en caso de emergencias" name="emergenciaTrabajador" id="emergenciaTrabajador" style="height: 100px;"><?php echo $trabajador['emergencia'] ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="comunaTrabajador">Estado Civil</label>
                                                        <select class="form-control required" name="estadoCivil" id="estadoCivil">
                                                            <option value="">Seleccione Estado Civil</option>
                                                            <option value="Soltero">Soltero(a)</option>
                                                            <option value="Casado">Casado(a)</option>
                                                        </select>
                                                        <script>$("#estadoCivil").val('<?php echo $trabajador['estadoCivil'] ?>') </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Informacion Contractual</h3>
                                    </div>
                                    <!-- /.box-header -->
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
                                                <script>$("#sucursalTrabajador").val('<?php echo $trabajador['sucursal_id'] ?>') </script>
                                            </div>
                                            <div class="form-group">
                                                <label for="departamentoTrabajador">Departamento</label>
                                                <select class="form-control required" name="departamentoTrabajador" id="departamentoTrabajador">
                                                    <option value="">Seleccione Departamento</option>
                                                    <?php foreach( $deptos as $d ){ ?>
                                                    <option value="<?php echo $d['id'] ?>"><?php echo $d['nombre'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <script>$("#departamentoTrabajador").val('<?php echo $trabajador['departamento_id'] ?>') </script>
                                            </div>
                                            <div class="form-group">
                                                <label for="cargoTrabajador">Cargo</label>
                                                <select class="form-control required" name="cargoTrabajador" id="cargoTrabajador">
                                                    <option value="">Seleccione Cargo</option>
                                                    <?php foreach( $cargos as $cargo ){ ?>
                                                    <option value="<?php echo $cargo['id'] ?>"><?php echo $cargo['id'] ?> - <?php echo $cargo['nombre'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <script>$("#cargoTrabajador").val('<?php echo $trabajador['cargo_id'] ?>') </script>
                                            </div>
                                            <div class="form-group">
                                                <label for="centroCostoTrabajador">Centro Costo</label>
                                                <select class="form-control required" name="centroCostoTrabajador" id="centroCostoTrabajador">
                                                    <option value="">Seleccione Centro Costo</option>
                                                    <?php foreach( $ccostos as $costo ){ ?>
                                                    <option value="<?php echo $costo['id'] ?>"><?php echo $costo['nombre'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <script>$("#centroCostoTrabajador").val('<?php echo $trabajador['centrocosto_id'] ?>') </script>
                                            </div>
                                            <div class="form-group">
                                                <label for="horarioTrabajador">Horario</label>
                                                <select class="form-control required" name="horarioTrabajador" id="horarioTrabajador">
                                                    <option value="">Seleccione Horario</option>
                                                    <?php foreach( $horario as $h ){ ?>
                                                    <option value="<?php echo $h['id'] ?>"><?php echo $h['nombre'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <script>$("#horarioTrabajador").val('<?php echo $trabajador['horario_id'] ?>') </script>                                         
                                            </div>
                                            <div class="form-group">
                                                <label for="relojControlIdTrabajador">ID Relojcontrol</label>
                                                <input type="number" class="form-control required" name="relojControlIdTrabajador" id="relojControlIdTrabajador" value="<?php echo $trabajador['relojcontrol_id'] ?>" />                                                                                       
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="diasVacacionesTrabajador">Dias vacaciones/Año</label>
                                                        <input name="diasVacacionesTrabajador" id="diasVacacionesTrabajador" value="<?php echo $trabajador['diasVacaciones'] ?>" class="form-control required" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="vacacionesProgresivasTrabajador">Vacaciones Progresivas</label>
                                                        <input name="vacacionesProgresivasTrabajador" id="vacacionesProgresivasTrabajador" value="<?php echo $trabajador['diasVacacionesProgresivas'] ?>" class="form-control required" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="sueldoBaseTrabajador">Sueldo Base</label>
                                                        <input name="sueldoBaseTrabajador" id="sueldoBaseTrabajador" value="<?php echo $trabajador['sueldoBase'] ?>" class="form-control required" />                                                                                          
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="top"> Gratificación </label>
                                                        <div class="radio">                            
                                                            <label>
                                                            <input type="radio" class="rbtGratificacion" name="gratificacionTrabajador[]" id="gratificacionTrabajadorSI" value="1" />
                                                            SI
                                                            </label>
                                                            &nbsp; &nbsp; &nbsp; 
                                                            <label>
                                                            <input type="radio" class="rbtGratificacion" name="gratificacionTrabajador[]" id="gratificacionTrabajadorNO" value="0" />
                                                            NO
                                                            </label>
                                                        </div>
                                                        <script> $("input.rbtGratificacion[value=<?php echo $trabajador['gratificacion'] ?>]").prop('checked',true) </script>                         
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
                                                            <input type="radio" class="rbtSalarioEstable" name="salarioEstableTrabajador[]" id="salarioEstableTrabajadorNO" value="0" />
                                                            NO
                                                            </label>
                                                        </div>
                                                        <script> $("input.rbtSalarioEstable[value=<?php echo $trabajador['salarioEstable'] ?>]").prop('checked',true) </script>                         
                                                    </div>
                                                    <?php if( empresaUsaRelojControl() ){ ?>
                                                    <div class="form-group">
                                                        <label class="top"> Marca Tarjeta </label>
                                                        <div class="radio">                            
                                                            <label>
                                                            <input type="radio" class="rbtMarcaTarjeta" name="marcaTarjetaTrabajador[]" id="marcaTarjetaTrabajadorSI" value="1" />
                                                            SI
                                                            </label>
                                                            &nbsp; &nbsp; &nbsp; 
                                                            <label>
                                                            <input type="radio" class="rbtMarcaTarjeta" name="marcaTarjetaTrabajador[]" id="marcaTarjetaTrabajadorNO" value="0" />
                                                            NO
                                                            </label>
                                                        </div>
                                                        <script> $("input.rbtMarcaTarjeta[value=<?php echo $trabajador['marcaTarjeta'] ?>]").prop('checked',true) </script>                      
                                                    </div>
                                                    <?php } else { ?>
                                                    <div class="form-group">
                                                        <label class="top"> Marca Tarjeta </label>
                                                        <div class="radio">                            
                                                            <label>
                                                            <input type="radio" class="rbtMarcaTarjeta" name="marcaTarjetaTrabajador[]" id="marcaTarjetaTrabajadorNO" value="0" checked disabled />
                                                            NO
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
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
                                                            <input type="radio" class="rbtAccionista" name="accionistaTrabajador[]" id="accionistaTrabajadorNO" value="0" />
                                                            NO
                                                            </label>
                                                        </div>
                                                        <script> $("input.rbtAccionista[value=<?php echo $trabajador['accionista'] ?>]").prop('checked',true) </script>                          
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
                                                            <input type="radio" class="rbtAgricola" name="agricolaTrabajador[]" id="agricolaTrabajadorNO" value="0" />
                                                            NO
                                                            </label>
                                                        </div>
                                                        <script> $("input.rbtAgricola[value=<?php echo $trabajador['agricola'] ?>]").prop('checked',true) </script>                      
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
                                                        <script> $("input.rbtRevisaReloj[value=<?php echo $trabajador['revisaReloj'] ?>]").prop('checked',true) </script>                    
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
                                                        <script> $("input.rbtFullJerarquia[value=<?php echo $trabajador['fullJerarquia'] ?>]").prop('checked',true) </script>                
                                                    </div>
                                                </div>
                                               
                                                <div class="col-lg-12">
                                                    <!-- Rounded switch -->
                                                    <p>&nbsp;</p>
                                                    <label class="switch">
                                                    <input type="checkbox" name="comisiones_pendientes" id="comisiones_pendientes">
                                                    <span class="slider round"></span>
                                                    </label>
                                                    &nbsp; <strong>Pagando Comisiones pendientes</strong>
                                                    <?php if($trabajador['comisiones_pendientes'] == 1){ ?>
                                                    <script> $("#comisiones_pendientes").prop('checked',true); </script>
                                                    <?php } ?>
                                                </div>

                                                 <div class="col-lg-12">
                                                    <!-- Rounded switch -->
                                                    <p>&nbsp;</p>
                                                    <label class="switch">
                                                    <input type="checkbox" name="teletrabajo" id="teletrabajo">
                                                    <span class="slider round"></span>
                                                    </label>
                                                    &nbsp; <strong>Teletrabajo</strong>
                                                    <?php if($trabajador['teletrabajo'] == 1){ ?>
                                                    <script> $("#teletrabajo").prop('checked',true); </script>
                                                    <?php } ?>
                                                </div>
                                                
                                            </div>


                                            <!-- ****** REDUCCION DE JORNADA LABORAL 2020 ******* -->

                                            <div class="row" style="margin-top: 50px;">
                                                <div class="col-lg-6 col-sm-12">
                                                    <!-- Rounded switch -->
                                                    <p>&nbsp;</p>
                                                    <label class="switch">
                                                    <input type="checkbox" name="reduccion_laboral" id="reduccion_laboral">
                                                    <span class="slider round"></span>
                                                    </label>
                                                    &nbsp; <strong>Reduccion de jornada laboral</strong>
                                                    <?php if($trabajador['reduccion_laboral'] == 1){ ?>
                                                    <script> $("#reduccion_laboral").prop('checked',true); </script>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-lg-6 col-sm-12">
                                                    <input type="text" name="horas_reduccion_laboral_semanal" value="<?php echo $trabajador['horas_reduccion_laboral_semanal'] ?>" style="display: none;" class="form-control" placeholder="Cant. de horas semanales" readonly>
                                                    <input type="hidden" name="horario_reduccion" value='<?php echo $trabajador['horario_reduccion'] ?>'>
                                                </div>
                                                <div class="col-lg-6 col-sm-12">
                                                    <button id="btn-reduccion-laboral" style="display: none;" type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-reduccion-laboral">
                                                        Definir horas semanales
                                                    </button>
                                                    <br>
                                                    <br>
                                                    <label id="sueldo_base_reducido" style="display: none;">Sueldo imponible reducido
                                                        <input type="text" name="sueldo_base_reducido" value="<?php echo $trabajador['sueldo_base_reducido'] ?>" class="form-control" placeholder="Sueldo base reducido">
                                                    </label>
                                                </div>
                                                
                                            </div>

                                            <div class="modal fade" id="modal-reduccion-laboral">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Horas semanales</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <table class="table" id="tabla-reduccion-jornada">
                                                        <thead>
                                                            <tr>
                                                                <th> Dia</th>
                                                                <th> Hora Inicio</th>
                                                                <th> Hora Término</th>
                                                                <th class="text-right" style="padding-right: 50px;"> Horas</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $tot_horas_reduccion = 0;
                                                            $json_horario = json_decode($trabajador['horario_reduccion']);
                                                            for($j=0;$j<=4;$j++):
                                                            $day = getNombreDia($j);
                                                            $day = str_replace(['á','é','í','ó','ú'], ['a','e','i','o','u'], $day);
                                                            $dia = strtolower($day);

                                                            $arr_entrada = explode(":",$json_horario->$dia->marcaje[0]);
                                                            $arr_salida = explode(":",$json_horario->$dia->marcaje[1]);
                                                            $tot_horas_reduccion += $json_horario->$dia->horas;
                                                            ?>
                                                            <tr data-dia="<?php echo $dia; ?>">
                                                                <th style="text-transform: uppercase;"> <?php echo $dia; ?> </th>
                                                                <td>  
                                                                    <select class="reduccion_horas_inicio" id="<?php echo $dia; ?>_hora_ini">
                                                                        <option value="00">--</option>
                                                                        <?php for($i=8;$i<=20;$i++): ?>
                                                                        <option value="<?php echo leadZero($i) ?>"><?php echo leadZero($i) ?></option>
                                                                        <?php endfor; ?>
                                                                    </select>
                                                                    <script> $("#<?php echo $dia; ?>_hora_ini").val('<?php echo $arr_entrada[0] ?>') </script>


                                                                    <select class="reduccion_minutos_inicio" id="<?php echo $dia; ?>_min_ini">
                                                                        <option value="00">--</option>
                                                                        <?php for($i=0;$i<=45;$i+=15): ?>
                                                                        <option value="<?php echo leadZero($i) ?>"><?php echo leadZero($i) ?></option>
                                                                        <?php endfor; ?>
                                                                    </select>
                                                                    <script> $("#<?php echo $dia; ?>_min_ini").val('<?php echo $arr_entrada[1] ?>') </script>


                                                                </td>
                                                                <td>  
                                                                    <select class="reduccion_horas_fin" id="<?php echo $dia; ?>_hora_end">
                                                                        <option value="00">--</option>
                                                                        <?php for($i=8;$i<=20;$i++): ?>
                                                                        <option value="<?php echo leadZero($i) ?>"><?php echo leadZero($i) ?></option>
                                                                        <?php endfor; ?>
                                                                    </select>
                                                                    <script> $("#<?php echo $dia; ?>_hora_end").val('<?php echo $arr_salida[0] ?>') </script>


                                                                    <select class="reduccion_minutos_fin" id="<?php echo $dia; ?>_min_end">
                                                                        <option value="00">--</option>
                                                                        <?php for($i=0;$i<=45;$i+=15): ?>
                                                                        <option value="<?php echo leadZero($i) ?>"><?php echo leadZero($i) ?></option>
                                                                        <?php endfor; ?>
                                                                    </select>
                                                                    <script> $("#<?php echo $dia; ?>_min_end").val('<?php echo $arr_salida[1] ?>') </script>


                                                                </td>
                                                                <td class="text-right" style="padding-right: 50px;"><input type="text" value="<?php echo $json_horario->$dia->horas ?>" class="total_horas_row" style="width: 50px; border: 0px; text-align: right; outline: none;" value="0" readonly></td>
                                                            </tr>
                                                            <?php endfor; ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="4" class="text-right" style="padding-right: 50px;"> 
                                                                    Total horas <input type="text" value="<?php echo $tot_horas_reduccion; ?>" class="total_horas_total" style="width: 50px; border: 0px; text-align: right; outline: none;" value="0" readonly> 
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="btn-definir-horas-reduccion">Definir</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>



                                            <!-- ****** FIN REDUCCION DE JORNADA LABORAL 2020 ******* -->

                                        </div>
                                        <div class="col-md-6">
                                            <!--
                                                <label class="pull-left"><strong>Estado del trabajador: </strong></label>
                                                <a href="#tab_2" class="switcher pull-left <?php echo ($trabajador['activo'] ? '' : 'off' ); ?>"></a>    
                                                -->
                                            <br class="clear">
                                            <div class="box" id="box_contratos">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="tipoContratoTrabajador">Tipo Contrato</label>
                                                        <select class="form-control required" name="tipoContratoTrabajador" id="tipoContratoTrabajador">
                                                            <option value="">Seleccione Tipo Contrato</option>
                                                            <option value="1">A Plazo Fijo</option>
                                                            <option value="2">Indefinido</option>
                                                            <option value="3">Finiquitado</option>
                                                            <option value="4">Despedido</option>
                                                        </select>
                                                        <script>$("#tipoContratoTrabajador").val('<?php echo $trabajador['tipocontrato_id'] ?>') </script>                                  
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inicioContratoTrabajador">Inicio Contrato</label>
                                                        <input type="text" class="form-control required datepicker" value="<?php echo $trabajador['fechaContratoInicio'] ?>" id="inicioContratoTrabajador" name="inicioContratoTrabajador" placeholder="YYYY-mm-dd" readonly="" />
                                                    </div>
                                                    <div class="form-group" id="fin_contrato_group">
                                                        <label for="finContratoTrabajador">FIN Contrato</label>
                                                        <input type="text" class="form-control datepicker" value="<?php echo ($trabajador['fechaContratoFin'] == '0000-00-00') ? '' : $trabajador['fechaContratoFin'];  ?>" id="finContratoTrabajador" name="finContratoTrabajador" placeholder="YYYY-mm-dd" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="contratosTrabajador">Contrato Redactado</label>
                                                        <select class="form-control" name="contratosTrabajador" id="contratosTrabajador">
                                                            <option value="">Seleccione Contrato</option>
                                                            <?php foreach( $contratos as $ctt ){ ?>
                                                            <option value="<?php echo $ctt['id'] ?>"><?php echo $ctt['nombre'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="sueldoBaseContrato">Sueldo Base</label>
                                                        <input type="text" class="form-control" id="sueldoBaseContrato" name="sueldoBaseContrato" />
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-default btn-add-contrato pull-right" type="button"> Agregar Contrato &nbsp; <i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <table class="table table-striped table-bordered table-curved" id="table_contratos_trabajador">
                                                        <thead>
                                                            <tr>
                                                                <th> Tipo</th>
                                                                <th> Inicio </th>
                                                                <th> Fin </th>
                                                                <th> Contrato </th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach( $contratos_asignados as $ca ): ?>
                                                            <tr>
                                                                <td> <?php echo getTipoContrato($ca['tipocontrato_id']) ?> </td>
                                                                <td> <?php echo $ca['fechaInicio'] ?> </td>
                                                                <td> <?php echo $ca['fechaTermino'] ?> </td>
                                                                <td> <?php echo fnGetNombre($ca['contrato_id'], 'm_contrato') ?> </td>
                                                                <td class="botones">                                                             
                                                                    <button data-id="<?php echo $ca['id'] ?>" type="button" class="btn-delete-contrato"><i class="fa fa-trash"></i></button> 
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="factorHoraExtraTrabajador">Factor Hora Extra</label>
                                                <input type="text" class="form-control required" value="<?php echo $trabajador['factorHoraExtra'] ?>" id="factorHoraExtraTrabajador" name="factorHoraExtraTrabajador" />
                                            </div>
                                            <div class="form-group">
                                                <label for="factorHoraExtraEspecial">Factor Hora Extra Especial</label>
                                                <input type="text" class="form-control required" value="<?php echo $trabajador['factorHoraExtraEspecial'] ?>" id="factorHoraExtraEspecial" name="factorHoraExtraEspecial" />
                                            </div>
                                            <div class="form-group">
                                                <label for="tipoPagoTrabajador">Tipo de pago</label>
                                                <select name="tipoPagoTrabajador" id="tipoPagoTrabajador" class="form-control required">
                                                    <option value="">Seleccione</option>
                                                    <?php foreach( $tipopago as $tp ){ ?>
                                                    <option value="<?php echo $tp['id'] ?>"><?php echo $tp['nombre'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <script> $("#tipoPagoTrabajador").val('<?php echo $trabajador['tipopago_id'] ?>') </script>
                                            </div>
                                            <div class="row" id="custom_fields"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Informacion Previsional</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="datos_previsionales">
                                                    <div class="form-group">
                                                        <label for="tipoTrabajadorPrev">Tipo trabajador</label>
                                                        <select name="tipoTrabajadorPrev" id="tipoTrabajadorPrev" class="form-control required">
                                                            <option value="">Seleccione</option>
                                                            <?php foreach( $tipotrabajador as $tt ){ ?>
                                                            <option value="<?php echo $tt['id'] ?>"><?php echo $tt['nombre'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <script>$("#tipoTrabajadorPrev").val('<?php echo $trabajador['tipotrabajador_id'] ?>') </script>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="afpTrabajadorPrev">AFP</label>
                                                        <select name="afpTrabajadorPrev" id="afpTrabajadorPrev" class="form-control required">
                                                            <option value="">Seleccione</option>
                                                            <?php foreach( $afp as $a ){ ?>
                                                            <option value="<?php echo $a['id'] ?>"><?php echo $a['nombre'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <script>$("#afpTrabajadorPrev").val('<?php echo $datos_prev['afp_id'] ?>') </script>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-9">
                                                            <div class="form-group">
                                                                <label for="cargasSimplesTrabajadorPrev">Cargas Simples</label>
                                                                <input name="cargasSimplesTrabajadorPrev" id="cargasSimplesTrabajadorPrev" value="<?php echo $datos_prev['cargasSimples'] ?>" class="form-control required" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label for="tramoCargasTrabajadorPrev">Tramo Cargas</label>
                                                                <select class="form-control" name="tramoCargasTrabajadorPrev" id="tramoCargasTrabajadorPrev" required>
                                                                    <option value="A">A</option>
                                                                    <option value="B">B</option>
                                                                    <option value="C">C</option>
                                                                    <option value="D">D</option>
                                                                </select>
                                                                <script>$("#tramoCargasTrabajadorPrev").val('<?php echo $datos_prev['tramoCargas'] ?>') </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cargasMaternalesTrabajadorPrev">Cargas Maternales</label>
                                                        <input name="cargasMaternalesTrabajadorPrev" id="cargasMaternalesTrabajadorPrev" value="<?php echo $datos_prev['cargasMaternales'] ?>" class="form-control required" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cargasInvalidezTrabajadorPrev">Cargas Invalidez</label>
                                                        <input name="cargasInvalidezTrabajadorPrev" id="cargasInvalidezTrabajadorPrev" value="<?php echo $datos_prev['cargasInvalidez'] ?>" class="form-control required" />
                                                    </div>
                                                </div>
                                                <h4> Ingresar APV </h4>
                                                <div class="box" id="box_apvs" style="padding: 5px 10px;">
                                                    <div class="col-md-4 nomargin">
                                                        <div class="form-group">
                                                            <label for="institucionApvTrabajador">Institución</label>
                                                            <select name="institucionApvTrabajador" id="institucionApvTrabajador" class="form-control required">
                                                                <option value="">Seleccione</option>
                                                                <?php foreach( $instituciones as $i ){ ?>
                                                                <option value="<?php echo $i['id'] ?>"><?php echo $i['nombre'] ?></option>
                                                                <?php } ?>                                                    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 nomargin">
                                                        <div class="form-group">
                                                            <label for="tipoMonedaApvTrabajador">Tipo Moneda</label>
                                                            <select name="tipoMonedaApvTrabajador" id="tipoMonedaApvTrabajador" class="form-control required">
                                                                <?php foreach( $tipomoneda as $t ){ ?>
                                                                <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 nomargin">
                                                        <div class="form-group">
                                                            <label for="tipoApvTrabajador">Tipo</label>
                                                            <select class="form-control required" name="tipoApvTrabajador" id="tipoApvTrabajador">
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 nomargin">
                                                        <div class="form-group">
                                                            <label for="montoApvTrabajador">Monto</label>
                                                            <input name="montoApvTrabajador" id="montoApvTrabajador" class="form-control required" type="text" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 nomargin">
                                                        <button class="btn btn-default btn-add-apv" type="button"><i class="fa fa-plus-circle"></i></button>
                                                    </div>
                                                    <div class="form-group">
                                                        <table class="table table-striped table-bordered table-curved" id="table_apv_trabajador">
                                                            <thead>
                                                                <tr>
                                                                    <th> Institución </th>
                                                                    <th> Tipo </th>
                                                                    <th> Tipo Moneda </th>
                                                                    <th> Monto </th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach( $apv as $a){ ?>
                                                                <tr>
                                                                    <td> <?php echo fnGetNombre($a['institucion_id'],'m_institucion', false) ?> </td>
                                                                    <td> <?php echo $a['tipo'] ?> </td>
                                                                    <td> 
                                                                        <?php 
                                                                            $bool = true;
                                                                            if( getComparte('TipoMoneda') )
                                                                                $bool = false;
                                                                            
                                                                            echo fnGetNombre($a['tipomoneda_id'],'m_tipomoneda', $bool); 
                                                                            ?> 
                                                                    </td>
                                                                    <td> 
                                                                        <?php 
                                                                            echo preg_replace('/^(\d+)\.0+$/', '$1', $a['monto']);
                                                                            //echo (number_format($a['monto'],0,'','.')) 
                                                                            ?> 
                                                                    </td>
                                                                    <td class="botones">                                                             
                                                                        <button data-id="<?php echo $a['id'] ?>" type="button" class="btn-delete-apv"><i class="fa fa-trash"></i></button> 
                                                                    </td>
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
                                                    <div class="form-group">
                                                        <div class="radio">
                                                            <label>
                                                            <input type="radio" name="optionsRadios[]" class="rbtSaludTrabajador" id="optionsRadios1" value="isapre" />
                                                            Isapre
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div id="datosIsapre" class="collapse datosSalud">
                                                        <div class="form-group">
                                                            <select class="form-control" name="isapreTrabajador" id="isapreTrabajador">
                                                                <option value="">Seleccione</option>
                                                                <?php foreach( $isapres as $i ){ ?>
                                                                <option value="<?php echo $i['id'] ?>"><?php echo $i['nombre'] ?></option>
                                                                <?php } ?>                                                    
                                                            </select>
                                                            <script> $("#isapreTrabajador").val('<?php echo $datos_prev['isapre_id'] ?>') </script>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tipoMonedaIsapreTrabajador">Tipo Moneda</label>
                                                            <select name="tipoMonedaIsapreTrabajador" id="tipoMonedaIsapreTrabajador" class="form-control required">
                                                                <?php foreach( $tipomoneda as $t ){ ?>
                                                                <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <script> $("#tipoMonedaIsapreTrabajador").val('<?php echo $datos_prev['tipomoneda_id'] ?>') </script>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="planPesoTrabajadorSalud">Plan $</label>
                                                            <input type="text" class="form-control" name="planPesoTrabajadorSalud" id="planPesoTrabajadorSalud" value="<?php echo $datos_prev['montoPlan'] ?>" />
                                                        </div>
                                                        <div class="box-header">
                                                            <h3 class="box-title">
                                                                <input type="checkbox" name="forzarPlanCompleto" id="forzarPlanCompleto" <?php if( $trabajador['forzar_plan_completo'] ){ echo 'checked'; } ?>> 
                                                                &nbsp; <label for="forzarPlanCompleto" style="font-weight: 400"> Forzar plan completo para finiquitar </label> 
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <div class="radio">
                                                            <label>
                                                            <input type="radio" name="optionsRadios[]" class="rbtSaludTrabajador" id="optionsRadios1" value="fonasa" />
                                                            Fonasa
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div id="datosFonasa" class="collapse datosSalud">
                                                        <div class="form-group">
                                                            <label for="fonasaTramoTrabajadorFonasa">Tramo</label>
                                                            <select name="fonasaTramoTrabajadorFonasa" id="fonasaTramoTrabajadorFonasa" class="form-control">
                                                                <option value="1">A</option>
                                                                <option value="2">B</option>
                                                                <option value="3">C</option>
                                                                <option value="4">D</option>
                                                            </select>
                                                            <script>$("#fonasaTramoTrabajadorFonasa").val('<?php echo $datos_prev['tramo_id'] ?>') </script>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                        if($datos_prev['fonosa']==1){
                                                            $radioValue = 'fonasa';
                                                            $idDivSalud = 'datosFonasa';                                            
                                                        } else{
                                                            $radioValue = 'isapre';
                                                            $idDivSalud = 'datosIsapre';
                                                            
                                                        }                                            
                                                        ?>
                                                    <script> $("input.rbtSaludTrabajador[value=<?php echo $radioValue ?>]").prop('checked',true) </script>
                                                    <script> 
                                                        $("#<?php echo $idDivSalud; ?>").show(); 
                                                        $("#datosIsapre input, #datosIsapre select, #datosFonasa input, #datosFonasa select").removeClass('required');
                                                        $("#<?php echo $idDivSalud; ?> input, #<?php echo $idDivSalud; ?> select").addClass('required');
                                                    </script>
                                                    <div class="box-header">
                                                        <h3 class="box-title">Cuenta 2</h3>
                                                        <div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Tiene Cuenta 2">
                                                            <div class="btn-group" data-toggle="btn-toggle">
                                                                <button type="button" class="btn btn-default btn-sm cuenta2_tooggler" value="1">SI</button>
                                                                <button type="button" class="btn btn-default btn-sm cuenta2_tooggler active" valign="0">NO</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="cuenta2_box" style="display: none;">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="tipoMonedaCuenta2Trabajador">Tipo Moneda</label>
                                                                <select name="tipoMonedaCuenta2Trabajador" id="tipoMonedaCuenta2Trabajador" class="form-control">
                                                                    <option value="">Seleccione</option>
                                                                    <?php foreach( $tipomoneda as $t ){ ?>
                                                                    <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <script>$("#tipoMonedaCuenta2Trabajador").val('<?php echo $datos_prev['tipomoneda2_id'] ?>') </script>                                             
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="montoCuenta2Trabajador">Monto</label>
                                                                <input name="montoCuenta2Trabajador" id="montoCuenta2Trabajador" value="<?php echo $datos_prev['montoCta2'] ?>" class="form-control" type="text" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="afpCuenta2TrabajadorPrev">AFP</label>
                                                                <select name="afpCuenta2TrabajadorPrev" id="afpCuenta2TrabajadorPrev" class="form-control">
                                                                    <option value="">Seleccione</option>
                                                                    <?php foreach( $afp as $a ){ ?>
                                                                    <option value="<?php echo $a['id'] ?>"><?php echo $a['nombre'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <script>$("#afpCuenta2TrabajadorPrev").val('<?php echo $datos_prev['cuenta2_id'] ?>') </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if($datos_prev['cuenta2_id']!=0){ ?>
                                                    <script>
                                                        $("#cuenta2_box").show();
                                                        $("#tipoMonedaCuenta2Trabajador").val('<?php echo $datos_prev['tipomoneda2_id'] ?>').addClass('required');
                                                        $("#montoCuenta2Trabajador").val('<?php echo $datos_prev['montoCta2'] ?>').addClass('required');
                                                        $("#afpCuenta2TrabajadorPrev").val('<?php echo $datos_prev['cuenta2_id'] ?>').addClass('required');
                                                        $("button.cuenta2_tooggler").removeClass('active');
                                                        $("button.cuenta2_tooggler[value=1]").addClass('active');
                                                    </script>   
                                                    <?php } ?>
                                                    <br>
                                                    <br>
                                                    <div class="form-group">
                                                        <label for="ccostoExterno">Centro Costo para empresa externa</label>
                                                        <select name="ccostoExterno" id="ccostoExterno" class="form-control">
                                                            <option value="">NO APLICA</option>
                                                            <?php foreach( $ccostos_externo as $a ){ ?>
                                                            <option value="<?php echo $a['codigo'] ?>"><?php echo $a['nombre'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <script>$("#ccostoExterno").val('<?php echo $trabajador['centrocosto_externo'] ?>') </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Debes y Haberes</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="col-md-12">
                                            <div class="col-md-6">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h3 class="box-title"> Debes </h3>
                                                    </div>
                                                    <div class="box-body" id="form_debe_trabajador">
                                                        <input type="hidden" name="regid_debes" id="regid_debes" value="<?php echo $trabajador['id']; ?>" />
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="mesDebeTrabajador">Mes</label>
                                                                        <select class="form-control required" name="mesDebeTrabajador" id="mesDebeTrabajador">
                                                                            <?php for( $i=1; $i<=12; $i++ ){ ?>
                                                                            <option value="<?php echo $i; ?>" <?php echo ( getMesMostrarCorte() ==$i) ? ' selected ' : ''; ?> > <?php echo getNombreMes($i); ?> </option>
                                                                            <?php } ?>                            
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="anoDebeTrabajador">Año</label>
                                                                        <input type="number" min="1900" class="form-control required" name="anoDebeTrabajador" id="anoDebeTrabajador" value="<?php echo getAnoMostrarCorte(); ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="descuentoDebeTrabajador">Descuento</label>
                                                                        <select  class="form-control required" name="descuentoDebeTrabajador" id="descuentoDebeTrabajador">
                                                                            <option value="">Seleccione</option>
                                                                            <?php foreach( $descuentos as $desc ){ ?>
                                                                            <option data-fijo="<?php echo $desc['fijo'] ?>" data-predet="<?php echo $desc['valorPredeterminado'] ?>" data-valor="<?php echo ($desc['valorPredeterminado']==1) ? $desc['valor'] : '' ?>"  data-tipo_moneda="<?php echo ($desc['valorPredeterminado']==1) ? $desc['tipomoneda_id'] : '' ?>" value="<?php echo $desc['id'] ?>"><?php echo $desc['nombre'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="glosaDebeTrabajador">Glosa adicional</label>
                                                                        <textarea class="form-control" name="glosaDebeTrabajador" id="glosaDebeTrabajador"></textarea>                                                                
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row collapse" id="debe_cuotas">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="cuotaActualDebeTrabajador">Cuota Actual</label>
                                                                        <input type="number" class="form-control" name="cuotaActualDebeTrabajador" id="cuotaActualDebeTrabajador" value="" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="totalCuotasDebeTrabajador">Total de Cuotas</label>
                                                                        <input type="number" class="form-control" name="totalCuotasDebeTrabajador" id="totalCuotasDebeTrabajador" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="valorDebeTrabajador">Valor Cuota Mensual</label>
                                                                        <input type="text" class="form-control required" name="valorDebeTrabajador" id="valorDebeTrabajador" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="tipoMonedaDescuento">Tipo Moneda</label>
                                                                        <select class="form-control required" name="tipoMonedaDescuento" id="tipoMonedaDescuento">
                                                                            <option value="">Seleccione...</option>
                                                                            <?php foreach($tipomoneda as $t){ ?>
                                                                            <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <button type="button" id="add_debe" class="btn btn-default btn-sm">Agregar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="cuptaActualtBody">
                                                                <?php                                                         
                                                                    foreach( $debes_trabajador as $dt ){ ?>
                                                                <tr id="tr_<?php echo $dt['id'] ?>">
                                                                    <td> <?php echo getNombreMes($dt['mesInicio']) ?> </td>
                                                                    <td> <?php echo $dt['anoInicio'] ?> </td>
                                                                    <td> 
                                                                        <?php 
                                                                            if( existeLiquidacion($trabajador_id) ){
                                                                                if( ( $dt['procesado'] == 1 )&& ( $dt['activo'] == 1 ) ){
                                                                                    echo ( $dt['cuotaActual'] - 1 ); 
                                                                                }else {
                                                                                    echo $dt['cuotaActual'];
                                                                                }                                                                    
                                                                            } else {
                                                                                echo $dt['cuotaActual'];    
                                                                            }
                                                                             
                                                                            ?> 
                                                                    </td>
                                                                    <td> <?php echo $dt['cuotaTotal'] ?> </td>
                                                                    <td> 
                                                                        <?php
                                                                            $bool = true;
                                                                            if( getComparte('Descuento') )
                                                                                $bool = false; 
                                                                            echo fnGetNombre($dt['descuento_id'],'m_descuento', $bool); 
                                                                            ?> 
                                                                    </td>
                                                                    <td>
                                                                        <div  data-toggle="tooltip" title="<?php echo getNombre($dt['tipomoneda_id'],'m_tipomoneda', false) ?>"> <?php echo $dt['valor'] ?> </div>
                                                                    </td>
                                                                    <td>
                                                                        <button class="delete_reg_debe" data-id="<?php echo $dt['id'] ?>" type="button" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button>
                                                                    </td>
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
                                                    <div class="box-body" id="form_haber_trabajador">
                                                        <input type="hidden" name="regid_haberes" id="regid_haberes" value="<?php echo $trabajador['id']; ?>" />
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="mesHaberTrabajador">Mes</label>
                                                                        <select class="form-control required" name="mesHaberTrabajador" id="mesHaberTrabajador">
                                                                            <?php for( $i=1; $i<=12; $i++ ){ ?>
                                                                            <option value="<?php echo $i; ?>" <?php echo (getMesMostrarCorte()==$i) ? ' selected ' : ''; ?> > <?php echo getNombreMes($i); ?> </option>
                                                                            <?php } ?>                            
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="anoHaberTrabajador">Año</label>
                                                                        <input type="number" class="form-control required" name="anoHaberTrabajador" id="anoHaberTrabajador" value="<?php echo getAnoMostrarCorte() ?>" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="descuentoHaberTrabajador">Haber</label>
                                                                        <select  class="form-control required" name="descuentoHaberTrabajador" id="descuentoHaberTrabajador">
                                                                            <option value="">Seleccione</option>
                                                                            <?php foreach( $haberes as $hab ){ ?>
                                                                            <option data-fijo="<?php echo $hab['fijo'] ?>" data-predet="<?php echo $hab['valorPredeterminado'] ?>" data-valor="<?php echo ($hab['valorPredeterminado']==1) ? $hab['valor'] : '' ?>"  data-tipo_moneda="<?php echo ($hab['valorPredeterminado']==1) ? $hab['tipomoneda_id'] : '' ?>" value="<?php echo $hab['id'] ?>"><?php echo $hab['nombre'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="glosaHaberTrabajador">Glosa adicional</label>
                                                                        <textarea class="form-control" name="glosaHaberTrabajador" id="glosaHaberTrabajador"></textarea>                                                                
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row collapse" id="haber_cuotas">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="cuotaActualHaberTrabajador">Cuota Actual</label>
                                                                        <input type="number" class="form-control" name="cuotaActualHaberTrabajador" id="cuotaActualHaberTrabajador" value="" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="totalCuotasHaberTrabajador">Total de Cuotas</label>
                                                                        <input type="number" class="form-control" name="totalCuotasHaberTrabajador" id="totalCuotasHaberTrabajador" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="valorHaberTrabajador">Valor</label>
                                                                        <input type="number" class="form-control required" name="valorHaberTrabajador" id="valorHaberTrabajador" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="tipoMonedaHaber">Tipo Moneda</label>
                                                                        <select class="form-control required" name="tipoMonedaHaber" id="tipoMonedaHaber">
                                                                            <option value="">Seleccione...</option>
                                                                            <?php foreach($tipomoneda as $t){ ?>
                                                                            <option value="<?php echo $t['id'] ?>"><?php echo $t['nombre'] ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <button type="button" id="add_haber" class="btn btn-default btn-sm">Agregar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach( $haberes_trabajador as $dt ){ ?>
                                                                <tr id="tr_<?php echo $dt['id'] ?>">
                                                                    <td> <?php echo getNombreMes($dt['mesInicio']) ?> </td>
                                                                    <td> <?php echo $dt['anoInicio'] ?> </td>
                                                                    <td> 
                                                                        <?php 
                                                                            if( existeLiquidacion($trabajador_id) ){
                                                                                if( ( $dt['procesado'] == 1 )&& ( $dt['activo'] == 1 ) ){
                                                                                    echo ( $dt['cuotaActual'] - 1 ); 
                                                                                }else {
                                                                                    echo $dt['cuotaActual'];
                                                                                }                                                                    
                                                                            } else {
                                                                                echo $dt['cuotaActual'];    
                                                                            }
                                                                             
                                                                            ?>                                                                 
                                                                    </td>
                                                                    <td> <?php echo $dt['cuotaTotal'] ?> </td>
                                                                    <td> 
                                                                        <?php
                                                                            $bool = true;
                                                                            if( getComparte('Haber') )
                                                                                $bool = false; 
                                                                            echo fnGetNombre($dt['haber_id'],'m_haber', $bool); 
                                                                            ?> 
                                                                    </td>
                                                                    <td> <?php echo $dt['valor'] ?> </td>
                                                                    <td>
                                                                        <button class="delete_reg_haber" data-id="<?php echo $dt['id'] ?>" type="button" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button>
                                                                    </td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_5">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">Ausencias y Atrasos </h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <?php if( ( empresaUsaRelojControl() ) && ( relojControlSync() ) && ( marcaTarjeta($trabajador['id']) ) ){ ?>
                                        <div class="col-md-12" id="relojcontrol_list">
                                            (Datos obtenidos de la base de datos del Reloj Control)
                                            <?php if( $parametros[2] && $parametros[3] ){ ?>
                                            <button type="button" class="btn btn-default pull-right" id="print_relojcontrol">Imprimir cartola</button>                                            
                                            <button type="button" class="btn btn-default pull-right" style="margin-right: 15px;" onclick="location.href='<?php echo BASE_URL . '/' . $entity . '/' . $parametros[0]. '/' . $parametros[1] . '/#tab_5' ?>'"> <i class="fa fa-chevron-left"></i> &nbsp; Volver</button>
                                            <?php } else { ?>
                                            <button type="button" class="btn btn-default pull-right" id="print_relojcontrol">Imprimir cartola <strong>Periodo Corte</strong></button>
                                            <?php } ?>
                                            <h4 class="box-title"> Horario del trabajador: de <strong><?php echo $m_horario_entrada ?></strong> a <strong><?php echo $m_horario_salida ?></strong> </h4>
                                            <?php 
                                                if( $parametros[2] && $parametros[3] ){
                                                ?>
                                            <div class="box box-solid box_datos_reloj">
                                                <div class="box-header">
                                                    <h3 class="box-title"> Ausencias, Atrasos y Horas Extras </h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" style="background: #fff;" id="table_reloj_control">
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
                                                                        $hora_marcada_ini_fds = '';
                                                                        $hora_marcada_out_fds = '';
                                                                        
                                                                        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                                                                        
                                                                        $fecha_iterar = date("Y-m-d", $i);
                                                                        $es_ausencia = comprobarAusencia($fecha_iterar, $trabajador['id']);
                                                                        
                                                                        if( estaFiniquitado($trabajador['id'],$fecha_iterar) ){
                                                                            break;
                                                                        }
                                                                        
                                                                        $fecha_iterar_int = str_replace("-","",$fecha_iterar);
                                                                        $fecha_iterar_int = (int)$fecha_iterar_int;
                                                                        ?>
                                                                    <tr>
                                                                        <?php 
                                                                            $dia_semana = date('N', strtotime($fecha_iterar));
                                                                            $dia_semana--;
                                                                            if( !in_array($dia_semana,$dias_laborales_horario) ){ // Si es un dia NO laboral, se pueden agregar horas extras en caso que se trabaje
                                                                            $tipo_j = 'H';
                                                                            
                                                                            
                                                                            foreach( $entradas as $I ){
                                                                                $datereg = explode(" ",$I['checktime']);                                                                            
                                                                                $fecha_comparar = date_create($I['checktime']);
                                                                                $fecha_comparar = date_format($fecha_comparar,"Y-m-d");
                                                                                
                                                                                if($fecha_iterar == $fecha_comparar){
                                                                                    $hora_marcada_ini_fds = $datereg[1];                                                                                
                                                                                }                                                                                                                                                      
                                                                            }
                                                                            
                                                                            
                                                                            foreach( $salidas as $O ){
                                                                                $datereg = explode(" ",$O['checktime']);                                                                            
                                                                                $fecha_comparar = date_create($O['checktime']);
                                                                                $fecha_comparar = date_format($fecha_comparar,"Y-m-d");
                                                                                
                                                                                if($fecha_iterar == $fecha_comparar){
                                                                                    $hora_marcada_out_fds = $datereg[1];                                                                                
                                                                                }
                                                                            }
                                                                            ?>
                                                                        <td class="no_laboral"><?php echo translateDia( date('D', strtotime($fecha_iterar)) ) . ": " . $fecha_iterar; ?></td>
                                                                        <td class="no_laboral" style="text-align: left;">
                                                                            <?php                                                                                     
                                                                                $arr_marcajes = getMarcajeFDS($fecha_iterar, $trabajador_id);
                                                                                if( $arr_marcajes['entrada'] != "" ){
                                                                                    $time = strtotime($arr_marcajes['entrada']['checktime']);
                                                                                    ?>
                                                                            <span class="badge">
                                                                            <?php 
                                                                                $horario_entrada_no_laboral = date('H:i:s',$time);
                                                                                echo $horario_entrada_no_laboral;
                                                                                ?>
                                                                            </span>
                                                                            <?php
                                                                                } 
                                                                                ?>
                                                                        </td>
                                                                        <td class="no_laboral">&nbsp;</td>
                                                                        <td class="no_laboral">
                                                                            <?php                                                                                     
                                                                                $arr_marcajes = getMarcajeFDS($fecha_iterar, $trabajador_id);                                                                                    
                                                                                if( $arr_marcajes['salida'] != "" ){
                                                                                    $time = strtotime($arr_marcajes['salida']['checktime']);
                                                                                    ?>
                                                                            <span class="badge">
                                                                            <?php echo date('H:i:s',$time); ?>
                                                                            </span>
                                                                            <?php
                                                                                } 
                                                                                ?>
                                                                        </td>
                                                                        <td class="no_laboral">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                <input type="checkbox" class="chk_autorize holi" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos_horaextra as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][io]" value="I" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_marcada]" value="<?php echo date('H:i:s',$time); ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][comentario]" class="hd_comm_ahe" value="" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][no_laboral]" value="<?php echo $horario_entrada_no_laboral; ?>" />
                                                                                <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                            </div>
                                                                        </td>
                                                                        <?php } elseif( isDiaFeriado($fecha_iterar) ){ ?> 
                                                                        <td class="no_laboral"><?php echo  translateDia( date('D', strtotime($fecha_iterar)) ) . ": " . $fecha_iterar; ?></td>
                                                                        <td class="no_laboral">
                                                                            <?php    
                                                                                $tipo_j = 'H';                                                                                 
                                                                                   $arr_marcajes = getMarcajeFDS($fecha_iterar, $trabajador_id);                                                                                    
                                                                                   if( $arr_marcajes['entrada'] != "" ){
                                                                                       $time = strtotime($arr_marcajes['entrada']['checktime']);
                                                                                       ?>
                                                                            <span class="badge">
                                                                            <?php 
                                                                                $horario_entrada_no_laboral = date('H:i:s',$time);
                                                                                echo $horario_entrada_no_laboral;
                                                                                ?>
                                                                            </span>
                                                                            <?php
                                                                                } 
                                                                                ?>
                                                                        </td>
                                                                        <td class="no_laboral">&nbsp;</td>
                                                                        <td class="no_laboral">
                                                                            <?php                                                                                     
                                                                                $arr_marcajes = getMarcajeFDS($fecha_iterar, $trabajador_id);                                                                                    
                                                                                if( $arr_marcajes['salida'] != "" ){
                                                                                    $time = strtotime($arr_marcajes['salida']['checktime']);
                                                                                    ?>
                                                                            <span class="badge">
                                                                            <?php echo date('H:i:s',$time); ?>
                                                                            </span>
                                                                            <?php
                                                                                } 
                                                                                ?>
                                                                        </td>
                                                                        <td class="no_laboral">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos_horaextra as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][io]" value="I" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_marcada]" value="<?php echo date('H:i:s',$time); ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][comentario]" class="hd_comm_ahe" value="" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][no_laboral]" value="<?php echo $horario_entrada_no_laboral; ?>" />
                                                                                <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                            </div>
                                                                        </td>
                                                                        <?php } elseif( $es_ausencia['es_ausencia'] ){ ?>
                                                                        <td class="ausente es_ausencia"><?php echo $fecha_iterar; ?></td>
                                                                        <td class="ausente es_ausencia" colspan="4" style="text-align: left;"><?php echo $es_ausencia['motivo'] ?> </td>
                                                                        <?php } else {  ?>
                                                                        <?php 
                                                                            $flag = 0;
                                                                            foreach( $entradas as $IN ){
                                                                                
                                                                                
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
                                                                        <td class="<?php echo $cls_no_trabaja; ?>">                                                                            
                                                                            <?php echo  translateDia( date('D', strtotime($fecha_iterar)) ) . ": " . $fecha_iterar; ?> 
                                                                        </td>
                                                                        <!-- Badeclass: bg-red Ó bg-transp-->
                                                                        <?php
                                                                            /** SI es un dia laboral **/
                                                                            if( in_array($dia_semana,$dias_laborales_horario) ){
                                                                                /** SI llego atrasado, muestra en rojo **/
                                                                                if( $hora_entrada > strtotime( $m_horario_entrada ) ) {
                                                                                    $cls='bg-red';
                                                                                    $tipo_j = 'A';                                                                                
                                                                                } elseif( $hora_entrada == strtotime( $m_horario_entrada ) ) {                                                                                
                                                                                    $cls='bg-transp';
                                                                                    $tipo_j = '';                                                                                
                                                                                } else{                                                                                
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
                                                                                <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][io]" value="I" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_marcada]" value="<?php echo $datereg[1]; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][comentario]" class="hd_comm_ahe" value="<?php echo $IN['comentario'] ?>" />
                                                                                <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
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
                                                                                <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][io]" value="I" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][hora_marcada]" value="<?php echo $datereg[1]; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i' ?>][comentario]" class="hd_comm_ahe" value="<?php echo $IN['comentario'] ?>" />
                                                                                <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
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
                                                                        <td class="ausente"><?php echo  translateDia( date('D', strtotime($fecha_iterar)) ) ?> <?php echo $fecha_iterar ?> </td>
                                                                        <td class="ausente" colspan="2">
                                                                            <div class="input-group" title="No marcó">
                                                                                <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][io]" value="I" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][comentario]" class="hd_comm_ahe" value="" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'i'; ?>][no_marco]" value="1" />
                                                                                <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'i' ?>"><i class="fa fa-thumb-tack"></i></a>
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
                                                                                    $cls='bg-green';
                                                                                    $tipo_j = 'H';
                                                                                } elseif( $hora_salida == strtotime( $m_horario_salida ) ) {
                                                                                    $cls='bg-transp';
                                                                                    $tipo_j = '';
                                                                                } else{
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
                                                                                <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][io]" value="O" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][hora_marcada]" value="<?php echo $datereg[1]; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][comentario]" class="hd_comm_ahe" value="<?php echo $OUT['comentario'] ?>" />                                                                                    
                                                                                <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'o' ?>"><i class="fa fa-thumb-tack"></i></a>
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
                                                                                                                                            
                                                                            ?>
                                                                        <td class="ausente"> <small><strong>NO MARCÓ</strong></small> </td>
                                                                        <td class="ausente" colspan="2">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon" style="border-right: 1px solid #d2d6de;">
                                                                                <input type="checkbox" class="chk_autorize" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][justificado]" />
                                                                                </span>
                                                                                <select class="form-control" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][justificativo]" style="width: 200px; display: none;">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php foreach( $justificativos as $j ){ ?>
                                                                                    <option value="<?php echo $j['id'] ?>"><?php echo $j['nombre'] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <input type="text" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][hora_extra_efectiva]" value="0" class="form-control he_efectiva" style="width: 50px; display: none" maxlength="4" data-toggle="tooltip" title="Horas extra efectivas (Ej: 2.5)" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][tipo]" value="<?php echo $tipo_j; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][io]" value="O" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][fecha]" value="<?php echo $fecha_iterar; ?>" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o' ?>][comentario]" class="hd_comm_ahe" value="" />
                                                                                <input type="hidden" name="justificativo[<?php echo $fecha_iterar_int.'o'; ?>][no_marco]" value="1" />
                                                                                <a href="#" class="pinit" data-logid="<?php echo $fecha_iterar_int.'o' ?>"><i class="fa fa-thumb-tack"></i></a>
                                                                            </div>
                                                                        </td>
                                                                        <?php 
                                                                            } 
                                                                            } 
                                                                            ?>                                                                        
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
                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-sm btn-primary" id="btn_frm_crear"> <i class="fa fa-check-square-o"></i> Guardar Justificaciones</button>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                            <div class="box box-solid box_datos_reloj">
                                                <div class="box-header">
                                                    <h3 class="box-title"> Seleccione rango de fechas </h3>
                                                </div>
                                                <div class="box-body">
                                                    <div class="col-md-6">
                                                        <label for="fechaInicioRevision"> Fecha inicio </label>
                                                        <input type="text" class="form-control required datepicker" value="" id="fechaInicioRevision" name="fechaInicioRevision" placeholder="YYYY-mm-dd" readonly="" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="fechaFinRevision">Fecha Fin</label>
                                                        <input type="text" class="form-control required datepicker" value="" id="fechaFinRevision" name="fechaFinRevision" placeholder="YYYY-mm-dd" readonly="" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="button" class="btn btn-sm btn-primary" id="btn_revisar_reloj"> Revisar </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <input type="hidden" name="fI" value="<?php echo $fechaInicio; ?>" />
                                            <input type="hidden" name="fF" value="<?php echo $fechaFin; ?>" />
                                            <?php  
                                                /*                                          
                                                show_array($arr_no_IN,0);
                                                show_array($arr_no_OUT,0);
                                                show_array($arr_ausencias,0);
                                                */
                                                ?>
                                            <div class="box box-solid box_datos_reloj">
                                                <div class="box-header">
                                                    <h3 class="box-title"> Ausencias </h3>
                                                </div>
                                                <div class="box-body table-responsive">
                                                    <div class="box" id="box_add_ausencias_sync">
                                                        <div class="box-header">
                                                            <h3 class="box-title">
                                                                Ingreso de Días de Ausencias <small>(Con reloj Sync)</small>
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
                                                                        <div id="pagadoras"></div>
                                                                        <br />
                                                                        <button type="button" id="add_ausencia_sync" class="btn btn-default btn-sm">Ingresar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered" id="table_ausencias_atrasos">
                                                                    <thead>
                                                                        <tr>
                                                                            <th> 
                                                                                <?php if( $ausencias_trabajador ){ ?>
                                                                                <input data-toggle="tooltip" title="Seleccionar todas las ausencias" data-placement="right" type="checkbox" id="check_all_ausencias" /> 
                                                                                <?php } ?>
                                                                            </th>
                                                                            <th> _Desde </th>
                                                                            <th> Hasta </th>
                                                                            <th> Días </th>
                                                                            <th> Motivo </th>
                                                                            <th> Opc. </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php 
                                                                            /** AUSENCIAS SIN INC. LICENCIAS **/
                                                                            if( $ausencias_trabajador ){
                                                                                foreach( $ausencias_trabajador as $at ){ 
                                                                            ?>
                                                                        <tr id="tr_<?php echo $at['id'] ?>">
                                                                            <td> <input type="checkbox" class="check_ausencia" data-id="<?php echo $at['id'] ?>" /> </td>
                                                                            <td> <?php echo $at['fecha_inicio'] ?> </td>
                                                                            <td> <?php echo $at['fecha_fin'] ?> </td>
                                                                            <td>
                                                                                <?php echo $at['dias']; ?>
                                                                                &nbsp; 
                                                                                <i class="fa fa-info-circle info_ausencias" data-toggle="tooltip" title="Se cuenta el total de dias, independiente del corte"></i>
                                                                            </td>
                                                                            <td> <?php echo getNombre($at['ausencia_id'], 'm_ausencia', false) ?> </td>
                                                                            <td> <button data-id="<?php echo $at['id'] ?>" type="button" id="delete_from_list" class="delete_ausencia_trabajador btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>
                                                                        </tr>
                                                                        <?php
                                                                            } 
                                                                            }
                                                                            ?>
                                                                        <?php
                                                                            /** AHORA SE RECORREN LAS LICENCIAS **/ 
                                                                            if( $licencias_trabajador ){
                                                                                foreach( $licencias_trabajador as $lic ){ 
                                                                            ?>
                                                                        <tr id="tr_<?php echo $lic['id'] ?>">
                                                                            <td> <input type="checkbox" class="check_ausencia" data-id="<?php echo $lic['id'] ?>" /> </td>
                                                                            <td> <?php echo $lic['fecha_inicio'] ?> </td>
                                                                            <td> <?php echo $lic['fecha_fin'] ?> </td>
                                                                            <td>
                                                                                <?php echo $lic['dias']; ?>
                                                                                &nbsp; 
                                                                                <i class="fa fa-info-circle info_ausencias" data-toggle="tooltip" title="Se cuenta el total de dias, independiente del corte"></i>
                                                                            </td>
                                                                            <td><?php echo getNombre($lic['ausencia_id'], 'm_ausencia', false) ?> </td>
                                                                            <td> <button data-id="<?php echo $lic['id'] ?>" type="button" id="delete_from_list" class="delete_ausencia_trabajador btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>
                                                                        </tr>
                                                                        <?php
                                                                            } 
                                                                            }
                                                                            ?>
                                                                    </tbody>
                                                                </table>
                                                                <button id="btn_delete_ausencia_batch" data-toggle="tooltip" title="Borrar todas las ausencias seleccionadas" class="btn btn-warning btn-sm pull-left" type="button"><i class="fa fa-trash"></i> Borrar Ausencias</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } else { ?>
                                        <div class="col-md-12" id="relojcontrol_inputs">
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
                                                                <option value="<?php echo $numero_nuevafecha; ?>"> <?php echo $nombre_nuevafecha; ?> </option>
                                                                <option value="<?php echo date('n'); ?>"> <?php echo getNombreMes(date('n')); ?> </option>
                                                            </select>
                                                            <script> $("#mesAusenciaAtraso").val('<?php echo (int)getMesMostrarCorte() ?>') </script>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="anoAusenciaAtraso">Año</label>
                                                            <input type="text" class="form-control required" name="anoAusenciaAtraso" id="anoAusenciaAtraso" value="<?php echo date('Y') ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">                                                        
                                                            <label for="minutosAtraso">Horas Antrasos</label>
                                                            <input value="<?php echo $minutos_trabajador['hrRetraso'] ?>" type="text" min="0" class="form-control required" name="minutosAtraso" id="minutosAtraso" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="minutosExtraNormal">Horas Extra Normal</label>
                                                            <input value="<?php echo $minutos_trabajador['hrExtra'] ?>" type="text" min="0" class="form-control required" name="minutosExtraNormal" id="minutosExtraNormal" value="" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="minutosExtraFestivo">Horas Extra Festivo</label>
                                                            <input value="<?php echo $minutos_trabajador['hrExtraFestivo'] ?>" type="text" min="0" class="form-control required" name="minutosExtraFestivo" id="minutosExtraFestivo" value="" />
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
                                                                        <th> Desde_ </th>
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
                                                                                $days_diff = $interval->format('%a');
                                                                                $days_diff++;
                                                                                echo $days_diff;
                                                                                ?>
                                                                        </td>
                                                                        <td> <?php echo fnGetNombre($at['ausencia_id'],'m_ausencia', false) ?> </td>
                                                                        <td> <button class="delete_ausencia_trabajador" data-id="<?php echo $at['id'] ?>" type="button" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></button> </td>
                                                                    </tr>
                                                                    <?php
                                                                        } 
                                                                        }
                                                                        ?>
                                                                    <?php 
                                                                        if( $licencias_trabajador ){
                                                                            foreach( $licencias_trabajador as $at ){ 
                                                                        ?>
                                                                    <tr id="tr_<?php echo $at['id'] ?>">
                                                                        <td> <?php echo $at['fecha_inicio'] ?> </td>
                                                                        <td> <?php echo $at['fecha_fin'] ?> </td>
                                                                        <td>
                                                                            <?php 
                                                                                $datetime1 = date_create($at['fecha_inicio']);
                                                                                $datetime2 = date_create($at['fecha_fin']);
                                                                                $interval = date_diff($datetime1, $datetime2);
                                                                                $days_diff = $interval->format('%a');
                                                                                $days_diff++;
                                                                                echo $days_diff;
                                                                                ?>
                                                                        </td>
                                                                        <td> <?php echo fnGetNombre($at['ausencia_id'],'m_ausencia', false) ?> </td>
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
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title"> Documentación</h3>
                                    </div>
                                    <!-- /.box-header -->                                
                                    <div class="box-body">
                                        <div class="col-md-6">
                                            <strong>Subir documento nuevo</strong><br /><br />
                                            <div class="form-group">
                                                <label for="docTrabajadorTitulo">Titulo del Documento</label>
                                                <input type="text" name="docTrabajadorTitulo" id="docTrabajadorTitulo" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label for="docTrabajadorDocumento">Documento Escaneado</label>
                                                <input type="file" id="docTrabajadorDocumento" name="docTrabajadorDocumento" />
                                            </div>
                                            <div class="form-group">
                                                <br class="clear" /><br class="clear" />
                                                <button type="button" name="btnSubirDoc" id="btnSubirDoc" value="" class="btn btn-primary"> Subir Documento </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Listado de documentos</strong><br /><br />
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th> Nombre </th>
                                                            <th style="text-align: right;"> Opciones </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach( $documentos_trabajador as $doc ){ ?>
                                                        <tr id="row_doc_<?php echo $doc['id'] ?>">
                                                            <td> <?php echo $doc['nombre'] ?> </td>
                                                            <td style="text-align: right;">
                                                                <button data-id="<?php echo $doc['id'] ?>" type="button" class="viewDocTrabajador btn btn-xs btn-default"><i class="fa fa-search"></i></button>
                                                                <button data-id="<?php echo $doc['id'] ?>" type="button" class="btn btn-xs btn-default deleteDocTrabajador"><i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary" id="btn_frm_crear">Guardar Datos Trabajador</button>                
                    <button type="button" name="action" value="" class="btn btn-primary pull-right" onclick="location.href='<?php echo BASE_URL ?>/liquidacion/ver/<?php echo $trabajador['id']; ?>'"> <i class="fa fa-file-text"></i> &nbsp; Liquidar Trabajador</button>                            
                </div>
        </div>
        </section>
</div>
<!-- /.content-wrapper -->
</form>
<script>
    $(document).ready(function(){

        <?php if($trabajador['reduccion_laboral'] == 1){ ?>
        $("[name=horas_reduccion_laboral_semanal]").show();
        $("#btn-reduccion-laboral").show();
        $("#sueldo_base_reducido").show();
        <?php } ?>

        $("#btn-definir-horas-reduccion").click(function(){
            $("[name=horas_reduccion_laboral_semanal]").val( $(".total_horas_total").val() );
            obj = {};
            $("#tabla-reduccion-jornada tbody tr").each(function(){
                my_tr = $(this);
                dia = my_tr.data('dia');
                time_inicio = my_tr.find('.reduccion_horas_inicio').val() + ':' + my_tr.find('.reduccion_minutos_inicio').val();
                time_fin = my_tr.find('.reduccion_horas_fin').val() + ':' + my_tr.find('.reduccion_minutos_fin').val();
                obj[dia] = {
                    'marcaje' : [time_inicio,time_fin],
                    'horas' : my_tr.find('.total_horas_row').val()
                };
            })

            obj.horas = $(".total_horas_total").val();

            $("[name=horario_reduccion]").val( JSON.stringify(obj) );
        })
        

        $("#tabla-reduccion-jornada select").change(function(){
            my_tr = $(this).closest('tr');

            time_inicio = my_tr.find('.reduccion_horas_inicio').val() + ':' + my_tr.find('.reduccion_minutos_inicio').val() + ':00';
            time_fin = my_tr.find('.reduccion_horas_fin').val() + ':' + my_tr.find('.reduccion_minutos_fin').val() + ':00';

            var diff = ( new Date("1970-1-1 " + time_fin) - new Date("1970-1-1 " + time_inicio) ) / 1000 / 60 / 60;  
            
            if( diff >= 0 ){
                my_tr.find('.total_horas_row').val(diff);    
            }


            tot = 0;
            $(".total_horas_row").each(function(){
                tot += parseFloat($(this).val());
            })
            $(".total_horas_total").val(tot)
        })


        $("#reduccion_laboral").change(function(){
            if( $(this).prop('checked') == true ){
                $("[name=horas_reduccion_laboral_semanal]").show();
                $("#btn-reduccion-laboral").show();
                $("#sueldo_base_reducido").show();
            } else {
                $("[name=horas_reduccion_laboral_semanal]").hide();
                $("#btn-reduccion-laboral").hide();
                $("#sueldo_base_reducido").hide();
            }
        })

        $("#motivoAusencia").change(function(){
            idMotivo = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                data: "idMotivo="+ idMotivo +"&action=get_if_licencia",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
                success: function (json) {
                    if( json.es_licencia == "TRUE" ){
                        html = '<label for="pagadora_licencia">Entidad Pagadora de Licencia</label>';
                        html += '<select class="form-control required" name="pagadora_licencia" id="pagadora_licencia">';
                        html += '<option value="">Seleccione</option>';
                        html += '<optgroup label="Entidades pagadoras">';
                        $.each(json.entidades,function(k,entidad){
                            html += '<option value="'+ entidad.codigo +'">'+ entidad.nombre +'</option>';
                        })

                        html += '</optgroup>';
                        html += '</select>';
                        $("#pagadoras").html(html);
                    } else {
                        $("#pagadoras").empty();
                    }
                    $(".overlayer").hide();
                }
            })    
        })
        
        $("#btn_revisar_reloj").click(function(){
            inicio = $("#fechaInicioRevision").val();
            fin = $("#fechaFinRevision").val();
            location.href = '<?php echo BASE_URL . '/' . $entity . '/' . $parametros[0]. '/' . $parametros[1] . '/' ?>' + inicio + '/' + fin + '#tab_5';
        })
        
        $(document).on('click','#btn_delete_ausencia_batch', function(e){
            e.preventDefault();
            var array_id = '';            
            $(".check_ausencia:checked").each(function(){
                 array_id += $(this).data('id') + ',';
            });        
            
            var conf = confirm('¿Eliminar los registros seleccionados?');        
            if( conf ){
                $.ajax({
              type: "POST",
              url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
              data: "ids="+array_id+"&action=delete_ausencia_trabajador_batch",
                    dataType: 'json',
                    beforeSend: function(){
                        $(".overlayer").show();
                    },
              success: function (json) {
                   //if( json.status == 'OK' ){
                       //window.location.reload();
                             $("#frmCrear")[0].submit();
                   //}
                    }
            })
            }
        })
        
        $("#check_all_ausencias, .check_ausencia").click(function(){
            if( $(".check_ausencia:checked").length > 0 ){
                $("#btn_delete_ausencia_batch").show();
            } else {
                $("#btn_delete_ausencia_batch").hide();
            }
        })
        
        $("#check_all_ausencias").click(function(){
            if( $(this).prop('checked') == true ){
                $(".check_ausencia").prop('checked',true);
                $("#btn_delete_ausencia_batch").show();
            } else {
                $(".check_ausencia").prop('checked',false);
                $("#btn_delete_ausencia_batch").hide();
            }
        })
        
        $(".he_efectiva").blur(function(){
            val = $(this).val();
            val = val.toLowerCase();
            if( ( val.charAt(0) == 'm' ) || ( val.charAt(0) == 'M' ) ){
                arr_val = val.split("m");
                int_minutos = arr_val[1];
                en_horas = ( int_minutos / 60 );
                en_horas = (Math.round( en_horas * 100) / 100);
                
                $(this).val( en_horas );
            }
        })
        
        $(".nav-tabs a").click(function(){
            window.location.hash = $(this).attr('href');
        })
        
        $("#print_relojcontrol").click(function(){
            <?php if( $parametros[2] && $parametros[3] ){ ?>        
            window.open('<?php echo BASE_URL . "/$entity/relojcontrol/$trabajador_id/$parametros[2]/$parametros[3]" ?>','','width=800,height=600');
            <?php } else { ?>
            window.open('<?php echo BASE_URL . "/$entity/relojcontrol/$trabajador_id" ?>','','width=800,height=600');
            <?php } ?>
        })
        
        $("select.cbo_justificativo_").change(function(){
            if( confirm( '¿Cambiar el motivo de la ausencia?' ) ){
                id_ausencia_trabajador = $(this).data('id-ausencia-trabajador');
                id_ausencia = $(this).val();
                $.ajax({
              type: "POST",
              url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
              data: "id_t_ausencia="+id_ausencia_trabajador+"&id_m_ausencia="+id_ausencia+"&action=actualizar_ausencia",
                    dataType: 'json',
                    beforeSend: function(){
                        $(".overlayer").show();
                    },
              success: function (json) {               
                   if( json.status == 'OK' ){                                                                    
                       $(".overlayer").hide();
                   }
                    }
            })
            }
        })
        
        $(".cuenta2_tooggler").click(function(){
            if( $(this).val() == 1 ){
                $("#tipoMonedaCuenta2Trabajador, #afpCuenta2TrabajadorPrev, #montoCuenta2Trabajador").val('').addClass('required');            
                $("#cuenta2_box").slideDown('fast');
            } else {            
                $("#tipoMonedaCuenta2Trabajador, #afpCuenta2TrabajadorPrev, #montoCuenta2Trabajador").val('').removeClass('required');            
                $("#cuenta2_box").slideUp('fast');
            }
        })
        
        $(".chk_autorize").click(function(){
            if($(this).is(':checked')){            
                $(this).closest('.input-group').find('.form-control').show();
                $(this).closest('.input-group').find('.pinit').show();
                $(this).closest('.input-group').find('select.form-control').addClass('required');
            } else {
                $(this).closest('.input-group').find('select.form-control').removeClass('required');
                $(this).closest('.input-group').find('.form-control').hide();
                $(this).closest('.input-group').find('.pinit').hide();            
            }
        })
        
        <?php 
        foreach( $t_atrasohoraextra as $ahe ){
            $ahe['horas'] = procesarDecimal($ahe['horas']);
            $fecha_int = str_replace("-","",$ahe['fecha']);
            $lowerIO = strtolower($ahe['io']);
        
            if( $ahe['logid'] ){
            ?>
            /* Tiene LOGID */
            $("input[name='justificativo[<?php echo $fecha_int.$lowerIO ?>][justificado]']").prop('checked',true);
            $("input[name='justificativo[<?php echo $fecha_int.$lowerIO ?>][hora_extra_efectiva]']").val('<?php echo $ahe['horas'] ?>');
            $("select[name='justificativo[<?php echo $fecha_int.$lowerIO ?>][justificativo]']").val('<?php echo $ahe['justificativo_id'] ?>');
            $("input[name='justificativo[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.form-control').show();
            $("input[name='justificativo[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.pinit').show();
            $("input[name='justificativo[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.pinit').attr('data-toggle','tooltip');
            $("input[name='justificativo[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.pinit').attr('title','<?php echo $ahe['comentario'] ?>');
            $("input[name='justificativo[<?php echo $fecha_int.$lowerIO ?>][comentario]']").val('<?php echo $ahe['comentario'] ?>');
            /* Tiene LOGID */
        <?php 
        } else { 
            if( $ahe['io'] == 'I' )
                $justificativo_no_marco = 'justificativo';
            else 
                $justificativo_no_marco = 'justificativo';
        ?>
            
            /* NO LOGID */
            $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").prop('checked',true);
            $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][hora_extra_efectiva]']").val('<?php echo $ahe['horas'] ?>');
            $("select[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificativo]']").val('<?php echo $ahe['justificativo_id'] ?>');
            $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.form-control').show();
            $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.pinit').show();
            $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.pinit').attr('data-toggle','tooltip');
            $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][justificado]']").closest('.input-group').find('.pinit').attr('title','<?php echo $ahe['comentario'] ?>');
            $("input[name='<?php echo $justificativo_no_marco ?>[<?php echo $fecha_int.$lowerIO ?>][comentario]']").val('<?php echo $ahe['comentario'] ?>');
            /* NO LOGID */
    
        <?php
        }
        } 
        ?>
        
        pinit_clicked = false;
        $(".pinit").click(function(e){
            pinit_clicked = $(this);
            logid = $(this).data('logid');
            val = $(this).data('original-title');        
            e.preventDefault();
            
            html = '<div class="modal-dialog pin_comment">';
            html += '    <div class="modal-content">';
            html += '      <div class="modal-header">';
            html += '        <button type="button" class="close closeModal" aria-label="Close"><span aria-hidden="true">×</span></button>';
            html += '        <h4 class="modal-title">Agregar comentario a la justificación</h4>';
            html += '      </div>';
            html += '      <div class="modal-body">';
            html += '        <input type="text" value="'+val+'" placeholder="Ingrese comentario..." class="form-control" id="ahe_comment" maxlength="100" />';
            html += '      </div>';
            html += '      <div class="modal-footer">';
            html += '        <button type="button" class="btn btn-default pull-left closeModal">Cerrar</button>';
            html += '        <button type="button" data-logid="'+logid+'" class="btn btn-primary" id="save_ahe_comment">Guardar</button>';
            html += '      </div>';
            html += '    </div>';
            html += '  </div>';
            
            $(".overlayer:first").css('opacity','0.9').show();
            $("body").append( html );
        })
        
        $(document).on('click', '.closeModal', function(){
            $(".overlayer:first").hide();
            $(".pin_comment").remove();
        })
        
        $(document).on('click', '#save_ahe_comment', function(){
            logid = $(this).data('logid');
            comment = $(this).closest('.pin_comment').find("#ahe_comment").val();
            
            $.ajax({
          type: "POST",
          url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
          data: "logid="+logid+"&comment="+comment+"&trabajador_id=<?php echo $trabajador_id ?>&action=add_ahe_comment",
                dataType: 'json',
                beforeSend: function(){                
                },
          success: function (json) {
                    pinit_clicked.attr('data-toggle','tooltip');
                    pinit_clicked.attr('data-original-title',comment);
                    pinit_clicked.closest('.input-group').find('.hd_comm_ahe').val(comment);
                    $(".overlayer:first").hide();
                    $(".pin_comment").remove();                
                    //$("#frmCrear")[0].submit();
                }
        })
        })
        
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
                var element_id = $(this).attr('id');
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
                   }
                         if( element_id == 'delete_from_list' ){
                            //window.location.reload();
                            $("#frmCrear")[0].submit();
                         } else {
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
            $("#tab_1 .required, #tab_2 .required, .datos_previsionales .required, #table_reloj_control .required").each(function(){
                if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
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
            } else {
                $("#frmCrear #btn_frm_crear").attr('data-toggle','tooltip');
                $("#frmCrear #btn_frm_crear").attr('data-original-title','Tiene campos requeridos sin completar');
                $("#frmCrear #btn_frm_crear").tooltip('show');
            }
        
        }) 
    
    
        
        $("#add_minutos").click(function(e){        
            e.preventDefault();
            err=0;
            $("#trabajadorMinutos .required").each(function(){
                if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
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
                if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
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

                if( $("#pagadora_licencia").length == 0 ){
                    dat += 'pagadora_licencia=0&';
                }
                
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
        
        
        
        $("#add_ausencia_sync").click(function(e){
            e.preventDefault();        
            err=0;
            $("#box_add_ausencias_sync .required").each(function(){
                if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
                    $(this).parent().addClass('has-error');                
                    err++;
                } else {
                    $(this).parent().removeClass('has-error');                
                }
            })
            
            if( err == 0 ){
                var dat = '';
                $('#box_add_ausencias_sync input, #box_add_ausencias_sync select').each(function(){
                    dat += $(this).attr('id') + "=" + $(this).val() + "&";
                });                    


            $.ajax({
                type: "POST",
                url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                data: dat + "action=check_ausencia_reloj&userid=" + $("#relojControlIdTrabajador").val(),
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
                success: function (json) {
                   if( json.exist == 'TRUE' ){
                       if( confirm('Existen registros en el reloj control que coinciden con la Ausencia ingresada\n\nEste registro sera reemplazado en el reloj control\n\n¿Proceder?') ){
                            var dat = '';
                            $('#box_add_ausencias_sync input, #box_add_ausencias_sync select').each(function(){
                                dat += $(this).attr('id') + "=" + $(this).val() + "&";
                            });
                            dat += 'regid_ausencias=<?php echo $trabajador['id'] ?>&';
                            if( $("#pagadora_licencia").length == 0 ){
                                dat += 'pagadora_licencia=0&';
                            }
                            $.ajax({
                                type: "POST",
                                url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                                data: dat + "action=add_ausencia",
                                dataType: 'json',
                                beforeSend: function(){
                                    $(".overlayer").show();
                                },
                                success: function (json) {
                                    if( json.supera_vacaciones == 'TRUE' ){
                                       alert('Atencion\nEsta pidiendo mas dias de los permitidos en el año');
                                    }                         
                                    $("#frmCrear")[0].submit();
                                }
                            })
                       } else {
                           $(".overlayer").hide();   
                       }
                   } else {
                            var dat = '';
                            $('#box_add_ausencias_sync input, #box_add_ausencias_sync select').each(function(){
                                dat += $(this).attr('id') + "=" + $(this).val() + "&";
                            });
                            dat += 'regid_ausencias=<?php echo $trabajador['id'] ?>&';
                            if( $("#pagadora_licencia").length == 0 ){
                                dat += 'pagadora_licencia=0&';
                            }

                            $.ajax({
                                type: "POST",
                                url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                                data: dat + "action=add_ausencia",
                                dataType: 'json',
                                beforeSend: function(){
                                    $(".overlayer").show();
                                },
                                success: function (json) {
                                    $("#frmCrear")[0].submit();
                                }
                            })
                       }
                    }
                })
                            
            }                
        })
        
        
        $("#add_debe").click(function(e){    
            e.preventDefault();
            err=0;
            $("#form_debe_trabajador .required").each(function(){
                if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
                    $(this).parent().addClass('has-error');                
                    err++;
                } else {
                    $(this).parent().removeClass('has-error');                
                }
            })
            
            data_valida_desc  = $('option:selected', $("#descuentoDebeTrabajador")).data();
            if( data_valida_desc.fijo == 0 ){
                if(( $("#cuotaActualDebeTrabajador").val() <= 0 ) && ( $("#totalCuotasDebeTrabajador").val() > 0 ) ){
                    $("#cuotaActualDebeTrabajador").parent().addClass('has-error');
                    $("#cuotaActualDebeTrabajador").parent().find('label').append(' <small>(No puede ser 0)</small>');
                    err++;
                }
                
                if( parseInt($("#cuotaActualDebeTrabajador").val()) > parseInt($("#totalCuotasDebeTrabajador").val()) ){
                    $("#cuotaActualDebeTrabajador").parent().addClass('has-error');
                    $("#cuotaActualDebeTrabajador").parent().find('label').append(' <small>(No puede ser mayor al total)</small>');
                    err++;
                }
            }
            
            
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
                if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
                    $(this).parent().addClass('has-error');                
                    err++;
                } else {
                    $(this).parent().removeClass('has-error');                
                }
            })
            
            data_valida_haber = $('option:selected', $("#descuentoHaberTrabajador")).data();
            if( data_valida_haber.fijo == 0 ){
                if(( parseInt($("#cuotaActualHaberTrabajador").val()) <= 0 ) && ( parseInt($("#totalCuotasHaberTrabajador").val()) > 0 ) ){
                    $("#cuotaActualHaberTrabajador").parent().addClass('has-error');
                    $("#cuotaActualHaberTrabajador").parent().find('label').append(' <small>(No puede ser 0)</small>');
                    err++;
                }
                
                if( parseInt($("#cuotaActualHaberTrabajador").val()) > parseInt($("#totalCuotasHaberTrabajador").val()) ){
                    $("#cuotaActualHaberTrabajador").parent().addClass('has-error');
                    $("#cuotaActualHaberTrabajador").parent().find('label').append(' <small>(No puede ser mayor al total)</small>');
                    err++;
                }
            }
            
    
            
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
        
        $(".datepicker").datepicker({
            startView : 'year',
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
    
        $("input.rbtSaludTrabajador").click(function(){
            $(".h4Salud").removeClass('has-error');
            $(".datosSalud").slideUp(200);
            $(".datosSalud input, .datosSalud select").removeClass('required');
            if( $(this).val() == 'fonasa' ){
                $("#datosFonasa").slideDown(200);
                $("#datosFonasa input, #datosFonasa select").addClass('required');
                $("#datosIsapre input, #datosIsapre select").removeClass('required');
                $("#forzarPlanCompleto").prop('checked',0);
            } else {
                $("#datosIsapre").slideDown(200);
                $("#datosIsapre input, #datosIsapre select").addClass('required');
                $("#datosFonasa input, #datosFonasa select").removeClass('required');
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
            var fechaInicio = $("#inicioContratoTrabajador").val();
            var fechaTermino = $("#finContratoTrabajador").val();
            var sueldoBase = $("#sueldoBaseContrato").val();
            var tipocontrato_id = $("#tipoContratoTrabajador").val();
                    
            $("#sueldoBaseContrato").closest('.form-group').removeClass('has-error');
            $("#contratosTrabajador").closest('.form-group').removeClass('has-error');
            
            data_get = "id_contrato="+id_contrato+"&tipocontrato_id="+tipocontrato_id+"&id_trabajador=<?php echo $parametros[1] ?>&fechaInicio="+fechaInicio+"&fechaTermino="+fechaTermino+"&sueldoBase="+sueldoBase+"&action=add_contrato";
            
            if( ( sueldoBase != "" ) && ( tipocontrato_id != "" ) ){
                $.ajax({
                  type: "POST",
                  url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                  data: data_get,
                    dataType: 'json',
                    beforeSend: function(){                    
                        $(".box#box_contratos").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
                    },
                  success: function (json) { 
                        $("#sueldoBaseContrato").val("");
                       if( json.status == 'OK' ){
                            $(".box#box_contratos .overlay").remove();
                            ht = '<tr>';                          
                            ht += '    <td> '+json.tipo_contrato+' </td>';
                            ht += '    <td> '+json.fechaInicio+' </td>';
                            ht += '    <td> '+json.fechaTermino+' </td>';
                            ht += '    <td> '+json.contrato+' </td>';                        
                            ht += '    <td class="botones">';                        
                            ht += '        <button data-id="'+json.id+'" type="button"><i class="fa fa-trash"></i></button>';
                            ht += '    </td>';
                            ht += '</tr>';
                            
                            $("#table_contratos_trabajador tbody").prepend(ht);
                            $("#contratosTrabajador").val('');
                       }
                    }
                })
            } else {
                $("#sueldoBaseContrato").closest('.form-group').addClass('has-error');
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
                if( ( $(this).val() == "" ) || ( $(this).val() == null ) ){
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
                       tipo: $("#tipoApvTrabajador").val(),
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
                
                    
        current_editing = false;
        $(document).on('change','input, select', function(){    
            current_editing = true;
        })
        
        
        $("#btnSubirDoc").click(function(){
            err = 0;
            $("#docTrabajadorTitulo, #docTrabajadorDocumento").parent().find('label').find('small').remove();
            
            if( $("#docTrabajadorTitulo").val() == "" ){
                $("#docTrabajadorTitulo").parent().addClass('has-error');  
                $("#docTrabajadorTitulo").parent().find('label').append(' <small> (Debe ingresar un titulo al documento)</small>');              
                err++;    
            }
            if( $("#docTrabajadorDocumento").val() == "" ){
                $("#docTrabajadorDocumento").parent().addClass('has-error');
                $("#docTrabajadorDocumento").parent().find('label').append(' <small> (Debe ingresar un documento)</small>');                
                err++;    
            }
            if( err == 0 ){
                $("#frmCrear")[0].submit();        
            }
        })
        
        
        $(".viewDocTrabajador").click(function(){
            var docId = $(this).data('id');        
            window.open('<?php echo BASE_URL ?>/private/documento.php?docId=' + docId);
             
        })    

        $(".deleteDocTrabajador").click(function(event) {
            id = $(this).data('id');
            if( confirm('¿Seguro que desea borrar el documento selecionado?') ){
                $.ajax({
                    type: "POST",
                    url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                    data: {
                        action: 'ajax_delete_doc',
                        id : id
                    },
                    dataType: 'json',
                    beforeSend: function(){
                        $(".overlayer").show();
                    },
                    success: function (json) { 
                        $("#row_doc_" + json.documento.id).fadeOut(500);
                        $(".overlayer").hide();
                    }
                })
            }
        });
            
        <?php if( $parametros[4] == 'OK' ){ ?>
        alert("Datos guardados correctamente");
        <?php } ?>
            
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
                        html += '       <input type="text" class="form-control required" id="'+valor.key+'" value="" name="camposPersonalizadosTipoPago['+valor.key+']" />';
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
            $("#comunaTrabajador").removeAttr('disabled');
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
    
    $(".switcher").click(function(e){
        e.preventDefault();
        if($(this).hasClass('off')){
            if(confirm("Seguro que quiere HABILITAR el trabajador")){
                $.ajax({
                    type: "POST",
                    url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                    data: "trabajador_id=<?php echo $trabajador_id ?>&action=cambiar_status_trabajador&new_status=1",
                    dataType: 'json',
                    beforeSend: function(){
                        $(".switcher").fadeTo(0, 0.3);
                    },
                    success: function (json) {
                        $(".switcher").removeClass('off');
                        $(".switcher").fadeTo(0, 1);
                    }
                })
            }
        } else {
            if(confirm("Seguro que quiere DESHABILITAR el trabajador")){
                $.ajax({
                    type: "POST",
                    url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
                    data: "trabajador_id=<?php echo $trabajador_id ?>&action=cambiar_status_trabajador&new_status=0",
                    dataType: 'json',
                    beforeSend: function(){
                        $(".switcher").fadeTo(0, 0.3);
                    },
                    success: function (json) {
                        $(".switcher").addClass('off');
                        $(".switcher").fadeTo(0, 1);
                    }
                })
            }
        }
    })
    
    
    $(window).load(function(){
        $(".overlayer").fadeOut('fast');
        $("#descuentoDebeTrabajador, #descuentoHaberTrabajador").select2();
    })


function timeDiff(time_ini,time_end){
    diff = ( new Date("1970-1-1 " + time_end) - new Date("1970-1-1 " + time_ini) ) / 1000 / 60 / 60;

    return diff;
}

             
</script>