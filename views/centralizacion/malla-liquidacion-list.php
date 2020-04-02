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
            <input type="hidden" name="malla_id" value="">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Registros</h3>
                    <div class="clearfix"></div>
                    <br>
                    <a href="<?php echo BASE_URL . '/' . $entity ?>/ingresar-malla-liquidacion" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> Nueva malla
                    </a>
                </div>




                <!-- /.box-header -->
                <div class="box-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab_1" data-toggle="tab">Malla Criterio x CCosto </a></li>
                          <li><a href="#tab_2" data-toggle="tab">Malla Criterio x Entidad </a></li>
                          <li><a href="#tab_3" data-toggle="tab">Malla Criterio x Individual</a></li>
                        </ul>
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab_1">
                                <table class="table table-bordered table-striped">
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
                                    <tbody>
                                        <?php 
                                            foreach( $registros_malla_ccosto as $reg ){ 
                                            ?>
                                        <tr>
                                            <td><input type="checkbox" class="chk_batch" name="batch[]" value="<?php echo $reg['id']; ?>"></td>
                                            <td> <?php echo $reg['id']; ?> </td>
                                            <td> <?php echo convertToName('origen',$reg['origen']); ?> </td>
                                            <td> <?php echo $reg['campo']; ?> </td>
                                            <td> <?php echo convertToName('tipo_criterio',$reg['tipo_criterio']); ?> </td>
                                            <td> <?php echo getNombreCriterio($reg['fk_criterioid'], $reg['tipo_criterio']) ?> </td>
                                            <td class="text-center">
                                                <button class="btn btn-xs btn-danger btnEliminar" type="button" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Eliminar"><i class="fa fa-remove"></i></button>
                                            </td>
                                        </tr>
                                        <?php } ?>                        
                                    </tbody>
                                </table>                                
                            </div>

                            <div class="tab-pane" id="tab_2">
                                <table class="table table-bordered table-striped">
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
                                    <tbody>
                                        <?php 
                                            foreach( $registros_malla_entidad as $reg ){ 
                                            ?>
                                        <tr>
                                            <td><input type="checkbox" class="chk_batch" name="batch[]" value="<?php echo $reg['id']; ?>"></td>
                                            <td> <?php echo $reg['id']; ?> </td>
                                            <td> <?php echo convertToName('origen',$reg['origen']); ?> </td>
                                            <td> <?php echo $reg['campo']; ?> </td>
                                            <td> <?php echo convertToName('tipo_criterio',$reg['tipo_criterio']); ?> </td>
                                            <td> <?php echo getNombreCriterio($reg['fk_criterioid'], $reg['tipo_criterio']) ?> </td>
                                            <td class="text-center">
                                                <button class="btn btn-xs btn-danger btnEliminar" type="button" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Eliminar"><i class="fa fa-remove"></i></button>
                                            </td>
                                        </tr>
                                        <?php } ?>                        
                                    </tbody>
                                </table>   
                            </div>

                            <div class="tab-pane" id="tab_3">
                                <table class="table table-bordered table-striped">
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
                                    <tbody>
                                        <?php 
                                            foreach( $registros_malla_personal as $reg ){ 
                                            ?>
                                        <tr>
                                            <td><input type="checkbox" class="chk_batch" name="batch[]" value="<?php echo $reg['id']; ?>"></td>
                                            <td> <?php echo $reg['id']; ?> </td>
                                            <td> <?php echo convertToName('origen',$reg['origen']); ?> </td>
                                            <td> <?php echo $reg['campo']; ?> </td>
                                            <td> <?php echo convertToName('tipo_criterio',$reg['tipo_criterio']); ?> </td>
                                            <td> <?php echo getNombreCriterio($reg['fk_criterioid'], $reg['tipo_criterio']) ?> </td>
                                            <td class="text-center">
                                                <button class="btn btn-xs btn-danger btnEliminar" type="button" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Eliminar"><i class="fa fa-remove"></i></button>
                                            </td>
                                        </tr>
                                        <?php } ?>                        
                                    </tbody>
                                </table>
                            </div>
                          <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                      </div>

                </div>
                <!-- /.box-body -->
            </div>
            <button style="display: none;" id="btnSubmitBatch" type="submit" data-toggle="tooltip" title="Eliminar todos los elementos seleccionados" class="btn btn-danger">
                Eliminar Batch
            </button>

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

$(".btnEliminar").click(function(e){
    e.preventDefault();
    malla_id = $(this).data('regid');
    if( confirm('¿Desea elminar el registro seleccionado?') ){
        $("[name=action]").val('eliminar_one');
        $("[name=malla_id]").val(malla_id);
        $("#mallaList")[0].submit();
    }
})

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

</script>