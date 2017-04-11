<!-- Content Wrapper. Contains page content -->    
<style>
.addedCols .input-group{
    margin: 10px 0;
}
.rotate{
    -ms-transform: rotate(90deg); /* IE 9 */
    -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
    transform: rotate(90deg);
}
.fa-file-o{
    font-size: 20px;
    margin: 0 10px 0 5px;
}
</style>    
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> GENERAR INFORME </h1>
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
          <div class="row">
              <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">                
                    <div class="box-header">
                      <h3 class="box-title">Filtros</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="frmCrear" method="post" target="_blank">
                    <input type="hidden" name="action" value="listado_trabajadores" />                    
                      <div class="box-body">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Departamento</label>
                                <div class="input-group">
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="depaTodos" name="depaTodos" /> <strong>TODOS</strong>
                                      </label>
                                    </div>
                                    <?php foreach( $departamentos as $dep ){ ?>
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" class="filtroDepartamento" name="filtroDepartamento[<?php echo $dep['id'] ?>]" /> <?php echo $dep['nombre'] ?>
                                      </label>
                                    </div>
                                    <?php } ?>
                                </div>                              
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Columnas a mostrar</label>
                                <div class="input-group">
                                    <div class="checkbox">
                                      <label>
                                        <input type="checkbox" id="colsTodas" name="colsTodas" /> <strong>TODAS</strong>
                                      </label>
                                    </div>                                                                         
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[apellidoPaterno]" value="Apellido Paterno" />Apellido Paterno</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[apellidoMaterno]" value="Apellido Materno" />Apellido Materno</label></div>
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[nombres]" value="Nombres" />Nombres</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[email]" value="Email" />Email</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[rut]" value="Rut" />Rut</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[sexo]" value="Sexo" />Sexo</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[fechaNacimiento]" value="Fecha Nacimiento" />Fecha Nacimiento</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[idNacionalidad]" value="Nacionalidad" />Nacionalidad</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[telefono]" value="Teléfono" />Teléfono</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[direccion]" value="Dirección" />Dirección</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[marcaTarjeta]" value="Marca Tarjeta" />Marca Tarjeta</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[gratificacion]" value="Gratificacion" />Gratificacion</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[sueldoBase]" value="Sueldo Base" />Sueldo Base</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[cargo_id]" value="Cargo" />Cargo</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[departamento_id]" value="Departamento" />Departamento</label></div> 
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[comuna_id]" value="Comuna" />Comuna</label></div>                                      
                                    <div class="checkbox"><label><input type="checkbox" class="filtroCols" name="filtroCols[fechaContratoInicio]" value="Fecha Contrato" />Fecha Contrato</label></div>
                                    
                                </div>                              
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <label>Ordenar por</label>
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="nombres" data-placeholder="Nombres" />Nombres</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="apellidoPaterno" data-placeholder="Apellido Paterno" checked />Apellido Paterno</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="apellidoMaterno" data-placeholder="Apellido Materno" />Apellido Materno</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="email" data-placeholder="Email" />Email</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="rut" data-placeholder="Rut" />Rut</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="sexo" data-placeholder="Sexo" />Sexo</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="fechaNacimiento" data-placeholder="Fecha Nacimiento" />Fecha Nacimiento</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="idNacionalidad" data-placeholder="Nacionalidad" />Nacionalidad</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="telefono" data-placeholder="Teléfono" />Teléfono</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="direccion" data-placeholder="Dirección" />Dirección</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="marcaTarjeta" data-placeholder="Marca Tarjeta" />Marca Tarjeta</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="gratificacion" data-placeholder="Gratificacion" />Gratificacion</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="sueldoBase" data-placeholder="Sueldo Base" />Sueldo Base</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="cargo_id" data-placeholder="Cargo" />Cargo</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="departamento_id" data-placeholder="Departamento" />Departamento</label></div> 
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="comuna_id" data-placeholder="Comuna" />Comuna</label></div>                                      
                            <div class="checkbox"><label><input type="radio" name="ordernarPor" value="fechaContratoInicio" data-placeholder="Fecha Contrato" />Fecha Contrato</label></div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Columnas Personalizadas</label>
                                <div class="addedCols">
                                    <div class="input-group">
                                        <input type="text" class="form-control inputTxt" name="cols_perso[]" placeholder="Nombre de la Columna" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-info addCol" type="button"><i class="fa fa-plus"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <p><label>Orientacion</label></p>                            
                            <a class="btn btn-default orientation" data-or="L">
                                <i class="fa fa-file-o rotate"></i> Horizontal
                            </a>                            
                            <a class="btn btn-primary orientation" data-or="P">
                                <i class="fa fa-check"></i><i class="fa fa-file-o"></i> Vertical
                            </a>                            
                            <input type="hidden" name="orientation" id="orientation" value="P" />
                            
                            <br /><br />
                            
                            <p><label>Formato</label></p>
                            
                            <a class="btn btn-default output" data-or="excel">
                                <i class="fa fa-file-excel-o"></i> &nbsp;  Excel
                            </a>
                            
                            <a class="btn btn-primary output" data-or="pdf">
                                <i class="fa fa-check"></i> &nbsp; <i class="fa fa-file-pdf-o"></i> &nbsp; PDF
                            </a>
                            
                            <input type="hidden" name="output" id="output" value="pdf" />
                            
                        </div>
                        
                      </div><!-- /.box-body -->
    
                      <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                      </div>
                    </form>
                  </div><!-- /.box -->
    
    
                </div>
          </div>   <!-- /.row -->
        </section>
        
      </div><!-- /.content-wrapper -->
      
<script>

$(document).ready(function(){
    
    $(".orientation").click(function(){
        $(".orientation").removeClass('btn-primary').addClass('btn-default');
        $(".orientation").find('.fa-check').remove();
        $(this).addClass('btn-primary').removeClass('btn-default');
        $(this).prepend('<i class="fa fa-check"></i>');
        $("input#orientation").val( $(this).data('or') );
    })
    
    
    $(".output").click(function(){
        $(".output").removeClass('btn-primary').addClass('btn-default');
        $(".output").find('.fa-check').remove();
        $(this).addClass('btn-primary').removeClass('btn-default');
        $(this).prepend('<i class="fa fa-check"></i>');
        $("input#output").val( $(this).data('or') );
    })
    
    $(".addCol").click(function(){
        nombre_col = $(this).closest('.input-group').find('.inputTxt').val();
        if( nombre_col != "" ){                        
            html = '<div class="input-group">';
            html += '<input type="text" class="form-control" name="cols_perso[]" value="'+nombre_col+'" />';
            html += '<span class="input-group-btn">';
            html += '<button class="btn btn-info delCol" type="button"><i class="fa fa-minus"></i></button>';
            html += '</span>';
            html += '</div>';
            
            $(".addedCols").append(html);
            $(this).closest('.input-group').find('.inputTxt').val('');
        }
    })
    
    $(document).on('click','.delCol', function(){
        $(this).closest('.input-group').remove();
    })
    
    $("#depaTodos").click(function(){
        if( $(this).prop('checked') == true ){
            $('.filtroDepartamento').prop('checked',true);
        } else {
            $('.filtroDepartamento').prop('checked',false);
        }
    })
    
    $('.filtroDepartamento').click(function(){
        if( $('.filtroDepartamento:checked').length < $('.filtroDepartamento').length ){
            $('#depaTodos').prop('checked',false);
        } else {
            $('#depaTodos').prop('checked',true);
        }
    })
    
    
     $("#colsTodas").click(function(){
        if( $(this).prop('checked') == true ){
            $('.filtroCols').prop('checked',true);
        } else {
            $('.filtroCols').prop('checked',false);
        }
    })
    
    $('.filtroCols').click(function(){
        if( $('.filtroCols:checked').length < $('.filtroCols').length ){
            $('#colsTodas').prop('checked',false);
        } else {
            $('#colsTodas').prop('checked',true);
        }
    })
    
})

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
    if( error == 0 ){
        $(".overlayer").show();
        $("#frmCrear")[0].submit();
        $(".overlayer").hide();
    }

})            
</script>
      