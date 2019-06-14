<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1> Criterios por Entidad </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php include ROOT . '/views/comun/alertas.php';  ?>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Criterios</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="tabla_cargo" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th>Criterio</th>
                            <th>Debe o Haber</th>
                            <th>Cuenta Contable</th>
                            <th>Entidad</th>
                            <th>Tipo Entidad</th>
                            <th style="width: 100px"> Opciones </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th> # </th>
                            <th>Criterio</th>
                            <th>Debe o Haber</th>
                            <th>Cuenta Contable</th>
                            <th>Entidad</th>
                            <th>Tipo Entidad</th>
                            <th style="width: 100px"> Opciones </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                            foreach( $registros as $reg ){ 
                            ?>
                        <tr>
                            <td> <?php echo $reg['id']; ?> </td>
                            <td> <?php echo $reg['criterio']; ?> </td>
                            <td> <?php echo getDebeHaber($reg['DH']); ?> </td>
                            <td> <?php echo $reg['nombre_cta']; ?> </td>
                            <td> <?php echo getNombre($reg['id_entidad'],$reg['tabla_entidad'], false); ?> </td>
                            <td> <?php echo $reg['tabla_entidad']; ?> </td>
                            <td>
                                <button class="btn btn-xs btn-warning" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Modificar"> <i class="fa fa-edit"></i> </button>
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
        <a href="<?php echo BASE_URL . '/' . $entity ?>/ingresar-criterio-entidad" class="btn btn-primary">
        <i class="fa fa-plus-circle"></i> Nuevo Criterio x Entidad
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