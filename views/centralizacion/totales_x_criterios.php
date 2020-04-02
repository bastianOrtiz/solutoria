<!-- Content Wrapper. Contains page content -->
<style>
tbody td{
    white-space: nowrap;
}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1> Totales por Criterios </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php include ROOT . '/views/comun/alertas.php';  ?>
    </section>
    <section class="content">
        
        <a href="<?php echo BASE_URL ?>/<?php echo $entity ?>/totales_x_criterios" class="btn btn-success btn-lg pull-right">
        Siguiente <i class="fa fa-arrow-right"></i> 
        </a>

        <div class="clear clearfix"></div>
        <br>
        <div class="box box-success">
            <div class="box-header with-border">
              <i class="fa fa-cog"></i>
              <h3 class="box-title">Totales por Centro Costo </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <?php foreach ($array_data['crit_x_ccosto'] as $ccosto_id => $value) { ?>

                    <h3> <?php echo $value['criterio'] ?>: <?php echo dinero($value['subtotal'],true) ?> </h3>

                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#ccosto_<?php echo $value['centro_costo_id'] ?>" aria-expanded="false" aria-controls="collapseExample">
                        Ver detalle <?php echo $value['criterio'] ?>
                    </button>

                    <div class="collapse" id="ccosto_<?php echo $value['centro_costo_id'] ?>">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>apellidoPaterno</th>
                                        <th>apellidoMaterno</th>
                                        <th>nombres</th>

                                        <?php  
                                        foreach ($value['totales'] as $key => $cabecera) { 
                                            echo '<th>' . $key . '</th>';
                                        }
                                        ?>
                                        <th> Subtotal </th>
                                    </tr>                        
                                </thead>
                                    <?php 
                                    $tot_imponible = 0;
                                    $tot_he = 0;
                                    $tot_he_100 = 0;
                                    $tot_bonos = 0;
                                    foreach ($arr_results[$value['centro_costo_id']] as $key => $value) { 
                                        $tot_imponible += $value['imponible'];
                                        $tot_he += $value['horaExtraMonto'];
                                        $tot_he_100 += $value['horaExtraFestivoMonto'];
                                        $tot_bonos += $value['totalHaberesImponibles'];
                                        ?>
                                        <tr>

                                            <td><?php echo $value['apellidoPaterno']; ?></td>
                                            <td><?php echo $value['apellidoMaterno']; ?></td>
                                            <td><?php echo $value['nombres']; ?></td>
                                            <td class="text-right"><?php echo number_format($value['sueldoBase'],0,',','.'); ?></td>
                                            <td class="text-right"><?php echo number_format($value['gratificacion'],0,',','.'); ?></td>
                                            <td class="text-right"><?php echo number_format($value['imponible'],0,',','.'); ?></td>
                                            <td class="text-right"><?php echo number_format($value['horaExtraMonto'],0,',','.'); ?></td>
                                            <td class="text-right"><?php echo number_format($value['horaExtraFestivoMonto'],0,',','.'); ?></td>
                                            <td class="text-right"><?php echo number_format($value['totalHaberesImponibles'],0,',','.'); ?>
                                            <td class="text-right">
                                                <?php  echo ( $value['imponible'] + $value['horaExtraMonto'] + $value['horaExtraFestivoMonto'] + $value['totalHaberesImponibles'] ); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    
                                    <?php  
                                    foreach ($value['data'] as $key => $trabajador_item) { 
                                        foreach ($value['totales'] as $key => $cabecera) { 
                                            $tot[$key] += $trabajador_item[$key];
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $trabajador_item['apellidoPaterno']; ?></td>
                                        <td><?php echo $trabajador_item['apellidoMaterno']; ?></td>
                                        <td><?php echo $trabajador_item['nombres']; ?></td>
                                        <?php foreach ($value['totales'] as $key => $cabecera) { ?>
                                        <td class="text-right"><?php echo number_format($trabajador_item[$key],0,',','.'); ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php } ?>
                                
                            </table>
                        </div>
                    </div>

                <?php } ?>
            
                <br><br>

            </div>
            <!-- /.box-body -->
        </div>


        <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-cog"></i>
              <h3 class="box-title">Totales por Entidad</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php foreach ($array_data['crit_x_entidad'] as $key => $criterio) { ?>
                    <h3> <?php echo $criterio['criterio'] ?>: <?php echo dinero($criterio['total'],true) ?> </h3>


                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#entidad_<?php echo $key ?>" aria-expanded="false" aria-controls="collapseExample">
                        Ver detalle <?php echo $criterio['criterio'] ?>
                    </button>

                    <div class="collapse" id="entidad_<?php echo $key ?>">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>apellidoPaterno</th>
                                        <th>apellidoMaterno</th>
                                        <th>nombres</th>
                                        <?php foreach ($criterio['campos'] as $key => $campo) { ?>
                                        <th><?php echo $campo['campo'] ?></th>
                                        <?php } ?>
                                    </tr>                        
                                </thead>
                                <tbody>
                                    <?php foreach ($criterio['data'] as $key => $trabajador) { ?>
                                        <tr> 
                                            <td><?php echo $trabajador['apellidoPaterno'] ?></td>
                                            <td><?php echo $trabajador['apellidoMaterno'] ?></td>
                                            <td><?php echo $trabajador['nombres'] ?></td>
                                            <?php foreach ($criterio['campos'] as $key => $campo) { ?>
                                            <td class="text-right"><?php echo $trabajador[$campo['campo']] ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>



                <?php } ?>
            </div>
            <!-- /.box-body -->
        </div>


        <div class="box box-warning">
            <div class="box-header with-border">
              <i class="fa fa-cog"></i>
              <h3 class="box-title">Totales por Individual</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            </div>
            <!-- /.box-body -->
        </div>

        <!-- /.box -->
        <a href="<?php echo BASE_URL ?>/<?php echo $entity ?>/totales_x_criterios" class="btn btn-success btn-lg pull-right">
        Siguiente <i class="fa fa-arrow-right"></i> 
        </a>

        <div class="clear clearfix"></div>

    </section>
</div>
<!-- /.content-wrapper -->            
<script>
$(function () {        
    $('#tabla_centralizacion_step_one').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "pageLength": false
    });
});

</script>