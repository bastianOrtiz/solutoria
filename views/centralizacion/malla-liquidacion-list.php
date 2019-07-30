<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1> Mallas Centralización </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php include ROOT . '/views/comun/alertas.php';  ?>
    </section>
    <section class="content">
        <form method="post" id="mallaList">
            <input type="hidden" name="action" value="eliminar_malla_batch">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Registros</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="tabla_cargo" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th> # </th>
                                <th>Origen</th>
                                <th>Campo</th>
                                <th>Tipo Criterio</th>
                                <th>Criterio</th>
                                <th style="width: 70px"> Eliminar </th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> # </th>
                                <th></th>
                                <th>Origen</th>
                                <th>Campo</th>
                                <th>Tipo Criterio</th>
                                <th>Criterio</th>
                                <th style="width: 70px"> Eliminar </th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                                foreach( $registros_malla as $reg ){ 
                                ?>
                            <tr>
                                <td><input type="checkbox" class="chk_batch" name="batch[]" value="<?php echo $reg['id']; ?>"></td>
                                <td> <?php echo $reg['id']; ?> </td>
                                <td> <?php echo convertToName('origen',$reg['origen']); ?> </td>
                                <td> <?php echo $reg['campo']; ?> </td>
                                <td> <?php echo convertToName('tipo_criterio',$reg['tipo_criterio']); ?> </td>
                                <td> <?php echo getNombreCriterio($reg['fk_criterioid'], $reg['tipo_criterio']) ?> </td>
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
            <button style="display: none;" id="btnSubmitBatch" type="submit" data-toggle="tooltip" title="Eliminar todos los elementos seleccionados" class="btn btn-danger">
                Eliminar Batch
            </button>

            <br>
            <br>

            <!-- /.box -->
            <a href="<?php echo BASE_URL . '/' . $entity ?>/ingresar-malla-liquidacion" class="btn btn-primary">
            <i class="fa fa-plus-circle"></i> Nueva malla
            </a>

    </section>
</div>
<!-- /.content-wrapper -->            
<script>

$(document).ready(function() {
    var $chkboxes = $('.chk_batch');
    var lastChecked = null;

    $chkboxes.click(function(e) {
        if (!lastChecked) {
            lastChecked = this;
            return;
        }

        if (e.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);

            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).prop('checked', lastChecked.checked);
        }

        lastChecked = this;
    });
});

$("#mallaList").submit(function(e){
    e.preventDefault();
    if( confirm('¿Desea elminar los elementos seleccionados?') ){
        $("#mallaList")[0].submit();
    }
})

$(document).on('click','.chk_batch', function(){
    if( $(".chk_batch:checked").length > 0 ){
        $("#btnSubmitBatch").show();
    } else {
        $("#btnSubmitBatch").hide();
    }
})

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