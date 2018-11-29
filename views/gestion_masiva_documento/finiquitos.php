<!-- Content Wrapper. Contains page content -->    
<style>
.checkbox{
    margin-left: 50px;
    display: none;
}

.checkbox.parent{
    margin-left: 0;
    display: block;
}
#seleccionTrabajadores label{
    font-weight: normal;
    cursor: pointer;
}
</style>    

<div class="content-wrapper">
    <form method="post">
        <input type="hidden" name="action" value="finiquitos">
        <section class="content-header">
            <h1> Finiquitos x trabajdor </h1>
            <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>

            <?php 
            if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
            $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
            ?>
            <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4> <i class="icon fa fa-check"></i> Mensaje:</h4>
                <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
            </div>
            <?php } ?> 
        </section>
                    
        <section class="content">
            
            <div class="tab-pane" id="tab_3">
                  <div class="row">
                        <div class="col-md-12">
                              <!-- general form elements -->
                            <div class="box">
                                <div class="box-header">
                                    <strong>Seleccione trabajadores</strong>
                                    <button type="submit" class="btn btn-primary btn-lg pull-right">Guardar</button>
                                </div>
                                <div class="box-body">                        
                                    <div class="col-xs-12">

                                        <table id="seleccionTrabajadores" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nombre Trabajador</th>
                                                    <th>Monto Finiquito</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                foreach( $trabajdores_todos as $trabajador ){ 
                                                $nombre_completo = $trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno'].' '.$trabajador['nombres'];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <span style="text-transform: uppercase;">
                                                            <?php echo $nombre_completo; ?> <span style="font-size: 12px;">(<?php echo getNombre($trabajador['departamento_id'],'m_departamento',0); ?>)</span>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <input type="number" value="<?php echo $trabajador['finiquito'] ?>" name="finiquito[<?php echo $trabajador['id'] ?>]" class="form-control txtFiniquito" style="text-align: right;">
                                                    </td>
                                                </tr>
                                                <?php } ?>                                                                                                                                        
                                            </tbody>
                                            <tfoot>
                                              <tr>                                                                                        
                                                <th>Nombre Trabajador</th>
                                                <th>Monto Finiquito</th>
                                              </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>    
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary btn-lg pull-right">Guardar</button>
                                </div>                                        
                            </div>                      
                        
                        </div>
                    </div>
                </form>
            </div>
            
        </section>
    </form>   
</div><!-- /.content-wrapper -->
      
<script>

$("input").keydown(function(){
    $(this).parent().removeClass('has-error');
    $(this).parent().find('label').find('small').remove();
})
$("select").change(function(){
    $(this).parent().removeClass('has-error');
    $(this).parent().find('label').find('small').remove();
})


$(document).ready(function(){
    $("#selectAll").click(function(){
        $("#seleccionTrabajadores input").prop('checked',true);
    })
})


$(function () {        
$('#seleccionTrabajadores').dataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bSort": false,
      "bInfo": true,
      "bAutoWidth": false
});
});


$("input[type='number']").click(function () {
   $(this).select();
});
            
</script>
      