<div class="content-wrapper">
    
    <section class="content-header">
          <h1> Mis invitaciones </h1>
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
                    <?php foreach( $all_invitaciones as $reg ){ ?>
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