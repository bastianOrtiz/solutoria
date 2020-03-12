<!-- Content Wrapper. Contains page content -->
<style>
.cbo_liq{
    font-size: 16px;
}
</style>
    <div class="content-wrapper">        
        <section class="content-header">
          <h1> Ver Liquidación </h1>
          <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        </section>
        
        
        <form method="post" id="frmSeleccionLiquidacion" target="_blank">
            <input type="hidden" name="hdn_trabajador_id" id="hdn_trabajador_id" />
            <input type="hidden" name="action" id="action" value="historial" />
            
            <section class="content">                
                 <div class="box">
                    <div class="box-header">
                        <div id="calendar"></div>                    
                        <div class="row">                    
                            <div class="col-md-6">
                            <div class="form-group">                      
                              <select class="form-control cbo_liq" name="mes_ver_liquidacion" id="mes_ver_liquidacion">
                                <option value="">Seleccione Mes</option>
                                <?php for( $i=1; $i<=12; $i++ ){ ?>                             
                                    <option value="<?php echo $i ?>"> <?php echo getNombreMes($i) ?> </option>                               
                                <?php } ?>                                                
                              </select>
                            </div>
                            </div>
                            
                            <div class="col-md-6">
                            <div class="form-group">                          
                              <select class="form-control cbo_liq" name="ano_ver_liquidacion" id="ano_ver_liquidacion">
                                <option value="">Seleccione Año</option>
                                <?php for( $i=2016; $i<=date('Y'); $i++ ){ ?>                             
                                    <option value="<?php echo $i ?>"> <?php echo $i ?> </option>                               
                                <?php } ?>                                                
                              </select>
                            </div>
                            </div>
                        </div>
                        
                    </div><!-- /.box-header -->
                </div>
                <div class="box">
                    <div class="box-body table-responsive">                
                    <?php if( $registros ){ ?>
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
                                <?php foreach( $registros as $reg ){ ?>
                                    <tr>
                                        <td> <?php echo $reg['id']?> </td>
                                        <td style="text-transform: uppercase;"> <?php echo ucfirst(strtolower($reg['apellidoPaterno'])) ?> <?php echo $reg['apellidoMaterno'] ?> <?php echo $reg['nombres'] ?>   </td>
                                        <td> <?php echo $reg['rut']?> </td>
                                        <td> <?php echo fnGetNombre($reg['cargo_id'],'m_cargo') ?> </td>
                                        <td> <?php echo fnGetNombre($reg['departamento_id'],'m_departamento') ?> </td>                                
                                        <td class="btn-group-xs">                                                                            
                                            <button class="btn btn-lg btn-info btn_ver_liquidacion" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Ver Liquidacion del Trabajador"> <i class="fa fa-search"></i> </button>                                                                                                                                                            
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
                      <?php } else { ?>                  
                        <pre> No hay datos disponibles </pre>                    
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
         $("#hdn_trabajador_id").val( $(this).data('regid') );
         if( ( $("#mes_ver_liquidacion").val() == "" ) || ( $("#ano_ver_liquidacion").val() == "" ) ){
            alert("Seleccione un mes y año primero");
         } else {
            $("#frmSeleccionLiquidacion")[0].submit();   
         }
         
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