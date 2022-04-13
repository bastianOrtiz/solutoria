<!-- Content Wrapper. Contains page content -->    
<div id="trabajador_detail">
    <div class="content-wrapper">

        <?php if($parametros[1]): ?>

        <section class="content-header">
            <h1> Ficha trabajador: <strong><?php echo $trabajador['nombres'] ?> <?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?></strong> </h1>
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
            <div class="overlayer" style="display: block;"><i class="fa fa-refresh fa-spin"></i></div>
            <ul class="nav nav-tabs">
                <li class="active"><a  onclick="javascript: return void(0);" href="#tab_1" data-toggle="tab">Información Personal</a></li>
                <li><a href="#tab_6" onclick="javascript: return void(0);" data-toggle="tab">Documentación</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Informacion Personal</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="fotoTrabajador">Foto</label>
                                                    <br class="clear" />
                                                    <img class="round" id="previewFotoTrabajador" src="<?php echo BASE_URL ?>/private/imagen.php?f=<?php echo base64_encode(base64_encode(date('Ymd')) . $trabajador['id']) ?>&t=<?php echo base64_encode('m_trabajador') ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="nombreTrabajador">Nombres</label> <br>
                                                        <?php echo $trabajador['nombres'] ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="apellidoPaternoTrabajador">Apellido Paterno</label>
                                                        <br><?php echo $trabajador['apellidoPaterno'] ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="apellidoMaternoTrabajador">Apellido Materno</label>
                                                        <br><?php echo $trabajador['apellidoMaterno'] ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rutTrabajador">Rut</label>
                                                        <br><?php echo $trabajador['rut'] ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="top">Sexo</label>
                                                        <br>                          
                                                        <span style="display: none;" id="sexo_1">
                                                        <i class="fa fa-male"></i> Masculino
                                                        </span>
                                                        
                                                        <span style="display: none;" id="sexo_0">
                                                        <i class="fa fa-female"></i> Femenino
                                                        </span>
                                                        <script> $("#sexo_<?php echo $trabajador['sexo'] ?>").show(); </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fechaNacimientoTrabajador">Fecha Nacimiento</label>
                                                    <br><?php echo $trabajador['fechaNacimiento'] ?>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6">
                                                        <p><strong>Datos de contacto Corporativos</strong></p>
                                                        <div class="form-group">
                                                            <label for="emailTrabajador">Email</label>
                                                            <br><?php echo $trabajador['email'] ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="telefonoTrabajador">Teléfono</label>
                                                            <br><?php echo $trabajador['telefono'] ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="celularTrabajador">Celular</label>
                                                            <br><?php echo $trabajador['celular'] ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <p><strong>Datos de contacto Personal</strong></p>
                                                        <div class="form-group">
                                                            <label for="emailTrabajador_pers">Email</label>
                                                            <br><?php echo $trabajador['email_pers'] ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="telefonoTrabajador_pers">Teléfono</label>
                                                            <br><?php echo $trabajador['telefono_pers'] ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="celularTrabajador_pers">Celular</label>
                                                            <br><?php echo $trabajador['celular_pers'] ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="top">Extranjero</label>
                                                    <br>
                                                    <?php echo booleano($trabajador['extranjero']) ?>
                                                </div>
                                                <div class="<?php echo($trabajador['extranjero']) ? '' : 'hidden'; ?>">
                                                    <div class="form-group">
                                                        <label for="nacionalidadTrabajador">Nacionalidad</label>
                                                        <br><?php echo getNombre($trabajador['idNacionalidad'],'m_pais',false) ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="pasaporteTrabajador">Pasaporte</label>
                                                        <br><?php echo $trabajador['pasaporte'] ?>
                                                    </div>
                                                </div>
                                                <?php if( $trabajador['extranjero'] == 1): ?>
                                                <script> 
                                                    $("#extranjeria_trabajador").show();
                                                    $("#extranjeria_trabajador select, #extranjeria_trabajador input").addClass('required'); 
                                                </script>
                                                <?php endif; ?>                                                                                            
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="direccionTrabajador">Dirección</label>
                                                    <br><?php echo $trabajador['direccion'] ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="regionTrabajador">Región</label>
                                                    <br><?php echo getNombre(fnGetRegion($trabajador['comuna_id']),'m_region',false); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="comunaTrabajador">Comuna</label>
                                                    <br><?php echo getNombre($trabajador['comuna_id'],'m_comuna', false); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="emergenciaTrabajador">En caso de emergencia</label>
                                                    <br><?php echo $trabajador['emergencia'] ?>
                                                </div>
                                                <div class="form-group">
                                                    <label for="comunaTrabajador">Estado Civil</label>
                                                    <br><?php echo $trabajador['estadoCivil'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </div>
                
                <div class="tab-pane" id="tab_6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"> Documentación</h3>
                                </div>
                                <!-- /.box-header -->                                
                                <div class="box-body">
                                    
                                    <div class="col-xs-12 col-md-8 col-lg-8">
                                        <strong>Listado de documentos</strong><br /><br />
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th> Nombre </th>
                                                        <th style="text-align: right;"> Opciones </th>
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
                                                            <button data-id="<?php echo $doc['id'] ?>" type="button" class="viewDocTrabajador btn btn-success"><i class="fa fa-search"></i></button>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    

                                                    <?php 
                                                    $documentos_requeridos = json_decode($trabajador['documentos_requeridos']);
                                                    $documentos_pendientes = json_decode($trabajador['documentos_pendientes']);

                                                    foreach( $codigos_documentos as $doc_pend => $doc ){ 
                                                        if( !in_array($doc_pend,$arr_codigos_listos) ){
                                                            
                                                            
                                                            if(in_array($doc_pend,$documentos_requeridos)){
                                                            ?>

                                                            <tr style="background-color: #ffbbbb;">
                                                                <td> <?php echo $doc_pend ?> - <?php echo $doc ?> </td>
                                                                <td style="text-align: right;">
                                                                    <small>(Doc. Incompleto)</small>
                                                                </td>
                                                            </tr>
                                                            
                                                            <?php 
                                                            } else {

                                                            if(in_array($doc_pend,$documentos_pendientes)){
                                                            ?>

                                                            <tr style="background-color: #b0edfb;">
                                                                <td> <?php echo $doc_pend ?> - <?php echo $doc ?> </td>
                                                                <td style="text-align: right;">
                                                                    <small>Doc. pendiente</small>
                                                                </td>
                                                            </tr>

                                                            <?php } else { ?>

                                                            <tr>
                                                                <td> <?php echo $doc_pend ?> - <?php echo $doc ?> </td>
                                                                <td style="text-align: right;">
                                                                    <small>No corresponde o No Aplica</small>
                                                                </td>
                                                            </tr>

                                                            <?php
                                                            }

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
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
        </section>

        <?php else: ?>


            <section class="content-header">
                <h1> Listar Trabajadores </h1>
                <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
            </section>
            <section class="content">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <?php if( $registros ){ ?>
                        <table id="trabajadores_list" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th>Nombre</th>
                                    <th>Rut</th>
                                    <th>Cargo</th>
                                    <th>Departamento</th>
                                    <th>Marca Tarjeta</th>
                                    <th> Ver </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $registros as $reg ){ ?>
                                <tr>
                                    <td> <?php echo $reg['id']?> </td>
                                    <td style="text-transform: uppercase;"> <?php echo $reg['apellidoPaterno']?> <?php echo $reg['apellidoMaterno']  ?> <?php echo $reg['nombres'] ?>   </td>
                                    <td> <?php echo $reg['rut']?> </td>
                                    <td> <?php echo fnNombreCargo($reg['cargo_id']) ?> </td>
                                    <td> <?php echo fnNombreDepartamento($reg['departamento_id']) ?> </td>
                                    <td> <?php echo booleano($reg['marcaTarjeta']) ?> </td>
                                    <td class="btn-group-xs">
                                    <a href="<?php echo BASE_URL ?>/trabajador/visualizar/<?php echo $reg['id'];?>" class="btn btn-success btn-ver"><i class="fa fa-search"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>                        
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> ID </th>
                                    <th>Nombre</th>
                                    <th> Opciones </th>
                                </tr>
                            </tfoot>
                        </table>
                        <script type="text/javascript">
                            $(function () {        
                            $('#trabajadores_list').dataTable({
                                "bPaginate": true,
                                "bLengthChange": false,
                                "bFilter": true,
                                "bSort": false,
                                "bInfo": true,
                                "bAutoWidth": false,
                                "pageLength": 30
                            });
                            });
                        </script>
                        <?php } else { ?>
                        <pre> No hay datos disponibles </pre>
                        <?php } ?>
                    </div>
                </div>
            </section>


        <?php endif; ?>

    </div>
</div>
<!-- /.content-wrapper -->
</form>
<script>
$(document).ready(function(){

    $(".btn-ver").click(function (e) { 
        e.preventDefault();
        url = $(this).attr('href');
        $(".overlayer").show();
        location.href = url;
    });
    
    $(".nav-tabs a").click(function(){
        window.location.hash = $(this).attr('href');
    })
    

    if( window.location.hash.length > 0 ){
        hash = window.location.hash;
        hash = hash.replace("#","");
        $(".nav-tabs a[href=#" + hash + "]").click();
    }

    
    $(".viewDocTrabajador").click(function(){
        var docId = $(this).data('id');        
        window.open('<?php echo BASE_URL ?>/private/documento.php?docId=' + docId);
            
    })    

    <?php if( $parametros[4] == 'OK' ){ ?>
    alert("Datos guardados correctamente");
    <?php } ?>
        
})
        
$(window).load(function(){
    $(".overlayer").fadeOut('fast');
})
             
</script>