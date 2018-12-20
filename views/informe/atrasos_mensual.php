<div class="content-wrapper">
    <section class="content-header">
      <h1> REPORTE ATRASOS MENSUAL </h1>
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
        <form role="form" id="frmVerAtrasos" method="post">
            <input type="hidden" name="action" id="action" value="atrasos_view" />
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">
                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group input-group-lg">
                                            <div class="input-group-btn">
                                              <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Seleccione mes
                                                <span class="fa fa-caret-down"></span></button>
                                              <ul class="dropdown-menu">
                                                <li><a href="#">Seleccione mes</a></li>
                                                <?php for($i=1;$i<=12;$i++){ ?>
                                                <li><a href="#"> <?php echo getNombreMes($i) ?> </a></li>
                                                <?php } ?>
                                              </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group input-group-lg">
                                            <div class="input-group-btn">
                                              <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">Seleccione Año
                                                <span class="fa fa-caret-down"></span></button>
                                              <ul class="dropdown-menu">
                                                <li><a href="#">Seleccione Año</a></li>
                                                <?php for($i=date('Y');$i>=2015;$i--){ ?>
                                                <li><a href="#"> <?php echo $i ?> </a></li>
                                                <?php } ?>
                                              </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <button class="btn btn-primary btn-lg">Enviar</button>
                                    </div>
                                </div>
                            </div>         

                        </div>                                            
                    </div>                      
                
                </div>
            </div>
        </form>
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


$(document).ready(function(){    
    
    $(".btnCartaAmonestacion").click(function(e){
        e.preventDefault();
        id = $(this).attr('href');
        $.ajax({
			type: "POST",
			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
			data: "id="+id+"&action=generate_carta",
            dataType: 'json',
            beforeSend: function(){                
            },
			success: function (json) {
			     window.open('<?php echo BASE_URL; ?>/private/carta.php?id=' + json.id);
            }
		})
    })
    
    $(".check_employee").click(function(){
        $("#check_all").prop('checked',false);
    })
    
    $("#check_all").click(function(){
        if( $(this).prop('checked') == true ){
            $(".check_employee").prop('checked',true);
        } else {
            $(".check_employee").prop('checked',false);
        }
    })
    
    $(".datepicker").datepicker({
        startView : 'year',
        autoclose : true,
        format : 'yyyy-mm-dd'
    });
    
    
    $(".btnEnviar").click(function(){
        if( $(".check_employee:checked").length == 0 ){
            alert("Debe seleccionar al menos 1 trabajador");
            return;
        } else {
            oTable.fnFilter('');
            $("#frmVerAtrasos")[0].submit();
        }
    })
    
    $(".btnImprimir").click(function(){
        $("#action").val('atrasos');
        $("#frmVerAtrasos").attr('target','_blank');
        $("#frmVerAtrasos")[0].submit();        
    })
    
    $(".btnExcel").click(function(){
        $("#action").val('atrasos_excel');
        $("#frmVerAtrasos").attr('target','_blank');
        $("#frmVerAtrasos")[0].submit();        
    })
    
    $(function () {        
        oTable = $('#seleccionTrabajadores').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": false,
            "bInfo": false,
            "bAutoWidth": false,
            "pageLength": 999
        });
    }); 
    
    $('#table_list_atrasos').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false,
        "pageLength": 999
    });
             
})

            
</script>
      