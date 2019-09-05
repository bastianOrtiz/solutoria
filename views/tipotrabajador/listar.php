<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> Listar <?php echo strtolower($entity) ?> </h1>
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
                  <h3 class="box-title"><?php echo ucfirst($entity) ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="tabla_tipotrabajador" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th colspan="2"></th>
                        <th colspan="3" class="text-center">Costos Trabajador</th>
                        <th colspan="3" class="text-center" style="border-left: 2px solid #ababab;">Costos Empresa</th>
                        <th colspan="2"></th>
                      </tr>
                      <tr>
                        <th> ID </th>
                        <th>Nombre</th>
                        <th> AFP </th>
                        <th> SALUD </th>
                        <th> AFC </th>

                        <th class="text-center" style="border-left: 2px solid #ababab;"> SIS </th> 
                        <th> SCES </th> 
                        <th class="text-center"> SCES (Solo empresa 0.8%) </th> 


                        <th> Opciones </th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $registros as $reg ){ ?>
                            <tr>
                                <td> <?php echo $reg['id']?> </td>
                                <td> <?php echo $reg['nombre']?> </td>
                                
                                <td> <?php echo booleano($reg['afp']) ?> </td>
                                <td> <?php echo booleano($reg['salud']) ?> </td>
                                <td> <?php echo booleano($reg['afc']) ?> </td>

                                <td  class="text-center" style="border-left: 2px solid #ababab;"> <?php echo booleano($reg['sis']) ?> </td>
                                <td> <?php echo booleano($reg['sces']) ?> </td>
                                <td class="text-center"> <?php echo booleano($reg['sces_full_empresa']) ?> </td>

                                <td>                                                                        
                                    <button class="btn btn-flat btn-warning" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Modificar"> <i class="fa fa-edit"></i> </button>
                                    <button class="btn btn-flat btn-danger" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Eliminar"><i class="fa fa-remove"></i></button>                                    
                                </td>                                                                                                                                                                                                
                            </tr>
                        <?php } ?>                        
                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              
                <a href="<?php echo BASE_URL . '/' . $entity ?>/ingresar" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> Nuevo Tipo Trabajador
                </a>
                
                
                <!-- Large modal -->                                                
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                          <h4 class="modal-title" id="myLargeModalLabel">
                          </h4>
                        </div>
                        <div class="modal-body">
                            <div class="box-body">                                                                                     
                            </div><!-- /.box-body -->
                        </div>
                        <br class="clear" />
                        <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                        <a href="" class="btn btn-info">Agregar Valores</a>
                        <a href="" class="btn btn-warning">Modificar</a>
                        <a href="" class="btn btn-danger">Eliminar</a>
                      </div>  
                    </div>
                  </div>
                </div><!-- /.modal -->
                
                  
        </section>
        
      </div><!-- /.content-wrapper -->            
      
      
    <script>
    $(function () {        
        $('#tabla_tipotrabajador').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
      
    $(".table button").click(function(){
        regid = $(this).data('regid');
        if( $(this).hasClass('btn-danger') ){
            location.href = '<?php echo BASE_URL . '/' . $entity . '/eliminar/'?>' + regid;
        }
        if( $(this).hasClass('btn-warning') ){
            location.href = '<?php echo BASE_URL . '/' . $entity . '/editar/'?>' + regid;
        }        
    })
    </script>