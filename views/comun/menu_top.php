<style>
.sidebar-toggle{ display: none; }
@media screen and (max-width:720px) {
    .sidebar-toggle{ display: block; }
}

</style>
<header class="main-header">
<!-- Logo -->
<a href="<?php echo BASE_URL; ?>" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini">RRHH</span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg"><b>RRHH</b>Tecnodata</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- Messages: style can be found in dropdown.less-->
      <?php if (isAdmin()) { ?>
      <li>
        <a href="javascript: procesarLiquidaciones();"><i class="fa fa-cogs"></i></a>
      </li>
      <?php } ?>
      <li class="dropdown messages-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-calendar"></i>          
        </a>
        <ul class="dropdown-menu drop-calendar">                    
          <li>                    
            <div id="menu_calendar" style="width: 100%"></div>                 
          </li>                  
        </ul>
      </li>
      <?php if( ! $_SESSION[ PREFIX . 'is_trabajador'] ){ ?>
      <li class="dropdown messages-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-scissors"></i>
          <?php if(debeCerrarMes()): ?>
          <span class="label label-danger alerta_corte"><i class="fa fa-exclamation"></i></span>
          <?php endif; ?>
        </a>
        <ul class="dropdown-menu drop-calendar">
            <li class="header">Seleccione dia de corte</li>                    
            <li>                              
                <div id="calendar_corte" style="width: 100%; padding: 10px;">
                    <p>Fecha de hoy: <?php echo date('d') ?>-<?php echo getNombreMes(date('m'),true) ?>-<?php echo date('Y') ?></p>
                    <div class="input-group">
                        <?php 
                        $mesMostrar = getMesMostrarCorte(); 
                        ?>
                        <select class="form-control" name="cboDiaCorte" id="cboDiaCorte">
                            <?php 
                            $limite = getLimiteMes($mesMostrar);
                            for($i=1; $i<=$limite; $i++){ 
                            ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                        <?php 
                        $diaCortado = getDiaCortado( $mesMostrar ); 
                        if( $diaCortado ){
                        ?>
                        <script> $("#cboDiaCorte").val('<?php echo $diaCortado; ?>') </script>
                        <?php } ?>
                        <span class="input-group-addon"><?php echo getNombreMes($mesMostrar); ?></span>
                        <span class="input-group-btn">
                          <button class="btn btn-info btn-flat" id="btn_guardar_corte" type="button">Guardar</button>
                        </span>
                    </div>
                </div>                 
            </li>                  
        </ul>
      </li>
      <!-- Notifications: style can be found in dropdown.less -->
      <li class="dropdown notifications-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-bell-o"></i>
          <?php 
            $alertas = fnAlertas();
            if( $alertas ){
          ?>
            <span class="label label-danger"><?php echo count($alertas); ?></span>
          <?php } ?>
        </a>
        <ul class="dropdown-menu">
            <?php             
            if( $alertas ){
            ?>
            <li class="header">Tiene <?php echo count($alertas); ?> alertas</li>
            <li>
            <!-- inner menu: contains the actual data -->
                <ul class="menu">              
                    <?php foreach( $alertas as $alerta ){ ?>
                    <li>
                        <a href="<?php echo $alerta['link'] ?>">
                            <i class="fa fa-warning text-red"></i> <?php echo $alerta['mensaje'] ?>
                        </a>
                    </li>
                    <?php } ?>                            
                </ul>
            </li>
            <?php }else { ?>
            <li class="header">No tiene alertas pendientes</li>
            <?php } ?>
                      
        </ul>
      </li>
      <?php
      }
      ?>
      
      
      <?php
      /*
      <!-- Tasks: style can be found in dropdown.less -->
      <li class="dropdown tasks-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <i class="fa fa-flag-o"></i>
          <span class="label label-danger">9</span>
        </a>
        <ul class="dropdown-menu">
          <li class="header">You have 9 tasks</li>
          <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
              <li><!-- Task item -->
                <a href="#">
                  <h3>
                    Design some buttons
                    <small class="pull-right">20%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                </a>
              </li><!-- end task item -->
              <li><!-- Task item -->
                <a href="#">
                  <h3>
                    Create a nice theme
                    <small class="pull-right">40%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">40% Complete</span>
                    </div>
                  </div>
                </a>
              </li><!-- end task item -->
              <li><!-- Task item -->
                <a href="#">
                  <h3>
                    Some task I need to do
                    <small class="pull-right">60%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">60% Complete</span>
                    </div>
                  </div>
                </a>
              </li><!-- end task item -->
              <li><!-- Task item -->
                <a href="#">
                  <h3>
                    Make beautiful transitions
                    <small class="pull-right">80%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">80% Complete</span>
                    </div>
                  </div>
                </a>
              </li><!-- end task item -->
            </ul>
          </li>
          <li class="footer">
            <a href="#">View all tasks</a>
          </li>
        </ul>
      </li>
      */
      ?>
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <?php if($_SESSION[ PREFIX . 'is_trabajador']): ?>
            <img src="<?php echo BASE_URL ?>/private/imagen.php?f=<?php echo base64_encode(base64_encode(date('Ymd')) . $_SESSION[PREFIX . 'login_uid']) ?>&t=<?php echo base64_encode('m_trabajador') ?>" style="object-fit: cover;" class="user-image" />
          <?php else: ?>
            <img src="<?php echo BASE_URL ?>/public/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
          <?php endif; ?>
          <span class="hidden-xs"><?php echo $_SESSION[ PREFIX . 'login_name' ] ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <?php if($_SESSION[ PREFIX . 'is_trabajador']): ?>
            <img src="<?php echo BASE_URL ?>/private/imagen.php?f=<?php echo base64_encode(base64_encode(date('Ymd')) . $_SESSION[PREFIX . 'login_uid']) ?>&t=<?php echo base64_encode('m_trabajador') ?>" style="object-fit: cover;" class="img-circle" />
          <?php else: ?>
            <img src="<?php echo BASE_URL ?>/public/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
          <?php endif; ?>
            <p>
              <?php echo $_SESSION[ PREFIX . 'login_name' ] ?>                    
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">              
              <a href="<?php echo BASE_URL ?>/usuario/perfil/" class="btn btn-default btn-flat">Perfil</a>
            </div>
            <div class="pull-right">
              <a href="<?php echo BASE_URL ?>/login/logout" class="btn btn-default btn-flat">Salir</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->              
    </ul>
  </div>
</nav>
</header>

<script>
$(document).ready(function(){
    $("#btn_guardar_corte").click(function(){
        var dia = $("#cboDiaCorte").val();
        $.ajax({
        	type: "POST",
        	url: "<?php echo BASE_URL . '/controllers/ajax/corte.ajax.php'?>",
        	data: 'dia=' + dia + '&action=set_corte',
            dataType: 'json',
            beforeSend: function(){            
            },
        	success: function (json) {
        	   alert("Guardado!");
        	   $("body").click();
               if( json.alerta_off == 1 ){
                    $(".alerta_corte").fadeOut('slow');
               }
               location.reload();
        	}
        })      
    })    
})

</script>