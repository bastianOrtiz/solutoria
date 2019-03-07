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
        
        
            <section class="content">
                <?php if( !$_POST ){ ?>                
                <form method="post" id="frmSeleccionLiquidacion">
                <input type="hidden" name="trabajador_id" id="trabajador_id" />
                <input type="hidden" name="action" id="action" value="certificado_sueldos" />
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
                    <?php if( $trabajadores_todos_cert_sueldos ){ ?>
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
                                <?php foreach( $trabajadores_todos_cert_sueldos as $reg ){ ?>
                                    <tr data-tr-id="<?php echo $reg['id']?>">
                                        <td> <?php echo $reg['id']?> </td>
                                        <td style="text-transform: uppercase;"> <?php echo ucfirst(strtolower($reg['apellidoPaterno'])) ?> <?php echo $reg['apellidoMaterno'] ?> <?php echo $reg['nombres'] ?>   </td>
                                        <td> <?php echo $reg['rut']?> </td>
                                        <td> <?php echo fnGetNombre($reg['cargo_id'],'m_cargo') ?> </td>
                                        <td> <?php echo fnGetNombre($reg['departamento_id'],'m_departamento') ?> </td>                                
                                        <td class="btn-group-xs">                                                                            
                                            <button class="btn btn-lg btn-info btn_ver_liquidacion" data-toggle="tooltip" data-regid="<?php echo $reg['id']?>" title="Ver certificado"> <i class="fa fa-search"></i> </button>                                                                                                                                                            
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
                </form>

                <?php } else { ?>

                <form method="post" id="frmPrintCertificado" target="_blank">
                    <input type="hidden" name="action" value="certificado_sueldos_print">
                    <input type="hidden" name="trabajador_id" value="<?php echo $trabajador_id; ?>">
                    <input type="hidden" name="ano_certificado" value="<?php echo $ano_certificado ?>">
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
                                        <th col="0"> Periodos </th>
                                        <th col="1"> Sueldo Bruto </th>
                                        <th col="2"> COTIZACIÓN PREVISIONAL O DE SALUD DE CARGO DEL TRABAJADOR </th>
                                        <th col="3"> RENTA  IMPONIBLE AFECTA AL IMPTO. ÚNICO DE  2° CAT.  </th>
                                        <th col="4"> IMPTO ÚNICO RETENIDO</th>
                                        <th col="5"> MAYOR  RETENCION DE IMPTO. SOLICITADA  ART. 88 LIR  </th>
                                        <th col="6"> RENTA TOTAL EXENTA </th>
                                        <th col="7"> RENTA TOTAL NO GRAVADA </th>
                                        <th col="8"> REBAJA POR ZONAS EXTREMAS (Franquicia  D.L. 889) </th>
                                        <th col="9"> FACTOR ACTUALIZACIÓN </th>
                                        <th col="10" style="border-left: 3px solid #eaeaea;"> RENTA AFECTA AL IMPTO.  ÚNICO DE 2° CAT.  </th>
                                        <th col="11"> IMPTO. ÚNICO  RETENIDO </th>
                                        <th col="12"> MAYOR RETENCIÓN DE IMPTO. SOLICITADA ART. 88 LIR </th>
                                        <th col="13"> RENTA TOTAL EXENTA  </th>
                                        <th col="14"> RENTA TOTAL NO GRAVADA  </th>
                                        <th col="15"> REBAJA POR ZONAS EXTREMAS (Franquicia D.L.889)  </th>
                                        
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
                                            <td class="dataCol5"> <input type="text" value="<?php echo number_format($data['col5'],0,',','.') ?>" class="txtCol9" name="txtRentaNoGravada[<?php echo $mes ?>]" style="text-align: right;" readonly> </td>
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
                    <button type="submit" class="btn btn-success pull-right"><i class="fa fa-file-pdf-o"></i> &nbsp; Generar &nbsp; <i class="fa fa-caret-right"></i> </button>
                    <!--<a href="#" class="btn btn-primary pull-left btn_guardar"><i class="fa fa-floppy-o"></i> &nbsp; Guardar &nbsp; </a>-->
                    <div class="clearfix"></div>
                </form>
                <?php } ?>
            </section>
      </div><!-- /.content-wrapper -->

<script>

function recalcularRentaNoGravada(factor, renta){
    total_renta_no_gravada = ( renta * factor );
    return total_renta_no_gravada;
}

$(document).ready(function(){

    $(".btn_guardar").click(function(){
        $.ajax({
            type: "POST",
            url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
            data:  $("#frmPrintCertificado").serialize() + "&action=save_data",
            dataType: 'json',
            beforeSend: function(){
                $(".overlayer").fadeIn(500);
            },
            success: function (json) {
                $(".overlayer").fadeOut(500);
            }
        })
    })

    $(".cbo_liq").change(function(){
        year = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo BASE_URL . '/controllers/ajax/' . $entity . '.ajax.php'?>",
            data: "year="+year+"&action=select_year",
            dataType: 'json',
            beforeSend: function(){
                $(".overlayer").fadeIn(500);
            },
            success: function (json) {
                $("#trabajadores_list tbody tr").show(200);
                $.each(json, function(k,v){
                    $("[data-tr-id="+v.id+"]").hide(500);
                })
                $(".overlayer").fadeOut(500);
            }
        })
    })

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