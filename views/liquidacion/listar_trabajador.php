<style>
    .modal-body{
        text-align: center;
    }
    .fa-pagelines{
        color: green;
        font-size: 28px;
    }
</style>
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
                    <div id="calendar"></div>
                  <h3 class="box-title"><?php echo ucfirst($entity) ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">                
                <?php if( $liquidaciones_trabajador ){ ?>
                  <table id="trabajadores_list" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th> Nro. </th>
                        <th>Año</th>                        
                        <th>Mes</th>                        
                        <th> Opciones </th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1; 
                        foreach( $liquidaciones_trabajador as $reg ){ ?>
                            <tr>
                                <td> <?php echo $i; ?> </td>
                                
                                <td> <?php echo $reg['ano']?> </td>
                                <td> <?php echo  getNombreMes($reg['mes']) ?> </td>
                                <td class="btn-group-md">                                                                        
                                    <a href="<?php echo BASE_URL . '/private/pdfgen.php?id=' . encrypt($reg['id']) ?>" class="btn btn-info btn_ver_liq" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Ver Liquidación"> <i class="fa fa-search"></i> </a>
                                </td>                                                                                                                                                                                                
                            </tr>
                        <?php 
                        $i++;
                        } 
                        ?>                        
                    </tbody>
                    <tfoot>
                      <tr>
                        <th> Nro. </th>
                        <th>Año</th>                        
                        <th>Mes</th>                        
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
      </div><!-- /.content-wrapper -->

<div class="modal print_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p><i class="fa fa-pagelines"></i> &nbsp; No me imprimas si no es necesario. Protejamos el medio ambiente. &nbsp; <i class="fa fa-pagelines"></i> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left btn_close_print">Cerrar</button>
        <a href="" target="_blank" class="btn btn-primary btn_print">Ver Liquidación</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<script>
$(".btn_ver_liq").click(function(e){
    e.preventDefault();
    href = $(this).attr('href');
    $(".print_modal").fadeIn(300);
    $(".btn_print").attr('href',href);
})
$(".btn_print, .btn_close_print").click(function(){
    $(".print_modal").fadeOut(300);
})
</script>
