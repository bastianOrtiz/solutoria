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
  <body class="login-page" style="background: #C6ECC8;">
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
        <form method="post" id="frmLogin" autocomplete="off">
            
            <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
            <input type="text" name="email" style="position: absolute;top: -99999px; left: -99999px">
            <input type="password" name="password" autocomplete="new-password" style="position: absolute;top: -99999px; left: -99999px">

            <input type="hidden" value="login" name="action" id="action" />
          <div class="form-group has-feedback login_cuenta">
            <input name="login_cuenta" type="text" class="form-control required" value="TECNODATA" placeholder="Empresa" />
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback login_email">
            <input name="login_rut" id="login_rut" type="text" class="form-control required" placeholder="Rut"/>
            <span class="glyphicon form-control-feedback" style="font-family: sans-serif; font-weight: bold;padding-right: 5px">RUT</span>
          </div>
          <div class="form-group has-feedback login_password">
            <input name="login_password" type="password" class="form-control required" placeholder="Password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8"></div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
            </div><!-- /.col -->
          </div>
        </form>
        <p> &nbsp; </p>
        <a href="#" class="forgot_pass">Solicitar / Recuperar password</a><br>        
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo BASE_URL ?>/public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo BASE_URL ?>/public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
    <script src="<?php echo BASE_URL ?>/public/js/custom.js" type="text/javascript"></script>
        
    <script>
    
    $(document).ready(function(){
        
        $("#login_rut").focus();
        
        $(".forgot_pass").click(function(){            
            $(".login_cuenta, .login_password").remove();
            $("input#action").val('req_pass');
            $(".login-box-msg").removeClass('error').text('Ingrese su RUT y el sistema enviará instrucciones para reestablecer su contraseña al mail asociado');
            $("#login_rut").val("");
            $(this).remove();
        })
    })
    
    $("#frmLogin").submit(function(e){
        e.preventDefault();
        var error = 0;
        $("#frmLogin .required").each(function(){
            if( $(this).val() == "" ){
                $(this).parent().addClass('has-error');
                $(this).parent().find('label').append(' &nbsp; <small>(Este campo es requerido)</small>');
                error++;
            }
        })
        
        if( error == 0 ){
            $("#frmLogin")[0].submit();
        } else {
            $(".login-box-msg").addClass('error').text('Debe ingresar los campos requeridos');
        }
        
    })
    
    $("#frmReqPass").submit(function(e){
        e.preventDefault();
        var error = 0;
        $("#frmReqPass .required").each(function(){
            if( $(this).val() == "" ){
                $(this).parent().addClass('has-error');
                $(this).parent().find('label').append(' &nbsp; <small>(Este campo es requerido)</small>');
                error++;
            }
        })
        
        if( error == 0 ){
            $("#frmReqPass")[0].submit();
        } else {
            $(".login-box-msg").addClass('error').text('Debe ingresar los campos requeridos');
        }
        
    })
    
    $("#login_rut").blur(function(){
        if( $(this).val() != "" ){
            $(this).val( format_rut( $(this).val() ) );
        }
    })
      
    </script>
  </body>
</html>