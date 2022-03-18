<style type="text/css">
.progress{
    position: fixed;
    top: 10px;
    width: 90%;
    z-index: 99999;
    left: 5%;
    border-radius: 50px;
    height: 27px;
    opacity: 0;
}

.progress-percent{
    position: absolute;
    left: 20px;
    top: 0px;
    text-shadow: 0 0 3px black;
    color: #fff;
    font-size: 18px;
}


@keyframes blink {
    0% { opacity: .1; }
    20% { opacity: 1; }
    100% { opacity: .1; }
}

.log em {
    animation-name: blink;
    animation-duration: 1.4s;
    animation-iteration-count: infinite;
    animation-fill-mode: both;
    font-size: 40px;
    line-height: 10px;
}

.log em:nth-child(2) {
    animation-delay: .2s;
}

.log em:nth-child(3) {
    animation-delay: .4s;
}

</style>
<div class="content-wrapper">

    <section class="content-header">
      <h1> Proceso de liquidacion masiva </h1>
      <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
      
        <?php 
        if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
        $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
        ?>          
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4> <i class="icon fa fa-check"></i> Mensaje:</h4>
            <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
    </section>


    <section class="content">                
        <div class="box">
            
            <?php if( $_GET['depto'] ): ?>

            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                <strong class="progress-percent">Progreso: <span>1</span>%</strong>
            </div>
            
            <div class="box-header form-inline">
                <h3 class="box-title">Departamento: <strong><?php echo $nombre_depto; ?></strong></h3>
            </div>
           
            <div class="log" style="padding: 12px"></div>

            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="box-body">
                        <div class="info-box" style="border:1px solid #d5d5d5">
                            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text"><strong>Mes / Año a liquidar</strong></span>
                                <span class="info-box-number"><?php echo getNombreMes(getMesMostrarCorte(), false) . ' / ' .  getAnoMostrarCorte() ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <form method="post" id="frm-liquidar">
                    <input type="hidden" name="action" value="liquidar_batch">
                    <button type="submit" class="btn btn-success btn-lg">GENERAR LIQUIDACIONES</button>
                    <br>
                    <a href="javascript: history.back()" class="btn btn-secondary">volver</a> 
                </form>
            </div>

            <h3 id="timer"style="padding-left: 20px;"><time>00:00:00</time></h3>

            <?php else: ?>

            <form method="get" onsubmit="javascript: $('.overlayer').show();">
                <div class="box-header form-inline">
                    <h3 class="box-title">Seleccione Departamento</h3>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="box-body">
                            <select name="depto" class="form-control">
                                <option>Departamento...</option>
                                <?php foreach($departamentos as $depto): ?>
                                <option value="<?php echo $depto['id']; ?>"><?php echo $depto['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-success btn-lg">SELECCIONAR</button>
                </div>
            </form>

            <?php endif; ?>

        </div>
    </section>






</div>
       
<script type="text/javascript">

json_trabajadores_id = <?php echo json_encode($trabajadores_ids_todos); ?>;
json_trabajadores_nombres = <?php echo json_encode($trabajadores_nombres); ?>;

$("#frm-liquidar").submit(function(event) {
    event.preventDefault();   
    swal({
        title: "",
        text: "Recuerde que antes de procesar debe tener actualizado:\n* Semana Corrida\n* UF\n* UTM\n* SIS",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((value) => {
        if(value){
            timer();
            $(".progress").css('opacity',1);
            $(".log").html('');

            trabajador_total = json_trabajadores_id.length;
            step = (100 / trabajador_total);
            percent = 0;
            trabajador_count = 0;
            error = 0;
            ids_ok = '';

            $(".progress-bar").css({
                width: '0%'
            });

            recursively_ajax();
        }
    })     
});

function recursively_ajax(){
    
    percent += step;

    $('.log').append('<div id="log_' + json_trabajadores_id[trabajador_count] + '">Procesando trabajador: ' + json_trabajadores_nombres[json_trabajadores_id[trabajador_count]] + ' &nbsp;  &nbsp;  &nbsp; <span><em>.</em><em>.</em><em>.</em></span></div>');

    $.ajax({
        url: '<?php echo BASE_URL; ?>/liquidacion',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'liquidar_batch',
            trabajador_id: json_trabajadores_id[trabajador_count]
        },
        beforeSend: function(){
            $(".overlayer").show();
        },
        success: function(json){
            error = 0;
            ids_ok += json.liquidacion_id + ',';

            $('.log #log_' + json_trabajadores_id[trabajador_count] + ' span').html('<span class="text-success">[OK]</span>');
            
            trabajador_count++;
            
            $(".progress-bar").css({
                width: (percent) + '%'
            });
            $(".progress-percent span").text(Math.round(percent));

            if(trabajador_count < trabajador_total){
                recursively_ajax(trabajador_count);
            } else {
                clearTimeout(t);

                swal("","PROCESO COMPLETADO\n¿Desea imprimir las liquidaciones?",'success', {
                    buttons: ["No", "Si"],
                })
                .then( (value) => {
                    
                    $(".overlayer").hide();
                    $(".progress").css('opacity',0);

                    if(value){
                        let a= document.createElement('a');
                        a.target= '_blank';
                        a.href= '<?php echo BASE_URL; ?>/private/pdfgen_batch.php?ids=' + ids_ok;
                        a.click();
                    }
                })

            }
        }
    })
    .fail(function(err) {
        $('.log #log_' + json_trabajadores_id[trabajador_count] + ' span').html('<span class="text-danger">[ERROR]</span>: ' + err.responseText);
        console.log(err);
        error++;

        if(error >= 10){
            swal('','Demasiados errores seguidos\nRevise todos los indicadores (uf, utm, semana corrida, etc) antes de continuar con el proceso de liquidación', 'error')
            .then((value) => {
                window.open = '<?php echo BASE_URL; ?>/liquidacion/batch';
            });
        } else {
            trabajador_count++;
            recursively_ajax();
        }
        
    })
}












// Cronometro 
var h1 = document.getElementById('timer');
var start = document.getElementById('strt');
var stop = document.getElementById('stp');
var reset = document.getElementById('rst');
var sec = 0;
var min = 0;
var hrs = 0;
var t;

function tick(){
    sec++;
    if (sec >= 60) {
        sec = 0;
        min++;
        if (min >= 60) {
            min = 0;
            hrs++;
        }
    }
}
function add() {
    tick();
    h1.textContent = (hrs > 9 ? hrs : "0" + hrs) 
             + ":" + (min > 9 ? min : "0" + min)
             + ":" + (sec > 9 ? sec : "0" + sec);
    timer();
}
function timer() {
    t = setTimeout(add, 1000);
}




</script>

