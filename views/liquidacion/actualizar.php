<div class="content-wrapper">
    <section class="content-header">            
      <h1> ACTUALIZAR VALORES DE SIS y SCES </h1>
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
        <form action="" method="post">
            <input type="hidden" name="action" value="actualizar_sis_sces">
            <div class="row">

                <div class="col-lg-3">
                    <div class="input-group input-group-lg">
                        <input type="hidden" name="mes" class="hdnValue">
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
                <div class="col-lg-3">
                    <div class="input-group input-group-lg">
                        <input type="hidden" name="ano" class="hdnValue">
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
                <div class="col-lg-3">
                    <button type="submit" id="" class="btn btn-primary btn-lg pull-right">ACTUALIZAR</button>
                </div>
            </div>
        </form>
    </section>

</div><!-- /.content-wrapper -->

<script>
    $(document).ready(function(){
        $(".datepicker").datepicker({
            startView : 'year',
            autoclose : true,
            format : 'yyyy-mm-dd'
        });

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
        
    });
    </script>      
