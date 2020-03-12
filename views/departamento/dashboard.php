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

        </section>
        
      </div><!-- /.content-wrapper -->