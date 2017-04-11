<!-- Content Wrapper. Contains page content -->    
<style>
.datepicker{
    padding: 10px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow{
    top: 8px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
	line-height: 38px;
	height: 45px;
}
.select2-container--default .select2-selection--single {
	border: 1px solid #d2d6de;
	border-radius: 0;
	height: 45px;
}
</style>    
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> Planilla de Imposiciones </h1>
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
                    
                    <a href="<?php echo BASE_URL ?>/private/imposiciones.php" target="_blank" class="btn btn-primary">Imprimir</a>
                    <br class="clear" />
                    <br class="clear" />
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Contratados a plazo fijo en el mes</h3>                  
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th> Nombre </th>
                                        <th> Fecha Inicio Contrato </th>
                                        <th> Fecha fin Contrato </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $inicio_plazo_fijo_mes as $row ){ ?>
                                    <tr>
                                        <td style="text-transform: uppercase;"> <?php echo $row['nombre']; ?> </td>
                                        <td> <?php echo $row['fechaContratoInicio']; ?> </td>
                                        <td> <?php echo $row['fechaContratoFin']; ?> </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div>
                    
                    
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Contratados indefinidos en el mes</h3>                  
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th> Nombre </th>
                                        <th> Fecha Inicio </th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $indefinidos_mes as $row ){ ?>
                                    <tr>
                                        <td style="text-transform: uppercase;"> <?php echo $row['nombre']; ?> </td>
                                        <td> <?php echo $row['fechaContratoInicio']; ?> </td>                                                                            
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div>
                    
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Contratos a plazo fijo</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th> Nombre </th>
                                        <th> Fecha Inicio Contrato </th>
                                        <th> Fecha fin Contrato </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $plazo_fijo_durante_mes as $row ){ ?>
                                    <tr>
                                        <td style="text-transform: uppercase;"> <?php echo $row['nombre']; ?> </td>
                                        <td> <?php echo $row['fechaContratoInicio']; ?> </td>
                                        <td> <?php echo $row['fechaContratoFin']; ?> </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Paso de plazo fijo a indefinido</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th> Nombre </th>
                                        <th> Fecha Inicio Contrato Indefinido </th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $arr_paso_a_indefinido as $row ){ ?>
                                    <tr>
                                        <td style="text-transform: uppercase;"> <?php echo $row['nombre']; ?> </td>
                                        <td> <?php echo $row['fechaContrato']; ?> </td>                                        
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Licencias</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th> Nombre </th>
                                        <th> Desde </th>
                                        <th> Hasta </th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $licencias as $row ){ ?>
                                    <tr>
                                        <td style="text-transform: uppercase;"> <?php echo $row['nombre']; ?> </td>
                                        <td> <?php echo $row['fecha_inicio']; ?> </td>
                                        <td> <?php echo $row['fecha_fin']; ?> </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Personas que faltaron</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th> Nombre </th>
                                        <th> Desde </th>
                                        <th> Hasta </th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $ausencias_no_justificadas as $row ){ ?>
                                    <tr>
                                        <td style="text-transform: uppercase;"> <?php echo $row['nombre']; ?> </td>
                                        <td> <?php echo $row['fecha_inicio']; ?> </td>
                                        <td> <?php echo $row['fecha_fin']; ?> </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Despedidos</h3>
                        </div>
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th> Nombre </th>
                                        <th> Fecha Fin Contrato </th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $despedidos as $row ){ ?>
                                    <tr>
                                        <td style="text-transform: uppercase;"> <?php echo $row['nombre']; ?> </td>                                        
                                        <td> <?php echo $row['fechaContratoFin']; ?> </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <br class="clear" />
                    <br class="clear" />
                    <a href="<?php echo BASE_URL ?>/private/imposiciones.php" target="_blank" class="btn btn-primary">Imprimir</a>  
                    
                </div>
            </div>   <!-- /.row -->
        </section>
        
      </div><!-- /.content-wrapper -->
      
<script>

$(document).ready(function(){
    
    $("#trabajador_id").select2();
    
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
      