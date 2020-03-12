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
                        <div class="box-header">
                            <h3 class="box-title"> Calendario de Vacaciones  </h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12">
                                <div id="calendar"></div>
                            </div>                            
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
            alert('Ausencia: ' + calEvent.desc);
          },
          editable: false,
          droppable: false, // this allows things to be dropped onto the calendar !!!           
        });
    
             
})

            
</script>
      