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
      <h1> SOLICITAR ANTICIPO </h1>
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
                <input type="hidden" name="action" value="anticipo" />                    
                  <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Monto</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-addon">$</span> 
                                <input name="anticipoMonto" id="anticipoMonto" type="text" class="form-control required"> 
                                <span class="input-group-addon"><i class="fa fa-question-circle" data-toggle="tooltip" title="<?php echo $reglas_anticipo; ?>"></i></span>
                            </div>                              
                        </div>
                        <p style="font-size: 18px;">
                            Correspondiente a <?php echo getNombreMes( getMesMostrarCorte()  ) ?> / <?php echo getAnoMostrarCorte() ?>
                        </p>
                    </div>
                         
                    <div class="col-md-6">
                    
                        <table class="table table-striped" id="table_anticipo_historial">
                            <thead>
                                <tr>
                                    <th> Mes </th>
                                    <th> Año </th>
                                    <th> Monto </th> 
                                    <th style="text-align: center;"> Aprobado </th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $anticipo_espera as $ant ){?>
                                    <tr>
                                        <td> <?php echo getNombreMes( $ant['mes'] ) ?> </td>
                                        <td> <?php echo $ant['ano'] ?> </td>
                                        <td> <?php echo number_format($ant['monto'],0,',','.') ?> </td>
                                        <td style="text-align: center;"> 
                                            <span class="tip espera" title="En espera de aprobación" data-toggle="tooltip"><i class="fa fa-clock-o"></i></span>                                            
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php foreach( $anticipo_historial as $ant ){?>
                                    <tr>
                                        <td> <?php echo getNombreMes( $ant['mesInicio'] ) ?> </td>
                                        <td> <?php echo $ant['anoInicio'] ?> </td>
                                        <td> <?php echo number_format($ant['valor'],0,',','.') ?> </td>
                                        <td style="text-align: center;">  
                                            <span class="tip aprobado"><i class="fa fa-check"></i></span>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                        <p> <strong> NO Aprobados </strong> </p>
                        <table class="table table-striped" id="table_anticipo_historial">
                            <thead>
                                <tr>
                                    <th> Mes </th>
                                    <th> Año </th>
                                    <th> Monto </th> 
                                    <th style="text-align: center;"> Rechazado </th>                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $anticipo_historial_rechazados as $ant ){?>
                                    <tr>
                                        <td> <?php echo getNombreMes( $ant['mes'] ) ?> </td>
                                        <td> <?php echo $ant['ano'] ?> </td>
                                        <td> <?php echo number_format($ant['monto'],0,',','.') ?> </td>
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
    
        if( $("#anticipoMonto").val() == 0 ){
            if( !$("#anticipoMonto").parent().hasClass('has-error') ){
                $("#anticipoMonto").parent().addClass('has-error');
                $("#anticipoMonto").parent().find('label').append(' <small>(Este campo es requerido)</small>');
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
      