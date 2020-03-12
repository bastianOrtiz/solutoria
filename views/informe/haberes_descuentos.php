<style>
.select2-container .select2-selection--single{
  height: 32px;
}
.select2-container .select2-selection--single > span{
    line-height: 32px;
}


.tr_anual td{
    background-color: #c3ffc5;
}
.tr_mensual td{
    background-color: #fff4b0;
}

</style>
<div class="content-wrapper">
    <section class="content-header">
      <h1> REPORTE HABERES / DESCUENTOS</h1>
      <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
      
        <?php 
        if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
        $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
        ?>
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4> <i class="icon fa fa-check"></i> Mensaje:</h4>
            <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
    </section>
                
    <section class="content">
        
            <div class="row">
                <div class="col-md-12">                                      
                    <div class="box">
                        <div class="box-body">
                            <div class="col-md-12">
                                
                                    <?php if($_POST): ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <?php 
                                        foreach($arr_parametros as $param){ 
                                            echo "<strong>".$param['nombre'].": </strong>" . $param['valor'] . "<br />";    
                                        } 
                                        ?>
                                        <p>&nbsp;</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-xs-6">
                                            <a href="<?php echo BASE_URL ?>/informe/haberes_descuentos" class="btn btn-primary btn-md"> <i class="fa fa-chevron-left"></i> Volver</a>
                                        </div>
                                        <div class="col-lg-6 col-xs-6 text-right">
                                            <form method="post" target="_blank" style="display: inline-block;">
                                                <input type="hidden" name="action" value="haberes_descuentos_pdf" />
                                                <button type="submit" class="btn btn-primary btn-md">Exportar a PDF</button>
                                            </form>
                                            
                                            <form method="post" style="display: inline-block;">
                                                <input type="hidden" name="action" value="haberes_descuentos_excel" />
                                                <button type="submit" class="btn btn-primary btn-md">Exportar a EXCEL</button>
                                            </form>
                                            <br /><br />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php if($results['registros']): ?>
                                            <table class="table table-bordered table-striped" id="tableReporte">
                                                <thead>
                                                    <tr>
                                                        <th> Nombre de Haber o Descuento </th>
                                                        <th> Año </th>
                                                        <th> Mes </th>
                                                        <th> Rut </th>
                                                        <th> Nombre Completo </th>
                                                        <th> Monto </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $i=0;
                                                    $sumatoria = 0;
                                                    $ano0 = $results['registros'][0]['ano'];
                                                    $mes0 = $results['registros'][0]['mes'];
                                                    $tot_anual = 0;
                                                    $tot_mensual = 0;
                                                        
                                                    foreach ($results['registros'] as $key => $result) :
                                                        
                                                        if( $consolidado == 'M' ){
                                                            if( $result['mes'] != $mes0 ){
                                                            ?>
                                                            <tr class="tr_mensual">
                                                                <td colspan="4">&nbsp; </td>
                                                                <td><strong>Total Mes <?php echo getNombreMes($mes0); ?></strong></td>
                                                                <td style="text-align: right;"><strong>$ <?php echo number_format($tot_mensual,0,',','.'); ?></strong></td>
                                                            </tr>
                                                            <?php
                                                            $tot_mensual = 0;
                                                            $mes0 = $result['mes'];
                                                            }
                                                        }
                                                        
                                                        
                                                        
                                                        if( $consolidado == 'A' ){    
                                                            if( $result['ano'] != $ano0 ){
                                                            ?>
                                                            <tr class="tr_anual">
                                                                <td colspan="4">&nbsp; </td>
                                                                <td><strong>Total año <?php echo $ano0; ?></strong></td>
                                                                <td style="text-align: right;"><strong>$ <?php echo number_format($tot_anual,0,',','.'); ?></strong></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        
                                                        
                                                        $tot_anual = 0;
                                                        $ano0 = $result['ano'];
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td> <?php echo $result['nombre'] ?> </td>
                                                            <td> <?php echo $result['ano'] ?> </td>
                                                            <td> <?php echo getNombreMes($result['mes']) ?> </td>
                                                            <td> <?php echo $result['rut'] ?> </td>
                                                            <td> <?php echo $result['nombreCompleto'] ?> </td>
                                                            <td style="text-align: right;"> $ <?php echo number_format($result['monto'],0,',','.') ?> </td>
                                                        </tr>
                                                        <?php 
                                                        
                                                        
                                                        
                                                        $sumatoria += ($result['monto']);
                                                        
                                                        
                                                        
                                                        if( $consolidado == 'A' ){
                                                            $tot_anual += $result['monto'];
                                                        }
                                                        
                                                        if( $consolidado == 'M' ){
                                                            $tot_mensual += $result['monto'];
                                                        }
                                                        
                                                        
                                                        

                                                        if( $i == (count($results['registros'])-1) ){
                                                            
                                                            if( $consolidado == 'M' ){
                                                            ?>
                                                            <tr class="tr_mensual">
                                                                <td colspan="4">&nbsp; </td>
                                                                <td><strong>Total mes<?php echo getNombreMes($mes0); ?></strong></td>
                                                                <td style="text-align: right;"><strong>$ <?php echo number_format($tot_mensual,0,',','.'); ?></strong></td>
                                                            </tr>
                                                            <?php } ?>
                                                            
                                                            
                                                            <?php if( $consolidado == 'A' ){ ?>
                                                            <tr class="tr_anual">
                                                                <td colspan="4">&nbsp; </td>
                                                                <td><strong>Total año <?php echo $ano0; ?></strong></td>
                                                                <td style="text-align: right;"><strong>$ <?php echo number_format($tot_anual,0,',','.'); ?></strong></td>
                                                            </tr>
                                                            <?php
                                                            }
                                                            
                                                            
                                                            if( $consolidado == 'A' ){
                                                                $ano0 = $result['ano'];
                                                            }
                                                            
                                                            if( $consolidado == 'M' ){
                                                                $mes0 = $result['mes'];
                                                            }
                                                        }
                                                        
                                                        
                                                        
                                                        $i++;
                                                    endforeach; 
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4"> &nbsp; </th>
                                                        <th class="text-right"> <strong>Total:</strong> </th>
                                                        <th class="text-right"> $ <?php echo number_format($sumatoria,0,',','.'); ?> </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <?php else: ?>
                                            <div class="callout callout-warning">
                                                <p>No existen registros con los filtros seleccionados</p>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="<?php echo BASE_URL ?>/informe/haberes_descuentos" class="btn btn-primary btn-md"> <i class="fa fa-chevron-left"></i> Volver</a>
                                        </div>
                                    </div>
                                    
                                    <?php else: ?>
                                    
                                    <form role="form" id="frmHaberesDescuentos" method="post">
                                        <input type="hidden" name="action" id="action" value="haberes_descuentos" />
                                        <input type="hidden" name="hdnTipoMovimiento" id="hdnTipoMovimiento" value="" />
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-4 cols-xs-12">
                                                <div class="form-group">
                                                    <label> Empresa </label>
                                                    <select class="form-control" name="empresa">
                                                        <option value="<?php echo $_SESSION[PREFIX.'login_eid'] ?>"><?php echo $_SESSION[PREFIX.'login_empresa'] ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-4 cols-xs-12">
                                                <label> Descuento o Haber </label>
                                                <select class="form-control" id="cboHaberesDescuentos" name="cboHaberesDescuentos" required>
                                                    <option value="">Seleccione Haber o Descuento</option>
                                                    <optgroup label="Haberes">
                                                        <?php foreach ($haberes as $haber) { ?>
                                                        <option value="<?php echo $haber['id'] ?>"> <?php echo $haber['nombre'] ?> </option>
                                                        <?php } ?>
                                                    </optgroup>
                                                    <optgroup label="Descuentos">
                                                        <?php foreach ($descuentos as $descuento) { ?>
                                                        <option value="<?php echo $descuento['id'] ?>"> <?php echo $descuento['nombre'] ?> </option>
                                                        <?php } ?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-sm-4 cols-xs-12">
                                                <label>Trabajador</label>
                                                <select class="form-control" id="cboTrabajadores" name="cboTrabajadores">
                                                    <option value="">TODOS</option>
                                                    <?php foreach ($trabajadores_todos_cert_sueldos as $trabajador) { ?>
                                                    <option value="<?php echo $trabajador['id'] ?>"><?php echo $trabajador['apellidoPaterno'] ?> <?php echo $trabajador['apellidoMaterno'] ?> <?php echo $trabajador['nombres'] ?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-4 cols-xs-12">
                                                <label>Fecha Inicio</label>
                                                <div class="row">
                                                    <div class="col-lg-6 col-xs-6">
                                                        <select class="form-control dateReport" name="anoIni" id="anoIni">
                                                            <option value="">Año</option>
                                                            <?php for($i=2016;$i<=2019;$i++): ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 col-xs-6">
                                                        <select class="form-control dateReport" name="mesIni" id="mesIni">
                                                            <option value="">Mes</option>
                                                            <?php for($i=1;$i<=12;$i++): ?>
                                                            <option value="<?php echo $i; ?>"><?php echo getNombreMes($i); ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-4 cols-xs-12">
                                                <label>Fecha Fin</label>
                                                <div class="row">
                                                    <div class="col-lg-6 col-xs-6">
                                                        <select class="form-control dateReport" name="anoFin" id="anoFin">
                                                            <option value="">Año</option>
                                                            <?php for($i=2016;$i<=2019;$i++): ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 col-xs-6">
                                                        <select class="form-control dateReport" name="mesFin" id="mesFin">
                                                            <option value="">Mes</option>
                                                            <?php for($i=1;$i<=12;$i++): ?>
                                                            <option value="<?php echo $i; ?>"><?php echo getNombreMes($i); ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="col-lg-4 col-sm-4 col-xs-12">
                                                <div class="radio">
                                                  <label>
                                                    <input type="radio" value="A" name="consolidado[]" checked> Totalizado x Año
                                                  </label>
                                                </div>
                                                <div class="radio">
                                                  <label>
                                                    <input type="radio" value="M" name="consolidado[]"> Totalizado x Mes
                                                  </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <button class="btn btn-primary btn-lg pull-right">Enviar</button>
                                            </div>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>         

                        </div>                                            
                    </div>                      
                
                </div>
            </div>
        
</section>
        
</div><!-- /.content-wrapper -->
      
<script>
$(document).ready(function(){ 
    
    $("#cboHaberesDescuentos").change(function(){
        var selectedOption = $('#cboHaberesDescuentos option:selected');
        var label = selectedOption.closest('optgroup').attr('label');
        $("#hdnTipoMovimiento").val(label);
    })

    $("#frmHaberesDescuentos").submit(function(e){
        e.preventDefault();
        err=0;
        $(".overlayer").show();
        $(".hdnValue").each(function(){
            if($(this).val()==""){
                err++;
            }
        })
        if( err == 0 ){
            $("#frmHaberesDescuentos")[0].submit();
        } else {
            alert('Seleccione mes y Año');
            $(".overlayer").hide();
            return false;
        }
    })

    $("#cboHaberesDescuentos, #cboTrabajadores").select2();

})


            
</script>
      