<div class="content-wrapper">
    <section class="content-header">
      <h1> GENERAR INFORME </h1>
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
        <form role="form" id="frmVerTrabajadoresJornadas" method="post">
            <input type="hidden" name="action" id="action" value="trabajadores_jornada" />
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Jornadas Trabajadores </h3>
                            <br>
                            <br>
                            <label>
                                <input type="radio" value="tele" name="show_trab" <?php if($_GET['show']=='tele'){ echo "checked"; } ?>> Mostrar Trabajadores con Teletrabajo
                            </label>
                            <br>
                            <label>
                                <input type="radio" value="reduc" name="show_trab" <?php if($_GET['show']=='reduc'){ echo "checked"; } ?>> Mostrar Trabajadores con Jornada reducida
                            </label>
                            <br>
                            <label>
                                <input type="radio" value="ambos" name="show_trab" <?php if($_GET['show']=='ambos'){ echo "checked"; } ?>> Mostrar ambos
                            </label>
                            <br>
                            <label>
                                <input type="radio" value="none" name="show_trab" <?php if($_GET['show']=='none'){ echo "checked"; } ?>> Mostrar trabajadores SIN NINGUNA jornada especial
                            </label>
                            <br>
                            <label>
                                <input type="radio" value="" name="show_trab"  <?php if(!$_GET['show']){ echo "checked"; } ?>> Mostrar Todos
                            </label>
                        </div>
                        <div class="box-body">

                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre Completo</th>
                                            <th>Rut</th>
                                            <th>Departamento</th>
                                            <th>S.Base (100%)</th>
                                            <th>S.Base Reducido</th>
                                            <th>Teletrabajo </th>
                                            <th>Jornada Reducida </th>
                                            <th>Cant. Horas Semana</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($trabajadores_jornada as $key => $trabajador) { ?>
                                        <tr <?php if( $trabajador['reduccion_laboral'] ){ echo 'class="bg-success"'; } ?>>
                                            <td> <?php echo getNombreTrabajador($trabajador['id']) ?> </td>
                                            <td style="white-space: nowrap;"><?php echo $trabajador['rut'] ?></td>
                                            <td><?php echo getNombre($trabajador['departamento_id'],'m_departamento') ?></td>
                                            <td><?php echo $trabajador['sueldoBase'] ?></td>
                                            <td><?php echo $trabajador['sueldoBase'] ?></td>
                                            <td><?php echo booleano($trabajador['teletrabajo']) ?></td>
                                            <td><?php echo booleano($trabajador['reduccion_laboral']) ?></td>
                                            <td><?php echo $trabajador['horas_reduccion_laboral_semanal'] ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <div class="row">
                                    <a href="javascript: void(0)" class="btnImprimir btn btn-primary pull-right" style="margin-left: 15px;"> <i class="fa fa-print"></i> &nbsp; PDF </a>
                                </div>
                            </div>         
                                                   
                            

                        </div>                                            
                    </div>                      
                
                </div>
            </div>
        </form>
</section>
        
</div><!-- /.content-wrapper -->
      
<script>

$("[name=show_trab]").click(function(){
    var val = $(this).val();
    if( val == "" ){
        location.href = "<?php echo BASE_URL ?>/informe/trabajadores_jornada";
    } else {
        location.href = "<?php echo BASE_URL ?>/informe/trabajadores_jornada?show=" + val;
    }
})

$(".btnImprimir").click(function(){
    $("#frmVerTrabajadoresJornadas").attr('target','_blank');
    $("#frmVerTrabajadoresJornadas")[0].submit();        
})

$(function () {        
    oTable = $('#frmVerTrabajadoresJornadas table').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "pageLength": 20
    });
}); 
            
</script>
      