<div class="content-wrapper">
    <section class="content-header">            
      <h1> INGRESAR VALORES COSTO EMPRESA</h1>
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
      <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">                
            <div class="box-header">
              <h3 class="box-title">Datos del registro</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="frmCrear" method="post">
                <input type="hidden" name="action" value="new" />                        
                                        
              <div class="box-body">
                <div class="form-group">
                  <label for="costoempresa">Costo</label>
                  <select name="costoempresa" id="costoempresa" class="form-control required">
                    <option value=""> Seleccione Costo </option>
                    <option value="1">SIS</option>
                    <option value="2">ACHS</option>
                    <option value="3">AFC para contratos a plazo fijo</option>
                    <option value="4"> AFC para contratos indefinidos</option>
                  </select>
                </div>
                
                <div class="form-group">
                    <label for="mesCostoEmpresa"> Mes </label><br class="clear" />  
                    <select name="mesCostoEmpresa" id="mesCostoEmpresa" class="form-control sticked">
                        <?php for( $i=1; $i<=12; $i++ ){ ?>
                        <option value="<?php echo $i ?>"><?php echo getNombreMes($i) ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">  
                <label for="anoCostoEmpresa">Año</label>                       
                    <select name="anoCostoEmpresa" id="anoCostoEmpresa" class="form-control sticked">
                        <?php for( $i=(int)date('Y'); $i>=2016; $i-- ){ ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="valorCostoEmpresa">Valor</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                        <input type="number" step="any" class="form-control required" name="valorCostoEmpresa" id="valorCostoEmpresa" />                                
                    </div>
                </div>
              </div><!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Ingresar</button>
              </div>
            </form>
          </div><!-- /.box -->
        </div>
                        
        
        <div class="col-md-6">
          <!-- general form elements -->
            <div class="box" id="box_listado">
                <div class="box-header">
                  <h3 class="box-title">Lista de valores</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding table-responsive">
                  <table class="table table-striped" id="tabla_valores_costos">
                    <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Valor</th>
                          <th>Mes</th>
                          <th>Año</th>       
                          <th> Borrar </th>                   
                        </tr>
                    </thead>
                    <tbody>  
                        <tr>
                            <td colspan="4">Seleccione un costo empresa</td>
                        </tr>                      
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->


        </div>
                        
  </div>   <!-- /.row -->
</section>

</div><!-- /.content-wrapper -->
      
<script>  

$(document).on('click','.btn_delete_costoempresa', function(){
    var costoempresa_id = $(this).data('id');
    var this_tr = $(this).closest('tr');
    var this_btn = $(this);
    if( confirm('¿Borrar el item seleccionado?') ){
        $.ajax({
			type: "POST",
			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
			data: "costoempresa_id="+costoempresa_id+"&action=borrar_costoempresa",
            dataType: 'json',
            beforeSend: function(){
                this_btn.replaceWith('<i class="fa fa-refresh fa-spin"></i>');
            },
			success: function (json) {
			     this_tr.fadeOut(500);
            }
		})
    }
})

$(document).ready(function(){
    $("#costoempresa").change(function(){
        var id_costoempresa = $(this).val();
        $.ajax({
			type: "POST",
			url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
			data: "costoempresa_id="+id_costoempresa+"&action=detalle_x_costo",
            dataType: 'json',
            beforeSend: function(){
                $(".overlayer").show();
            },
			success: function (json) {
			     tbody = '';
                 i=1;
			     if( json.status == 'success' ){
                     $.each(json.registros, function(k,v){
			             tbody += '<tr>';
                         tbody += '<td>'+i+'</td>';
                         tbody += '<td>'+v.valor+'</td>';
                         tbody += '<td>'+v.mes+'</td>';
                         tbody += '<td>'+v.ano+'</td>';
                         tbody += '<td><button data-id="'+v.id+'" type="button" class="btn_delete_costoempresa"><i class="fa fa-trash"></i></button></td>';
                         tbody += '<tr>';
			             i++;
                     })
			     } else {
			         tbody = '<tr><td colspan="4">No existen datos</td></tr>';
			     }
                 $("#tabla_valores_costos tbody").html( tbody );
            
                $(".overlayer").hide();
            }
		})
    })
})
          
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

    if( error == 0 ){
        $(".overlayer").show();
        $("#frmCrear")[0].submit();
    }
})            
</script>
      