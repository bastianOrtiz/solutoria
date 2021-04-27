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
    <section class="content-header">
      <h1> GENERAR INFORME </h1>
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
        <form role="form" id="frmVerAtrasos" method="post">
            <input type="hidden" name="action" id="action" value="dias_trabajados" />
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title pull-left"> Dias Trabajados </h3>
                            <div class="pull-right text-right">
                                <a href="<?php echo BASE_URL ?>/informe/dias_trabajados/pdf" target="_blank" class="btn btn-primary">PDF</a>
                                <a href="<?php echo BASE_URL ?>/informe/dias_trabajados/excel" target="_blank" class="btn btn-primary">EXCEL</a>
                            </div>
                        </div>
                        <div class="box-body">
                            <?php 
                            if( $_POST ){  
                                ?>

                                <table class="table table-bordered" id="tabla_data">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Rut</th>
                                            <th>Departamento</th>
                                            <th>Mes/ano</th>
                                            <th>Dias trabajados</th>
                                            <th>Dias Licencia</th>
                                            <th>Dias Vacaciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($array_dias_trabajados as $item) { ?>
                                        <tr>    
                                            <td><?php echo $item['trabajador_id'] ?></td>
                                            <td><?php echo $item['nombre'] ?></td>
                                            <td><?php echo $item['rut'] ?></td>
                                            <td><?php echo $item['departamento'] ?></td>
                                            <td><?php echo $item['mesano'] ?></td>
                                            <td><?php echo $item['diasTrabajados'] ?></td>
                                            <td><?php echo $item['diaLicencia'] ?></td>
                                            <td><?php echo $item['diaVacaciones'] ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            <?php } else { ?>                        
                            <div class="col-md-6">
                                <div class="box-header">
                                    <h3 class="box-title"> Seleccione Fecha Inicio </h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">                                                        
                                        <input type="text" class="form-control required datepicker" name="fecha_desde" readonly id="fecha_desde" value="<?php echo date('Y-m-d'); ?>" />                                        
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="col-md-6">
                                <div class="box-header">
                                    <h3 class="box-title"> Seleccione Fecha Termino </h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">                                                        
                                        <input type="text" class="form-control required datepicker" name="fecha_hasta" readonly id="fecha_hasta" value="<?php echo date('Y-m-d'); ?>" />                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="button" class="btnEnviar btn btn-primary" value="Enviar" />
                                    </div>
                                </div>                                    
                            </div>
                            <?php } ?> 
                        </div>                                            
                    </div>                      
                
                </div>
            </div>
        </form>
</section>
        
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
    
    $(".btnCartaAmonestacion").click(function(e){
        e.preventDefault();
        id = $(this).attr('href');
        $.ajax({
			type: "POST",
			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
			data: "id="+id+"&action=generate_carta",
            dataType: 'json',
            beforeSend: function(){                
            },
			success: function (json) {
			     window.open('<?php echo BASE_URL; ?>/private/carta.php?id=' + json.id);
            }
		})
    })
    
    $(".check_employee").click(function(){
        $("#check_all").prop('checked',false);
    })
    
    $("#check_all").click(function(){
        if( $(this).prop('checked') == true ){
            $(".check_employee").prop('checked',true);
        } else {
            $(".check_employee").prop('checked',false);
        }
    })
    
    $(".datepicker").datepicker({
        startView : 'year',
        autoclose : true,
        format : 'yyyy-mm-dd'
    });
    
    
    $(".btnEnviar").click(function(){
           $("#frmVerAtrasos")[0].submit();

    })
    
    $(".btnImprimir").click(function(){
        $("#action").val('atrasos');
        $("#frmVerAtrasos").attr('target','_blank');
        $("#frmVerAtrasos")[0].submit();        
    })
    
    $(".btnExcel").click(function(){
        $("#action").val('atrasos_excel');
        $("#frmVerAtrasos").attr('target','_blank');
        $("#frmVerAtrasos")[0].submit();        
    })
    
    $(function () {        
        oTable = $('#seleccionTrabajadores').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": false,
            "bInfo": false,
            "bAutoWidth": false,
            "pageLength": 999
        });
    }); 
    
    $('#tabla_data').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true,
        "pageLength": 999
    });
             
})

            
</script>
      