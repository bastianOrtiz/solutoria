<style>
.sticked{
    width: 49%;
    float: left;
}
.totales{
    text-align: right; 
    padding-right: 15px;
}
</style>
<div class="content-wrapper">        
        <section class="content-header">
          <h1> REMUNERACIONES X CENTRO COSTO / DFEPARTAMENTO</h1>
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
        
        <form role="form" id="frmCrear" method="post">
        <input type="hidden" name="action" value="remuneraciones-ccosto" />
        
            <div class="box box-primary">                
                <div class="box-header">
                    <h3 class="box-title">Filtros</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label> Desde </label><br class="clear" />  
                            <select name="mesRemuneracionCCosto" id="mesRemuneracionCCosto" class="form-control sticked">
                                <?php for( $i=1; $i<=12; $i++ ){ ?>
                                <option value="<?php echo $i ?>"><?php echo getNombreMes($i) ?></option>
                                <?php } ?>
                            </select>                      
                            <select name="anoRemuneracionCCosto" id="anoRemuneracionCCosto" class="form-control sticked">
                                <?php for( $i=(int)date('Y'); $i>=2016; $i-- ){ ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>                      
                            
                        </div>
                        
                        <div class="col-md-3">
                            <label> Hasta </label><br class="clear" />  
                            <select name="mesRemuneracionCCostoHasta" id="mesRemuneracionCCostoHasta" class="form-control sticked">
                                <?php for( $i=1; $i<=12; $i++ ){ ?>
                                <option value="<?php echo $i ?>"><?php echo getNombreMes($i) ?></option>
                                <?php } ?>
                            </select>                      
                            <select name="anoRemuneracionCCostoHasta" id="anoRemuneracionCCostoHasta" class="form-control sticked">
                                <?php for( $i=(int)date('Y'); $i>=2016; $i-- ){ ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>                      
                            
                        </div>
                        
                        <div class="col-md-3">   
                            <label> C. Costo / Dpto. </label>                     
                            <div class="radio">
                                <label>
                                  <input type="radio" class="rbtCcosto" name="rbtCcosto[]" id="rbtCcostoCcosto" value="centro costo" checked="">
                                  Por Centro Costo
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                  <input type="radio" class="rbtCcosto" name="rbtCcosto[]" id="rbtCcostoDepa" value="departamento">
                                  Por Departamento
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <label> C. Costo / Dpto. </label>
                            <select name="cboCentroCostos" id="cboCentroCostos" class="form-control">
                                <option value="*">Todos los Centro Costo</option>
                                <?php foreach( $ccostos_todos as $c ){ ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['nombre']; ?></option>
                                <?php } ?>
                            </select>
                            
                            <select name="cboDepartamentos" id="cboDepartamentos" class="form-control" style="display: none;">
                                <option value="*">Todos los Departamentos</option>
                                <?php foreach( $departamentos_todos as $d ){ ?>
                                <option value="<?php echo $d['id']; ?>"><?php echo $d['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                                                        
                    </div>                                        
                    
                </div>    
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>                    
            </div>
            
            <?php if( $_POST ){ ?>
            <script>
            $("#mesRemuneracionCCosto").val('<?php echo $mesRemuneracionCCosto; ?>');
            $("#anoRemuneracionCCosto").val('<?php echo $anoRemuneracionCCosto; ?>');
            $("#mesRemuneracionCCostoHasta").val('<?php echo $mesRemuneracionCCostoHasta; ?>');
            $("#anoRemuneracionCCostoHasta").val('<?php echo $anoRemuneracionCCostoHasta; ?>');
            </script>
            <?php } ?>
            
            <?php if( $_POST ){ ?>
            
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Resultados</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>NOMBRE</th>
                            <?php 
                            $fechaINIconcat = $anoRemuneracionCCosto.leadZero($mesRemuneracionCCosto).'28';                            
                            $fechaFINconcat = $anoRemuneracionCCostoHasta.'-'.leadZero($mesRemuneracionCCostoHasta).'-28';
                            
                            $time_ITERAR = strtotime($fechaINIconcat);
                            $time_FIN = strtotime($fechaFINconcat);
                            $column = array();
                            $col = 0;
                            while(  $time_ITERAR <= $time_FIN ){
                            ?>
                            
                                <th style="width: 120px; text-align: right;"><?php echo getNombreMes(date('n',$time_ITERAR)) ?>/<?php echo date('Y',$time_ITERAR); ?></th>
                            
                            <?php           
                                $fechaIterando = date('Y-m-d',$time_ITERAR);
                                $nuevaFecha = sumaMes($fechaIterando,1);
                                $time_ITERAR = strtotime( $nuevaFecha );
                                
                                $column[$col] = 0;
                                
                                $col++;
                            }                                                         
                            
                            ?>
                            <th>AÑO</th>
                            <th><?php echo strtoupper($tipo_ccosto) ?></th>
                            <th style="width: 120px; text-align: right;">TOTAL</th>
                        </tr>
                        <?php 
                        $i=1;
                        $super_total = 0;
                        foreach( $result as $t ){
                        ?>
                        <tr>
                            <td><?php echo $i; ?>.</td>
                            <td><?php echo $t['nombres'].' '.$t['apellidoPaterno'].' '.$t['apellidoMaterno'] ?></td>                                                
                            <?php 
                            $subtotal_row = 0;
                            $time_ITERAR = strtotime($fechaINIconcat);
                            $time_FIN = strtotime($fechaFINconcat);
                            $col = 0;
                            while(  $time_ITERAR <= $time_FIN ){
                                $mes_iterar = date("n", $time_ITERAR);
                                $ano_iterar = date("Y", $time_ITERAR);
                                $alcance_liquido = getAlcanceLiquido( $t['id'],$mes_iterar, $ano_iterar );
                                if($alcance_liquido == ""){
                                    echo '<td style="width: 120px; text-align: right;">$ 0</td>';
                                } else {
                                    $super_total += $alcance_liquido;
                                    $subtotal_row += $alcance_liquido;
                                    echo '<td style="width: 120px; text-align: right;">$ ' . number_format($alcance_liquido,0,',','.') . '</td>';
                                
                                    $column[$col] += $alcance_liquido;
                                } 
                                
                                $fechaIterando = date('Y-m-d',$time_ITERAR);
                                $nuevaFecha = sumaMes($fechaIterando,1);
                                $time_ITERAR = strtotime( $nuevaFecha );                       
                                
                                $col++;
                            } 
                            ?>
                            <td> <?php echo $anoRemuneracionCCosto; ?> </td>
                            <td> <?php echo $t['nombre'] ?> </td>
                            <td class="totales">
                                $ <?php echo number_format($subtotal_row,0,',','.'); ?>
                            </td>
                        </tr>
                        <?php 
                        $i++;
                        }
                        ?>
                    
                  </tbody>
                  
                  <tfoot>                                                        
                    <tr>
                        <th>&nbsp;</th>
                        <th > <strong>Totales</strong> </th>
                        <?php 
                        $time_ITERAR = strtotime($fechaINIconcat);
                        $time_FIN = strtotime($fechaFINconcat);
                        $col = 0;
                        while(  $time_ITERAR <= $time_FIN ){                            
                        ?>
                            <th class="totales"> $ <?php echo number_format($column[$col],0,',','.'); ?> </th>
                        <?php 
                        $fechaIterando = date('Y-m-d',$time_ITERAR);
                        $nuevaFecha = sumaMes($fechaIterando,1);
                        $time_ITERAR = strtotime( $nuevaFecha );                       
                        
                        $col++;
                        } 
                        ?>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th class="totales"><?php echo "$ " . number_format($super_total,0,',','.'); ?></th>
                    </tr>
                  </tfoot>
                  
                  </table>
                </div><!-- /.box-body -->
              </div>
            
            <?php } ?>
            
        </form>
                                            
        </section>
        
      </div><!-- /.content-wrapper -->
      
<script>

$(document).ready(function(){
    
    $(".rbtCcosto").click(function(){        
        if( $(this).attr('id') == "rbtCcostoCcosto" ){
            $("#cboCentroCostos").show();
            $("#cboDepartamentos").hide();
        } else {
            $("#cboCentroCostos").hide();
            $("#cboDepartamentos").show();
        }
    })
    
    $(".dropdown-menu a").click(function(e){
        e.preventDefault();
        var target = $(this).attr('href');
        $(target).val( $(this).data('val') );
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
            $(".overlayer").hide();
        }
    
    })
    
})          
</script>