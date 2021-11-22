<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Tecnodata RRHH</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo BASE_URL ?>/public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <!-- FontAwesome 4.3.0 -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
    <!-- Theme style -->
    <link href="<?php echo BASE_URL ?>/public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo BASE_URL ?>/public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    
    <!-- DATA TABLES -->
    <link href="<?php echo BASE_URL ?>/public/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    
    <!-- iCheck -->    
    <link href="<?php echo BASE_URL ?>/public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart 
    <link href="<?php echo BASE_URL ?>/public/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    -->    
    <!-- jvectormap -->
    <link href="<?php echo BASE_URL ?>/public/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="<?php echo BASE_URL ?>/public/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="<?php echo BASE_URL ?>/public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="<?php echo BASE_URL ?>/public/plugins/wysiwyg/editor.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>/public/css/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>/public/css/custom.css" rel="stylesheet" type="text/css" />
    
    <!-- Select2-->
    <link href="<?php echo BASE_URL ?>/public/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    
    <!-- fullCalendar 2.2.5-->
    <link href="<?php echo BASE_URL ?>/public/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo BASE_URL ?>/public/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media='print' />
    
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <link rel="stylesheet" type="text/css" media="print" href="<?php echo BASE_URL ?>/public/css/print.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery 2.1.4 -->
    <script>
    BASE_URL = '<?php echo BASE_URL ?>';
    MES_CORTE = '<?php echo getMesMostrarCorte(); ?>';
    MES_CORTE_TXT = '<?php echo getNombreMes(getMesMostrarCorte()); ?>';
    ANO_CORTE = '<?php echo getAnoMostrarCorte(); ?>';
    </script>
    <script src="<?php echo BASE_URL ?>/public/plugins/jQuery/jQuery-2.1.4.min.js"></script>    
  </head>
  <!-- COmentario html desde mac -->
    <body class="skin-blue sidebar-mini" id="body_<?php echo $entity ?>">
        <div class="wrapper">            
          