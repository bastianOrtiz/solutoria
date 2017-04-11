      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
      
      <span style="color: #Fff;">      
      </span>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
        
        <?php if( !$_SESSION[PREFIX.'is_trabajador'] ){ ?>
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="input-group input-group-lg">
                <div class="input-group-btn">
                
                  <button type="button" class="btn btn-block btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php echo fnAcortaNombreEmpresa($_SESSION[PREFIX . 'login_empresa']) ?>  
                    <span class="fa fa-caret-down"></span>
                  </button>                                            
                  <ul class="dropdown-menu" id="list_empresa_changer">
                    <?php
                    $empresas = fnListaEmpresasXUsuario($_SESSION[PREFIX . 'login_uid']);
                    foreach( $empresas as $e ){                        
                    ?>
                        <li><a href="#" data-empresa-id="<?php echo $e['id_empresa']; ?>"><?php echo fnAcortaNombreEmpresa($e['nombre']); ?></a></li>                                                    
                    <?php } ?>                        
                  </ul>
                    <form id="frmEmpresaChanger" action="<?php echo BASE_URL ?>/empresa" method="post">
                        <input type="hidden" name="current_url" value="<?php echo BASE_URL."/".$entity."/".@$parametros[0]."/".@$parametros[1]; ?>" />
                        <input type="hidden" name="eid" id="eid" />
                        <input type="hidden" name="action" value="change_empresa"  />
                    </form>
                </div><!-- /btn-group -->                    
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form" autocomplete="off" onsubmit="return false">
            <div class="input-group">
              <input type="text" name="buscarTrabajador" id="buscarTrabajadorSidebar" class="form-control" placeholder="Buscar trabajador..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <?php } ?>
            
            <?php echo generaMenu(); ?>
          
          <script>
          $(document).ready(function(){
            $(".sidebar-menu li#menu_item_<?php echo $entity ?>").addClass('active');
          })
          </script>
        </section>
        <!-- /.sidebar -->
      </aside>
      
      <script>
      $("#list_empresa_changer li a").click(function(){
        id = $(this).data('empresa-id');
        nombre = $(this).text();
        if( confirm('Está a punto de cambiar a empresa "'+nombre+'"') ){
            $("#eid").val(id);
            $("#frmEmpresaChanger")[0].submit();
        }
      })
      </script>