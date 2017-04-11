<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
      <h1> Mis Solicitudes</h1>
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
      <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de vacaciones solicitadas</h3>
            </div><!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Periodo</th>                  
                  <th style="width: 40px">Aprovada</th>
                </tr>
                <tr>
                  <td>1.</td>
                  <td>Perdiodo desde: <strong>2015-02-01</strong> al <strong>2015-02-20</strong> </td>                
                  <td><span class="badge bg-green"><i class="fa fa-check"></i></span></td>
                </tr>
                <tr>
                  <td>2.</td>
                  <td>Perdiodo desde: <strong>2016-02-01</strong> al <strong>2016-02-20</strong> </td>
                  <td><span class="badge bg-red"><i class="fa fa-times"></i></span></td>
                </tr>
                <tr>
                  <td>3.</td>
                  <td>Perdiodo desde: <strong>2016-02-01</strong> al <strong>2016-02-20</strong> </td>
                  <td><span class="badge bg-green"><i class="fa fa-check"></i></span></td>
                </tr>
                <tr>
                  <td>4.</td>
                  <td>Perdiodo desde: <strong>2016-02-01</strong> al <strong>2016-02-20</strong> </td>
                  <td><span class="badge bg-green"><i class="fa fa-check"></i></span></td>
                </tr>
              </tbody></table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
        <!-- /.col -->
      </div><!-- /.row -->          
    </section>        
</div><!-- /.content-wrapper -->                  