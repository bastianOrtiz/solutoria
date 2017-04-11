<!-- Content Wrapper. Contains page content -->
<style>
.select2-container--default .select2-selection--single{border-radius: 0px; }
.select2-container .select2-selection--single{ height: 34px; }
</style>
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> Reloj Control </h1>
          <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        </section>
        
        <section class="content">  
        <div class="col-md-8 col-md-offset-2">      
            <div class="box box-default">
                <div class="box-header with-border">
                  <i class="fa fa-user"></i>
                  <h3 class="box-title">Seleccione un trabajador</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                    <div class="input-group margin">
                        <select id="trabajador_id" class="form-control required">
                            <option value=""> Seleccione Trabajador de su Área </option>
                            <?php 
                            foreach( $trabajadores_x_cargo as $t ){ 
                            if( !estaFiniquitado($t['id'],date('Y-m-d')) ){
                            ?>
                            <option value="<?php echo $t['id'] ?>"> <?php echo $t['apellidoPaterno'] ?> <?php echo $t['apellidoMaterno'] ?> <?php echo $t['nombres'] ?> </option>
                            <?php } } ?>
                        </select>    
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-flat" id="btn_go" type="button">Revisar</button>
                        </span>
                    </div>
                
                    
                </div><!-- /.box-body -->
              </div>
            </div>
            
        </section>
        
      </div><!-- /.content-wrapper -->

<script>
$(document).ready(function() {
    
    $("#trabajador_id").select2();
    
    $("#btn_go").click(function(){
        if( $("#trabajador_id").val() != "" ){
            location.href = '<?php echo BASE_URL ?>/relojcontrol/editar/' + $("#trabajador_id").val();
        }
    })
});
</script>