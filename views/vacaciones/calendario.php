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
      <h1> Calendario de vacaciones </h1>
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

                        <?php if(isAdmin()): ?>
                        <div class="box-header">
                            <h5 class="box-title"> Filtrar por departamento: </h5><br>
                            <a class="btn btn-sm btn-default btn-filter-calendar" href="<?php echo BASE_URL ?>/vacaciones/calendario">
                                Todos &nbsp; <i class="fa fa-square-o"></i>
                            </a>
                            <?php foreach ($departamentos as $key => $depto) { ?>
                            <a class="btn btn-sm btn-default btn-filter-calendar" href="<?php echo BASE_URL ?>/vacaciones/calendario/?dep=<?php echo $depto['id'] ?>">
                                <?php echo $depto['nombre']; ?> &nbsp; <i class="fa fa-square" style="color: <?php echo $arr_colors[$depto['id']] ?>;"></i>
                            </a>
                            <?php } ?>
                        </div>
                        <?php endif; ?>

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

    $(".btn-filter-calendar").click(function(event) {
        event.preventDefault();
        href = $(this).attr('href');
        $(".overlayer").show();
        window.location.href = href;
    });         
        
    $('#calendar').fullCalendar({
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
        height: 800,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día'
        },
          //Random default events
        events: [
            <?php echo $events; ?>
        ],
        eventClick: function(calEvent, jsEvent, view) {
            swal('','Trabajador: ' + calEvent.desc);
        },
        editable: false,
        droppable: false,
        firstDay: 1
    });
    
             
})

            
</script>
      