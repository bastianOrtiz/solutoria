<style>
.fa-question-circle{
    font-size: 20px;
    cursor: help;
}
.tooltip-inner{
    white-space:pre;
    max-width:none;
}
</style>    
<div class="content-wrapper">
    
    <section class="content-header">
      <h1> LISTA DE VACACIONES SOLICITADAS </h1>
      <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
    </section>
            
    <section class="content">
      <div class="row">
          <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">                
                <div class="box-header">                
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frmCrear" method="post">
                <input type="hidden" name="action" id="action" value="confirmar_vacaciones" />
                <input type="hidden" name="status_aprobacion" id="status_aprobacion" value="" />  
                <input type="hidden" name="vacaciones_id" id="vacaciones_id" value="" />
                                  
                  <div class="box-body">                    
                         
                    <div class="col-md-10">
                    
                        <table class="table table-striped" id="table_vacaciones_historial">
                            <thead>
                                <tr>
                                    <th> Trabajador </th>
                                    <th> Desde </th>
                                    <th> Hasta </th>                                     
                                    <th> Dias </th>                                     
                                    <th> Tipo </th>                                     
                                    <th style="text-align: center;"> Acciones </th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach( $vacaciones_espera_todos as $ant ){
                                $person = $db->where('id',$ant['trabajador_id'])->getOne('m_trabajador');
                                ?>
                                    <tr>
                                        <td> <?php echo $person['apellidoPaterno'] ?> <?php echo $person['apellidoMaterno'] ?> <?php echo $person['nombres'] ?>  </td>
                                        <td> <?php echo $ant['fecha_inicio'] ?> </td>
                                        <td> <?php echo $ant['fecha_fin'] ?> </td>                                        
                                        <td> <?php echo $ant['totalDias'] ?> </td>                                        
                                        <td> <?php echo ucfirst($ant['tipo']) ?> </td>                                        
                                        <td style="text-align: center;"> 
                                        
                                        <?php if( ( $ant['aprobado'] === null ) || ( $ant['aprobado'] === "" ) || ( $ant['aprobado'] === 0 ) ){ ?>
                                            <span class="tip warning" style="background:#f79949" title="Esperando aprobacion del jefe" data-toggle="tooltip"><i class="fa fa-clock-o"></i></span>
                                        <?php } else { ?>
                                            <?php if( ( $ant['confirmada'] === null ) || ( $ant['confirmada'] === "" ) || ( $ant['confirmada'] === 0 ) ){ ?>
                                            <a href="#" data-id="<?php echo $ant['id'] ?>"  data-accion="1" class="btn btn-success btn-sm btn_aprobar">
                                                CONFIRMAR
                                            </a>
                                            <a href="#" data-id="<?php echo $ant['id'] ?>"  data-accion="0" class="btn btn-danger btn-sm btn_aprobar">
                                                ELIMINAR
                                            </a>
                                            <!--
                                            &nbsp; &nbsp; &nbsp; 
                                            <a href="#" data-id="<?php echo $ant['id'] ?>" data-accion="0" class="btn_aprobar">
                                                <span class="tip rechazado" title="Rechazar" data-toggle="tooltip"><i class="fa fa-times"></i></span>
                                            </a>
                                            --> 
                                            
                                            <?php } else { ?>
                                                <?php if( $ant['confirmada'] == 1 ){ ?>
                                                <span class="tip aprobado" title="Confirmada" data-toggle="tooltip"><i class="fa fa-check"></i></span>
                                                <?php } ?>
                                                
                                                <?php if( $ant['confirmada'] == 0 ){ ?>
                                                <span class="tip rechazado" title="Rechazado" data-toggle="tooltip"><i class="fa fa-times"></i></span>
                                                <?php } ?>
                                                                                                
                                            <?php } ?> 
                                        <?php } ?> 

                                        </td>
                                    </tr>
                                <?php } ?>                                
                            </tbody>
                        </table>                                                
                         
                    </div>               
                    
                  </div><!-- /.box-body -->
                
                </form>
              </div><!-- /.box -->


            </div>
      </div>   <!-- /.row -->
    </section>    
</div><!-- /.content-wrapper -->
      
<script>
$(document).ready(function(){        
    $(".btn_aprobar").click(function(event){
        event.preventDefault();
        var vacaciones_id = $(this).data('id');
        var status_aprobacion = $(this).data('accion');
        if( status_aprobacion == 1 ){
            accion_apr = 'CONFIRMAR';
            desc = '';
        } else {
            accion_apr = 'ELIMINAR';
            desc = 'Esta accion NO puede deshacerse';
        }

        swal({
            title: "¿" + accion_apr + " vacaciones?",
            text: desc,
            buttons: true,
            dangerMode: true,
        })
        .then((go) => {
            if (go) {
                $(".overlayer").show();
                $("#status_aprobacion").val(status_aprobacion);
                $("#vacaciones_id").val(vacaciones_id);
                $("#frmCrear")[0].submit();
            }
        });

    })
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
    $(".required").each(function(){
        if( $(this).val() == "" ){
            if( !$(this).parent().hasClass('has-error') ){
                $(this).parent().addClass('has-error');
                $(this).parent().find('label').append(' <small>(Este campo es requerido)</small>');
            }
            error++;
        }
    })    
    if( error == 0 ){
        $(".overlayer").show();
        $("#frmCrear")[0].submit();
    }

})  

$(document).ready(function(){
<?php 
if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
$array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
?>
swal('','<?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>','<?php echo $array_reponse['status'] ?>');
<?php } ?> 
})
</script>
      