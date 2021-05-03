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
  <h1> Lista Firma </h1>
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
            <div id="calendar"></div>
          <h3 class="box-title"><?php echo ucfirst($entity) ?></h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">

        <div class="overlayer_int"><i class="fa fa-refresh fa-spin"></i></div>
        
        <?php if( $registros ){ ?>
          <table id="trabajadores_list" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th> ID </th>
                <th></th>
                <th>Ap. Paterno</th>                        
                <th>Ap. Materno</th>                        
                <th>Nombres</th>
                <th>Cargo</th>
                <th>Departamento</th>
                <th>Telefono</th>
                <th>Celular</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
                <?php foreach( $trabajadors as $reg ){ ?>
                    <tr data-id="<?php echo $reg['id']?>">
                        <form  target="_blank" method="post" action="<?php echo BASE_URL . '/' . $entity ?>/generar_firmas/">
                        <td> <?php echo $reg['id']?> </td>
                        <td><button type="submit" class="btn btn-success">Generar Firma</button></td>
                        <td> <input type="text" class="form-control text-uppercase" name="apellidoPaterno" value="<?php echo $reg['apellidoPaterno'] ?>"> <span style="position: absolute; left: -999999px"><?php echo $reg['apellidoPaterno'] ?></span> </td>
                        <td> <input type="text" class="form-control text-uppercase" name="apellidoMaterno" value="<?php echo $reg['apellidoMaterno'] ?>"> <span style="position: absolute; left: -999999px"><?php echo $reg['apellidoMaterno'] ?></span> </td>
                        <td> <input type="text" class="form-control text-uppercase" name="nombres" value="<?php echo $reg['nombres'] ?>"> <span style="position: absolute; left: -999999px"><?php echo $reg['nombres'] ?></span> </td>
                        <td>
                            <select id="cargo_id_<?php echo $reg['id']?>" class="form-control" name="cargo_id">
                                <?php foreach ($cargos as $key => $cargo) { ?>
                                <option value="<?php echo $cargo['nombre'] ?>"><?php echo $cargo['nombre'] ?></option>
                                <?php } ?>
                            </select>
                            <script>$("#cargo_id_<?php echo $reg['id']?>").val('<?php echo fnNombreCargo($reg['cargo_id']) ?>')</script>
                            <span style="position: absolute; left: -999999px"><?php echo fnNombreCargo($reg['cargo_id']) ?></span> 
                        </td>
                        <td> 
                            <input type="text" class="form-control" name="" value="<?php echo fnNombreDepartamento($reg['departamento_id']) ?>"> 
                            <span style="position: absolute; left: -999999px"><?php echo fnNombreDepartamento($reg['departamento_id']) ?></span> 
                        </td>
                        <td> <input type="text" class="form-control" name="telefono" value="<?php echo $reg['telefono'] ?>"> <span style="position: absolute; left: -999999px"><?php echo $reg['telefono'] ?></span> </td>
                        <td> <input type="text" class="form-control" name="celular" value="<?php echo $reg['celular'] ?>"> <span style="position: absolute; left: -999999px"><?php echo $reg['celular'] ?></span> </td>
                        <td> <input type="text" class="form-control" name="email" value="<?php echo $reg['email'] ?>" style="width: 300px"> <span style="position: absolute; left: -999999px"><?php echo $reg['email'] ?></span> </td>
                        </form>
                    </tr>
                <?php } ?>                        
            </tbody>
            <tfoot>
              <tr>
                <th> ID </th>
                <th>Nombre</th>
                <th> Opciones </th>
              </tr>
            </tfoot>
          </table>
            <script type="text/javascript">
              $(function () {        
                $('#trabajadores_list').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "pageLength": 30
                });
              });
            </script>
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
    field = $(this).attr('name');
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

$("select").change(function(){
    regid = $(this).closest('tr').data('id');
    field = $(this).attr('name');
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

$(window).load(function() {
    $(".overlayer_int").hide();
});

</script>