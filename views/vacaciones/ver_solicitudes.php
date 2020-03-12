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
      
        <?php 
        if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
        $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
        ?>
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4>	<i class="icon fa fa-check"></i> Mensaje:</h4>
            <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
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
                <input type="hidden" name="action" id="action" value="vacaciones" />
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
                                    <th style="text-align: center;"> Aprobar / Rechazar </th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $vacaciones_espera_todos as $ant ){?>
                                    <tr>
                                        <td> <?php echo getNombreTrabajador($ant['trabajador_id']) ?> </td>
                                        <td> <?php echo $ant['fecha_inicio'] ?> </td>
                                        <td> <?php echo $ant['fecha_fin'] ?> </td>                                        
                                        <td style="text-align: center;"> 
                                            <?php if( ( $ant['aprobado'] === null ) || ( $ant['aprobado'] === "" ) ){ ?>                                            
                                            <a href="#" data-id="<?php echo $ant['id'] ?>" data-accion="1" class="btn_aprobar">
                                                <span class="tip aprobado" title="Aprobar" data-toggle="tooltip"><i class="fa fa-check"></i></span>
                                            </a>
                                            &nbsp; &nbsp; &nbsp; 
                                            <a href="#" data-id="<?php echo $ant['id'] ?>" data-accion="0" class="btn_aprobar">
                                                <span class="tip rechazado" title="Rechazar" data-toggle="tooltip"><i class="fa fa-times"></i></span>
                                            </a>
                                            
                                            <?php } else { ?>                                            
                                                <?php if( $ant['aprobado'] == 1 ){ ?>
                                                <span class="tip aprobado" title="Aprobado" data-toggle="tooltip"><i class="fa fa-check"></i></span>
                                                <?php } ?>
                                                
                                                <?php if( $ant['aprobado'] == 0 ){ ?>
                                                <span class="tip rechazado" title="Rechazado" data-toggle="tooltip"><i class="fa fa-times"></i></span>
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
    $(".btn_aprobar").click(function(){
        var vacaciones_id = $(this).data('id');
        var status_aprobacion = $(this).data('accion');
        if( status_aprobacion == 1 ){
            accion_apr = 'APROBAR';
        } else {
            accion_apr = 'RECHAZAR';
        }
        if( confirm( "¿" + accion_apr + " EL vacaciones?" ) ){
            $("#status_aprobacion").val(status_aprobacion);
            $("#vacaciones_id").val(vacaciones_id);
            $("#action").val('aprobar');
            
            $("#frmCrear")[0].submit();
        }
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
        $(".overlayer").hide();
    }

})            
</script>
      