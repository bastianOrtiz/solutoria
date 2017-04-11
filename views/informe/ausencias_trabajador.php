<style>
button{
    outline: none;
}
.fc-content{
    cursor: pointer;
}
#calendar{
    border: 1px solid #d2d6de;
    border-radius: 5px;
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
            <input type="hidden" name="action" id="action" value="ausencias_trabajador" />
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">                        
                       <?php if( !$_POST ){ ?>
                       <div class="box-header">
                            <h3 class="box-title"> Calendario de Ausencias </h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Trabajador</label>                                
                                    <select id="trabajador_id" name="trabajador_id" class="form-control required input-lg">
                                        <option value=""> Seleccione Trabajador </option>
                                        <?php foreach( $trabajadores_todos as $t ){ ?>
                                        <option value="<?php echo $t['id'] ?>">
                                        <?php echo $t['apellidoPaterno'] ?> <?php echo $t['apellidoMaterno'] ?> <?php echo $t['nombres'] ?> 
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>                                                        
                        </div>
                        <div class="box-footer">
                            <input type="button" class="btnEnviar btn btn-primary" value="Enviar" />
                        </div>
                        <?php } ?>
                    </div>
                    
                    <?php if( $_POST ){ ?>
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Calendario de Ausencias para: <strong><?php echo getNombreTrabajador($trabajador_id) ?></strong> </h3>
                        
                            <button type="button" class="btn btn-default pull-right" style="margin-right: 15px;" onclick="location.href='<?php echo BASE_URL ?>/informe/ausencias_trabajador'"> 
                                <i class="fa fa-chevron-left"></i> &nbsp; Buscar otro Trabajador
                            </button>
                            
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div id="calendar"></div>
                            </div>
                            <div class="col-md-6">
                                <strong>Resumen Anual</strong>
                                <div class="form-group">
                                    <select class="form-control" id="ano_resumen">
                                        <option value="">Seleccione Año</option>
                                        <?php for( $i=(int)date('Y'); $i>=2016; $i-- ){ ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div id="table_resumen" style="display: none; padding: 15px;">
                                    <div class="row">
                                        <table class="table table-striped resumen_ausencias">
                                            <thead>
                                                <tr>
                                                    <th> Nombre </th>
                                                    <th> Total Dias </th>
                                                </tr>
                                            </thead>
                                            <tbody>                                            
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <br class="clear" />
                                        <p> <strong> Total Atrasos: </strong> <span class="total_atrasos"></span> </p>
                                        <div class="progress">
                                            <div data-toggle="tooltip" title=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    
    $("#ano_resumen").change(function(){
        var ano = $(this).val(); 
        if( ano != "" ){
            $("#table_resumen").show();
            $.ajax({
    			type: "POST",
    			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
    			data: "ano="+ano+"&trabajador_id=<?php echo $trabajador_id; ?>&action=resumen_anual",
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
    			success: function (json) {
    			     /** MOstrar tabla con resumen de ausencias **/
                    $("#table_resumen table.resumen_ausencias tbody").empty();
                    if( json.status == 'success' ){                        
                        $.each(json.registros, function(k,v){
        		             $("#table_resumen table.resumen_ausencias tbody").append('<tr> <td> '+ v.nombre +' </td> <td> '+ v.total_dias +' </td> </tr>');
                        })                       
                    } else {
                        $("#table_resumen table.resumen_ausencias tbody").append('<tr> <td colspan="2"> No hay datos </td> </tr>');
                    }                                
                    
                    /** Mostrar resumen de atrasos **/
                    $("#table_resumen span.total_atrasos").text(json.total_atrasos);
                    $("#table_resumen .progress div").attr('title','Lleva ' + json.total_atrasos + ' atrasos, de ' + json.total_marcaje + ' días trabajados');
                    $("#table_resumen .progress div").removeClass();
                    $("#table_resumen .progress div").addClass('progress-bar progress-bar-striped');
                    $("#table_resumen .progress div").addClass(json.progress_class);
                    $("#table_resumen .progress div").width(json.porcentaje_atraso+'%');
                    
                    $(".overlayer").hide();	     
                }
    		})
        } else {
            $("#table_resumen").hide();
        }
    })

    $("#trabajador_id").select2(); 
   
    $(".datepicker").datepicker({
        startView : 'year',
        autoclose : true,
        format : 'yyyy-mm-dd'
    });
    
    
    $(".btnEnviar").click(function(){
        $("#frmVerAtrasos")[0].submit();
    })        
        
    $('#calendar').fullCalendar({
          header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
          },
          buttonText: {
            today: 'today',
            month: 'month',
            week: 'week',
            day: 'day'
          },
          //Random default events
          events: [
            <?php echo $events; ?>
          ],
          eventClick: function(calEvent, jsEvent, view) {
            alert('Ausencia: ' + calEvent.title);
          },
          editable: false,
          droppable: false, // this allows things to be dropped onto the calendar !!!           
        });
    
             
})

            
</script>
      