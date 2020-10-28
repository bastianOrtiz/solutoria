<div class="content-wrapper">
    <section class="content-header">
      <h1> GENERAR DOCUMENTO </h1>
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
        <form role="form" id="frmVerAtrasos" method="post">
            <input type="hidden" name="action" id="action" value="atrasos_view" />
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"> Informe de Atrasos </h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="box-header">
                                    <h3 class="box-title"> Seleccione Documento </h3>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">                                                        
                                        <select class="form-control" name="documento">
                                            <option value="">Seleccione...</option>
                                            <?php foreach ($documentos as $key => $doc) { ?>
                                            <option value="<?php echo $doc['id'] ?>"><?php echo $doc['nombre'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>                                    
                            </div>
                            <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label>Trabajadores</label>                              
                                </div>                                                             
                                <table id="seleccionTrabajadores" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nombre Trabajador</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach( $trabajadores_todos as $trabajador ){ 
                                        $nombre_completo = $trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno'].' '.$trabajador['nombres'];
                                        ?>
                                        <tr>
                                            <td>
                                                <span style="text-transform: uppercase;">
                                                    <?php echo $nombre_completo; ?> <span style="font-size: 12px;">(<?php echo getNombre($trabajador['departamento_id'],'m_departamento',0); ?>)</span>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="#" data-trabajador-id="<?php echo $trabajador['id'] ?>" class="btn btn-success btn-generar-doc">
                                                    Generar
                                                </a>                                                                                                                                                                                               
                                            </td>
                                        </tr>
                                        <?php } ?>                                                                                                                                        
                                    </tbody>
                                    <tfoot>
                                      <tr>                                                                                        
                                        <th>Nombre Trabajador</th>
                                      </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>                                            
                    </div>                      
                
                </div>
            </div>
        </form>
</section>
        
</div><!-- /.content-wrapper -->
      
<script>


$(document).ready(function(){    
    
    $(".btn-generar-doc").click(function(){
        doc_id = $("[name=documento]").val();
        trabajador_id = $(this).data('trabajador-id');
        if( doc_id == "" ){
            alert('Seleccione primero un Documento');
            $("[name=documento]").focus();
        } else {
            window.open('<?php echo BASE_URL ?>/private/documento_trabajador.php?trabajador_id=' + trabajador_id +'&doc_id=' + doc_id);    
        }
        
    })
   
    $(function () {        
        oTable = $('#seleccionTrabajadores').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": false,
            "bInfo": false,
            "bAutoWidth": false,
            "pageLength": 999
        });
    }); 
             
})

            
</script>
      