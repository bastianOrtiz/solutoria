<!-- Content Wrapper. Contains page content -->
<style>
thead th{
    font-size: 12px;
    text-align: center;    
}
<?php if( $_POST ): ?>
tbody td,
tfoot td{
    text-align: right;
}
<?php endif; ?>
</style>
    <div class="content-wrapper">        
        <section class="content-header">
          <h1> Certificado de Sueldos </h1>
          <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        </section>
        
        
        <form method="post" id="frmSeleccionLiquidacion">            
            <input type="hidden" name="trabajador_id" id="trabajador_id" />
            <input type="hidden" name="action" id="action" value="certificado_sueldos" />
            
            <section class="content">
                <?php if( !$_POST ){ ?>                
                 <div class="box">
                    <div class="box-header">
                        <div id="calendar"></div>                    
                        <div class="row">                    
                            <div class="col-md-6">
                                <div class="form-group">                          
                                  <select class="form-control cbo_liq" name="ano_certificado" id="ano_certificado">
                                    <option value="">Seleccione Año</option>
                                    <?php for( $i=2016; $i<=date('Y'); $i++ ){ ?>                             
                                        <option value="<?php echo $i ?>"> <?php echo $i ?> </option>                               
                                    <?php } ?>                                                
                                  </select>
                                </div>
                            </div>
                        </div>
                        
                    </div><!-- /.box-header -->
                </div>
                <div class="box">
                    <div class="box-body table-responsive">                
                    <?php if( $trabajadores_todos ){ ?>
                      <table id="trabajadores_list" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th> ID </th>
                                <th>Nombre</th>                        
                                <th>Rut</th>
                                <th>Cargo</th>
                                <th>Departamento</th>                        
                                <th> Ver </th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php foreach( $trabajadores_todos as $reg ){ ?>
                                    <tr>
                                        <td> <?php echo $reg['id']?> </td>
                                        <td style="text-transform: uppercase;"> <?php echo ucfirst(strtolower($reg['apellidoPaterno'])) ?> <?php echo $reg['apellidoMaterno'] ?> <?php echo $reg['nombres'] ?>   </td>
                                        <td> <?php echo $reg['rut']?> </td>
                                        <td> <?php echo fnGetNombre($reg['cargo_id'],'m_cargo') ?> </td>
                                        <td> <?php echo fnGetNombre($reg['departamento_id'],'m_departamento') ?> </td>                                
                                        <td class="btn-group-xs">                                                                            
                                            <button class="btn btn-lg btn-info btn_ver_liquidacion" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Ver Liquidacion del Trabajador"> <i class="fa fa-search"></i> </button>                                                                                                                                                            
                                        </td>                                                                                                                                                                                                
                                    </tr>
                                <?php } ?>                        
                            </tbody>
                            <tfoot>
                              <tr>
                                <th> ID </th>
                                <th>Nombre</th>
                                <th> Opciones </th>
                              </tr>
                            </tfoot>
                          </table>                    
                      <?php } else { ?>                  
                        <pre> No hay datos disponibles </pre>                    
                      <?php } ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <?php } else { ?>
                <div class="box">
                    <div class="box-header">
                        <strong><?php echo getNombreTrabajador($trabajador_id) ?> - <?php echo $ano_certificado ?></strong>
                        <a href="javascript: history.back()" class="btn btn-primary btn-xs pull-right"><strong> <i class="fa fa-chevron-left"></i> volver</strong></a>
                    </div>
                </div>
                <div class="box">
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>  
                                    <th colspan="10">  </th>
                                    <th colspan="6" style="border-left: 3px solid #eaeaea;"> MONTOS ACTUALIZADOS </th>
                                </tr>
                                <tr>
                                    <th> Periodos </th>
                                    <th> Sueldo Bruto </th>
                                    <th> COTIZACIÓN PREVISIONAL O DE SALUD DE CARGO DEL TRABAJADOR </th>
                                    <th> RENTA  IMPONIBLE AFECTA AL IMPTO. ÚNICO DE  2° CAT.  </th>
                                    <th> IMPTO ÚNICO RETENIDO</th>
                                    <th> MAYOR  RETENCION DE IMPTO. SOLICITADA  ART. 88 LIR  </th>
                                    <th> RENTA TOTAL EXENTA </th>
                                    <th> RENTA TOTAL NO GRAVADA </th>
                                    <th> REBAJA POR ZONAS EXTREMAS (Franquicia  D.L. 889) </th>
                                    <th> FACTOR ACTUALIZACIÓN </th>
                                    <th style="border-left: 3px solid #eaeaea;"> RENTA AFECTA AL IMPTO.  ÚNICO DE 2° CAT.  </th>
                                    <th> IMPTO. ÚNICO  RETENIDO </th>
                                    <th> MAYOR RETENCIÓN DE IMPTO. SOLICITADA ART. 88 LIR </th>
                                    <th> RENTA TOTAL EXENTA  </th>
                                    <th> RENTA TOTAL NO GRAVADA  </th>
                                    <th> REBAJA POR ZONAS EXTREMAS (Franquicia D.L.889)  </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                for( $mes=1; $mes<=12; $mes++ ){ 
                                    $data = getInfoSueldos($ano_certificado, $mes, $trabajador_id);
                                    $totales['col1'] += $data['col1'];
                                    $totales['col2'] += $data['col2'];
                                    $totales['col3'] += $data['col3'];
                                    $totales['col4'] += $data['col4'];
                                    $totales['col5'] += $data['col5'];
                                    $totales['col6'] += $data['col6'];
                                    $totales['col7'] += $data['col7'];
                                    $totales['col8'] += $data['col8'];
                                    $totales['col9'] += $data['col9'];                                
                                    ?>
                                    <tr>
                                        <td class="dataCol0" style="text-align: left;"> <?php echo getNombreMes($mes) ?> </td>
                                        <td class="dataCol1"> <?php echo number_format($data['col1'],0,',','.') ?> </td>
                                        <td class="dataCol2"> <?php echo number_format($data['col2'],0,',','.') ?> </td>
                                        <td class="dataCol3"> <?php echo number_format($data['col3'],0,',','.') ?> </td>
                                        <td class="dataCol4"> <?php echo number_format($data['col4'],0,',','.') ?> </td>
                                        <td style="background: #ffe"> - </td>
                                        <td style="background: #ffe"> - </td>
                                        <td class="dataCol5"> <input type="text" value="<?php echo number_format($data['col5'],0,',','.') ?>" class="txtCol9" name="" style="text-align: right;"> </td>
                                        <td style="background: #ffe"> - </td>
                                        <td class="dataCol6"> <?php echo $data['col6'] ?> </td>
                                        <td class="dataCol7"> <?php echo number_format($data['col7'],0,',','.') ?> </td>
                                        <td class="dataCol7"> <?php echo number_format($data['col8'],0,',','.') ?> </td>
                                        <td style="background: #ffe"> - </td>
                                        <td style="background: #ffe"> - </td>
                                        <td class="dataCol9"> <?php echo number_format($data['col9'],0,',','.') ?> </td>
                                        <td style="background: #ffe"> - </td>
                                        
                                    </tr>
                                <?php } ?>      
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="text-align: left;"> <strong>Totales</strong> </td>
                                    <td> <?php echo number_format($totales['col1'],0,',','.') ?> </td>
                                    <td> <?php echo number_format($totales['col2'],0,',','.') ?> </td>
                                    <td> <?php echo number_format($totales['col3'],0,',','.') ?> </td>
                                    <td> <?php echo number_format($totales['col4'],0,',','.') ?> </td>
                                    <td style="background: #ffe"> - </td>
                                    <td style="background: #ffe"> - </td>
                                    <td class="totalRenta"> <?php echo number_format($totales['col5'],0,',','.') ?> </td>
                                    <td style="background: #ffe"> - </td>
                                    <td>  </td>
                                    <td> <?php echo number_format($totales['col7'],0,',','.') ?> </td>
                                    <td> <?php echo number_format($totales['col8'],0,',','.') ?> </td>
                                    <td style="background: #ffe"> - </td>
                                    <td style="background: #ffe"> - </td>
                                    <td class="totalRentaNoGravada"> <?php echo number_format($totales['col9'],0,',','.') ?> </td>
                                    <td style="background: #ffe"> - </td>
                                    
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <?php } ?>                                                
                                                          
            </section>
        </form>
        
      </div><!-- /.content-wrapper -->

<script>

function recalcularRentaNoGravada(factor, renta){
    total_renta_no_gravada = ( renta * factor );

    return total_renta_no_gravada;
}

$(document).ready(function(){

    $(".txtCol9").focus(function(){
        $(this).val( $(this).val().replace(".","") );
    })

    $(".txtCol9").blur(function(){
        valor = $(this).val();
        factor = $(this).closest('tr').find('.dataCol6').text();

        // Recalcula la renta no gravada de ESTA fila
        nuevaRenta = recalcularRentaNoGravada(factor,valor);
        nuevaRenta = numeral( nuevaRenta ).format('0,0');
        nuevaRenta = nuevaRenta.replace(",",".");
        $(this).closest('tr').find('.dataCol9').text(nuevaRenta);


        // Vuelve a sumar todas las rentas no gravadas
        total_renta = 0;
        $(".txtCol9").each(function(){
            thisVal = $(this).val().replace(".","");
            thisVal = parseInt(thisVal);

            total_renta += thisVal;
        })
        total_renta = numeral( total_renta ).format('0,0');
        total_renta = total_renta.replace(",",".");

        $(".totalRenta").text(total_renta);


        // Recalcula el total de las rentas de todas las filas ya aplicado el factor
        total_renta_con_factor = 0;
        $(".dataCol9").each(function(){
            thisVal = $(this).text().replace(".","");
            thisVal = parseInt(thisVal);

            total_renta_con_factor += thisVal;
        })
        total_renta_con_factor = numeral( total_renta_con_factor ).format('0,0');
        total_renta_con_factor = total_renta_con_factor.replace(",",".");

        $(".totalRentaNoGravada").text(total_renta_con_factor);



        // Al final vuelve a dejar el numero formateado con punto
        num_format = numeral( valor ).format('0,0');
        num_format = num_format.replace(",",".");
        $(this).val(num_format);
    })
    
    $(".btn_ver_liquidacion").click(function(e){
        e.preventDefault();
         $("#trabajador_id").val( $(this).data('regid') );
         if( $("#ano_certificado").val() == "" ){
            alert("Seleccione un año primero");
         } else {
            $("#frmSeleccionLiquidacion")[0].submit();   
         }
         
    });

    $(function () {        
        $('#trabajadores_list').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false,
            "pageLength": 30
        });
    });

})


</script>      