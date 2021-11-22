  <div class="content-wrapper">
    
    <section class="content-header">
      <h1> Saldos de Dias de Vacaciones x trabajador </h1>
      <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
    </section>
            
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <a href="<?php echo BASE_URL ?>/informe/saldo_vacaciones/pdf" target="_blank" class="btn btn-primary pull-right">Imprimir</a>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered table-striped" id="table-saldos">
                            <thead>
                                <tr>
                                    <th> Nombre </th>
                                    <th class="text-center"> Área </th>
                                    <th class="text-center"> Vacaciones Legales </th>
                                    <th class="text-center"> Vacaciones Progresivas </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $trabajadores_vacaciones as $row ){ ?>
                                <tr>
                                    <td> <?php echo $row['apellidoPaterno']; ?> <?php echo $row['apellidoMaterno']; ?>  <?php echo $row['nombres']; ?> </td>
                                    <td> <?php echo getNombre($row['departamento_id'], 'm_departamento', false) ?> </td>
                                    <td class="text-center"> <?php echo $row['diasVacaciones']; ?> </td>
                                    <td class="text-center"> <?php echo $row['diasVacacionesProgresivas']; ?> </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
                
            </div>
        </div>   <!-- /.row -->
    </section>
    
  </div><!-- /.content-wrapper -->
  
  
<script>
$(window).on('load', function(event) {

    var esp ={
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    };

    $('#table-saldos').DataTable({
        pageLength: 50,
        "language":esp
    })
});
</script>
