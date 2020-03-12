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
                <a href="<?php echo BASE_URL . '/' . $entity ?>/ingresar" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> Nuevo <?php echo ucfirst($entity) ?>
                </a>
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
                        <th> Opciones </th>
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
                                    <button class="btn btn-flat btn-default" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Liguidar"> <i class="fa fa-file-text"></i> </button>                                    
                                    <button class="btn btn-flat btn-info" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Finiquitar"> <i class="fa fa-paper-plane"></i> </button>
                                    <!--
                                    <button class="btn btn-flat btn-info" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Detalles"> <i class="fa fa-search"></i> </button>
                                    <button class="btn btn-flat btn-success" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Ver"> <i class="fa fa-eye"></i> </button>
                                    -->
                                    <button class="btn btn-flat btn-warning" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Modificar"> <i class="fa fa-edit"></i> </button>
                                    <button class="btn btn-flat btn-danger" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Eliminar"><i class="fa fa-remove"></i></button>                                    
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
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              
                <a href="<?php echo BASE_URL . '/' . $entity ?>/ingresar" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> Nuevo <?php echo ucfirst($entity) ?>
                </a>
                
                
                <!-- Large modal -->                                                
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                          <h4 class="modal-title" id="myLargeModalLabel"></h4>
                          <div class="image"></div>
                        </div>
                        <div class="modal-body">
                            <div class="box-body col-md-12">
                                                                                                   
                            </div><!-- /.box-body -->
                        </div>
                        <br class="clear" />
                        <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                        <a href="" class="btn btn-warning">Modificar</a>
                        <a href="" class="btn btn-danger">Eliminar</a>
                      </div>  
                    </div>
                  </div>
                </div><!-- /.modal -->
                
                  
        </section>
        
      </div><!-- /.content-wrapper -->            
               
      
    <script>
    $(".table button").click(function(){
        regid = $(this).data('regid');
        
        if( $(this).hasClass('btn-default') ){
            location.href = '<?php echo BASE_URL . '/liquidacion/ver/'?>' + regid;
        }
        if( $(this).hasClass('btn-danger') ){
            location.href = '<?php echo BASE_URL . '/' . $entity . '/eliminar/'?>' + regid;
        }
        if( $(this).hasClass('btn-warning') ){
            location.href = '<?php echo BASE_URL . '/' . $entity . '/editar/'?>' + regid;
        }
        if( $(this).hasClass('btn-success') ){
            location.href = '<?php echo BASE_URL . '/' . $entity . '/ver/'?>' + regid;
        }
        if( $(this).hasClass('btn-info') ){
            // Ajax pasando parametro regid.
            $.ajax({
				type: "POST",
				url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
				data: 'regid=' + regid + '&action=detalle',
                dataType: 'json',
                beforeSend: function(){
                    $(".overlayer").show();
                },
				success: function (json) {
				    if(json.status == 'success'){
				        
                        //LLenar el div con datos retornados por JSON
				        $(".modal .modal-body").empty();
                        $(".modal .modal-body").html('<div class="col-md-2 foto_trabajdor"></div><div class="col-md-10 fields_trabajadores"></div>');
                        $.each(json.registros, function(k,v) {                            
                            html_iterante = '<div class="col-md-6 col_field">';
                            html_iterante += '<div class="input-group">';                            
                            html_iterante += '  <span class="input-group-btn">';
                            html_iterante += '    <a class="btn btn-default btn-flat">'+k+'</a>';
                            html_iterante += '  </span>';
                            if( k == "Sueldo Base" ){
                            html_iterante += '  <input type="text" id="sueldo_base_trabajador" class="field_value_trabajador no-radio form-control" value="'+v+'" readonly />';
                            } else {
                            html_iterante += '  <input type="text" class="field_value_trabajador form-control" data-toggle="tooltip" value="'+v+'" title="'+v+'" readonly />';    
                            }
                            if( k == "Sueldo Base" ){
                            html_iterante += '  <span class="input-group-addon">';
                            html_iterante += '      <a href="#" id="view_sueldo_quick" class="fa fa-eye view_sueldo"></a>';
                            html_iterante += '  </span>';
                            }
                            html_iterante += '</div>';
                            html_iterante += '</div>';                            
                            
                            
                            /*
                            html_iterante = '<div class="col-md-6">';
                            html_iterante += '<div class="_contenedor">';                            
                            html_iterante += '      <span class="_label">'+k+'</span>';
                            html_iterante += '      <span class="_input">'+v+'</span>';                            
                            html_iterante += '</div>';
                            html_iterante += '</div>';
                            */
                            
                            $(".modal .modal-body .fields_trabajadores").append(html_iterante);                                                            
                        });                        
                        
                        $(".modal h4").text(json.titulo); 
                        $(".modal .modal-body .foto_trabajdor").html('<img src="'+BASE_URL+'/private/imagen.php?t='+base64_encode('m_trabajador')+'&f='+base64_encode('<?php echo base64_encode(date('Ymd')) ?>'+regid)+'" style="width: 100%; height: auto" />');
                        $(".modal .modal-footer .btn-warning").attr('href','<?php echo BASE_URL ?>/<?php echo $entity ?>/editar/' + regid );
                        $(".modal .modal-footer .btn-danger").attr('href','<?php echo BASE_URL ?>/<?php echo $entity ?>/eliminar/' + regid );
                        //Mostrar el Modal, cargado
                        
                        hideFieldValue('#sueldo_base_trabajador','#view_sueldo_quick');
                        
                        $(".bs-example-modal-lg").modal('show');
				    } else {
				        alert(json.mensaje);                        
				    }
                    $(".overlayer").hide();                    		        
                }
			})                                    
        }        
    })
    </script>