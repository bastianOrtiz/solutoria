<!-- Content Wrapper. Contains page content -->    
   
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> INGRESAR <?php echo strtolower($entity) ?> </h1>
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
          <div class="row">
              <div class="col-md-12">
                  <!-- general form elements -->
                  <div class="box box-primary">
                    <div class="box-header">                      
                      <h3 class="box-title">Datos del Registro</h3>
                    </div><!-- /.box-header -->
                    
                    <form role="form" id="frmCrear" method="post">
                    <input type="hidden" name="action" value="new" />
                    <div class="box-body">                                                                                
                        <div class="col-md-6">                                                                  
                            <div class="form-group">
                              <label for="nombreUsuario">Nombre</label>
                              <input type="text" class="form-control required" value="" id="nombreUsuario" name="nombreUsuario" placeholder="Nombre Completo" />
                            </div>                                                                        
                            <div class="form-group">
                              <label for="emailUsuario">Email Usuario</label>
                              <input type="text" class="form-control required" id="emailUsuario" name="emailUsuario" placeholder="usuario@dominio.cl" />
                            </div>
                            <div class="form-group">
                            <label class="top">Es administrador</label>
                              <div class="radio">                            
                                <label>
                                  <input type="radio" name="administradorUsuario[]" id="administradorUsuarioSI" value="1" />
                                  SI
                                </label>
                                &nbsp; &nbsp; &nbsp; 
                                <label>
                                  <input type="radio" name="administradorUsuario[]" id="administradorUsuarioNO" value="0" checked="" />
                                  NO
                                </label>
                              </div>                          
                            </div>
                            <div class="form-group">
                              <label for="passwordUsuario">Password</label>
                              <input type="password" class="form-control required" id="passwordUsuario" name="passwordUsuario" placeholder="Elija contraseña" />
                            </div>
                            <div class="form-group">
                              <label for="rePasswordUsuario">Reingrese Password</label>
                              <input type="password" class="form-control required" id="rePasswordUsuario" name="rePasswordUsuario" placeholder="Reescriba la contraseña elejida" />
                            </div>
                            
                            <div class="form-group checkboxes">
                                <label class="top">Empresas asignadas</label>                        
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="selecctall" id="selecctall" checked="checked" /> Todas las empresas
                                    </label>
                                </div> 
                                <div class="box" id="box_empresas_list">                                       
                                    <?php                                 
                                    foreach( $all_empresas as $c ){ ?>                    
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="chkEmpresa[<?php echo $c['id'] ?>]" value="<?php echo $c['id'] ?>" class="chk flat-blue" />
                                            <?php echo $c['nombre'] ?>
                                        </label>
                                    </div>
                                    <?php } ?>       
                                </div>                     
                                
                                
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>                                                                            
                        </div><!-- /.box-body -->                                                
                    
                        <div class="col-md-6">
                            <?php 
                            $entidades = obtenerContenidoDirectorio(ROOT . '/views',false);                            
                            foreach( $entidades as $ent ){
                                ?>
                                <div class="item_roles">                                    
                                    <strong><?php echo $ent; ?> </strong> 
                                    <br />                                                                
                                    <?php
                                    $acciones = obtenerContenidoDirectorio(ROOT . '/views/' . $ent,true);
                                    foreach( $acciones as $acc ){
                                        ?>
                                        <label for='acc_<?php echo $ent; ?>_<?php echo $acc; ?>' style="font-weight: normal;"><?php echo $acc; ?> </label> 
                                        <input type='checkbox' class="chk_roles" id="acc_<?php echo $ent; ?>_<?php echo $acc; ?>" name="roles[<?php echo $ent; ?>][<?php echo $acc; ?>]" /> &nbsp; 
                                        <?php
                                    }
                                ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                      </div>
                      
                    </form>
                  </div><!-- /.box -->
                </div>
          </div>   <!-- /.row -->
        </section>
        
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
  
  $("#frmCrear").submit(function(e){
    e.preventDefault();
    error = 0;
    $(".required").each(function(){
        if( $(this).val() == "" ){
            if( !$(this).parent().hasClass('has-error') ){
                $(this).parent().addClass('has-error');
                $(this).parent().find('label').append(' <small>(Este campo es requerido)</small>');
            }
            error++;
        }
    })
    
    if( $(".checkboxes input:checked").length == 0 ){
        error++;  
        $('label.top').find('small').remove();
        $('label.top').append('<small> &nbsp; (Debe seleccionar al menos 1 item)</small>').parent().addClass('has-error');
    }    
    
    if( error == 0 ){
        
        if( $("#passwordUsuario").val() != $("#rePasswordUsuario").val() ){
            $("#passwordUsuario, #rePasswordUsuario").parent().addClass('has-error');
            $("#passwordUsuario, #rePasswordUsuario").parent().find('label').find('small').remove();
            $("#passwordUsuario, #rePasswordUsuario").parent().find('label').append('<small> (Las password no coinciden)</small>');
        } else {            
            $(".overlayer").show();
            $("#frmCrear")[0].submit();
        }
    }
    
  })

$(document).ready(function() {
    $('.chk').click(function(){
        $('label.top').parent().removeClass('has-error');
        $('label.top').find('small').remove()
        cuantos_checked = 0;
        $('.chk').each(function() {
            if( $(this).is(':checked') )
                cuantos_checked++;          
        });
        if( cuantos_checked == $(".chk").length ){
            $('#selecctall').prop('checked', true);
        } else {
            $('#selecctall').prop('checked', false);
        }
        
    })
    $('#selecctall').click(function(event) {  
        $('label.top').parent().removeClass('has-error');
        $('label.top').find('small').remove()
        $("#box_empresas_list").slideDown('fast');
        if(this.checked) {
            $('.chk').each(function() {
                this.checked = true;               
            });
        }else{
            $('.chk').each(function() {
                this.checked = false;                       
            });         
        }
    });
});
                    
</script>
      