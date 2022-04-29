<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>


<style>
.fa-question-circle{
    font-size: 20px;
    cursor: help;
}
.tooltip-inner{
    white-space:pre;
    max-width:none;
}
#dias_counter{
    display: block;
    position: relative;
    border-radius: 5px; 
    margin-top: 35px; 
    width: 100%;
}

#dias_counter:after {
    content: '';
    background: #53c1ef;
    width: 15px;
    height: 15px;
    position: absolute;
    left: -7px;
    top: 34px;
    -webkit-transform: rotate(45deg);
    -moz-transform: rotate(45deg);
    transform: rotate(45deg);
}
.box-primary.border{
    border-left: 1px solid #81c2e7;
    border-right: 1px solid #81c2e7;
    border-bottom: 1px solid #81c2e7;
}
.box-success.border{
    border-left: 1px solid #00a65a;
    border-right: 1px solid #00a65a;
    border-bottom: 1px solid #00a65a;
}

@media(max-width:  768px){
    #dias_counter:after {
        left: 47%;
        top: -7px;
    }
}
</style>    
<div class="content-wrapper">
    
    <section class="content-header">
      <h1> SOLICITAR VACACIONES </h1>
      <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
    </section>
            
    <section class="content">
      <div class="row">
          <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">                
                <div class="box-header">                
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frmCrear" method="post" autocomplete="off">
                <input type="hidden" name="action" value="solicitar_vacaciones" />                    
                  <div class="box-body">
                    <div class="col-md-6">                                                         
                      <div class="box-body">
                        
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="form-group">
                                  <label for="desdeVacaciones">Desde </label>
                                  <input type="text" class="form-control required flatpickr" value="" id="desdeVacaciones" name="desdeVacaciones" placeholder="Fecha de inicio de vacaciones" autocomplete="off" />
                                </div>                                                                        
                                <div class="form-group" id="hastaVacacionesGroup">
                                  <label for="hastaVacaciones">Hasta</label>
                                  <input type="text" class="form-control required flatpickr" value="" id="hastaVacaciones" name="hastaVacaciones" placeholder="Fecha fin de vacaciones" autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <span class="info-box-icon bg-aqua" id="dias_counter">0</span>
                                <div class="text-center">      
                                    <small>Días Hábiles</small>
                                </div>
                            </div>
                        </div>  


                        <div class="form-group">
                            <label> <input type="checkbox" name="vacaciones_mediodia"> Medio día de vacaciones</label> <br>
                        </div>

                        
                        <div class="form-group">
                            <label>Con cargo a:</label> <br>
                            <label>
                                <input type="radio" name="cargo" value="legal" required>
                                Vacaciones Legales <strong class="text-success">(<?php echo $diasVacacionesTrabajador ?> días disponibles)</strong>
                            </label> <br>
                            <label>
                                <input type="radio" name="cargo" value="progresivas" <?php echo($diasVacacionesProgresivasTrabajador == 0) ? 'disabled' : ''; ?>>
                                Vacaciones Progresivas <strong class="text-primary">(<?php echo $diasVacacionesProgresivasTrabajador; ?> días disponibles)</strong>
                            </label>
                            <div class="callout callout" style="border-top: 1px solid #e7e7e7;border-bottom: 1px solid #e7e7e7; border-right: 1px solid #e7e7e7; margin-top: 20px;">
                                <p><i class="fa fa-info-circle"></i> &nbsp; Si necesita de ambos, debe hacer 2 solicitudes por separado</p>
                            </div>
                        </div>

                      </div><!-- /.box-body -->
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                      </div>
                    </div>
                         
                <div class="col-md-6">
                    <div class="box box-success border">
                        <div class="box-body">
                           
                            <h5><strong>Solicitudes en espera de aprobación</strong></h5>
                            <table class="table table-striped table_vacas" id="table_vacaciones_espera">
                                <thead>
                                    <tr>
                                        <th> Desde </th>
                                        <th> Hasta </th>
                                        <th class="text-center"> Total Dias </th>                                    
                                        <th style="text-align: center;"> Estado </th>                                  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach( $vacaciones_espera as $ant ){?>
                                        <tr>
                                            <td> <?php echo $ant['fecha_inicio']; ?> </td>
                                            <td> <?php echo $ant['fecha_fin']; ?> </td>
                                            <td class="text-center"> <?php echo $ant['totalDias']; ?> </td>                                        
                                            <td style="text-align: center;"> 
                                                <span class="tip warning" title="En espera de aprobación" data-toggle="tooltip"><i class="fa fa-clock-o"></i></span>                                            
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            
                            <hr />
                            <h5><strong>Solicitudes Aprobadas</strong></h5>
                            <table class="table table-striped table_vacas" id="table_vacaciones_rechazadas">
                                <thead>
                                    <tr>
                                        <th> Desde </th>
                                        <th> Hasta </th>
                                        <th class="text-center"> Total Dias </th> 
                                        <th style="text-align: center;">Estado</th>                                  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $vacaciones_aprobadas as $ant ){?>
                                        <tr>
                                            <td> <?php echo $ant['fecha_inicio']; ?> </td>
                                            <td> <?php echo $ant['fecha_fin']; ?> </td>
                                            <td class="text-center"> <?php echo $ant['totalDias']; ?> </td>
                                            <td style="text-align: center; white-space: nowrap;">  
                                                <span class="tip success" title="Aprobada" data-toggle="tooltip"><i class="fa fa-check"></i></span>
                                                <?php if($ant['confirmada']): ?>
                                                <span class="tip success" title="Confirmada" data-toggle="tooltip"><i class="fa fa-flag"></i></span>
                                                <?php else : ?>
                                                <span class="tip success" style="background-color: #b9e1b9" title="En espera de confirmación por RRHH" data-toggle="tooltip"><i class="fa fa-flag"></i></span>
                                                <?php endif; ?>


                                                &nbsp;  &nbsp;
                                                <a href="#" class="btn-reenviar-form" data-vacaciones_id="<?php echo $ant['id']; ?>" title="Reenviar Formulario de Vacaciones por correo" data-toggle="tooltip"><span class="tip" style="background-color: #fff; background-color: #dd2f2f;"><i class="fa fa-envelope"></i></span></a>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                               
                            <hr />
                            <h5><strong>Solicitudes Rechazadas</strong></h5>
                            <table class="table table-striped table_vacas" id="table_vacaciones_rechazadasl">
                                <thead>
                                    <tr>
                                        <th> Desde </th>
                                        <th> Hasta </th>
                                        <th class="text-center"> Total Dias </th> 
                                        <th style="text-align: center;"> Estado </th>                                  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $vacaciones_historial_rechazados as $ant ){?>
                                        <tr>
                                            <td> <?php echo $ant['fecha_inicio']; ?> </td>
                                            <td> <?php echo $ant['fecha_fin']; ?> </td>
                                            <td class="text-center"> <?php echo $ant['totalDias']; ?> </td>
                                            <td style="text-align: center;">  
                                                <span class="tip danger" title="Rechazada" data-toggle="tooltip"><i class="fa fa-times"></i></span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                             
                            <hr />
                            <h5><strong>Solicitudes Anuladas</strong></h5>
                            <table class="table table-striped table_vacas" id="table_vacaciones_rechazadasl">
                                <thead>
                                    <tr>
                                        <th> Desde </th>
                                        <th> Hasta </th>
                                        <th class="text-center"> Total Dias </th> 
                                        <th style="text-align: center;">Estado</th>                                  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $vacaciones_anuladas as $ant ){?>
                                        <tr>
                                            <td> <?php echo $ant['fecha_inicio']; ?> </td>
                                            <td> <?php echo $ant['fecha_fin']; ?> </td>
                                            <td class="text-center"> <?php echo $ant['totalDias']; ?> </td>
                                            <td style="text-align: center;">  
                                                <span class="tip warning" title="Anulada" data-toggle="tooltip"><i class="fa fa-times"></i></span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                        <hr>

                        <div class="box box-primary border">
                            <div class="box-header">
                                <h5><strong>Historial de Vacaciones</strong></h5>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped table_vacas" id="table_vacaciones_historial">
                                    <thead>
                                        <tr>
                                            <th> Desde </th>
                                            <th> Hasta </th>
                                            <th class="text-center"> Total Dias </th>                                    
                                            <th style="text-align: center;"> Estado </th>                                  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach( $vacaciones_historial as $ant ){?>
                                            <tr>
                                                <td> <?php echo $ant['fecha_inicio']; ?> </td>
                                                <td> <?php echo $ant['fecha_fin']; ?> </td>
                                                <td class="text-center"> <?php echo ($ant['totalDias'] == 0.5) ? '0.5' : diasHabiles($_SESSION[PREFIX.'login_uid'],$ant['fecha_inicio'], $ant['fecha_fin'], $id_ausencia_vacaciones); ?> </td> 
                                                <td style="text-align: center;">  
                                                    <span class="tip aprobado"><i class="fa fa-check"></i></span>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                         
                    </div>               
                    
                  </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->


            </div>
      </div>   <!-- /.row -->
    </section>    
</div><!-- /.content-wrapper -->
      
<script>
global_desde = '';
global_hasta = '';
hoy = <?php echo date('Ymd') ?>;
$(document).ready(function(){        
    $(".flatpickr").flatpickr({
        "locale": "es",
        onClose: function(selectedDates, dateStr, instance){
            console.log(instance.element);
            $.ajax({
                url: '<?php echo BASE_URL ?>/vacaciones/solicitar',
                type: 'post',
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
                data: {
                    action: 'ajax_count_days',
                    desde: $("[name=desdeVacaciones]").val(),
                    hasta: $("[name=hastaVacaciones]").val()
                },
                success: function(json){
                    if( $("[name=vacaciones_mediodia]").prop('checked') == true){
                        $("#dias_counter").text('0.5');    
                    } else {
                        $("#dias_counter").text(json.dias);
                    }

                    global_desde = json.desde_format;
                    global_hasta = json.hasta_format;
                    if( json.desde_int < hoy || json.hasta_int < hoy ){
                        swal({
                            title: "",
                            text: "Esta seleccionando una fecha anterior a la actual. ¿Esta seguro?",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((go) => {
                            if (!go) {
                                $("[name=desdeVacaciones]").val('');
                                $("[name=hastaVacaciones]").val('');
                            }
                        });
                    }
                }
            })
            .always(function() {
                $(".overlayer").hide();
            });
            
        }
    });
})


$("[name=vacaciones_mediodia]").change(function(event) {
    if( $(this).prop('checked') ){
        $("[name=hastaVacaciones]").removeClass('required').val('');
        $("#hastaVacacionesGroup").slideUp('fast');
        $("#dias_counter").text('0.5');
    } else {
        $("[name=hastaVacaciones]").addClass('required').val('');
        $("#hastaVacacionesGroup").slideDown('fast');
        $("#dias_counter").text('0');
    }
});

$(".btn-reenviar-form").click(function(event) {
    event.preventDefault();
    vacaciones_id = $(this).data('vacaciones_id');
    swal({
        title: "",
        text: "¿Re-enviar formulario de Vacaciones a tu correo?",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $(".overlayer").show();
            $.ajax({
                url: '<?php echo BASE_URL ?>/vacaciones/solicitar',
                type: 'post',
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
                data: {
                    action: 'ajax_resend_form',
                    vacaciones_id: vacaciones_id
                },
                success: function(json){
                    if( json.status == 'ok' ){
                        swal('','Correo enviado correctamente','success');
                    }
                }
            })
            .always(function() {
                $(".overlayer").hide();
            });
        }
    });
});


$("input").keydown(function(){
    $(this).parent().removeClass('has-error');
    $(this).parent().find('label').find('small').remove();
})

$("select").change(function(){
    $(this).parent().removeClass('has-error');
    $(this).parent().find('label').find('small').remove();
})

$("#frmCrear").submit(function(e){
    e.preventDefault();
    error = 0;
    $(".required").each(function(){
        if( $(this).val() == "" ){
            if( !$(this).parent().hasClass('has-error') ){
                $(this).parent().addClass('has-error');
                $(this).parent().find('label').append(' <small>(Este campo es requerido)</small>');
            }
            error++;
        }
    })

    if( $("#table_vacaciones_espera tbody tr").length > 0 ){
        swal('','Ya tiene una solicitud en espera de aprobación. Espere a que su jefe directo la apruebe o rechace.','error');
        error++;
    }
     
    if( error == 0 ){

        if( $("[name=vacaciones_mediodia]").prop('checked') == false ){
            txt_hasta = " hasta el " + global_hasta;
        } else {
            txt_hasta = "";
        }

        event.preventDefault();
        swal({
            title: "",
            text: "Todo parece en orden... ¿Enviar solicitud de vacaciones desde el " + global_desde + txt_hasta + "?",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $(".overlayer").show();
                $("#frmCrear")[0].submit();
            }
        });

    }

})
<?php 
if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
$array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
?>
swal('','<?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>','<?php echo $array_reponse['status'] ?>');
<?php } ?> 

</script>
      



