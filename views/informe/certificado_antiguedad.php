<!-- Content Wrapper. Contains page content -->
<style>
thead th{
    font-size: 12px;
    text-align: center;    
}
<?php if( $_POST ): ?>
tbody td,
tfoot td{
    text-align: right;
}
<?php endif; ?>
</style>
    <div class="content-wrapper">        
        <section class="content-header">
          <h1> Certificado de Antigüedad </h1>
          <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        </section>
        
        
        <form method="post" id="frmSeleccionLiquidacion" action="<?php echo BASE_URL ?>/private/certificado.php" target="_blank">            
        <input type="hidden" name="trabajador_id" id="trabajador_id" />            
            
            <section class="content">                                
                 
                <div class="box">
                    <div class="box-body table-responsive">                
                    <?php if( $trabajadores_todos ){ ?>
                      <table id="trabajadores_list" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th> ID </th>
                                <th>Nombre</th>                        
                                <th>Rut</th>
                                <th>Cargo</th>
                                <th>Departamento</th>                        
                                <th> Ver </th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $trabajadores_todos as $reg ){ ?>
                                    <tr>
                                        <td> <?php echo $reg['id']?> </td>
                                        <td style="text-transform: uppercase;"> <?php echo ucfirst(strtolower($reg['apellidoPaterno'])) ?> <?php echo $reg['apellidoMaterno'] ?> <?php echo $reg['nombres'] ?>   </td>
                                        <td> <?php echo $reg['rut']?> </td>
                                        <td> <?php echo fnGetNombre($reg['cargo_id'],'m_cargo') ?> </td>
                                        <td> <?php echo fnGetNombre($reg['departamento_id'],'m_departamento') ?> </td>                                
                                        <td class="btn-group-xs">                                                                            
                                            <button class="btn btn-lg btn-info btn_ver_liquidacion" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Ver Certificado"> <i class="fa fa-search"></i> </button>                                                                                                                                                            
                                        </td>                                                                                                                                                                                                
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
                      <?php } ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->                                                               
                                                          
            </section>
        </form>
        
      </div><!-- /.content-wrapper -->

<script>
$(document).ready(function(){        

    $(".btn_ver_liquidacion").click(function(e){
        e.preventDefault();
        $("#trabajador_id").val( $(this).data('regid') );
        $("#frmSeleccionLiquidacion")[0].submit();
    });
    

    $(function () {        
        $('#trabajadores_list').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "pageLength": 30
        });
    });

})


</script>      