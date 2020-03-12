<div class="content-wrapper">        
    <section class="content-header">
      <h1> Liquidación Historica </h1>
    </section>

    <section class="content">    
        <div class="box box-primary">
            <div class="row">
            <div class="col-lg-6">
                <form style="padding: 50px">
                <?php 
                $liquidaciones = $db->getOne('liquidacion');
                foreach ($liquidaciones as $key => $value) {
                ?>
                <div class="form-group">
                    <label><?php echo $key; ?></label>
                    <input type="text" class="form-control" name="<?php echo $key; ?>">
                </div>
                <?php
                }
                ?>
                </form>
            </div>
            </div>
        </div>
    </section>
  
</div><!-- /.content-wrapper -->
