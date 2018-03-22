<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> Factor de actualización Renta</h1>
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
            <?php if( $parametros[1] ){ ?>
            
            <form role="form" id="frmCrear" method="post">
                <input type="hidden" name="action" value="modify" />
                        
                <div class="box box-primary">                
                    <div class="box-header">
                      <h3 class="box-title">Factor de corrección monetaria para <strong><?php echo $parametros[1]; ?></strong> </h3>
                    </div>                
                    <div class="box-body">                    
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Enero</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[1] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Febrero</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[2] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>marzo</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[3] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Abril</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[4] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Mayo</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[5] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Junio</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[6] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Julio</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[7] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Agosto</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[8] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Septiembre</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[9] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Octubre</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[10] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Noviembre</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[11] ?>"  />                            
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Diciembre</label>
                                <input type="text" class="form-control" name="factor[]"  value="<?php echo $facts[12] ?>"  />                            
                            </div>
                        </div>
                    </div><!-- /.box-body -->    
                    <div class="box-footer">
                        
                        <button type="button" class="btn btn-primary" onclick="location.href='<?php echo BASE_URL ?>/factorcorreccion/listar'"> <i class="fa fa-chevron-left"></i> &nbsp; Volver</button>
                        <button type="submit" class="btn btn-success pull-right"> <i class="fa fa-floppy-o"></i> &nbsp; Guardar</button>
                    </div>                
                </div>
            </form>                    
            
            <?php } else { ?>
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title"> Listado x años </h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="tabla_factorcorreccion" class="table table-bordered table-striped">
                    <thead>
                      <tr>                        
                        <th>Año</th>
                        <th> Opciones </th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $anos as $reg ){ ?>
                            <tr>
                                <td> <?php echo $reg['ano']; ?> </td>                                
                                <td>                                    
                                    <a href="<?php echo BASE_URL ?>/factorcorreccion/listar/<?php echo $reg['ano'] ?>" class="btn btn-flat btn-info" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Detalles"> <i class="fa fa-search"></i> </a>                                                                        
                                </td>                                                                                                                                                                                                
                            </tr>
                        <?php } ?>                        
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Año</th>
                        <th> Opciones </th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
                </div><!-- /.box -->
                <a href="#" class="btn btn-primary btnNuevoFactor pull-left">
                    <i class="fa fa-plus-circle"></i> Nueva <?php echo ucfirst($entity) ?>
                </a>
                <div class="pull-left" style="width: 200px; display: none; margin-left: 10px; overflow: hidden;" id="boxAno">
                    <form method="post">
                        <input type="hidden" name="action" value="crear_ano_factor" />
                        <input type="text" class="form-control pull-left" name="anoFactor" placeholder="Año" style="width: 100px">
                        <button class="btn btn-success pull-left">Crear</button>
                    </form>
                </div>
                <?php } ?>              
                                
        </section>
      </div><!-- /.content-wrapper -->

<script>

$(document).ready(function(){
    $(".btnNuevoFactor").click(function(ee){
        ee.preventDefault();
        $("#boxAno").slideDown('fast');
    })
})

</script>