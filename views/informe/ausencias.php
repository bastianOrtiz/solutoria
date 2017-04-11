<style>
#table_list_ausencias td{
    text-transform: uppercase;
    font-size: 12px;
}
label.disabled{
    color: #d8d8d8;
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
            <input type="hidden" name="action" id="action" value="ausencias" />
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Informe de Ausencias </h3>
                        </div>                        
                        <?php if( $_POST ){ ?>
                        <div class="box-body">
                            <button type="button" class="btn btn-default pull-right" style="margin-right: 15px;" onclick="history.back()"> 
                                <i class="fa fa-chevron-left"></i> &nbsp; Volver a filtrar
                            </button>
                        </div>
                        <?php } else{ ?>
                        <div class="box-body">
                            <div class="col-md-4">
                                <label> Seleccione Fecha </label>
                                <input type="text" class="form-control required datepicker" name="fechaTrabajadorAusencia" readonly id="fechaTrabajadorAusencia" value="<?php echo( $_POST ) ? $_POST['fechaTrabajadorAusencia'] : date('Y-m-d'); ?>" />
                            </div>
                            
                            <div class="col-md-8">
                                <div class="filtros">
                                    
                                    <div class="col-md-12">
                                        <input type="checkbox" id="chkAusenciasTodas" name="chkAusenciasTodas" checked /> <label for="chkAusenciasTodas"> TODAS </label>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <input type="checkbox" class="chkFiltroAusencia" id="tipoAusencia0" name="chkTipoAusencia[0]" checked /> <label for="tipoAusencia0"> No marcó Reloj Control </label>                                     
                                    </div>
                                    <?php 
                                    foreach( $ausencias_todas as $aus ){
                                    ?>
                                    <div class="form-group col-md-4">
                                        <input type="checkbox" class="chkFiltroAusencia" id="tipoAusencia<?php echo $aus['id'] ?>" name="chkTipoAusencia[<?php echo $aus['id'] ?>]" checked /> <label for="tipoAusencia<?php echo $aus['id'] ?>"> <?php echo $aus['nombre'] ?> </label>                                    
                                    </div>    
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="button" class="btnEnviar btn btn-primary" value="Enviar" />
                        </div>
                        <?php } ?>
                    </div>
                    
                    <?php 
                    if( $_POST ){
                        
                    // Procesar arreglo con todos los ID de las ausencias seleccionadas en el filtro
                    $arr_ausencias_ids = array();
                    foreach( $chkTipoAusencia as $key => $f ){
                        $arr_ausencias_ids[] = $key;
                    }                                                                                
                    ?>
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Resultados para <strong><?php echo $fechaTrabajadorAusencia ?></strong> </h3>
                        </div>
                        <div class="box-body">
                            
                            <table class="table table-striped" id="table_list_ausencias">
                                <thead>
                                    <tr>
                                        <th> Nombre </th>
                                        <th> Motivo </th>
                                        <th> Marca Tarjeta </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach( $trabajadores_todos as $t ){
                                        if( marcaTarjeta($t['id']) ){
                                            if( ! in_array( $t['relojcontrol_id'],$array_ausencias ) ){
                                                $ausenciaDB = getAusencia($t['id'],$fechaTrabajadorAusencia,$arr_ausencias_ids);                                                 
                                                if( $ausenciaDB['stat'] == true ){                                                    
                                                ?>
                                                <tr>
                                                    <td> <?php echo $t['apellidoPaterno'].' '.$t['apellidoMaterno'].' '.$t['nombres'] ?> </td>
                                                    <td> <?php echo getNombre($ausenciaDB['ausencia_id'],'m_ausencia') ?> </td>
                                                    <td> SI </td>
                                                </tr>
                                                <?php   
                                                } elseif($chkTipoAusencia[0]) {
                                                ?>
                                                <tr>
                                                    <td> <?php echo $t['apellidoPaterno'].' '.$t['apellidoMaterno'].' '.$t['nombres'] ?> </td>
                                                    <td> No marcó reloj control </td>
                                                    <td> SI </td>
                                                </tr>
                                                <?php 
                                                }
                                            ?>                                            
                                            <?php 
                                            }
                                        } else {
                                            $ausenciaDB = getAusencia($t['id'],$fechaTrabajadorAusencia,$arr_ausencias_ids);                                                 
                                            if( $ausenciaDB['stat'] == true ){                                                    
                                            ?>
                                            <tr>
                                                <td> <?php echo $t['apellidoPaterno'].' '.$t['apellidoMaterno'].' '.$t['nombres'] ?> </td>
                                                <td> <?php echo getNombre($ausenciaDB['ausencia_id'],'m_ausencia') ?> </td>
                                                <td> NO </td>
                                            </tr>
                                            <?php   
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            
                            
                        </div>                                                                               
                    </div>
                    
                    <?php } ?>
                    
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
    
    $("input[type=checkbox]").click(function(){
        if( $(this).prop('checked') == true ){
            $(this).next('label').removeClass('disabled');            
        } else {
            $(this).next('label').addClass('disabled');
        }
    })
    
    $("#chkAusenciasTodas").click(function(){
        if( $(this).prop('checked') == true ){
            $(".chkFiltroAusencia").prop('checked',true);
            $('.filtros label').removeClass('disabled');
        } else {
            $(".chkFiltroAusencia").prop('checked',false);
            $('.filtros label').addClass('disabled');
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
    
    
    $('#table_list_ausencias').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 999
    });
             
})

            
</script>
      