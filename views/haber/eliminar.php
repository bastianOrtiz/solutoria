      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> Confirmación de eliminar registro </h1>
          <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>                     
        </section>
        
        
        <section class="content">        
             <div class="box">
                <div class="callout callout-warning">                    
                    <h4><i class="icon fa fa-warning"></i> ¿Está seguro que desea eliminar el registro? </h4>
                    Haber: <strong><?php echo $haber['nombre'] ?></strong>
                </div>
              </div><!-- /.box -->
              <form method="post">
                <input type="hidden" name="action" value="delete" />
                <input type="hidden" name="haber_id" value="<?php echo $parametros[1] ?>" />                
                <button class="btn btn-danger"><i class="fa fa-check-square"></i> ELIMINAR </button>
                <a href="<?php echo BASE_URL .'/'. $entity ?>/listar" class="btn btn-default"> <i class="fa fa-caret-left "></i> CANCELAR </a>            
            </form> 
        </section>        
      </div><!-- /.content-wrapper -->            
      
      