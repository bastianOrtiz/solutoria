<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Login de Trabajador</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo BASE_URL ?>/public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>/public/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo BASE_URL ?>/public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo BASE_URL ?>/public/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo BASE_URL ?>/public/index2.html">
            <img src="<?php echo BASE_URL ?>/public/img/logo.png" />
        </a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg <?php echo @$array_reponse['status']; ?>">
        <?php echo (isset($array_reponse)) ? "<strong>".@$array_reponse['mensaje']."</strong>" : "Ingrese sus datos para iniciar sesión"; ?>
        </p>
        <div class="row">
            <div class="col-xs-8"></div><!-- /.col -->
            <div class="col-xs-4">
                <p> &nbsp; </p>
              <a href="<?php echo BASE_URL ?>/login_trabajador" class="btn btn-primary btn-block btn-flat">Ingresar</a>
            </div><!-- /.col -->
          </div>                                        
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo BASE_URL ?>/public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo BASE_URL ?>/public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo BASE_URL ?>/public/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    
  </body>
</html>