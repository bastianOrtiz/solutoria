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
            <input type="hidden" name="action" id="action" value="atrasos_view" />
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Informe de Atrasos </h3>
                        </div>
                        <div class="box-body">
                            <?php 
                            if( $_POST['html'] ){                                 
                            $_SESSION[PREFIX.'informe_atrasos_action'] = 'atrasos';
                            $_SESSION[PREFIX.'informe_atrasos_trabajadorAtraso'] = $_POST['trabajadorAtraso'];
                            $_SESSION[PREFIX.'informe_atrasos_fechaTrabajadorAtraso'] = $_POST['fechaTrabajadorAtraso'];
                            $_SESSION[PREFIX.'informe_atrasos_html'] = $_POST['html'];
                            ?> 
                            
                            <div class="col-md-12">
                                <?php echo $_POST['html']; ?>
                                <div class="row">
                                <a href="<?php echo BASE_URL ?>/<?php echo $entity ?>/atrasos" class="btn btn-primary pull-left"> <i class="fa fa-chevron-left"></i> Volver</a>
                                <a href="javascript: void(0)" class="btnImprimir btn btn-primary pull-right" style="margin-left: 15px;"> <i class="fa fa-print"></i> &nbsp; PDF </a>
                                <a href="javascript: void(0)" class="btnExcel btn btn-primary pull-right"> <i class="fa fa-file-excel-o"></i> &nbsp; EXCEL </a>
                                </div>
                            </div>         
                                                   
                            <?php } else { ?>                        
                            <div class="col-md-6">
                                
                                <div class="form-group">
                                  <label>Seleccione Trabajadores</label>                              
                                </div>
                                <div class="pull-left">
                                    <input data-toggle="tooltip" title="Seleccionar todoss los Trabajadores" type="checkbox" id="check_all" /> 
                                    <label for="check_all">Seleccionar todos</label>
                                </div>                                                              
                                <table id="seleccionTrabajadores" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nombre Trabajador</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach( $trabajadores_todos as $trabajador ){ 
                                        $nombre_completo = $trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno'].' '.$trabajador['nombres'];
                                        ?>
                                        <tr>
                                            <td>
                                              <label>
                                                <input type="checkbox" class="check_employee" name="trabajadorAtraso[<?php echo $trabajador['id'] ?>]" /> 
                                                <span style="text-transform: uppercase;">
                                                    <?php echo $nombre_completo; ?> <span style="font-size: 12px;">(<?php echo getNombre($trabajador['departamento_id'],'m_departamento',0); ?>)</span>
                                                </span>
                                              </label>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-default" onclick="location.href='<?php echo BASE_URL ?>/private/informe.php?trabajador_id=<?php echo $trabajador['id'] ?>'" >
                                                    Reporte Anual
                                                </button>                                                                                                                                                                                               
                                            </td>
                                        </tr>
                                        <?php } ?>                                                                                                                                        
                                    </tbody>
                                    <tfoot>
                                      <tr>                                                                                        
                                        <th>Nombre Trabajador</th>
                                      </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="box-header">
                                    <h3 class="box-title"> Seleccione Fecha </h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">                                                        
                                        <input type="text" class="form-control required datepicker" name="fechaTrabajadorAtraso" readonly id="fechaTrabajadorAtraso" value="<?php echo date('Y-m-d'); ?>" />                                        
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
        if( $(".check_employee:checked").length == 0 ){
            alert("Debe seleccionar al menos 1 trabajador");
            return;
        } else {
            oTable.fnFilter('');
            $("#frmVerAtrasos")[0].submit();
        }
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
    
    $('#table_list_atrasos').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 999
    });
             
})

            
</script>
      