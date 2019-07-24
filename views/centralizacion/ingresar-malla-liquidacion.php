<!-- Content Wrapper. Contains page content -->    
<style>
#campos_list, #campos_selected{
    padding: 5px 10px;
    margin-top: 15px;
}    
#campos_list{
    background: #eaeaea;
}
#campos_selected{
    background: #caeccd;
}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1> Ingresar Malla Centralización </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php include ROOT . '/views/comun/alertas.php';  ?>
    </section>
    <section class="content">
        <form role="form" id="frmCrear" method="post">
            <input type="hidden" name="action" value="new_malla_liq" />
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Datos de la malla</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nombreEmpresa">Empresa</label>
                                <input type="text" class="form-control" name="nombreEmpresa" value="<?php echo $_SESSION[PREFIX.'login_empresa'] ?>" readonly />
                            </div>
                        </div>
                        

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="origenMalla">Tabla Origen</label>
                                <select class="form-control" name="origenMalla" id="origenMalla" required>
                                    <option value="">Seleccione</option>
                                    <option value="liquidacion">Liquidacion</option>
                                    <option value="l_haber">Haberes</option>
                                    <option value="l_descuento">Descuentos</option>
                                    <option value="l_apv">APV</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="tipoCriterioMalla">Tipo Criterio</label>
                                <select class="form-control" name="tipoCriterioMalla" id="tipoCriterioMalla" required>
                                    <option value="">Seleccione</option>
                                    <option value="1">Criterio por Centro Costo</option>
                                    <option value="2">Criterio por Entidad</option>
                                    <option value="3">Criterio por Individual</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="criterioMalla">Criterio</label>
                                <select class="form-control" name="criterioMalla" id="criterioMalla" required>
                                    <option value="">Seleccione primero un Tipo Criterio</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label>Campos</label>
                                <div class="row">
                                    <div class="col-lg-6 col-xs-6">
                                        <div class="form-group" id="campos_list"></div>
                                    </div>

                                    <div class="col-lg-6 col-xs-6">
                                        <div class="form-group" id="campos_selected"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success btn-lg">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>


<script>

//

$(document).on('click','#campos_list input', function(){
    if( $(this).prop('checked') == true ){
        $(this).closest('.checkbox').detach().prependTo('#campos_selected');
    }
})

$(document).on('click','#campos_selected input', function(){
    if( $(this).prop('checked') !== true ){
        $(this).closest('.checkbox').detach().prependTo('#campos_list');
    }
})


$("[name=cuentaContable]").change(function(){
    var nombreCtaCont = $(this).find('option:selected').text();
    $("[name=nombreCuentaContable]").val(nombreCtaCont);
});

$("#origenMalla").change(function(){
    $("#campos_selected").empty();
    if( $(this).val() != "" ){
        tabla = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo BASE_URL . '/controllers/ajax/centralizacion.ajax.php'?>",
            data: "ajax_action=get_campos&tabla=" + tabla,
            dataType: 'json',
            beforeSend: function(){
                $(".overlayer").show();
            },
            success: function (json) {
                html_chk = ''
                $.each(json.campos, function(i,v){
                    html_chk += '<div class="checkbox">' +
                                '    <label>' +
                                '      <input type="checkbox" name="campos[]" value="'+ v +'">' +
                                '      '+ v +
                                '    </label>' +
                                '  </div>';
                })
                $("#campos_list").html(html_chk);
                $(".overlayer").hide();
            }
        })
    } else {
        $("#campos_list").html('');
    }
})



$("#tipoCriterioMalla").change(function(){
    if( $(this).val() != "" ){
        tipo_criterio = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo BASE_URL . '/controllers/ajax/centralizacion.ajax.php'?>",
            data: "ajax_action=get_criterios&tipo_criterio=" + tipo_criterio,
            dataType: 'json',
            beforeSend: function(){
                $(".overlayer").show();
            },
            success: function (json) {
                html_opts = '<option value="">Seleccione primero un Tipo Criterio</option>'
                $.each(json.criterios, function(i,v){
                    html_opts += '<option value="'+ v.id +'">'+ v.criterio +'</option>';
                })
                $("#criterioMalla").html(html_opts);
                $(".overlayer").hide();
            }
        })
    } else {
        $("#criterioMalla").html('<option value="">Seleccione primero un Tipo Criterio</option>');
    }
})

</script>
