<script>
<?php 
$aray_f = "array_feriados = [";
$feriados = $db->get("m_diaferiado"); 
foreach( $feriados as $feriado ){
    $aray_f .= "'" . $feriado['fecha'] . "',";
}
$aray_f = trim($aray_f,',');
$aray_f .= '];';
echo $aray_f."\n";
?>
</script>
        
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2015 Tecnodata S.A.</strong>
      </footer>
      <!-- Control Sidebar -->      
      <div class='control-sidebar-bg'></div>
    </div><!-- ./wrapper -->
    
    <div class="overlayer"><i class="fa fa-refresh fa-spin"></i></div>    
     
        
    <!-- jQuery UI 1.11.2 -->    
    <script src="<?php echo BASE_URL ?>/public/js/jquery-ui.min.last.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->    
    <script>
      $.widget.bridge('uibutton', $.ui.button);      
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo BASE_URL ?>/public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>    
    <!-- Morris.js charts 
    <script src="<?php echo BASE_URL ?>/public/js/raphael-min.js"></script>
    <script src="<?php echo BASE_URL ?>/public/plugins/morris/morris.min.js" type="text/javascript"></script>
    -->
    
    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo BASE_URL ?>/public/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo BASE_URL ?>/public/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    
    <!-- Sparkline -->
    <script src="<?php echo BASE_URL ?>/public/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="<?php echo BASE_URL ?>/public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="<?php echo BASE_URL ?>/public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo BASE_URL ?>/public/plugins/knob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="<?php echo BASE_URL ?>/public/js/moment.min.js" type="text/javascript"></script>
    <script src="<?php echo BASE_URL ?>/public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="<?php echo BASE_URL ?>/public/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo BASE_URL ?>/public/plugins/wysiwyg/editor.js" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="<?php echo BASE_URL ?>/public/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='<?php echo BASE_URL ?>/public/plugins/fastclick/fastclick.min.js'></script>
    <!-- Select2 -->
    <script src='<?php echo BASE_URL ?>/public/plugins/select2/js/select2.min.js'></script>
    
    <!-- ChartJS -->
    <script src='<?php echo BASE_URL ?>/public/plugins/chartjs/Chart.min.js'></script>
    
    <!-- AdminLTE App -->
    <script>
    var AdminLTEOptions = {
        //Enable sidebar expand on hover effect for sidebar mini
        //This option is forced to true if both the fixed layout and sidebar mini
        //are used together
        sidebarExpandOnHover: true,
        //BoxRefresh Plugin
        enableBoxRefresh: true,
        //Bootstrap.js tooltip
        enableBSToppltip: true
      };
    </script>
    <script src="<?php echo BASE_URL ?>/public/dist/js/app.min.js" type="text/javascript"></script>        
    <script src="<?php echo BASE_URL ?>/public/js/icheck.min.js" type="text/javascript"></script>    
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo BASE_URL ?>/public/dist/js/demo.js" type="text/javascript"></script>
    <script src="<?php echo BASE_URL ?>/public/js/numeral.js" type="text/javascript"></script>
    <script src="<?php echo BASE_URL ?>/public/js/custom.js" type="text/javascript"></script>
    
    <!-- fullCalendar 2.2.5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
    <script src="<?php echo BASE_URL ?>/public/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    
                
  </body>
</html>