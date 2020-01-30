<div class="content-wrapper">  
    <section class="content-header">
        <h1> Previred </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
    </section>
    <section class="content">
    	<div class="row">
    		<div class="col-lg-12">


                <!--<form method="post" id="frmPrevi">
                    <input type="hidden" name="action" value="obtenerEmpleados" />
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo $nombre_empresa ?>" name="nombre_empresa" id="nombre_empresa" class="form-control" readonly>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" value="<?php echo date('Y-m-d') ?>" name="fecha_ini" id="fecha_ini" class="form-control datepicker input-lg" readonly>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" id="" class="btn btn-primary btn-lg pull-right">prueba</button>
                        </div>
                    </div>
                </form>-->
                <?php if ($_POST): ?>
                <form method="post" id="frmPrevi">

                    <input type="hidden" name="action" value="enviarEmpleados" />
                    <input type="hidden" name="mesAtraso" value="<?php echo $_POST['mesAtraso'] ?>" />
                    <input type="hidden" name="anoAtraso" value="<?php echo $_POST['anoAtraso'] ?>" />

                    <div class="row">
                        <button type="submit" id="" class="btn btn-primary btn-lg pull-right">Generar Archivo Previred</button>
                    </div>

                    <div class="table-responsive">
                        
                        <table class="table table-bordered table-striped" style="background-color: #fff">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rut</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Nombres</th>
                                    <th>Sexo</th>
                                    <th>Nacionalidad</th>
                                    <th>Tipo Pago</th>
                                    <th>Periodo Desde</th>
                                    <th>Periodo Hasta</th>
                                    <th>AFP</th>
                                    <th>Tipo Trabajador</th>
                                    <th>Días Trabajados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i=1;
                                foreach ($empleados as $empleado) : 
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td style="white-space: nowrap;"><?php echo $empleado['rut']; ?></td>
                                    <td><?php echo $empleado['apellidoPaterno']; ?></td>
                                    <td><?php echo $empleado['apellidoMaterno']; ?></td>
                                    <td><?php echo $empleado['nombres']; ?></td>
                                    <td><?php echo fnSexo($empleado['sexo']); ?></td>
                                    <td><?php echo fnPais($empleado['extranjero'], $empleado['idNacionalidad']); ?></td>
                                    <td><?php echo fnTipPago($empleado['tipopago_id']); ?></td>
                                    <td><?php echo $periodoDesde; ?></td>
                                    <td><?php echo $periodoHasta; ?></td>
                                    <td>
                                        <?php 
                                        $afp = previTrabajador($empleado["id"]);
                                        echo $afp['nombre'];
                                        ?>  
                                    </td>
                                    <td>
                                        <?php 
                                        $tipoTrabajador = tipoEmpleado($empleado["tipotrabajador_id"]);
                                        echo $tipoTrabajador['nombre'];
                                        ?>
                                    </td>
                                    <td><?php echo getDiasTrabajados($empleado["id"],$_POST['mesAtraso'],$_POST['anoAtraso']);?><td>
                                        
                                    <input type="hidden" name="rut[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['rut']; ?>">
                                    <input type="hidden" name="id[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['id']; ?>">
                                    <input type="hidden" name="apellidoPaterno[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['apellidoPaterno']; ?>">
                                    <input type="hidden" name="apellidoMaterno[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['apellidoMaterno']; ?>">
                                    <input type="hidden" name="nombres[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['nombres']; ?>">
                                    <input type="hidden" name="sexo[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['sexo']; ?>">
                                    <input type="hidden" name="extranjero[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['extranjero']; ?>">
                                    <input type="hidden" name="nacionalidad[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['idNacionalidad']; ?>">
                                    <input type="hidden" name="tipo_pago[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['tipopago_id']; ?>">
                                    <input type="hidden" name="periodoDesde[<?php echo $empleado['rut']; ?>]" value="<?php echo $periodoDesde; ?>">
                                    <input type="hidden" name="periodoHasta[<?php echo $empleado['rut']; ?>]" value="<?php echo $periodoHasta; ?>">
                                    <input type="hidden" name="tipo_trabajador[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['tipotrabajador_id']; ?>">
                                    <input type="hidden" name="nombre_afp[<?php echo $empleado['rut']; ?>]" value="<?php $afp = previTrabajador($empleado["tipotrabajador_id"]);echo $afp['id']; ?>">
                                </tr>
                                <?php 
                                $i++;
                                endforeach; 
                                ?>
                            </tbody>
                        </table>

                    </div>
                    
                </form>
                <?php else: ?>
                    <form method="post">
                    <div class="box-footer">
                        <div class="row">

                            <div class="col-lg-2">
                                <div class="input-group input-group-lg">
                                    <input type="hidden" name="mesAtraso" class="hdnValue">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-warning" data-toggle="dropdown">Seleccione mes
                                        <span class="fa fa-caret-down"></span></button>
                                      <ul class="dropdown-menu" id="cboMes">
                                        <li><a href="#">Seleccione mes</a></li>
                                        <?php for($i=1;$i<=12;$i++){ ?>
                                        <li><a href="#" data-val="<?php echo $i ?>"> <?php echo getNombreMes($i) ?> </a></li>
                                        <?php } ?>
                                      </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="input-group input-group-lg">
                                    <input type="hidden" name="anoAtraso" class="hdnValue">
                                    <div class="input-group-btn">
                                      <button type="button" class="btn btn-warning" data-toggle="dropdown">Seleccione Año
                                        <span class="fa fa-caret-down"></span></button>
                                          <ul class="dropdown-menu" id="cboAno">
                                            <li><a href="#">Seleccione Año</a></li>
                                            <?php for($i=date('Y');$i>=2015;$i--){ ?>
                                            <li><a href="#" data-val="<?php echo $i ?>"> <?php echo $i ?> </a></li>
                                            <?php } ?>
                                          </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-success btn-lg pull-right">filtrar</button>
                            </div>
                        </div>
                    </div>
                    </form>
                <?php endif; ?>

    		</div>
    	</div>
    </section>
</div>

<script>
    $(document).ready(function(){
        $(".datepicker").datepicker({
            startView : 'year',
            autoclose : true,
            format : 'yyyy-mm-dd'
        });

        $(".dropdown-menu a").click(function(e){
            e.preventDefault();
            var txt = $(this).text();
            var val = $(this).data('val');
            $(this).closest('.input-group-btn').find('button.btn').html(txt + '<span class="fa fa-caret-down"></span>');
            $(this).closest('.input-group').find('.hdnValue').val(val);
        })

        $("#frmVerAtrasosMensual").submit(function(e){
            e.preventDefault();
            err=0;
            $(".overlayer").show();
            $(".hdnValue").each(function(){
                if($(this).val()==""){
                    err++;
                }
            })
            if( err == 0 ){
                $("#frmVerAtrasosMensual")[0].submit();
            } else {
                alert('Seleccione mes y Año');
                $(".overlayer").hide();
                return false;
            }
        })
        
    });
    </script>