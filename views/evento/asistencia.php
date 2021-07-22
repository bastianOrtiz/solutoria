<!-- Content Wrapper. Contains page content -->
<style>
.checkbox{
    width: 22px;
    height: 22px;
}
</style>
  <div class="content-wrapper">
    
    <section class="content-header">
        <h1> Tomar Asistencia </h1>
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
        <form method="post" id="frm-asistencia">  
            <input type="hidden" name="post_action" value="tomar_asistencia">
            <input type="hidden" name="evento_id" value="<?php echo $_GET['evento_id'] ?>">
            
            <div class="box">
                <div class="box-header">
                    <strong>Evento:</strong> <span id="cabecera_evento_titulo"></span><br>
                    <strong>Tipo Evento:</strong> <span id="cabecera_evento_tipo_evento"></span><br>
                    <strong>Fecha/Hora Inicio:</strong> <span id="cabecera_evento_inicio"></span><br>
                    <strong>Fecha/Hora Termino:</strong> <span id="cabecera_evento_termino"></span><br>
                    
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Asistió</th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($participantes as $key => $person) { ?>
                                <tr>
                                    <td>
                                        <label>
                                            <?php echo $person['nombres'] . ' ' . $person['apellidoPaterno'] . ' ' . $person['apellidoMaterno']; ?>
                                        </label>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="checkbox" name="asistencia[<?php echo $person['id']; ?>]">
                                    </td>
                                    <td>
                                        <textarea class="form-control" rows="2" name="notes[<?php echo $person['id']; ?>]"></textarea>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success">Guardar asistencia</button>
                </div>
            </div>
        </form>
    </section>

</div>
  
  



<script>
$(document).ready(function(){

    <?php 
    foreach ($asistencias as $key => $asistencia) { 
    if( $asistencia['asistencia'] == 1 ){
    ?>
    $("input[name='asistencia[<?php echo $asistencia['trabajador_id'] ?>]']").prop('checked', true);
    <?php } } ?>

    <?php foreach ($asistencias as $key => $asistencia) { ?>
    $("textarea[name='notes[<?php echo $asistencia['trabajador_id'] ?>]']").val('<?php echo $asistencia['nota']; ?>');
    <?php } ?>

    $("#frm-asistencia").submit(function(event) {
        event.preventDefault();
        $(".overlayer").show();
        $("#frm-asistencia")[0].submit();
    });

    $.ajax({
        url: '<?php echo BASE_URL ?>/evento/listar',
        type: 'POST',
        dataType: 'json',
        data: {
            post_action: 'ajax_get_evento',
            evento_id: <?php echo $_GET['evento_id'] ?>
        },
        beforeSend:function(){
            $(".overlayer").show();
        }, 
        success: function(json){
            evento = json.evento;
            $("#cabecera_evento_titulo").text(evento.titulo);
            $("#cabecera_evento_tipo_evento").text(evento.tipo_evento);
            $("#cabecera_evento_inicio").text(evento.fechaHoraInicio);
            $("#cabecera_evento_termino").text(evento.fechaHoraTermino);
            $(".overlayer").fadeOut(300);
        }
    });
    
});
</script>