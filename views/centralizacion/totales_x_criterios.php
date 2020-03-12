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
                                        $tot = [];
                                        foreach ($value['totales'] as $key => $cabecera) { 
                                        $tot[$key] = 0;
                                        ?>
                                        <th><?php echo $key; ?></th>
                                        <?php } ?>
                                        
                                    </tr>                        
                                </thead>
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
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Totales</th>
                                        <?php foreach ($value['totales'] as $key => $cabecera) { ?>
                                        <th class="text-right"><?php echo number_format($tot[$key],0,',','.'); ?></th>
                                        <?php } ?>
                                    </tr>
                                </tfoot>
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
                <?php foreach ($array_data['crit_x_entidad'] as $key => $value) { ?>
                    <h3> <?php echo $value['criterio'] ?>: <?php echo dinero($value['subtotal'],true) ?> </h3>
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