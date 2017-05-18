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
                <div class="box-body">
                    <form role="form" id="frmCrear" method="post">
                    <input type="hidden" name="action" value="edit" />
                    <input type="hidden" name="usuario_id" value="<?php echo $usuario['id'] ?>" />
                
                    <!-- form start -->
                    <div class="col-md-6">                            
                          <div class="box-body">
                                <div class="form-group">
                                  <label for="nombreUsuario">Nombre</label>
                                  <input type="text" class="form-control required" value="<?php echo $usuario['nombre'] ?>" id="nombreUsuario" name="nombreUsuario" placeholder="Nombre Completo" />
                                </div>                                                                        
                                <div class="form-group">
                                  <label for="emailUsuario">Email Usuario</label>
                                  <input type="text" class="form-control required" value="<?php echo $usuario['user'] ?>" id="emailUsuario" name="emailUsuario" placeholder="usuario@dominio.cl" />
                                </div>
                                <div class="form-group">
                                <label class="top">Es administrador</label>
                                  <div class="radio">                            
                                    <label>
                                      <input type="radio" class="rbtAdmin" name="administradorUsuario[]" id="administradorUsuarioSI" value="1" />
                                      SI
                                    </label>
                                    &nbsp; &nbsp; &nbsp; 
                                    <label>
                                      <input type="radio" class="rbtAdmin" name="administradorUsuario[]" id="administradorUsuarioNO" value="0" />
                                      NO
                                    </label>
                                  </div>
                                  <script> $("input.rbtAdmin[value=<?php echo $usuario['administrador'] ?>]").prop('checked',true) </script>                          
                                </div>
                                <div class="form-group">
                                  <label for="passwordUsuario">Password</label>
                                  <input type="password" class="form-control required" value="**********" id="passwordUsuario" name="passwordUsuario" placeholder="Elija contraseña" />
                                </div>
                                <div class="form-group">
                                  <label for="rePasswordUsuario">Reingrese Password</label>
                                  <input type="password" class="form-control required" value="**********" id="rePasswordUsuario" name="rePasswordUsuario" placeholder="Reescriba la contraseña elejida" />
                                </div>
                                <div class="form-group checkboxes">
                                    <label class="top">Empresas asignadas</label>                        
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="selecctall" id="selecctall" <?php echo ( $usuario['empresasTodas'] == 1 ) ? ' checked="checked" ' : ' '; ?> /> Todas las empresas
                                        </label>
                                    </div> 
                                    <div class="box" id="box_empresas_list" <?php echo ( $usuario['empresasTodas'] == 0 ) ? ' style="display:block" ' : ' '; ?>>
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
                                
                                <div class="form-group checkboxes">
                                    <label class="top">Items de menu autorizados</label>       
                                    <?php foreach( $menu as $menu_key => $menu_item ){ ?>                
                                        <div class="item_roles">
                                            <label for="parent_<?php echo $menu_key ?>">
                                                <i class="<?php echo $menu_item['icon_class'] ?>"></i>
                                                <?php echo $menu_item['label'] ?> 
                                            </label> 
                                            <input data-entidad="<?php echo $menu_key ?>" data-label="<?php echo $menu_item['label'] ?>" data-icon="<?php echo $menu_item['icon_class'] ?>" name="menuitem[<?php echo $menu_key ?>]" id="parent_<?php echo $menu_key ?>" type="checkbox" class="menuitem_parent" /><br />
                                            <?php foreach( $menu_item['childs'] as $subemnu_item_key => $subemnu_item ){ ?>            
                                                <div class="fieldset" style="width: auto; margin-right: 15px;">
                                                    <label for="children_<?php echo $menu_key ?>_<?php echo  $subemnu_item['entidad'] ?>_<?php echo  $subemnu_item['accion'] ?>">
                                                        <?php echo  $subemnu_item['label'] ?>
                                                    </label> 
                                                    <input data-accion="<?php echo $subemnu_item['accion'] ?>" data-entidad="<?php echo $subemnu_item['entidad'] ?>" data-label="<?php echo $subemnu_item['label'] ?>" data-link="<?php echo $subemnu_item['entidad'] ?>/<?php echo $subemnu_item['accion'] ?>" class="menuitem_children" id="children_<?php echo $menu_key ?>_<?php echo  $subemnu_item['entidad'] ?>_<?php echo  $subemnu_item['accion'] ?>" type="checkbox" />
                                                </div>                                                       
                                            <?php } ?>
                                            <br class="clear" />
                                        </div>                                         
                                    <?php } ?>
                                </div>
                                                        
                              </div><!-- /.box-body -->
        
                          <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="<?php echo BASE_URL . '/' . $entity ?>/listar" class="btn btn-default">Cancelar</a>
                          </div>                            
                    </div>
                
                    <div class="col-md-6">
                        <strong class="chkTooglerAll" style="cursor: pointer;" data-toggle="tooltip" title="Seleccionar/Deseleccionar Todos"> Seleccionar Todos <i class="fa fa-check-square-o"></i> </strong>
                        <?php 
                        $entidades = obtenerContenidoDirectorio(ROOT . '/views',false);                            
                        foreach( $entidades as $ent ){
                            ?>
                            <div class="item_roles">                                    
                                <strong class="chkToogler" style="cursor: pointer;"> <?php echo $ent; ?> <i class="fa fa-check-square-o" data-toggle="tooltip" title="Seleccionar/Deseleccionar Todos"></i> </strong>                                                                                                 
                                <?php
                                $acciones = obtenerContenidoDirectorio(ROOT . '/views/' . $ent,true);
                                foreach( $acciones as $acc ){
                                ?>
                                <div class="fieldset">
                                    <label for='acc_<?php echo $ent; ?>_<?php echo $acc; ?>' style="font-weight: normal;"><?php echo $acc; ?> </label> 
                                    <input type='checkbox' class="chk_roles" id="acc_<?php echo $ent; ?>_<?php echo $acc; ?>" name="roles[<?php echo $ent; ?>][<?php echo $acc; ?>]" /> &nbsp; 
                                </div>
                                <?php
                                }
                                ?>
                                <br class="clear" />                                
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    
                    <input type="hidden" name="json_menuitems" id="json_menuitems" />
                    </form>
                </div>
              </div><!-- /.box -->
            
        </div>
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
    
    if( $(".checkboxes input:checked").length == 0 ){
        error++;
        $('label.top').find('small').remove();
        $('label.top').append('<small> &nbsp; (Debe seleccionar al menos 1 item)</small>').parent().addClass('has-error');
    }    
    
    if( error == 0 ){
        if( $("#passwordUsuario").val() != $("#rePasswordUsuario").val() ){
            $("#passwordUsuario, #rePasswordUsuario").parent().addClass('has-error');
            $("#passwordUsuario, #rePasswordUsuario").parent().find('label').append(' <small>(Las password no coinciden)</small>');
        } else {
            
            i = 1;
            total_parent = $("input.menuitem_parent:checked").length;
            json = '{';            
            $("input.menuitem_parent:checked").each(function(){
            
                json += '"'+$(this).data('entidad')+'":{';
                json += '"label":"'+$(this).data('label')+'",';
                json += '"icon":"'+$(this).data('icon')+'",';
                json += '"hijos":{';
                    
                    j=1;
                    tot_childs = $(this).parent().find('.menuitem_children:checked').length                        
                    $(this).parent().find('.menuitem_children:checked').each(function(){
                        
                        json += '"'+ $(this).data('entidad') +'_'+ $(this).data('accion') +'": {';
                        json += '"label":"'+ $(this).data('label') +'",',
                        json += '"link":"'+ $(this).data('link') +'"'
                        json += '}'
                        if( j < tot_childs ){
                            json += ',';    
                        }                        
                        j++;
                    })
                    
                json += '}';
                json += '}';
                
                if( i < total_parent ){
                    json += ',';    
                }
                
                i++;
            })
            json += '}';
            
            $("#json_menuitems").val(json)  
            
            $(".overlayer").show();
            $("#frmCrear")[0].submit();
        }
    }
    
  })   

$(document).ready(function() {
    
    $(".chkTooglerAll").click(function(){
        $(this).children('i').toggleClass('fa-check-square');
        $(this).children('i').toggleClass('fa-check-square-o');
                               
        if( $(this).children('i').hasClass('fa-check-square') ){
            $('.chk_roles').prop("checked", true);
            $(".chkToogler").each(function(){
                $(this).children('i').removeClass('fa-check-square-o');
                $(this).children('i').addClass('fa-check-square');
            })                
        } else {
            $(".chkToogler").each(function(){
                $(this).children('i').addClass('fa-check-square-o');
                $(this).children('i').removeClass('fa-check-square');
            })
            $('.chk_roles').prop("checked", false);
        }         
    })
    
    
    $(".chkToogler").click(function(){
        $(this).children('i').toggleClass('fa-check-square');
        $(this).children('i').toggleClass('fa-check-square-o');
                               
        if( $(this).children('i').hasClass('fa-check-square') ){
            $(this).parent().find('.fieldset').each(function(){
                $(this).find('.chk_roles').prop("checked", true);
            })    
        } else {
            $(this).parent().find('.fieldset').each(function(){
                $(this).find('.chk_roles').prop("checked", false);
            })
        }         
    })
    
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

    <?php foreach( $usuarioempresa as $ue ){ ?>
    $("input[value=<?php echo $ue['empresa_id'] ?>]").prop('checked', true);
    <?php } ?>
    
    <?php 
    $roles = json_decode($usuario['roles']);
    if( $roles ){    
        foreach( $roles as $entidad => $rol ){ 
            foreach( $rol as $accion => $r ){
        ?>
            $("input#acc_<?php echo $entidad; ?>_<?php echo $accion; ?>").prop('checked', true);
        <?php        
            }
        }
    } 
    ?>
    
    
    
    
    <?php 
    $menuItems = json_decode($usuario['menuItem']);
    if( @$menuItems ){
        foreach( $menuItems as $menu_key => $menu_item ){
        ?>
            $("#parent_<?php echo $menu_key ?>").prop('checked',true);
            <?php foreach( $menu_item->hijos as $subemnu_item ){ ?>
            
            $(".menuitem_children[data-link='<?php echo $subemnu_item->link ?>']").prop('checked',true);
            
            <?php
            }                                
        }
    }
    ?>
    
    
   
});
           
</script>
