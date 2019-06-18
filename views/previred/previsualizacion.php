
<div class="content-wrapper">  
    <section class="content-header">
        <h1> Previred </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
    </section>
    <section class="content">
    	<div class="row">
    		<div class="col-lg-12">
                <?php if ($_POST) { ?>

                <?php }else{?>

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
                <form method="post" id="frmPrevi">
                <input type="hidden" name="action" value="enviarEmpleados" />
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" style="background-color: #fff">
                            <thead>
                                <tr>
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
                                <?php foreach ($empleados as $empleado) : ?>
                                <tr>
                                    <td><?php echo $empleado['rut']; ?></td>
                                    <input type="hidden" name="rut[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['rut']; ?>">
                                    <td><?php echo $empleado['apellidoPaterno']; ?></td>
                                    <input type="hidden" name="apellidoPaterno[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['apellidoPaterno']; ?>">
                                    <td><?php echo $empleado['apellidoMaterno']; ?></td>
                                    <input type="hidden" name="apellidoMaterno[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['apellidoMaterno']; ?>">
                                    <td><?php echo $empleado['nombres']; ?></td>
                                    <input type="hidden" name="nombres[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['nombres']; ?>">
                                    <td><?php echo fnSexo($empleado['sexo']); ?></td>
                                    <input type="hidden" name="sexo[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['sexo']; ?>">
                                    <td><?php echo fnPais($empleado['idNacionalidad'], $empleado['sexo']); ?></td>
                                    <input type="hidden" name="nacionalidad[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['idNacionalidad']; ?>">
                                    <td><?php echo fnTipPago($empleado['tipopago_id']); ?></td>
                                    <input type="hidden" name="tipo_pago[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['tipopago_id']; ?>">
                                    <td><?php echo $periodoDesde; ?></td>
                                    <input type="hidden" name="periodoDesde[<?php echo $empleado['rut']; ?>]" value="<?php echo $periodoDesde; ?>">
                                    <td><?php echo $periodoHasta; ?></td>
                                    <input type="hidden" name="periodoHasta[<?php echo $empleado['rut']; ?>]" value="<?php echo $periodoHasta; ?>">
                                    <input type="hidden" name="tipo_trabajador[<?php echo $empleado['rut']; ?>]" value="<?php echo $empleado['tipotrabajador_id']; ?>">
                                    <td>
                                        <?php 
                                        $afp = previTrabajador($empleado["tipotrabajador_id"]);
                                        echo $afp['nombre'];
                                        ?>  
                                    </td>
                                    <input type="hidden" name="nombre_afp[<?php echo $empleado['rut']; ?>]" value="<?php $afp = previTrabajador($empleado["tipotrabajador_id"]);
                                        echo $afp['id']; ?>">
                                    <td>
                                        <?php 
                                        $tipoTrabajador = tipoTrabajador($empleado["tipotrabajador_id"]);
                                        echo $tipoTrabajador['nombre'];
                                        ?>
                                    </td>
                                    <td>30</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <div class="box-footer">
                                <button type="submit" id="" class="btn btn-primary btn-lg pull-right">prueba</button>
                            </div>
                        </table>
                    </div>
                </form>
                <?php }?>
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
    });
</script>