<!-- Content Wrapper. Contains page content -->
<style>
.pl-5{
    padding-left: 30px;
}
</style>
  <div class="content-wrapper">
    
    <section class="content-header">
        <h1> Calendario de Eventos </h1>
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
        <div class="box">
            <div class="box-body table-responsive">
                <div id="calendar"></div>
            </div>
        </div>
    </section>

</div>
  
  

<div class="modal fade" tabindex="-1" role="dialog" id="modal-evento">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <h4 class="modal-title"></h4>
            </div>
            
            <div class="modal-body"></div>
            
            <div class="modal-footer">

                <a href="" class="btn btn-flat btn-success pull-left"> Tomar asistencia de este evento <i class="fa fa-calendar"></i> </a>
                <a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>
            </div>  
        </div>
    </div>
</div>


<script>
$(document).ready(function(){

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        height: 530,
        buttonText: {
            today: 'Hoy',
            month: 'Ver mes',
            week: 'Ver semana',
            day: 'Ver dia'
        },
        events: [
            <?php foreach ($all_eventos as $key => $evento) { ?>
            {
                title: '<?php echo $evento['titulo'] ?>',
                start: '<?php echo $evento['fechaHoraInicio'] ?>',
                end: '<?php echo $evento['fechaHoraTermino'] ?>',
                backgroundColor: '#528f3f',
                borderColor: '#528f3f',
                evento_id: <?php echo $evento['id'] ?>
            },
            <?php } ?>
        ],
        eventClick: function(calEvent, jsEvent, view) {
            console.log(calEvent);
            showEvento(calEvent.evento_id);
            $("#modal-evento").modal('show');
        },
        editable: false,
        droppable: false,
        timeFormat: 'h:mm',
        dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']
    });

    $(".fc-event").each(function(index, el) {
        $(this).attr('title',$(this).find('.fc-title').text());
        $(this).data('toggle', 'tooltip');
        $(this).tooltip();
    });

});


function showEvento(evento_id){
    $.ajax({
        url: '<?php echo BASE_URL ?>/evento/listar',
        type: 'POST',
        dataType: 'json',
        data: {
            post_action: 'ajax_get_evento',
            evento_id: evento_id
        },
        beforeSend:function(){
            $(".overlayer").show();
        }, 
        success: function(json){
            evento = json.evento;
            participantes = json.participantes;

            modal_html = `
                <strong>Descripción del evento: </strong><br>` + evento.descripcion + ` <br>
                <strong>Tipo de evento: </strong>` + evento.tipo_evento + ` <br>
                <strong>Fecha/Hora Inicio:  </strong>` + evento.fechaHoraInicioVista + `<br>
                <strong>Fecha/Hora Termino: </strong>` + evento.fechaHoraTerminoVista + `<br>
                <strong>Participantes:</strong> <br>
            `;

            $.each(participantes, function(index, val) {
                modal_html += `<span class="pl-5">&bull;</span> <a title="Enviarle un correo a ` + val.nombres + `" data-toggle="tooltip" href="mailto:` + val.email + `">` + val.email + `</a> <br>`;
            });

            $("#modal-evento .btn-success").attr('href','<?php echo BASE_URL ?>/evento/asistencia/?evento_id=' + evento.id);
            $("#modal-evento h4").text(evento.titulo);
            $("#modal-evento .modal-body").html(modal_html);
            
            $(".overlayer").fadeOut(300);
        }
    });
}


</script>