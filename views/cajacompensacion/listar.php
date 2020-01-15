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
                  <h3 class="box-title"><?php echo ucfirst($entity) ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                  <table id="tabla_cajacompensacion" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th> ID </th>
                        <th>Nombre</th>
                        <th>Codigo Previred</th>
                        <th> Opciones </th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $registros as $reg ){ ?>
                            <tr>
                                <td> <?php echo $reg['id']?> </td>
                                <td> <?php echo $reg['nombre']?> </td>
                                <td> <?php echo $reg['codigo']?> </td>
                                <td>                                    
                                    <button class="btn btn-flat btn-info" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Detalles"> <i class="fa fa-search"></i> </button>
                                    <button class="btn btn-flat btn-warning" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Modificar"> <i class="fa fa-edit"></i> </button>
                                    <button class="btn btn-flat btn-danger" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Eliminar"><i class="fa fa-remove"></i></button>                                    
                                </td>                                                                                                                                                                                                
                            </tr>
                        <?php } ?>                        
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              
              
                <a href="<?php echo BASE_URL . '/' . $entity ?>/ingresar" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> Nueva <?php echo ucfirst($entity) ?>
                </a>
                
                
                <!-- Large modal -->                                                
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                          <h4 class="modal-title" id="myLargeModalLabel">
                          </h4>
                        </div>
                        <div class="modal-body">
                            <div class="box-body">                                                                                     
                            </div><!-- /.box-body -->
                        </div>
                        <br class="clear" />
                        <div class="modal-footer">
                        <a href="#" class="btn btn-default" data-dismiss="modal">Cerrar</a>
                        <a href="" class="btn btn-info">Agregar Valores</a>
                        <a href="" class="btn btn-warning">Modificar</a>
                        <a href="" class="btn btn-danger">Eliminar</a>
                      </div>  
                    </div>
                  </div>
                </div><!-- /.modal -->
                
                  
        </section>
        
      </div><!-- /.content-wrapper -->            
      
      
    <script>
    $(function () {        
        $('#tabla_cajacompensacion').dataTable({
          "bPaginate": true,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
      
    $(".table button").click(function(){
        regid = $(this).data('regid');
        if( $(this).hasClass('btn-danger') ){
            location.href = '<?php echo BASE_URL . '/' . $entity . '/eliminar/'?>' + regid;
        }
        if( $(this).hasClass('btn-warning') ){
            location.href = '<?php echo BASE_URL . '/' . $entity . '/editar/'?>' + regid;
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
                        
                        html_iterante = '<div class="col-md-4">';
                        $.each(json.registros, function(k,v) {
                            html_iterante += '<div class="_contenedor">';                            
                            html_iterante += '      <span class="_label">'+k+'</span>';
                            html_iterante += '      <span class="_input">'+v+'</span>';                            
                            html_iterante += '</div>';    
                        });                        
                        html_iterante += '</div>';
                                            
                        html_iterante += '<div class="col-md-8">';
                        html_iterante += '<div class="box">';
                        html_iterante += '<div class="box-header">';
                        html_iterante += '  <h3 class="box-title">Lista de valores</h3>';
                        html_iterante += '</div>';
                        html_iterante += '<div class="box-body no-padding table-responsive">';
                        html_iterante += '  <table class="table table-striped">';
                        html_iterante += '    <tbody><tr>';
                        html_iterante += '      <th style="width: 10px">#</th>';
                        html_iterante += '      <th>% Pension</th>';
                        html_iterante += '      <th>% Seguro</th>';
                        html_iterante += '      <th>% Sis</th>';
                        html_iterante += '      <th>% Pensionado</th>';
                        html_iterante += '      <th>Mes</th>';
                        html_iterante += '      <th style="width: 40px">Año</th>';
                        html_iterante += '    </tr>';    
                        
                        if( json.cajacompensacionvalores != 'vacio' ){                    
                            var j = 1;
                            $.each(json.cajacompensacionvalores, function(k,v){
                                html_iterante += '<tr>';
                                html_iterante += '<td>'+j+'</td>';
                                $.each(v, function(key,val){                                
                                    html_iterante += '<td>';
                                    html_iterante += '' + val + '';
                                    html_iterante += '</td>';
                                })                                    
                                j++;
                            })
                            html_iterante += '</tr>';
                        } else {
                            html_iterante += '<tr>';
                            html_iterante += '<td colspan="8">No hay registros</td>';
                            html_iterante += '</tr>';
                        }
                        
                        html_iterante += '  </tbody></table>';
                        html_iterante += '</div>';
                        html_iterante += '</div>';
                        html_iterante += '</div>';
                        
                        
                        $(".modal .modal-body").append( html_iterante );
                         
                        $(".modal h4").text(json.titulo);
                        $(".modal .btn.btn-info").attr('href','<?php echo BASE_URL ?>/cajacompensacionvalor/ingresar/' + regid);
                        $(".modal .modal-footer .btn-warning").attr('href','<?php echo BASE_URL ?>/<?php echo $entity ?>/editar/' + regid );
                        $(".modal .modal-footer .btn-danger").attr('href','<?php echo BASE_URL ?>/<?php echo $entity ?>/eliminar/' + regid );
                        //Mostrar el Modal, cargado
                        
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