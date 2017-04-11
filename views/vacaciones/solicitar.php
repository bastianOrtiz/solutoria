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
      <h1> SOLICITAR VACACIONES </h1>
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
                <input type="hidden" name="action" value="solicitar_vacaciones" />                    
                  <div class="box-body">
                    <div class="col-md-6">                                                         
                          <div class="box-body">
                            <div class="form-group">
                              <label for="desdeVacaciones">Desde</label>
                              <input type="text" class="form-control required datepicker" value="" id="desdeVacaciones" name="desdeVacaciones" placeholder="Fecha de inicio de vacaciones" />
                            </div>                                                                        
                            <div class="form-group">
                              <label for="hastaVacaciones">Hasta</label>
                              <input type="text" class="form-control required datepicker" value="" id="hastaVacaciones" name="hastaVacaciones" placeholder="Fecha fin de vacaciones" />
                            </div>                       
                            
                          </div><!-- /.box-body -->
                    </div>
                         
                    <div class="col-md-6">
                    
                        <table class="table table-striped" id="table_vacaciones_historial">
                            <thead>
                                <tr>
                                    <th> Desde </th>
                                    <th> Hasta </th>
                                    <th> Total Dias </th>                                    
                                    <th style="text-align: center;"> Aprobado </th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $vacaciones_espera as $ant ){?>
                                    <tr>
                                        <td> <?php echo $ant['fecha_inicio']; ?> </td>
                                        <td> <?php echo $ant['fecha_fin']; ?> </td>
                                        <td> <?php echo $ant['totalDias']; ?> </td>                                        
                                        <td style="text-align: center;"> 
                                            <span class="tip espera" title="En espera de aprobación" data-toggle="tooltip"><i class="fa fa-clock-o"></i></span>                                            
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php foreach( $vacaciones_historial as $ant ){?>
                                    <tr>
                                        <td> <?php echo $ant['fecha_inicio']; ?> </td>
                                        <td> <?php echo $ant['fecha_fin']; ?> </td>
                                        <td> <?php echo $ant['totalDias']; ?> </td> 
                                        <td style="text-align: center;">  
                                            <span class="tip aprobado"><i class="fa fa-check"></i></span>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                        <p> <strong> NO Aprobados </strong> </p>
                        <table class="table table-striped" id="table_vacaciones_historial">
                            <thead>
                                <tr>
                                    <th> Mes </th>
                                    <th> Año </th>
                                    <th> Monto </th> 
                                    <th style="text-align: center;"> Rechazado </th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $vacaciones_historial_rechazados as $ant ){?>
                                    <tr>
                                        <td> <?php echo $ant['fecha_inicio']; ?> </td>
                                        <td> <?php echo $ant['fecha_fin']; ?> </td>
                                        <td> <?php echo $ant['totalDias']; ?> </td>
                                        <td style="text-align: center;">  
                                            <span class="tip rechazado"><i class="fa fa-times"></i></span>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                         
                    </div>               
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                  </div>
                </form>
              </div><!-- /.box -->


            </div>
      </div>   <!-- /.row -->
    </section>    
</div><!-- /.content-wrapper -->
      
<script>
$(document).ready(function(){        
    $(".datepicker").datepicker({
        startView : 'year',
        autoclose : true,
        format : 'yyyy-mm-dd'
    });
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
      