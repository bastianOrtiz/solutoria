<!-- Content Wrapper. Contains page content -->
<style>
tbody td{
    white-space: nowrap;
}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1> Proceso de Centralizacion </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php include ROOT . '/views/comun/alertas.php';  ?>
    </section>
    <section class="content">
        <div class="box">
            <div class="box-header">
                <a href="<?php echo BASE_URL ?>/<?php echo $entity ?>/totales_x_criterios" class="btn btn-success btn-lg pull-right">
                Siguiente <i class="fa fa-arrow-right"></i> 
                </a>
                <div class="clear clearfix"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table id="tabla_centralizacion_step_one" class="hidden table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>CENTRO COSTO    </th>
                            <th>RUT </th>
                            <th>NOMBRE  </th>
                            <th>BASE    </th>
                            <th>GRATIFICACIÓN   </th>
                            <th>DIAS    </th>
                            <th>IMPONIBLE   </th>
                            <th>CANT.   </th>
                            <th>HORAS EXTRAS    </th>
                            <th>CANT.   </th>
                            <th>HORAS EXTRAS 100%   </th>
                            <th>COMISIONES  </th>
                            <th>SEMANA CORRIDA  </th>
                            <th>BONO IMP    </th>
                            <th>TOTAL IMPONIBLE </th>
                            <th>IMPONIBLE AFC   </th>
                            <th>APV </th>
                            <th>BONO NO IMP     </th>
                            <th>ASIGN. FAMILIAR </th>
                            <th>SIS </th>
                            <th>CESANTIA    </th>
                            <th>ACHS    </th>
                            <th>AFP </th>
                            <th>SALUD    </th>
                            <th>AFP MONTO     </th>
                            <th>DESEMPLEO  </th>
                            <th>SALUD   </th>
                            <th>PLAN EN UF  </th>
                            <th>IMPTO UNICO </th>
                            <th>PTMO CAJA   </th>
                            <th>AHORRO AFP  </th>
                            <th>APV AFP CAPITAL </th>
                            <th>APV METLIFE </th>
                            <th>APV SECURITY        </th>
                            <th>PTMO BCI    </th>
                            <th>CAJA LOS HEROES     </th>
                            <th>A. COMISIONES   </th>
                            <th>PTMO EMP.   </th>
                            <th>ANTICIPO    </th>
                            <th>METILFE </th>
                            <th>CHILENA </th>
                            <th>FALP    </th>
                            <th>ABONO TELEF.    </th>
                            <th>SEG. CARGAS </th>
                            <th>OT.DCTOS.   </th>
                            <th>CELULAR </th>
                            <th>TOTAL A PAG </th>
                            <th>LIQUIDO PAGADO  </th>
                            <th>DIFERENCIA  </th>
                            <th>CHEQUES </th>
                            <th>BCI </th>
                            <th>CHILE </th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>CENTRO COSTO    </th>
                            <th>RUT </th>
                            <th>NOMBRE  </th>
                            <th>BASE    </th>
                            <th>GRATIFICACIÓN   </th>
                            <th>DIAS    </th>
                            <th>IMPONIBLE   </th>
                            <th>CANT.   </th>
                            <th>HORAS EXTRAS    </th>
                            <th>CANT.   </th>
                            <th>HORAS EXTRAS 100%   </th>
                            <th>COMISIONES  </th>
                            <th>SEMANA CORRIDA  </th>
                            <th>BONO IMP    </th>
                            <th>TOTAL IMPONIBLE </th>
                            <th>IMPONIBLE AFC   </th>
                            <th>APV </th>
                            <th>BONO NO IMP     </th>
                            <th>ASIGN. FAMILIAR </th>
                            <th>SIS </th>
                            <th>CESANTIA    </th>
                            <th>ACHS    </th>
                            <th>AFP </th>
                            <th>SALUD    </th>
                            <th>AFP MONTO     </th>
                            <th>DESEMPLEO  </th>
                            <th>SALUD   </th>
                            <th>PLAN EN UF  </th>
                            <th>IMPTO UNICO </th>
                            <th>PTMO CAJA   </th>
                            <th>AHORRO AFP  </th>
                            <th>APV AFP CAPITAL </th>
                            <th>APV METLIFE </th>
                            <th>APV SECURITY        </th>
                            <th>PTMO BCI    </th>
                            <th>CAJA LOS HEROES     </th>
                            <th>A. COMISIONES   </th>
                            <th>PTMO EMP.   </th>
                            <th>ANTICIPO    </th>
                            <th>METILFE </th>
                            <th>CHILENA </th>
                            <th>FALP    </th>
                            <th>ABONO TELEF.    </th>
                            <th>SEG. CARGAS </th>
                            <th>OT.DCTOS.   </th>
                            <th>CELULAR </th>
                            <th>TOTAL A PAG </th>
                            <th>LIQUIDO PAGADO  </th>
                            <th>DIFERENCIA  </th>
                            <th>CHEQUES </th>
                            <th>BCI </th>
                            <th>CHILE </th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($results as $item) { ?>
                        <tr>
                            <td> <?php echo getCCosto($item['centrocosto_id'], 'm_centrocosto') ?> </td>
                            <td> <?php echo $item['rut'] ?> </td>
                            <td> <?php echo getNombreTrabajador($item['trabajador_id']) ?>  </td>
                            <td class="text-right"> <?php echo dinero($item['sueldoBase']) ?></td>
                            <td class="text-right"> <?php echo dinero($item['gratificacion']) ?></td>
                            
                            <td class="text-right"> <?php echo ( 30 - $item['diaLicencia'] - $item['diaAusencia'] ) ?></td>
                            <td class="text-right"> <?php echo dinero($item['totalImponible']) ?></td>
                            <td> CANT. H. EXTRA </td>
                            <td> H. EXTRA MONTO </td>
                            <td>CANT.   </td>
                            <td>HORAS EXTRAS 100%   </td>
                            <td>COMISIONES  </td>
                            <td>SEMANA CORRIDA  </td>
                            <td>BONO IMP    </td>
                            <td>TOTAL IMPONIBLE </td>
                            <td>IMPONIBLE AFC   </td>
                            <td>APV </td>
                            <td>BONO NO IMP     </td>
                            <td>ASIGN. FAMILIAR </td>
                            <td>SIS </td>
                            <td>CESANTIA    </td>
                            <td>ACHS    </td>
                            <td>AFP </td>
                            <td>SALUD    </td>
                            <td>AFP MONTO     </td>
                            <td>DESEMPLEO  </td>
                            <td>SALUD   </td>
                            <td>PLAN EN UF  </td>
                            <td>IMPTO UNICO </td>
                            <td>PTMO CAJA   </td>
                            <td>AHORRO AFP  </td>
                            <td>APV AFP CAPITAL </td>
                            <td>APV METLIFE </td>
                            <td>APV SECURITY        </td>
                            <td>PTMO BCI    </td>
                            <td>CAJA LOS HEROES     </td>
                            <td>A. COMISIONES   </td>
                            <td>PTMO EMP.   </td>
                            <td>ANTICIPO    </td>
                            <td>METILFE </td>
                            <td>CHILENA </td>
                            <td>FALP    </td>
                            <td>ABONO TELEF.    </td>
                            <td>SEG. CARGAS </td>
                            <td>OT.DCTOS.   </td>
                            <td>CELULAR </td>
                            <td>TOTAL A PAG </td>
                            <td>LIQUIDO PAGADO  </td>
                            <td>DIFERENCIA  </td>
                            <td>CHEQUES </td>
                            <td>BCI </td>
                            <td>CHILE </td>
                        </tr>  
                        <?php } ?>                
                    </tbody>
                    
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <a href="<?php echo BASE_URL ?>/<?php echo $entity ?>/totales_x_criterios" class="hidden btn btn-success btn-lg pull-right">
        Siguiente <i class="fa fa-arrow-right"></i> 
        </a>

        <div class="clear clearfix"></div>

    </section>
</div>
<!-- /.content-wrapper -->            

