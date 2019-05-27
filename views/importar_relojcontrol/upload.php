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
                                        <input type="text" name="fechaInicioRango" id="fechaInicioRango" class="form-control datepicker" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Fecha Fin del Rango (opcional)</label>
                                        <input type="text" name="fechaFinRango" id="fechaFinRango" class="form-control datepicker" readonly>
                                    </div>
                                </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-lg">Subir <i class="fa fa-upload"></i> </button>
                        </div>
                    </div>
                 </form>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<script>

$(document).ready(function(){

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
            var fechaIniInt = fechaIniInt.replace('-','');

            var fechaEndInt = $("#fechaFinRango").val();
            var fechaEndInt = fechaEndInt.replace('-','');

            console.log( fechaIniInt + " - " + fechaEndInt );
            if( ( $("#fechaInicioRango").val() == "" ) && ( $("#fechaFinRango").val() != "" ) ){
                if( !$("#fechaInicioRango").parent().hasClass('has-error') ){
                    $("#fechaInicioRango").parent().addClass('has-error');
                    $("#fechaInicioRango").parent().find('label').append('<br><small>(Si elije fecha de Fin, DEBE seleccionar fecha Inicio)</small>');
                }
                error++;
            }
        }


        if( error == 0 ){
            $(".overlayer").show();
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