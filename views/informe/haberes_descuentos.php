<style>
.select2-container .select2-selection--single{
  height: 32px;
}
.select2-container .select2-selection--single > span{
    line-height: 32px;
}

</style>
<div class="content-wrapper">
    <section class="content-header">
      <h1> REPORTE ATRASOS MENSUAL </h1>
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
        <form role="form" id="frmVerAtrasosMensual" method="post">
            <input type="hidden" name="action" id="action" value="haberes_descuentos" />
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">
                        <div class="box-body">
                            <div class="col-md-12">
                                
                                    <?php if($_POST): ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th> Rut </th>
                                                        <th> Nombre Completo </th>
                                                        <th> Monto </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <?php 
                                                        $sumatoria = 0;
                                                        for($i=0;$i<10;$i++): 
                                                        ?>
                                                        <tr>
                                                            <td> sadsadasds </td>
                                                            <td> sadsadasds </td>
                                                            <td class="text-right"> <?php echo ($i*100); ?> </td>
                                                        </tr>
                                                        <?php 
                                                        $sumatoria += ($i*100);
                                                        endfor; 
                                                        ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th> &nbsp; </th>
                                                        <th class="text-right"> <strong>Total:</strong> </th>
                                                        <th class="text-right"> <?php echo $sumatoria; ?> </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="<?php echo BASE_URL ?>/informe/haberes_descuentos" class="btn btn-primary btn-lg"> <i class="fa fa-chevron-left"></i> Volver</a>
                                        </div>
                                    </div>
                                    
                                    <?php else: ?>
                                    
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-4 cols-xs-12">
                                            <div class="form-group">
                                                <label> Empresa </label>
                                                <select class="form-control" name="empresa">
                                                    <option value="<?php echo $_SESSION[PREFIX.'login_eid'] ?>"><?php echo $_SESSION[PREFIX.'login_empresa'] ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-4 cols-xs-12">
                                            <label> Descuento o Haber </label>
                                            <select class="form-control" id="cboHaberesDescuentos" name="cboHaberesDescuentos">
                                                <optgroup label="Haberes">
                                                    <?php foreach ($haberes as $haber) { ?>
                                                    <option value="<?php echo $haber['id'] ?>"> <?php echo $haber['nombre'] ?> </option>
                                                    <?php } ?>
                                                </optgroup>
                                                <optgroup label="Descuentos">
                                                    <?php foreach ($descuentos as $descuento) { ?>
                                                    <option value="<?php echo $descuento['id'] ?>"> <?php echo $descuento['nombre'] ?> </option>
                                                    <?php } ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-sm-4 cols-xs-12">
                                            <label>Trabajador</label>
                                            <select class="form-control" id="cboTrabajadores" name="cboTrabajadores">
                                                <option value="">TODOS</option>
                                                <?php foreach ($trabajadores_todos_cert_sueldos as $trabajador) { ?>
                                                <option value="<?php echo $trabajador['id'] ?>"><?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?> <?php echo $trabajador['nombres'] ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary btn-lg pull-right">Enviar</button>
                                        </div>
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

    $("#cbo_haberes_descuentos, #cboTrabajadores").select2();

})


            
</script>
      