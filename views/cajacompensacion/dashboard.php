<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> DASHBOARD <?php echo strtolower($entity) ?> </h1>
          <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        </section>
        
        <section class="content">        
            <strong>Parametros:</strong><br />
            <?php
            echo "<pre>";
            print_r( $parametros );
            echo "</pre>"; 
            ?>
            
            <a href="<?php echo BASE_URL . '/' . $entity ?>/ingresar" class="btn btn-primary">
                <i class="fa fa-plus-circle"></i> Nueva <?php echo ucfirst($entity) ?>
            </a>
            
        </section>
        
      </div><!-- /.content-wrapper -->