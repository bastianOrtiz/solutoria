<!-- Content Wrapper. Contains page content -->       
<div id="listar_tope">
      <div class="content-wrapper">
        
        <section class="content-header">
          <h1> Topes <br /> 
          <span style="font-size: 18px;">Valor UF a <?php echo getNombreMes($valor_uf['mes']).", ".$valor_uf['ano'] ?>: <strong>$<?php echo number_format($valor_uf['valor'],2,',','.') ?></strong></span> 
          </h1>          
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
            <div class="col-md-6">
              
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Rentas Topes Imponibles</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table">
                        <tbody>
                            <tr data-codigo="1">
                              <td>1.</td>
                              <td> Para afiliados a una AFP  </td>
                              <td>
                                <span class="uf" data-db="<?php echo fnGetTope(1); ?>"><?php echo fnGetTope(1); ?></span> UF
                              </td>
                              <td><span class="badge bg-light-blue"> $ <?php echo fnCalculaEnPesos(fnGetTope(1)); ?> </span></td>
                              <td> <button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button> </td>
                            </tr>
                            <tr data-codigo="2">
                              <td>2.</td>
                              <td> Para afiliados al IPS (ex INP)	 </td>
                              <td>
                                <span class="uf" data-db="<?php echo fnGetTope(2); ?>"><?php echo fnGetTope(2); ?></span> UF
                              </td>
                              <td><span class="badge bg-light-blue"> $ <?php echo fnCalculaEnPesos(fnGetTope(2)); ?> </span></td>
                              <td> <button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button> </td>
                            </tr>
                            <tr data-codigo="3">
                              <td>3.</td>
                              <td> Para Seguro de Cesantía </td>
                              <td> <span class="uf" data-db="<?php echo fnGetTope(3); ?>"><?php echo fnGetTope(3); ?></span> UF
                              </td>
                              <td><span class="badge bg-light-blue">$ <?php echo fnCalculaEnPesos(fnGetTope(3)); ?></span></td>
                              <td> <button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button> </td>
                            </tr>
                        
                        </tbody>
                      </table>
                    </div><!-- /.box-body -->
                  </div>
                  
                  <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Ahorro Previsional Voluntario (APV)</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table">
                        <tbody>
                            <tr data-codigo="7">
                              <td>7.</td>
                              <td>Tope Mensual</td>
                              <td> <span class="uf" data-db="<?php echo fnGetTope(7); ?>"><?php echo fnGetTope(7); ?></span> UF </td>
                              <td><span class="badge bg-light-blue">$ <?php echo fnCalculaEnPesos(fnGetTope(7)); ?></span></td>
                              <td> <button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button> </td>
                            </tr>
                            <tr data-codigo="8">
                              <td>8.</td>
                              <td>Tope Anual</td>
                              <td> <span class="uf" data-db="<?php echo fnGetTope(8); ?>"><?php echo fnGetTope(8); ?></span> UF </td>
                              <td><span class="badge bg-light-blue">$ <?php echo fnCalculaEnPesos(fnGetTope(8)); ?></span></td>
                              <td> <button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button> </td>
                            </tr>
                        
                        </tbody>
                      </table>
                    </div><!-- /.box-body -->
                  </div>
                  
            </div>
            
            <div class="col-md-6">
              
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Rentas Mínimas Imponibles</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table">
                        <tbody>
                            <tr data-codigo="4">
                              <td>4.</td>
                              <td>Trab. Dependientes e Independientes</td>
                              <td> &nbsp; </td>
                              <td><span class="badge bg-light-blue">$ <span class="peso" data-db="<?php echo number_format(fnGetTope(4),0,'','.'); ?>"><?php echo number_format(fnGetTope(4),0,'','.'); ?></span></span></td>
                              <td> <button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button> </td>
                            </tr>
                            <tr data-codigo="5">
                              <td>5.</td>
                              <td>Menores de 18 y Mayores de 65</td>
                              <td> &nbsp; </td>
                              <td><span class="badge bg-light-blue">$ <span class="peso" data-db="<?php echo number_format(fnGetTope(5),0,'','.'); ?>"><?php echo number_format(fnGetTope(5),0,'','.'); ?></span></span></td>
                              <td> <button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button> </td>
                            </tr>
                            <tr data-codigo="6">
                              <td>6.</td>
                              <td>Trabajadores de Casa Particular</td>
                              <td> &nbsp; </td>
                              <td><span class="badge bg-light-blue">$ <span class="peso" data-db="<?php echo number_format(fnGetTope(6),0,'','.'); ?>"><?php echo number_format(fnGetTope(6),0,'','.'); ?></span></span></td>
                              <td> <button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button> </td>
                            </tr>
                        </tbody>
                      </table>
                    </div><!-- /.box-body -->
                  </div>
                  
                  <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Depósito Convenido</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body no-padding">
                      <table class="table">
                        <tbody>
                            <tr data-codigo="9">
                              <td>9.</td>
                              <td>Tope Anual</td>
                              <td> <span class="uf" data-db="<?php echo fnGetTope(9); ?>"><?php echo fnGetTope(9); ?></span> UF </td>
                              <td><span class="badge bg-light-blue">$ <?php echo fnCalculaEnPesos(fnGetTope(9)); ?></span></td>
                              <td> <button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button> </td>
                            </tr>
                        
                        </tbody>
                      </table>
                    </div><!-- /.box-body -->
                  </div>
            </div>                    
                  
        </section>
        
      </div><!-- /.content-wrapper -->            
</div>
      
<script>
$(document).ready(function(){
    $(document).on('click', '.btn-cancel', function(){        
        resetTrEditing('cancel');
    })
    
    $(document).on('click', '.btn-save', function(){        
        valor = $(this).closest('tr').find('input[type=number]').val();
        codigo = $(this).closest('tr').find('input[type=number]').data('codigo');
        box = $(this).closest('.box');
        tr = $(this).closest('tr');
        $.ajax({
        	type: "POST",
        	url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
        	data: 'codigo=' + codigo + '&valor='+valor+'&action=add_tope',
            dataType: 'json',
            beforeSend: function(){
                box.append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
            },
        	success: function (json) {
        	    box.find('.overlay').remove();
                //alert(json.pesos);
                tr.find('.badge').text("$ " + json.pesos);
                resetTrEditing('save');                
            }
        })
    })
    
    $(document).on('click', '.btn-edit', function(){      
        resetTrEditing('cancel');
        var codigo = $(this).closest('tr').data('codigo');
        
        $(this).closest('tr').addClass('editing');                
        if( (codigo==4)||(codigo==5)||(codigo==6) ){
            span_value = $(this).closest('tr').find('span.peso').text();
            span_value = span_value.replace(".","");
            span_value = span_value.replace(",","");
            span_value = parseInt(span_value); 
        } else {
            span_value = $(this).closest('tr').find('span.uf').text();
        }        
        
        $(this).closest('tr').find('span.uf').replaceWith('<input data-codigo="'+codigo+'" type="number" class="form-control small uf" value="'+span_value+'" data-db="'+span_value+'" />');                
        if( (codigo==4)||(codigo==5)||(codigo==6) ){
            $(this).closest('tr').find('span.badge').replaceWith('<input data-codigo="'+codigo+'" type="number" class="form-control small uf" value="'+span_value+'" data-db="'+span_value+'" />');    
        }
        $(this).replaceWith('<button class="btn btn-save btn-success"><i class="fa fa-floppy-o"></i></button> <button class="btn btn-cancel btn-default"><i class="fa fa-ban"></i></button>');        
    })    
    
    function resetTrEditing(opt){
        $('tr.editing').each(function(){
            var codigo = $(this).data('codigo');
            
            if( opt == 'cancel' )
                value = $(this).find('input.uf').data('db');
            else
                value = $(this).find('input.uf').val(); 
            
            if( (codigo==4)||(codigo==5)||(codigo==6) ){
                string_peso = numeral(value).format('0,0[.]00');
                string_peso = string_peso.replace(",",".");
                $(this).find('input.uf').replaceWith('<span class="badge bg-light-blue">$<span class="peso">'+string_peso+'</span></span>');
            } else {
                $(this).find('input.uf').replaceWith('<span class="uf">'+value+'</span>');
            }
            $(this).find('.btn-save').replaceWith('<button class="btn btn-sm btn-edit btn-default"><i class="fa fa-pencil"></i></button>');
            $(this).find('.btn-cancel').remove();
            $(this).removeClass('editing');            
        })
    }
    $(document).keyup(function(e) {
         if (e.keyCode == 27) {
            resetTrEditing();
        }
    });
    
})
</script>