<!-- Content Wrapper. Contains page content -->    
<style>
.checkbox{
    margin-left: 50px;
    display: none;
}

.checkbox.parent{
    margin-left: 0;
    display: block;
}
#seleccionTrabajadores label{
    font-weight: normal;
    cursor: pointer;
}
</style>    

<div class="content-wrapper">
    <form method="post" target="_blank">
        <input type="hidden" name="action" value="generar_documento">
        <section class="content-header">
            <h1> Gestión de documentos Masivo </h1>
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
            
            <div class="tab-pane" id="tab_3">
                  <div class="row">
                        <div class="col-md-12">
                              <!-- general form elements -->
                            <div class="box">
                                
                                <div class="box-body">                        
                                    <div class="col-md-8">
                                        <div class="form-group" style="margin-bottom: 50px">
                                            <label>Seleccione documento</label>
                                            <select class="form-control" name="documento" required>
                                                <option value="">Seleccione</option>
                                                <?php foreach ($documents as $doc) { ?>
                                                <option value="<?php echo $doc['id'] ?>"><?php echo $doc['nombre'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <a href="#" id="selectAll" class="btn btn-default pull-right"> Seleccionar todos <i class="fa fa-check-square"></i> </a>
                                                <br class="clearfix">
                                                <br class="clearfix">
                                            </div>
                                        </div>
                                        <table id="seleccionTrabajadores" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nombre Trabajador</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                foreach( $trabajdores_todos as $trabajador ){ 
                                                $nombre_completo = $trabajador['apellidoPaterno'].' '.$trabajador['apellidoMaterno'].' '.$trabajador['nombres'];
                                                ?>
                                                <tr>
                                                    <td>
                                                      <label>
                                                        <input type="checkbox" name="trabajadorDocumentoMasivo[<?php echo $trabajador['id'] ?>]" /> 
                                                        <span style="text-transform: uppercase;">
                                                            <?php echo $nombre_completo; ?> <span style="font-size: 12px;">(<?php echo getNombre($trabajador['departamento_id'],'m_departamento',0); ?>)</span>
                                                        </span>
                                                      </label>
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
                                    
                                    <div class="col-md-4">
                                        <div class="box-body">
                                            <button type="submit" class="btn btn-primary btn-lg">Generar documentos</button>
                                        </div>                                    
                                    </div> 
                                </div>                                            
                            </div>                      
                        
                        </div>
                    </div>
                </form>
            </div>
            
        </section>
    </form>   
</div><!-- /.content-wrapper -->
      
<script>

$("input").keydown(function(){
    $(this).parent().removeClass('has-error');
    $(this).parent().find('label').find('small').remove();
})
$("select").change(function(){
    $(this).parent().removeClass('has-error');
    $(this).parent().find('label').find('small').remove();
})


$(document).ready(function(){
    $("#selectAll").click(function(){
        $("#seleccionTrabajadores input").prop('checked',true);
    })
})

$(window).load(function(){
    $("#seleccionTrabajadores_filter").closest('.row').find('.col-sm-6:first').html('<strong>Seleccione trabajadores</strong>');
})

            
</script>
      