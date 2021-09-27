<div class="content-wrapper">

    <section class="content-header">
      <h1> Listar documentos </h1>
      <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
      
        <?php 
        if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
        $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
        ?>          
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4> <i class="icon fa fa-check"></i> Mensaje:</h4>
            <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
    </section>


    <section class="content">                
        <div class="box">

            <div class="box-body">
                <div class="col-md-6">
                    
                    <strong>Listado de documentos</strong><br /><br />
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th> Nombre </th>
                                    <th style="text-align: right;"> Ver </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $arr_codigos_listos = [];
                                foreach( $documentos_trabajador as $doc ){ 
                                $arr_codigos_listos[] = substr($doc['nombre'], 0,3);
                                ?>
                                <tr class="bg-success" id="row_doc_<?php echo $doc['id'] ?>">
                                    <td> <?php echo $doc['nombre'] ?> </td>
                                    <td style="text-align: right;">
                                        <button data-id="<?php echo $doc['id'] ?>" type="button" class="viewDocTrabajador btn btn-primary"><i class="fa fa-search"></i></button>
                                    </td>
                                </tr>
                                <?php } ?>
                                

                                <?php 
                                $documentos_requeridos = json_decode($trabajador['documentos_requeridos']);

                                foreach( $codigos_documentos as $doc_pend => $nombre_doc ){ 
                                    if( !in_array($doc_pend,$arr_codigos_listos) ){
                                        if(in_array($doc_pend,$documentos_requeridos)){
                                        ?>
                                        <tr class="bg-danger">
                                            <td> <?php echo $doc_pend ?> </td>
                                            <td style="text-align: right;">
                                                <small>(pendiente)</small>
                                            </td>
                                        </tr>
                                    <?php 
                                        } else {
                                        ?>
                                        <tr>
                                            <td> <?php echo $doc_pend ?> </td>
                                            <td style="text-align: right;">
                                                <small>(pendiente pero no requerido)</small>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                    } 
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>  
        </div>
    </section>

</div>

<script>
$(".viewDocTrabajador").click(function(){
    var docId = $(this).data('id');        
    window.open('<?php echo BASE_URL ?>/private/documento.php?docId=' + docId);
})
</script>
