<style>
.box-body{
    position: relative;
}
.overlayer_int{
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #FFF;
    z-index: 9998;
    opacity: .55;
    -moz-opacity: 0.55;
    -webkit-opacity: 0.55;
    -o-opacity: 0.55;
    -ms-opacity: 0.55;
    filter: alpha(opacity=55);
}
.overlayer_int i {
    position: absolute;
    top: 100px;
    left: 50%;
    margin-left: -15px;
    margin-top: -15px;
    color: #000;
    font-size: 30px;
}
.text-uppercase{
    text-transform: uppercase;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

<section class="content-header">
  <h1> Editar SIS y SCES </h1>
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
        <div class="box-header form-inline">
        	<form method="get">
	        	<select class="form-control" name="mes" required>
	        		<option value="">Mes</option>
	        		<?php for($i=1;$i<=12;$i++): ?>
	    			<option value="<?php echo $i; ?>"><?php echo getNombreMes($i); ?></option>
	    			<?php endfor; ?> 
	        	</select>
				<script> $("[name=mes]").val(<?php echo @$_GET['mes'] ?>) </script>

	        	<select class="form-control" name="ano" required>
	        		<option value="">Año</option>
	        		<?php for($i=2021;$i>=2016;$i--): ?>
	    			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
	    			<?php endfor; ?> 
	        	</select>
	        	<script> $("[name=ano]").val(<?php echo @$_GET['ano'] ?>) </script>

	        	<button type="submit" class="btn btn-success" style="margin-top: -10px;">Enviar</button>
        	</form>
        </div>
        <div class="box-body table-responsive">

        <div class="overlayer_int"><i class="fa fa-refresh fa-spin"></i></div>

        <?php if( $registros ){ ?>
          <table id="trabajadores_list" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Ap. Paterno</th>                        
                <th>Ap. Materno</th>                        
                <th>Nombres</th>
                <th>SIS</th>
                <th>SCES</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach( $registros as $reg ){ ?>
                    <tr data-id="<?php echo $reg['liquidacion_id']?>">
                        <td> <?php echo $reg['trabajador_id']?> </td>
                        <td> <?php echo $reg['apellidoPaterno'] ?> </td>
                        <td> <?php echo $reg['apellidoMaterno'] ?></td>
                        <td> <?php echo $reg['nombres'] ?></td>
                        <td><input type="text" data-name="sis" value="<?php echo $reg['sis'] ?>" class="form-control" style="width: 100px;"></td>
                        <td><input type="text" data-name="sces" value="<?php echo $reg['sces'] ?>" class="form-control" style="width: 100px;"></td>
                    </tr>
                <?php } ?>                        
            </tbody>
          </table>

          <?php } else { ?>
          
            <pre> No hay datos disponibles </pre>  
          
          <?php } ?>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      
           
        
        <!-- Large modal -->                                                
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                  <h4 class="modal-title" id="myLargeModalLabel"></h4>
                  <div class="image"></div>
                </div>
                <div class="modal-body">
                    <div class="box-body col-md-12">
                                                                                           
                    </div><!-- /.box-body -->
                </div>
                <br class="clear" />
                <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                <a href="" class="btn btn-warning">Modificar</a>
                <a href="" class="btn btn-danger">Eliminar</a>
              </div>  
            </div>
          </div>
        </div><!-- /.modal -->
        
          
</section>

</div><!-- /.content-wrapper -->            
       

<script>

$("input").blur(function(){
    regid = $(this).closest('tr').data('id');
    field = $(this).data('name');
    value = $(this).val();
    $.ajax({
        type: "POST",
        url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
        data: {
            regid : regid,
            action : 'ajax_update_field',
            field : field,
            value : value
        },
        dataType: 'json',
        beforeSend: function(){
            $(".overlayer").show();
        },
        success: function (json) {
            console.log(json);
            $(".overlayer").hide();                                 
        }
    })
})

$(document).ready(function() {

    $('#trabajadores_list').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": true,
        "pageLength": 30,
        "order": [[ 1, "ASC" ]]
    });
});


$(window).load(function() {
    $(".overlayer_int").hide();
});

</script>