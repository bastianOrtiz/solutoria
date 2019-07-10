<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1> Malla Liquidaciones </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php include ROOT . '/views/comun/alertas.php';  ?>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Registros</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="tabla_cargo" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th>Origen</th>
                            <th>Campo</th>
                            <th>Tipo Criterio</th>
                            <th style="width: 70px"> Eliminar </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th> # </th>
                            <th>Origen</th>
                            <th>Campo</th>
                            <th>Tipo Criterio</th>
                            <th style="width: 70px"> Eliminar </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                            foreach( $registros_malla as $reg ){ 
                            ?>
                        <tr>
                            <td> <?php echo $reg['id']; ?> </td>
                            <td> <?php echo convertToName('origen',$reg['origen']); ?> </td>
                            <td> <?php echo $reg['campo']; ?> </td>
                            <td> <?php echo convertToName('tipo_criterio',$reg['tipo_criterio']); ?> </td>
                            <td class="text-center">
                                <button class="btn btn-xs btn-danger" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Eliminar"><i class="fa fa-remove"></i></button>
                            </td>
                        </tr>
                        <?php } ?>                        
                    </tbody>
                    
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <a href="<?php echo BASE_URL . '/' . $entity ?>/ingresar-malla-liquidacion" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i> Nueva malla
        </a>
    </section>
</div>
<!-- /.content-wrapper -->            
<script>
    $(function () {        
        $('#tabla_cargo').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false,
          "pageLength": 100
        });
      });
</script>