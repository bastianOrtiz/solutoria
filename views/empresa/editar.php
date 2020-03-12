<!-- Content Wrapper. Contains page content -->    
    
      <div class="content-wrapper">
        
        <section class="content-header">
        <h1> Editar <?php echo strtolower($entity) ?> </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
          
        <?php         
        if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
        $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
        ?>
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
            <h4><i class="icon fa fa-check"></i> Mensaje:</h4>
        <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "<br />ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
        </section>
                
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">                
                <div class="box-header">
                  <h3 class="box-title">Datos del Registro</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="frmCrear" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit" />
                <input type="hidden" name="empresa_id" value="<?php echo $empresa['id'] ?>" />
                <div class="box-body">
                    <div class="col-md-6">       
                        <div class="form-group">                                
                            <label for="logoEmpresa">Logo</label>
                            <br class="clear" />
                            <?php 
                            if( $empresa['foto'] ){
                                $src = BASE_URL . '/private/imagen.php?f=' . base64_encode(base64_encode(date('Ymd')) . $empresa['id']) . '&t=' . base64_encode('m_empresa'); 
                            } else {
                                $src = SRC_LOGO_EMPRESA_DEFAULT;
                            } 
                            ?>
                            <img class="round" id="previewLogoEmpresa" src="<?php echo $src; ?>"/>

                            <div class="input_file">
                                <span></span>
                                <input type="file" accept="image/*" id="logoEmpresa" name="logoEmpresa" onchange="loadFile(event)" />
                            </div>                                                                        
                            <p class="help-block" style="font-size: 12px;">(Archivo en JPG o PNG, máximo 500Kb ó 300x300 pixeles)</p>
                        </div>
                        <div class="form-group">
                          <label for="nombreEmpresa">Nombre</label>
                          <input type="text" class="form-control required" value="<?php echo $empresa['nombre'] ?>" id="nombreEmpresa" name="nombreEmpresa" placeholder="Nombre Empresa" />
                        </div>
                        <div class="form-group">
                          <label for="razonSocial">Razón Social</label>
                          <input type="text" class="form-control required" value="<?php echo $empresa['razonSocial'] ?>" id="razonSocial" name="razonSocial" placeholder="Razón Social" />
                        </div>
                        <div class="form-group">
                          <label for="rutEmpresa">Rut</label>
                          <input type="text" class="form-control required" value="<?php echo $empresa['rut'] ?>" id="rutEmpresa" name="rutEmpresa" placeholder="Rut Empresa" readonly="readonly" />
                        </div>
                        <div class="form-group">
                          <label for="direccionEmpresa">Dirección</label>
                          <input type="text" class="form-control required" value="<?php echo $empresa['direccion'] ?>" id="direccionEmpresa" name="direccionEmpresa" placeholder="Dirección Empresa" />
                        </div>
                        <div class="form-group">
                          <label for="ciudadEmpresa">Ciudad</label>
                          <input type="text" class="form-control required" value="<?php echo $empresa['ciudad'] ?>" id="ciudadEmpresa" name="ciudadEmpresa" placeholder="Ciudad Empresa" />
                        </div>
                        <div class="form-group">
                          <label for="giroEmpresa">Giro</label>
                          <input type="text" class="form-control required" value="<?php echo $empresa['giro'] ?>" id="giroEmpresa" name="giroEmpresa" placeholder="Giro Empresa" />                      
                        </div>                         
                        <div class="form-group">
                            <label for="empresaRegion">Región</label>
                            <select class="form-control required" name="empresaRegion" id="empresaRegion">
                                <option value="">Seleccione Región</option>
                                <?php foreach($regiones as $r){ ?>
                                <option value="<?php echo $r['id'] ?>"><?php echo $r['nombre'] ?></option>
                                <?php } ?>
                            </select>
                            <script>$("#empresaRegion").val('<?php echo fnGetRegion($empresa['comuna_id']) ?>') </script>
                        </div>
                            
                        <div class="form-group">
                            <label for="empresaComuna">Comuna</label>
                            <select disabled="disabled" class="form-control required" name="empresaComuna" id="empresaComuna">
                                <option value="">Seleccione Comuna</option>
                                <?php foreach($comunas as $c){ ?>
                                <option data-region="<?php echo $c['region_id'] ?>" value="<?php echo $c['id'] ?>"><?php echo $c['nombre'] ?></option>
                                <?php } ?>
                            </select>
                        </div>    
                        <div class="form-group">
                            <label for="representante">Representante</label>
                            <input type="text" class="form-control required" value="<?php echo $empresa['representante'] ?>" id="representante" name="representante" placeholder="Representante de la Empresa" />
                        </div>
                        <div class="form-group">
                            <label for="rut_representante">Rut Representante</label>
                            <input type="text" class="form-control required" value="<?php echo $empresa['rut_representante'] ?>" id="rut_representante" name="rut_representante" />
                        </div>
                    </div>    
                    
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="fechaCorteEmpresa">Día de Corte</label>
                          <input type="number" class="form-control required" value="<?php echo $empresa['diaCorte'] ?>" id="fechaCorteEmpresa" name="fechaCorteEmpresa" placeholder="Día de Corte" />
                        </div>
                        <div class="form-group">
                              <label for="fechaCierreEmpresa">Día de Cierre</label>
                              <input type="number" class="form-control required" value="<?php echo $empresa['diaCierre'] ?>" id="fechaCierreEmpresa" name="fechaCierreEmpresa" placeholder="Día de Cierre" />
                            </div>
                        <div class="form-group">
                          <label for="relojControl">Usa Reloj Control</label>
                          <div class="radio">
                            <label>
                              <input type="radio" class="rbt_relojcontrol" name="relojControl[]" value="1" id="relojControlSi" />
                              SI
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="rbt_relojcontrol" name="relojControl[]" value="0" id="relojControlNo" />
                              NO
                            </label>
                          </div>
                          <script>
                          $(".rbt_relojcontrol[value=<?php echo $empresa['empleaRelojControl'] ?>]").attr('checked','checked')
                          </script>
                        </div>
                        
                        <div class="form-group">
                          <label for="relojControlSync">Reloj Control Sincronizado</label>
                          <div class="radio">
                            <label>
                              <input type="radio" class="rbtRelojControlSync" name="relojControlSync[]" value="1" id="relojControlSyncSi" checked="checked" />
                              SI
                            </label>
                          </div>
                          <div class="radio">
                            <label>
                              <input type="radio" class="rbtRelojControlSync" name="relojControlSync[]" value="0" id="relojControlSyncNo" />
                              NO
                            </label>
                          </div>
                          <script>
                          $(".rbtRelojControlSync[value=<?php echo $empresa['relojControlSync'] ?>]").attr('checked','checked')
                          </script>
                        </div>
                        
                        <div class="form-group">
                          <label for="minutoGraciaEmpresa">Minutos de Gracia</label>
                          <input type="number" class="form-control required" value="<?php echo $empresa['minutoGracia'] ?>" id="minutoGraciaEmpresa" name="minutoGraciaEmpresa" placeholder="--" />
                        </div>
                        
                        <div class="form-group">
                          <label for="horasNomarcoEmpresa">Horas a descontar en caso de no marcar</label>
                          <input type="number" class="form-control required" value="<?php echo $empresa['horasDescuentoNoMarca'] ?>" id="horasNomarcoEmpresa" name="horasNomarcoEmpresa" placeholder="--" />
                        </div>
                        
                        <div class="form-group">
                                                
                          <label>Umbral RelojControl (Para determinar AM / PM)</label>
                          <br class="clear" />
                          <div class="col-md-3">                          
                            <label for="horaUmbralRelojControl">Hora</label>
                            <select class="form-control" id="horaUmbralRelojControl" name="horaUmbralRelojControl">
                                <?php for( $i=0;$i<23;$i++ ){ ?>
                                <option value="<?php echo leadZero($i) ?>"><?php echo leadZero($i) ?></option>
                                <?php } ?>
                            </select>
                            <script> $("#horaUmbralRelojControl").val('<?php echo $umbralHora ?>'); </script>
                          </div>
                          
                          <div class="col-md-3">
                            <label for="minutoUmbralRelojControl">Minutos</label>
                            <select class="form-control" id="minutoUmbralRelojControl" name="minutoUmbralRelojControl">
                                <?php for( $i=0;$i<60;$i+=15 ){ ?>
                                <option value="<?php echo leadZero($i); ?>"><?php echo leadZero($i) ?></option>
                                <?php } ?>
                            </select>
                            <script> $("#minutoUmbralRelojControl").val('<?php echo $umbralMinuto ?>'); </script>
                          </div>
                                                    
                        </div>
                        
                        <br class="clear" />
                        
                        <div class="form-group">
                          <label for="tipoAusenciaVacaciones">Ausencia tipo "Vacaciones"</label>
                          <select class="form-control" id="tipoAusenciaVacaciones" name="tipoAusenciaVacaciones">
                                <?php foreach( $ausencias_empresa as $aus ){ ?>
                                <option value="<?php echo $aus['id'] ?>"><?php echo $aus['nombre'] ?></option>
                                <?php } ?>
                            </select>
                            <script> $("#tipoAusenciaVacaciones").val('<?php echo $empresa['ausenciaVacaciones'] ?>'); </script>                          
                        </div> 


                        <div class="form-group">
                          <label for="institucionAseguradora">Institución Aseguradora</label>
                          <select class="form-control" id="institucionAseguradora" name="institucionAseguradora" required>
                              <option value="">Seleccione</option>
                              <?php foreach( $instituciones_aseguradoras as $aus ){ ?>
                              <option value="<?php echo $aus['id'] ?>"><?php echo $aus['nombre'] ?></option>
                              <?php } ?>
                          </select>
                          <script> $("#institucionAseguradora").val('<?php echo $empresa['mutual_id'] ?>'); </script>                          
                        </div>  

                        <div class="form-group">
                          <label for="cajaCompensacion">Caja de compensación</label>
                          <select class="form-control" id="cajaCompensacion" name="cajaCompensacion" required>
                              <option value="">Seleccione</option>
                              <?php foreach( $cajas as $caja ){ ?>
                              <option value="<?php echo $caja['id'] ?>"><?php echo $caja['nombre'] ?></option>
                              <?php } ?>
                          </select>
                          <script> $("#cajaCompensacion").val('<?php echo $empresa['cajacompensacion_id'] ?>'); </script>                          
                        </div>                                                
                        
                    </div>
                </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="<?php echo BASE_URL . '/' . $entity ?>/listar" class="btn btn-default">Cancelar</a>
                  </div>
                </form>
              </div><!-- /.box -->


            </div>
          </div>   <!-- /.row -->
        </section>
        
      </div><!-- /.content-wrapper -->
      
<script>

$("#frmCrear").submit(function(e){
    e.preventDefault();
    var error = 0;
    $(".required").each(function(){
        if( $(this).val() == "" ){
            $(this).parent().addClass('has-error');
            $(this).parent().find('label').append(' &nbsp; <small>(Este campo es requerido)</small>');
            error++;
        }
    })

    if( error == 0 ){
        $(".overlayer").show();
        $("#frmCrear")[0].submit();
    }

})

$("#empresaRegion").change(function(){
    idRegion = $(this).val();
    $("#empresaComuna").val('');
    $("#empresaComuna").empty();
    if( idRegion != "" ){
        cargaComuna(idRegion);  
    } else {
        $("#empresaComuna").attr('disabled','disabled');
    }            
})

$(window).load(function(){
    cargaComuna('<?php echo fnGetRegion($empresa['comuna_id']) ?>');        
})
function cargaComuna(idRegion){
    $.post("<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>", {
        regid: idRegion,
        action: 'get_comuna'
    }, function (json) {
        html_options = "<option value=''>Seleccione Comuna</option>";
        $.each(json.registros, function(key,valor) {                    
            html_options += '<option value="' + valor.id + '">' + valor.nombre + '</option>';
        })
        $("#empresaComuna").html( html_options );
        $("#empresaComuna").removeAttr('disabled');
        $("#empresaComuna").val('<?php echo $empresa['comuna_id'] ?>');
    },'json')  
}

function loadFile(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('previewLogoEmpresa');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};
            
</script>
      