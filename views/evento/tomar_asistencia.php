<!-- Content Wrapper. Contains page content -->
<style>
.btn-add-participante{
    margin-top: 300px;
}
#tabla_eventos .fa-calendar:after{
    font-family: 'FontAwesome';
    content: '\f00c';
    position: absolute;
    right: -7px;
    top: 5px;
}
.trabajadores_list{
    height: 210px; 
    overflow-y: auto;
}
</style>
  <div class="content-wrapper">
    
    <section class="content-header">
      <h1> Eventos </h1>
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
        <div class="box-header">
        </div>
        <div class="box-body table-responsive">
          <table id="tabla_eventos" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th> ID </th>
                <th>Titulo</th>
                <th>Tipo Evento</th>
                <th>Fecha/Hora Inicio</th>
                <th>Fecha/Hora Término</th>
                <th> Participantes </th>
                <th> Opciones </th>
              </tr>
            </thead>
            <tbody>
                <?php foreach( $all_eventos as $reg ){ ?>
                    <tr id="row_<?php echo $reg['id']?>">
                        <td> <?php echo $reg['id']?> </td>
                        <td> <a href="#" data-evento_id="<?php echo $reg['id']?>" class="btn-info-evento"> <?php echo $reg['titulo']?></a> </td>
                        <td> <?php echo getTipoEvento($reg['tipoevento_id']) ?> </td>
                        <td> <?php echo formatDateEventos($reg['fechaHoraInicio']) ?> </td>
                        <td> <?php echo formatDateEventos($reg['fechaHoraTermino']) ?> </td>
                        <td>  
                            <?php foreach($reg['participantes'] as $participante): ?>
                                <a href="mailto:<?php echo $participante['email']; ?>" title="Enviarle un correo a <?php echo $participante['nombres']; ?>" data-toggle="tooltip"><?php echo $participante['email']; ?></a><br>
                            <?php endforeach; ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-flat btn-info btn-info-evento" data-evento_id="<?php echo $reg['id'] ?>" data-toggle="tooltip" title="Ver detalles del evento"> <i class="fa fa-search"></i> </a>
                            <a href="<?php echo BASE_URL ?>/evento/asistencia/?evento_id=<?php echo $reg['id'] ?>" class="btn btn-flat btn-success" data-toggle="tooltip" title="Tomar asistencia del evento"> <i class="fa fa-calendar"></i> </a>
                        </td>                      
                    </tr>
                <?php } ?>                        
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
              
    </section>
    
</div><!-- /.content-wrapper -->            
  
  
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

    $(".btn-info-evento").click(function(event) {
        event.preventDefault();
        showEvento($(this).data('evento_id'));
        $("#modal-evento").modal('show');
    });

    $(".btn-show-checked").click(function(event) {
        event.preventDefault();
        $(".trabajador_container").each(function(){
            if( $(this).find('input').is(':checked') ){
                $(this).show();
            } else {
                $(this).hide();
            }
        })
    });

    <?php if($_GET['papelera']): ?>
    $(".btn-restaurar-evento").click(function(event) {
        if( confirm('Restaurar el evento seleccionado?') ){
            event.preventDefault();
            evento_id = $(this).data('regid');
            row = $(this).closest('tr');
            $.ajax({
                url: '<?php echo BASE_URL ?>/evento/listar',
                type: 'POST',
                dataType: 'json',
                data: {
                    post_action: 'ajax_restaurar_evento',
                    evento_id: evento_id
                },
                beforeSend:function(){
                    $(".overlayer").show();
                }, 
                success: function(json){
                    $(".overlayer").hide();
                    row.fadeOut(500);
                    alert("Evento restaurado correctamente");
                }
            });
        }
    });
    <?php endif; ?>

    $(".btn-delete-evento").click(function(event) {
        if( confirm('¿Eliminar el evento seleccionado?') ){
            event.preventDefault();
            evento_id = $(this).data('regid');
            row = $(this).closest('tr');
            $.ajax({
                url: '<?php echo BASE_URL ?>/evento/listar',
                type: 'POST',
                dataType: 'json',
                data: {
                    post_action: 'ajax_delete_evento',
                    evento_id: evento_id
                },
                beforeSend:function(){
                    $(".overlayer").show();
                }, 
                success: function(json){
                    $(".overlayer").hide();
                    row.fadeOut(500);
                }
            });
        }
    });

    $(".btn-edit-evento").click(function(event) {
        event.preventDefault();
        evento_id = $(this).data('regid');
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

                $("#frm-nuevo-evento [name=evento_titulo]").val(evento.titulo);
                $("#frm-nuevo-evento [name=descripcion]").val(evento.descripcion);
                $("#frm-nuevo-evento [name=evento_tipo]").val(evento.tipoevento_id);
                $("#frm-nuevo-evento [name=evento_fechahora_inicio]").val(evento.fechaHoraInicio);
                $("#frm-nuevo-evento [name=evento_fechahora_termino]").val(evento.fechaHoraTermino);
                $("#frm-nuevo-evento [name=post_action]").val('editar_evento');
                $("#frm-nuevo-evento [name=evento_id]").val(evento.id);
                $('#frm-nuevo-evento .btn-success').text('Guardar');
                
                $.each(participantes, function(index, val) {
                     $("input[value=" + val.id + "]").prop('checked',true);
                });

                $("#modal-nuevo-evento").modal('show');
                $(".overlayer").fadeOut(300);
            }
        });
        
    });

    $("[href='#modal-nuevo-evento']").click(function(event) {
        $('#frm-nuevo-evento [name=post_action]').val('crear_evento');
        $('#frm-nuevo-evento .btn-success').text('Crear');
        $('#frm-nuevo-evento')[0].reset();
    });

    $("#modal-nuevo-evento [href=#]").click(function(event) {
        event.preventDefault();
        my_check = $(this).find('[type=checkbox]');
        if( my_check.prop('checked') == true ){
            my_check.prop('checked',false);
        } else {
            my_check.prop('checked',true);
        }
    });

    $(".departamentos_list a").click(function(event) {
        event.preventDefault();
        id_depto = $(this).data('departamento');

        if( $(".departamentos_list input:checked").length == 0 ){
            $(".trabajadores_list .trabajador_container").show();
        } else {

            $(".trabajadores_list .trabajador_container").hide();
            
            $(".departamentos_list input").each(function(){
                depto_id = $(this).parent('a').data('departamento');
                if( $(this).prop('checked') == true ){
                    console.log(".trabajadores_list .depto_id_" + depto_id);
                    $(".trabajadores_list .depto_id_" + depto_id).show();
                }
            })
        }
    });

    $("input#trabajador_search").keyup(function(){
        match_text = $(this).val();
        if($(this).val().length >= 3){
            $(".trabajadores_list .trabajador_container").hide();
            $(".trabajadores_list .trabajador_container a span:contains('" + match_text + "')").closest('.trabajador_container').show();
        } else {
            $(".trabajadores_list .trabajador_container").show();
        }
    })


    $('#evento_fechahora_inicio').daterangepicker({ 
        timePicker: true, 
        timePickerIncrement: 15, 
        singleDatePicker: true,
        format: 'DD/MM/YYYY HH:mm'
    });

    $('#evento_fechahora_termino').daterangepicker({ 
        timePicker: true, 
        timePickerIncrement: 15,
        singleDatePicker: true,
        format: 'DD/MM/YYYY HH:mm'
    });

    $("#frm-nuevo-evento").submit(function(event) {
        if( $(".trabajadores_list .trabajador_container input:checked").length == 0 ){
            alert('Debe seleccionar al menos 1 participante para su evento');
            return false;
        } else {
            $("#frm-nuevo-evento")[0].submit();
        }
    });


    $(function () {        
        $('#tabla_eventos').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
    });


})
    


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



jQuery.expr[':'].contains = function(a, i, m) {
  return jQuery(a).text().toUpperCase()
      .indexOf(m[3].toUpperCase()) >= 0;
};
      
</script>