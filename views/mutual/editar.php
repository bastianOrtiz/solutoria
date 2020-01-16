<!-- Content Wrapper. Contains page content -->    
<div class="content-wrapper">
    <section class="content-header">
        <h1> Editar <?php echo strtolower($entity) ?> </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php         
            if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
              $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
              ?>
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
            <h4><i class="icon fa fa-check"></i> Mensaje:</h4>
            <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "<br />ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Datos del Registro</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="frmCrear" method="post">
                        <input type="hidden" name="mutual_id" value="<?php echo $mutual['id'] ?>" />
                        <input type="hidden" name="action" value="edit" />
                        <div class="box-body">


                            <div class="row">
                                <div class="col-lg-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="nombreMutual">Nombre</label>
                                        <input type="text" class="form-control required" value="<?php echo $mutual['nombre'] ?>" id="nombreMutual" name="nombreMutual" placeholder="Nombre Mutual" />
                                    </div>
                                    <div class="form-group">
                                        <label for="codigoMutual">Código Previred</label>
                                        <input type="text" class="form-control required" value="<?php echo $mutual['codigo'] ?>" id="codigoMutual" name="codigoMutual" placeholder="Código Previred" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="tasaBase">Tasa Base</label>
                                        <input type="text" class="form-control" name="tasaBase" id="tasaBase">
                                        <script> $("#tasaBase").val('<?php echo $mutual['tasaBase'] ?>') </script>
                                    </div>
                                    <div class="form-group">
                                        <label for="tasaAdicional">Tasa Adicional</label>
                                        <input type="text" class="form-control" name="tasaAdicional" id="tasaAdicional">
                                        <script> $("#tasaAdicional").val('<?php echo $mutual['tasaAdicional'] ?>') </script>
                                    </div>
                                    <div class="form-group">
                                        <label for="tasaExtraordinaria">Tasa Extraordinaria</label>
                                        <input type="text" class="form-control" name="tasaExtraordinaria" id="tasaExtraordinaria">
                                        <script> $("#tasaExtraordinaria").val('<?php echo $mutual['tasaExtraordinaria'] ?>') </script>
                                    </div>
                                    <div class="form-group">
                                        <label for="tasaLeyEspecial">Tasa Ley Especial (Ley Sanna)</label>
                                        <input type="text" class="form-control" name="tasaLeyEspecial" id="tasaLeyEspecial">
                                        <script> $("#tasaLeyEspecial").val('<?php echo $mutual['tasaLeyEspecial'] ?>') </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Enviar</button>                        
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
</div>
<!-- /.content-wrapper -->
<script>
$("#frmCrear").submit(function(e){
    e.preventDefault();
    var error = 0;
    $(".required").each(function(){
        if( $(this).val() == "" ){
          $(this).parent().addClass('has-error');
          $(this).parent().find('label').append(' &nbsp; <small>(Este campo es requerido)</small>');
          error++;
        }
    })
  
    if( error == 0 ){

        if( <?php echo $mutual['id'] ?> == 1 ){
            alert("Recuerde que al modificar la Tasa Base y la Tasa Adicional, debe cambiar el valor para ACHS en el mantenedor de Costos de Empresa\n(Menú Misceláneos -> Costos Empresa -> Costo: ACHS)");
        }

        $(".overlayer").show();
        $("#frmCrear")[0].submit();
    }
})            
</script>