<div class="content-wrapper">
    <section class="content-header">
      <h1> REPORTE ATRASOS MENSUAL </h1>
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
        <form role="form" id="frmVerAtrasosMensual" method="post">
            <input type="hidden" name="action" id="action" value="reporte_atrasos_mensual" />
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">
                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <?php if($_POST): ?>
                                        <div class="small-box bg-green">
                                            <div class="inner">
                                              <h3 style="font-size: 80px"><?php echo $tot_global_atrasos; ?></h3>
                                              <p>Atrasos en el mes de <strong><?php echo getNombreMes($mesAtraso) ?></strong> de <?php echo ($anoAtraso) ?> </p>
                                            </div>
                                            <div class="icon">
                                              <i class="ion ion-stats-bars"></i>
                                            </div>
                                            <a href="<?php echo BASE_URL ?>/<?php echo $entity ?>/atrasos" class="small-box-footer">Obtener informe detallado por dia <i class="fa fa-arrow-circle-right"></i></a>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="<?php echo BASE_URL ?>/<?php echo $entity ?>/atrasos_mensual" class="btn btn-primary pull-left"> <i class="fa fa-chevron-left"></i> Volver</a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                    <div class="col-lg-4">
                                        <div class="input-group input-group-lg">
                                            <input type="hidden" name="mesAtraso" class="hdnValue">
                                            <div class="input-group-btn">
                                              <button type="button" class="btn btn-warning" data-toggle="dropdown">Seleccione mes
                                                <span class="fa fa-caret-down"></span></button>
                                              <ul class="dropdown-menu" id="cboMes">
                                                <li><a href="#">Seleccione mes</a></li>
                                                <?php for($i=1;$i<=12;$i++){ ?>
                                                <li><a href="#" data-val="<?php echo $i ?>"> <?php echo getNombreMes($i) ?> </a></li>
                                                <?php } ?>
                                              </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group input-group-lg">
                                            <input type="hidden" name="anoAtraso" class="hdnValue">
                                            <div class="input-group-btn">
                                              <button type="button" class="btn btn-warning" data-toggle="dropdown">Seleccione Año
                                                <span class="fa fa-caret-down"></span></button>
                                                  <ul class="dropdown-menu" id="cboAno">
                                                    <li><a href="#">Seleccione Año</a></li>
                                                    <?php for($i=date('Y');$i>=2015;$i--){ ?>
                                                    <li><a href="#" data-val="<?php echo $i ?>"> <?php echo $i ?> </a></li>
                                                    <?php } ?>
                                                  </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-primary btn-lg">Enviar</button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>         

                        </div>                                            
                    </div>                      
                
                </div>
            </div>
        </form>
</section>
        
</div><!-- /.content-wrapper -->
      
<script>
$(document).ready(function(){    
   
    $(".dropdown-menu a").click(function(e){
        e.preventDefault();
        var txt = $(this).text();
        var val = $(this).data('val');
        $(this).closest('.input-group-btn').find('button.btn').html(txt + '<span class="fa fa-caret-down"></span>');
        $(this).closest('.input-group').find('.hdnValue').val(val);
    })

    $("#frmVerAtrasosMensual").submit(function(e){
        e.preventDefault();
        err=0;
        $(".overlayer").show();
        $(".hdnValue").each(function(){
            if($(this).val()==""){
                err++;
            }
        })
        if( err == 0 ){
            $("#frmVerAtrasosMensual")[0].submit();
        } else {
            alert('Seleccione mes y Año');
            $(".overlayer").hide();
            return false;
        }
    })

})

            
</script>
      