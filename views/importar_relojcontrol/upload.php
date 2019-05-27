<style>
#loadme_overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.7);
    z-index: 9999;
}

#loadme_overlay .progress{
    position: absolute;
    width: 70%;
    top: 50%;
    left: 15%;
    height: 40px;
    border-radius: 30px;
    border: 1px solid #ccc;
}
#loadme_overlay .progress span{
    color: #000;
    font-size: 18px;
    display: block;
    line-height: 38px;
    text-align: center;
}


</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1> Subir Archivo del RelojControl (.dat) </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php 
            if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
            $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
            ?>
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
            <h4>  <i class="icon fa fa-check"></i> Mensaje:</h4>
            <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form role="form" id="frmCrear" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_dat" />
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Seleccione Archivo</label>
                                        <input type="file" name="archivo_dat" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Fecha Inicio del Rango (opcional)</label>
                                        <input type="text" value="<?php echo date('Y-m-d') ?>" name="fechaInicioRango" id="fechaInicioRango" class="form-control datepicker input-lg" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Fecha Fin del Rango (opcional)</label>
                                        <input type="text" value="<?php echo date('Y-m-d') ?>" name="fechaFinRango" id="fechaFinRango" class="form-control datepicker" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="box-footer">
                            <button type="submit" id="btnSubmit" class="btn btn-primary btn-lg pull-right">Subir archivo e Importar data <i class="fa fa-upload"></i> </button>
                        </div>
                    </div>
                 </form>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->


<div id="loadme_overlay">
    <div class="progress">
        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
        </div>
    </div>
</div>


<script>
sec=0;
function loadMe() {
    $("#loadme_overlay").fadeIn(300);
    repeat = setInterval(function(){
        if( sec <= 100 ){
            $(".progress-bar").css({
                'width' : sec + '%' 
             });
             sec++;
        } else {
            sec=0;
        }
    },200);
}


$(document).ready(function(){

    $("input").focus(function(){
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

        if( ( $("#fechaInicioRango").val() != "" ) && ( $("#fechaFinRango").val() == "" ) ){
            if( !$("#fechaFinRango").parent().hasClass('has-error') ){
                $("#fechaFinRango").parent().addClass('has-error');
                $("#fechaFinRango").parent().find('label').append('<br><small>(Si elije fecha de Inicio, DEBE seleccionar fecha Fin)</small>');
            }
            error++;
        }

        if( ( $("#fechaInicioRango").val() == "" ) && ( $("#fechaFinRango").val() != "" ) ){
            if( !$("#fechaInicioRango").parent().hasClass('has-error') ){
                $("#fechaInicioRango").parent().addClass('has-error');
                $("#fechaInicioRango").parent().find('label').append('<br><small>(Si elije fecha de Fin, DEBE seleccionar fecha Inicio)</small>');
            }
            error++;
        }

        if( ( $("#fechaInicioRango").val() != "" ) && ( $("#fechaFinRango").val() != "" ) ){
            var fechaIniInt = $("#fechaInicioRango").val();
            var fechaIniInt = fechaIniInt.replace(/-/g, "");

            var fechaEndInt = $("#fechaFinRango").val();
            var fechaEndInt = fechaEndInt.replace(/-/g, "");

            if( parseInt(fechaIniInt) > parseInt(fechaEndInt) ){
                $("#fechaInicioRango").parent().addClass('has-error');
                $("#fechaInicioRango").parent().find('label').append('<br><small>(La fecha de Inicio no puede ser mayor a la fecha Fin)</small>');
                
                $("#fechaFinRango").parent().addClass('has-error');
                $("#fechaFinRango").parent().find('label').append('<br><small>(La fecha de Inicio no puede ser mayor a la fecha Fin)</small>');   
                error++;
            }
            
        }
    

        if( error == 0 ){
            $("#btnSubmit").prop('disabled',true);            
            loadMe();
            $("#frmCrear")[0].submit();
        }
    })   

    $(".datepicker").datepicker({
        startView : 'year',
        autoclose : true,
        format : 'yyyy-mm-dd'
    });
})

</script>