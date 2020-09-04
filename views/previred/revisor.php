<style>
#table-previred th,
#table-previred td{
    white-space: nowrap;
}
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
        <h1> Subir Archivo Previred </h1>
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
                <?php if( $revisor ):  ?>
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-previred">
                                <thead>
                                    <tr>
                                        <th> Rut </th>
                                        <th> Apellido P. </th>
                                        <th> Apellido M. </th>
                                        <th> Nombres </th>
                                        <th> Sexo </th>
                                        <th> Extranjero </th>
                                        <th> Tipo Pago </th>
                                        <th> Período (Desde)  </th>
                                        <th> Período (Hasta)  </th>
                                        <th> Regimen Previsional  </th>
                                        <th> Tipo Trabajador  </th>
                                        <th> Dias Trabajados  </th>
                                        <th> Tipo Linea  </th>
                                        <th> Codigo Mov. de Personal  </th>
                                        <th> Fecha Desde  </th>
                                        <th> Fecha Hasta  </th>
                                        <th> Tramo Asig. Familiar </th>
                                        <th> Nro. Cargas Simples </th>
                                        <th> Nro. Cargas Maternales </th>
                                        <th> Asignación Familiar </th>
                                        <th> Asignación Familiar Retroactiva </th>
                                        <th> Reintegro Cargas Familiares </th>
                                        <th> Solicitud Trabajador Joven </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($revisor as $key => $value) : ?>
                                    <tr>
                                        <td> 
                                            <?php echo substr($value, 0, 11); ?>-<?php echo substr($value, 11, 1); ?>
                                        </td>
                                        <td> <input type="text" value="<?php echo substr($value, 12, 30); // Ap. Pat. ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 42, 30); // Ap. Mat. ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 72, 30); // Nombres  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 102, 1); // Sexo  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 103, 1); // Extranjero  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 104, 2); // Tipo Pago  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 106, 6); // Periodo Desde  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 112, 6); // Periodo Hasta ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 118, 3); // Regimen Prev. ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 121, 1); // Tipo Trabajador  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 122, 2); // Dias Trabajados  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 124, 2); // Tipo Linea  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 126, 2); // Codigo Mov. de Personal  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 128,10); // Fecha Desde  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 138,10); // Fecha Hasta  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 148,1); // Tramo Asig. Familiar  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 149,2); // Nro. Cargas Simples  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 151,1); // Nro. Cargas Maternales  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 152,6); // Asignación Familiar  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 158,6); // Asignación Familiar retro  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 164,6); // Reintegro Cargas Familiares  ?>" class="form-control" style="width: 200px"> </td>
                                        <td> <input type="text" value="<?php echo substr($value, 170,1); // Solicitud Trabajador Joven  ?>" class="form-control" style="width: 200px"> </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <form role="form" id="frmCrear" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_previred" />
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Seleccione Archivo</label>
                                        <input type="file" name="archivo_previred" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-lg pull-left" style="margin-top: 18px;">Subir archivo y Revisar <i class="fa fa-upload"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                 </form>
                <?php endif; ?>
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

        if( error == 0 ){
            $("#btnSubmit").prop('disabled',true);            
            loadMe();
            $("#frmCrear")[0].submit();
        }
    })   

})

</script>