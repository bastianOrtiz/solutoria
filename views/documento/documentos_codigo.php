<!-- Content Wrapper. Contains page content -->
<style>
#modal-new-documento label{
    width: 100%;
}
</style>
<div class="content-wrapper">
    
    <section class="content-header">
      <h1> Documentos x código </h1>
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
         <div class="box">
            <div class="box-header">
              <h3 class="box-title">Documentos</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive">
              <table id="tabla_documento" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th> ID </th>
                    <th>Código </th>
                    <th>Nombre</th>
                    <th> Descripción </th>
                    <th> Opciones </th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach( $documentos_codigo as $reg ){ ?>
                        <tr>
                            <td> <?php echo $reg['id']?> </td>
                            <td> <?php echo $reg['codigo_dcto']?> </td>
                            <td> <?php echo $reg['nombre'] ?> </td>
                            <td> <?php echo $reg['descripcion'] ?> </td>
                            <td>                                    
                                <button class="btn btn-sm btn-warning" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Modificar"> <i class="fa fa-edit"></i> </button>
                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Eliminar"><i class="fa fa-remove"></i></button>                                    
                            </td>                                                                                                                                                                                                
                        </tr>
                    <?php } ?>                        
                </tbody>
              </table>
            </div>
          </div>
          
        <a href="#modal-new-documento" data-toggle="modal" class="btn btn-primary">
            <i class="fa fa-plus-circle"></i> Nuevo <?php echo ucfirst($entity) ?>
        </a>
              
    </section>
    
  </div><!-- /.content-wrapper -->            
  
  
<div class="modal fade bs-example-modal-lg" id="modal-new-documento" tabindex="-1" role="dialog">
    <form id="frm-nuevo-documento">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">Nuevo documento</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <label> Codigo
                                    <input type="text" name="codigo_dcto" maxlength="3" class="form-control" required>
                                </label>
                            </div>
                            <div class="col-lg-3">
                                <label> Nombre
                                    <input type="text" name="nombre" class="form-control" required>
                                </label>
                            </div>
                            <div class="col-lg-6">
                                <label> Descripción
                                    <textarea name="descripcion" class="form-control"></textarea>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <br class="clear" />
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>  
            </div>
        </div>
    </form>
</div><!-- /.modal -->


<script>
$(function () {        
    $('#tabla_documento').dataTable({
      "bPaginate": false,
      "bLengthChange": false,
      "bFilter": true,
      "bSort": true,
      "bInfo": false,
      "bAutoWidth": false,
      'pageLength' : 30
    });
});

  
$("#frm-nuevo-documento").submit(function(event){
    event.preventDefault();
    $.ajax({
		type: "POST",
		url: "<?php echo BASE_URL; ?>/documento/documentos_codigo",
		data: $("#frm-nuevo-documento").serialize() + '&action=add_tipo_documento',
        dataType: 'json',
        beforeSend: function(){
            $(".overlayer").show();
        },
		success: function (json) {
            if(!json.status){
                alert('Código ya existe');
                $(".overlayer").hide();
            } else {
                window.location.reload();    
            }
            
        }
	})
})
</script>