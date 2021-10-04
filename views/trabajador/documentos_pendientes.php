<div class="content-wrapper">        
    <section class="content-header">
        <h1> Documentos pendientes x trabajador </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>  
    </section>
            
    <section class="content">                
        <div class="box">
            <div class="box-header">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <p><strong>Leyenda:</strong></p>
                        <p><span style="background-color: #b7ff9a; padding: 3px 10px; border-radius: 5px;" class="text-center"><i class="fa fa-check"></i></span> &nbsp; Documento listo</p>
                        <p><span style="background-color: #ffbbbb; padding: 3px 10px; border-radius: 5px;" class="text-center"><i class="fa fa-times"></i></span> &nbsp; Documento Incompleto</p>
                        <p><span style="background-color: #b0edfb; padding: 3px 10px; border-radius: 5px;" class="text-center"><i class="fa fa-clock-o"></i></span> &nbsp; Documento Pendiente</p>
                        <p><span style="background-color: #f4f4f4; padding: 3px 10px; border-radius: 5px; border: 1px solid #d7d7d7;" class="text-center">n/c</span> &nbsp; Documento No Corresponde o No Aplica</p>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <a href="<?php echo BASE_URL ?>/trabajador/pdf_documentos_pendientes" class="btn btn-danger pull-right" target="_blank" style="margin-left: 10px;">PDF</a>
                        <a href="<?php echo BASE_URL ?>/trabajador/excel_documentos_pendientes" class="btn btn-success pull-right" target="_blank">Excel</a>                
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="tabla_afp" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th colspan="2"></th>
                                <th colspan="<?php echo $total_documentos; ?>" style="white-space: nowrap;">Documentos del Trabajador    </th>
                            </tr>
                            <tr>
                                <th> ID </th>
                                <th>Nombre</th>
                                <?php foreach($codigos_documentos as $cod => $nombre_doc): ?>
                                <th class="no-sort text-center"><?php echo $nombre_doc; ?></th>
                                <?php endforeach; ?>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        foreach( $lista_trabajadores as $person ){ 
                        $documentos_requeridos = json_decode($person['documentos_requeridos']);
                        $documentos_pendientes = json_decode($person['documentos_pendientes']);
                        ?>
                            <tr>
                                <td> <?php echo $person['id']?> </td>
                                <td style="white-space: nowrap;"> <?php echo $person['apellidoPaterno'] ?> <?php echo $person['apellidoMaterno'] ?> <?php echo $person['nombres'] ?> </td>
                                <?php 
                                $documentos_x_trabajador = getDocumentosPorTrabajador($person['id']);
                                foreach($codigos_documentos as $cod => $nombre_doc){
                                    if( in_array($cod,$documentos_x_trabajador) ){
                                    ?>
                                    <td style="background-color:#b7ff9a" class="text-center"><i class="fa fa-check"></i></td>
                                    <?php 
                                    } else { 

                                        if(in_array($cod,$documentos_requeridos)){
                                            ?>
                                            <td style="background-color:#ffbbbb" class="text-center"><i class="fa fa-times"></i></td>
                                            <?php 
                                        } else {
                                            if(in_array($cod,$documentos_pendientes)){
                                            ?>
                                                <td style="background-color:#b0edfb" class="text-center"><i class="fa fa-clock-o"></i></td>
                                            <?php
                                            } else {
                                            ?>
                                                <td style="background-color:#f5f5f5" class="text-center">n/c</td>
                                            <?php 
                                            }
                                        }

                                    }


                                }
                                ?>
                                <td>
                                    <a href="<?php echo BASE_URL ?>/trabajador/editar/<?php echo $person['id']?>/#tab_6" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Subir documento"><i class="fa fa-upload"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
      

<script>

$(function () {        
    $('#tabla_afp').dataTable({
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "pageLength": 50,
        "ordering": true,
        columnDefs: [{
            orderable: false,
            targets: "no-sort"
        }],
        "order": [[ 2, "desc" ]]
    });
});

</script>