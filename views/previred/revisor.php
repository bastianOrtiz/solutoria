<style>
#table-previred th,
#table-previred td{
    white-space: nowrap;
}


.DTFC_LeftBodyWrapper{
    background: rgb(255,255,255) !important;
}
.overlay{
    display: block;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    background: rgba(255,255,255,0.8);
    z-index: 9999;
}
.overlay i.fa{
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -45px 0 0 -45px;
    font-size: 70px;
    color: #367fa9;
    z-index: 10000;
}
</style>
<?php if( $revisor ):  ?>
<div class="overlay"><i class="fa fa-spin fa-cog"></i></div>
<?php endif; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1> Subir Archivo Previred </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php 
            if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
            $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
            ?>
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
            <h4>  <i class="icon fa fa-check"></i> Mensaje:</h4>
            <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php if( $revisor ):  ?>
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="table-responsive">
                            <form method="post" action="">
                                <input type="hidden" name="action" value="generar_archivo_previred">
                                <table class="table table-bordered table-hover" id="table-previred">
                                    <thead>
                                        <tr>
                                            <th> Rut </th>
                                            <th> Apellido P. </th>
                                            <th> Apellido M. </th>
                                            <th> Nombres </th>
                                            <th> Sexo </th>
                                            <th> Extranjero </th>
                                            <th> Tipo <br> Pago </th>
                                            <th> Período <br> (Desde)  </th>
                                            <th> Período <br> (Hasta)  </th>
                                            <th> Regimen <br> Previsional  </th>
                                            <th> Tipo <br> Trabajador  </th>
                                            <th> Dias <br> Trabajados  </th>
                                            <th> Tipo <br> Linea  </th>
                                            <th> Codigo Mov.  <br>de Personal  </th>
                                            <th> Fecha <br> Desde  </th>
                                            <th> Fecha <br> Hasta  </th>
                                            <th> Tramo Asig. <br> Familiar </th>
                                            <th> Nro. Cargas <br> Simples </th>
                                            <th> Nro. Cargas <br> Maternales </th>

                                            <th> Nro. Cargas <br> Inválidas </th>

                                            <th> Asignación Familiar </th>
                                            <th> Asignación Familiar  <br> Retroactiva </th>
                                            <th> Reintegro Cargas <br> Familiares </th>
                                            <th> Solicitud Trabajador <br> Joven </th>
                                            <th> Código AFP </th>
                                            <th> Renta imponible <br>AFP </th>
                                            <th> Cotizac. Obligatoria<br>AFP </th>
                                            <th> Cotizac. SIS </th>
                                            <th> Ahorro Voluntario <br> AFP </th>
                                            <th> Renta Imp. <br> Sust. AFP </th>
                                            <th> Tasa Pactada <br> (Sustit.) </th>
                                            <th> Aporte Indemn. <br> (Sustit.) </th>
                                            <th> N° Períodos <br> (Sustit.) </th>
                                            <th> Período Desde <br> (Sustit.) </th>
                                            <th> Período Hasta <br> (Sustit.) </th>
                                            <th> Puesto  <br>de Trabajo Pesado </th>
                                            <th> % Cotización <br> Trabajo Pesado </th>
                                            <th> Cotización <br> Trabajo Pesado </th>
                                            <th> Código Institución <br> APVI </th>
                                            <th> Número de Contrato <br> APVI </th>
                                            <th> Forma de Pago <br> APVI </th>
                                            <th> Cotización <br> APVI </th>
                                            <th> Cotización Depósitos <br> Convencidos </th>
                                            <th> Código Institución <br> Autorizada APVC </th>
                                            <th> Nro Contrato <br> APVC </th>

                                            <th> Forma de Pago APVC </th>
                                            <th> Cotización Trabajador APVC </th>
                                            <th> Cotización Empleador APVC </th>
                                            <th> RUT Afiliado Voluntario </th>
                                            <th> DV Afiliado Voluntario </th>
                                            <th> Apellido Paterno Af voluntario </th>
                                            <th> Apellido Materno Af voluntario </th>
                                            <th> Nombres Af Voluntario </th>
                                            <th> Código Movimiento de Personal </th>
                                            <th> Fecha Desde movimiento </th>
                                            <th> Fecha Hasta movimiento </th>
                                            <th> Código de la AFP </th>
                                            <th> Monto Capitalización Voluntaria </th>
                                            <th> Monto Ahorro Voluntario </th>
                                            <th> Número de períodos de cotización </th>
                                            <th> Código Ex-Caja Régimen </th>
                                            <th> Tasa Cotización Ex-Cajas de Previsión </th>
                                            <th> Renta Imponible IPS </th>
                                            <th> Cotización Obligatoria IPS </th>
                                            <th> Renta Imponible Desahucio </th>
                                            <th> Código Ex-Caja Régimen Desahucio </th>
                                            <th> Tasa Cotizac Desahucio Ex-Cajas Previsión </th>
                                            <th> Cotización Desahucio </th>
                                            <th> Cotización Fonasa </th>
                                            <th> Cotización Acc. Trabajo (ISL) </th>
                                            <th> Bonificación Ley 15.386 </th>
                                            <th> Descuento por cargas familiares (ISL) </th>
                                            <th> Bonos de Gobierno </th>
                                            <th> Código Institución de Salud </th>
                                            <th> Número de FUN </th>
                                            <th> Renta Imponible Isapre </th>
                                            <th> Moneda del plan pactado Isapre </th>
                                            <th> Cotización Pactada </th>
                                            <th> Cotización Obligatoria Isapre </th>
                                            <th> Cotización Adicional Voluntaria </th>
                                            <th> Monto GES (Futuro) </th>
                                            <th> Código CCAF </th>
                                            <th> Renta Imponible CCAF </th>
                                            <th> Créditos Personales CCAF </th>
                                            <th> Dscto Dental CCAF </th>
                                            <th> Dsctos por Leasing </th>
                                            <th> Dsctos por seguro de vida CCAF </th>
                                            <th> Otros descuentos CCAF </th>
                                            <th> Cotizac a CCAF no afiliados Isapres </th>
                                            <th> Descuento Cargas Familiares CCAF </th>
                                            <th> Otros descuentos CCAF 1 (Futuro) </th>
                                            <th> Otros descuentos CCAF 2 (Futuro) </th>
                                            <th> Bonos Gobierno (Futuro) </th>
                                            <th> Código de Sucursal (Futuro) </th>
                                            <th> Código Mutualidad </th>
                                            <th> Renta Imponible Mutual </th>
                                            <th> Cotización MUTUAL </th>
                                            <th> Sucursal para pago Mutual </th>
                                            <th> Renta Imp Seguro Cesantía </th>
                                            <th> Aporte Trabajador Seguro Cesantía </th>
                                            <th> Aporte Empleador Seguro Cesantía </th>
                                            <th> Rut Pagadora Subsidio </th>
                                            <th> DV Pagadora Subsidio </th>
                                            <th> CCostos, Suc, Agencia, Obra, Región </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($revisor as $key => $value) : ?>
                                        <tr>
                                            <td> 
                                                <input type="hidden" name="rut[]" value="<?php echo substr($value, 0, 11); ?>">
                                                <input type="hidden" name="dv[]" value="<?php echo substr($value, 11, 1); ?>">
                                                <?php echo substr($value, 0, 11); ?>-<?php echo substr($value, 11, 1); ?>
                                            </td>
                                            <td> 
                                                <input type="hidden" name="apellido_paterno[]" value="<?php echo utf8_encode(substr($value, 12, 30)); // Ap. Pat. ?>">
                                                <?php echo utf8_encode(substr($value, 12, 30)); // Ap. Pat. ?> 
                                            </td>
                                            <td> 
                                                <input type="hidden" name="apellido_materno[]" value="<?php echo utf8_encode(substr($value, 42, 30)); // Ap. Mat. ?>">
                                                <?php echo utf8_encode(substr($value, 42, 30)); // Ap. Mat. ?>
                                            </td>
                                            <td> 
                                                <input type="hidden" name="nombres[]" value="<?php echo utf8_encode(substr($value, 72, 30)); // Nombres ?>">
                                                <?php echo utf8_encode(substr($value, 72, 30)); // Nombres  ?>
                                            </td>
                                            <td> <input type="text" name="sexo[]" value="<?php echo substr($value, 102, 1); // Sexo  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="extranjero[]" value="<?php echo substr($value, 103, 1); // Extranjero  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="tipo_pago[]" value="<?php echo substr($value, 104, 2); // Tipo Pago  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="periodo_desde[]" value="<?php echo substr($value, 106, 6); // Periodo Desde  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="periodo_hasta[]" value="<?php echo substr($value, 112, 6); // Periodo Hasta ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="regimen_prev[]" value="<?php echo substr($value, 118, 3); // Regimen Prev. ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="tipo_trabajador[]" value="<?php echo substr($value, 121, 1); // Tipo Trabajador  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="dias_trabajados[]" value="<?php echo substr($value, 122, 2); // Dias Trabajados  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="tipo_linea[]" value="<?php echo substr($value, 124, 2); // Tipo Linea  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="cod_mov_personal[]" value="<?php echo substr($value, 126, 2); // Codigo Mov. de Personal  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="fecha_desde[]" value="<?php echo substr($value, 128,10); // Fecha Desde  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="fecha_hasta[]" value="<?php echo substr($value, 138,10); // Fecha Hasta  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="tramo_asig_fam[]" value="<?php echo substr($value, 148,1); // Tramo Asig. Familiar  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="nro_cargas_simples[]" value="<?php echo substr($value, 149,2); // Nro. Cargas Simples  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="nro_cargas_maternales[]" value="<?php echo substr($value, 151,1); // Nro. Cargas Maternales  ?>" class="form-control" style="width: 100px"> </td>
                                            
                                            <td> <input type="text" name="nro_cargas_invalidas[]" value="<?php echo substr($value, 152,1); // Nro. Cargas Invalidas  ?>" class="form-control" style="width: 100px"> </td>
                                            
                                            <td> <input type="text" name="asig_familiar[]" value="<?php echo substr($value, 153,6); // Asignación Familiar  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="asig_familiar_retro[]" value="<?php echo substr($value, 159,6); // Asignación Familiar retro  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="reintegro_cargas_fam[]" value="<?php echo substr($value, 165,6); // Reintegro Cargas Familiares  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="solicitud_trabajador_joven[]" value="<?php echo substr($value, 171,1); // Solicitud Trabajador Joven  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="codigo_afp[]" value="<?php echo substr($value, 172,2); // Codigo AFP  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="renta_imponible_afp[]" value="<?php echo substr($value, 174,8); // Renta imponible AFP  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="cotizacion_obligatoria_afp[]" value="<?php echo substr($value, 182,8); // Cotizac. Obligatoria AFP  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="cotizacion_sis[]" value="<?php echo substr($value, 190,8); // Cotizac. SIS  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="apv_afp[]" value="<?php echo substr($value, 198,8); // Ahorro voluntario AFP  ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="renta_imponible_sust_afp[]" value="<?php echo substr($value, 206,8); // Renta Imp. Sust. AFP ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="tasa_pactada_sust[]" value="<?php echo substr($value, 214,5); // Tasa Pactada (Sustit.) ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="aporte_indem_sust[]" value="<?php echo substr($value, 219,9); // Aporte Indemn. (Sustit.) ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="nro_periodo_sust[]" value="<?php echo substr($value, 228,2); // N° Períodos (Sustit.) ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="periodo_desde_sust[]" value="<?php echo substr($value, 230,10); // Período Desde (Sustit.) ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="periodo_hasta_sust[]" value="<?php echo substr($value, 240,10); // Período Hasta (Sustit.) ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="puesto_trabajo_pesado[]" value="<?php echo substr($value, 250,40); // Puesto de Trabajo Pesado ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="percent_cotizac_trabajo_pesado[]" value="<?php echo substr($value, 290,5); // % Cotización Trabajo Pesado ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="cotizacion_trabajo_pesado[]" value="<?php echo substr($value, 295,6); // Cotización Trabajo Pesado ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="codigo_inst_apvi[]" value="<?php echo substr($value, 301,3); // Código de la Institución APVI ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="nro_contrato_apvi[]" value="<?php echo substr($value, 304,20); // Número de Contrato APVI ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="forma_pago_apvi[]" value="<?php echo substr($value, 324,1); // Forma de Pago APVI ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="cotizacion_apvi[]" value="<?php echo substr($value, 325,8); // Cotización APVI ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="cotizacion_depositos_convencidos[]" value="<?php echo substr($value, 333,8); // Cotización Depósitos Convencidos ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="cod_inst_autorizada_apvc[]" value="<?php echo substr($value, 341,3); // Código Institución Autorizada APVC ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="nro_contrato_apvc[]" value="<?php echo substr($value, 344,20); // Nro Contrato APVC ?>" class="form-control" style="width: 100px"> </td>
                                            <td> <input type="text" name="forma_de_pago_apvc[]" value="<?php echo substr($value, 364,1); // Forma_de_Pago_APVC ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_trabajador_apvc[]" value="<?php echo substr($value, 365,8); // Cotización_Trabajador_APVC ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_empleador_apvc[]" value="<?php echo substr($value, 373,8); // Cotización_Empleador_APVC ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="rut_afiliado_voluntario[]" value="<?php echo substr($value, 381,11); // RUT_Afiliado_Voluntario ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="dv_afiliado_voluntario[]" value="<?php echo substr($value, 392,1); // DV_Afiliado_Voluntario ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="apellido_paterno_af_voluntario[]" value="<?php echo substr($value, 393,30); // Apellido_Paterno_Af_voluntario ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="apellido_materno_af_voluntario[]" value="<?php echo substr($value, 423,30); // Apellido_Materno_Af_voluntario ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="nombres_af_voluntario[]" value="<?php echo substr($value, 453,30); // Nombres_Af_Voluntario ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="codigo_movimiento_de_personal[]" value="<?php echo substr($value, 483,2); // Código_Movimiento_de_Personal ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="fecha_desde_movimiento[]" value="<?php echo substr($value, 485,10); // Fecha_Desde_movimiento ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="fecha_hasta_movimiento[]" value="<?php echo substr($value, 495,10); // Fecha_Hasta_movimiento ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="codigo_de_la_afp[]" value="<?php echo substr($value, 497,2); // Código_de_la_AFP ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="monto_capitalizacion_voluntaria[]" value="<?php echo substr($value, 499,8); // Monto_Capitalización_Voluntaria ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="monto_ahorro_voluntario[]" value="<?php echo substr($value, 507,8); // Monto_Ahorro_Voluntario ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="numero_de_periodos_de_cotizacion[]" value="<?php echo substr($value, 515,2); // Número_de_períodos_de_cotización ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="codigo_ex_caja_regimen[]" value="<?php echo substr($value, 516,4); // Código_Ex-Caja_Régimen ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="tasa_cotizacion_ex_cajas_de_prevision[]" value="<?php echo substr($value, 520,5); // Tasa_Cotización_Ex-Cajas_de_Previsión ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="renta_imponible_ips[]" value="<?php echo substr($value, 525,8); // Renta_Imponible_IPS ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_obligatoria_ips[]" value="<?php echo substr($value, 533,8); // Cotización_Obligatoria_IPS ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="renta_imponible_desahucio[]" value="<?php echo substr($value, 541,8); // Renta_Imponible_Desahucio ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="codigo_ex_caja_regimen_desahucio[]" value="<?php echo substr($value, 549,4); // Código_Ex-Caja_Régimen_Desahucio ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="tasa_cotizac_desahucio_ex_cajas_prevision[]" value="<?php echo substr($value, 554,5); // Tasa_Cotizac_Desahucio_Ex-Cajas_Previsión ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_desahucio[]" value="<?php echo substr($value, 559,8); // Cotización_Desahucio ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_fonasa[]" value="<?php echo substr($value, 566,8); // Cotización_Fonasa ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_acc__trabajo_isl[]" value="<?php echo substr($value, 575,8); // Cotización_Acc._Trabajo_(ISL) ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="bonificacion_ley_15_386[]" value="<?php echo substr($value, 583,8); // Bonificación_Ley_15.386 ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="descuento_por_cargas_familiares_isl[]" value="<?php echo substr($value, 591,8); // Descuento_por_cargas_familiares_(ISL) ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="bonos_de_gobierno[]" value="<?php echo substr($value, 599,8); // Bonos_de_Gobierno ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="codigo_institucion_de_salud[]" value="<?php echo substr($value, 607,2); // Código_Institución_de_Salud ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="numero_de_fun[]" value="<?php echo substr($value, 609,16); // Número_de_FUN ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="renta_imponible_isapre[]" value="<?php echo substr($value, 625,8); // Renta_Imponible_Isapre ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="moneda_del_plan_pactado_isapre[]" value="<?php echo substr($value, 633,1); // Moneda_del_plan_pactado_Isapre ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_pactada[]" value="<?php echo substr($value, 634,8); // Cotización_Pactada ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_obligatoria_isapre[]" value="<?php echo substr($value, 642,8); // Cotización_Obligatoria_Isapre ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_adicional_voluntaria[]" value="<?php echo substr($value, 650,8); // Cotización_Adicional_Voluntaria ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="monto_ges_futuro[]" value="<?php echo substr($value, 658,8); // Monto_GES_(Futuro) ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="codigo_ccaf[]" value="<?php echo substr($value, 666,2); // Código_CCAF ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="renta_imponible_ccaf[]" value="<?php echo substr($value, 668,8); // Renta_Imponible_CCAF ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="creditos_personales_ccaf[]" value="<?php echo substr($value, 676,8); // Créditos_Personales_CCAF ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="dscto_dental_ccaf[]" value="<?php echo substr($value, 684,8); // Dscto_Dental_CCAF ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="dsctos_por_leasing[]" value="<?php echo substr($value, 692,8); // Dsctos_por_Leasing ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="dsctos_por_seguro_de_vida_ccaf[]" value="<?php echo substr($value, 700,8); // Dsctos_por_seguro_de_vida_CCAF ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="otros_descuentos_ccaf[]" value="<?php echo substr($value, 708,8); // Otros_descuentos_CCAF ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizac_a_ccaf_no_afiliados_isapres[]" value="<?php echo substr($value, 716,8); // Cotizac_a_CCAF_no_afiliados_Isapres ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="descuento_cargas_familiares_ccaf[]" value="<?php echo substr($value, 724,8); // Descuento_Cargas_Familiares_CCAF ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="otros_descuentos_ccaf_1_futuro[]" value="<?php echo substr($value, 732,8); // Otros_descuentos_CCAF_1_(Futuro) ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="otros_descuentos_ccaf_2_futuro[]" value="<?php echo substr($value, 740,8); // Otros_descuentos_CCAF_2_(Futuro) ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="bonos_gobierno_futuro[]" value="<?php echo substr($value, 748,8); // Bonos_Gobierno_(Futuro) ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="codigo_de_sucursal_futuro[]" value="<?php echo substr($value, 756,20); // Código_de_Sucursal_(Futuro) ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="codigo_mutualidad[]" value="<?php echo substr($value, 776,2); // Código_Mutualidad ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="renta_imponible_mutual[]" value="<?php echo substr($value, 778,8); // Renta_Imponible_Mutual ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="cotizacion_mutual[]" value="<?php echo substr($value, 786,8); // Cotización_MUTUAL ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="sucursal_para_pago_mutual[]" value="<?php echo substr($value, 794,3); // Sucursal_para_pago_Mutual ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="renta_imp_seguro_cesantia[]" value="<?php echo substr($value, 797,8); // Renta_Imp_Seguro_Cesantía ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="aporte_trabajador_seguro_cesantia[]" value="<?php echo substr($value, 805,8); // Aporte_Trabajador_Seguro_Cesantía ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="aporte_empleador_seguro_cesantia[]" value="<?php echo substr($value, 813,8); // Aporte_Empleador_Seguro_Cesantía ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="rut_pagadora_subsidio[]" value="<?php echo substr($value, 824,11); // Rut_Pagadora_Subsidio ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="dv_pagadora_subsidio[]" value="<?php echo substr($value, 825,1); // DV_Pagadora_Subsidio ?>" class="form-control" style="width: 100px">
                                            <td> <input type="text" name="ccosots_suc_agencia_obra_region[]" value="<?php echo substr($value, 845,20); // Centro de Costos, Sucursal, Agencia, Obra, Región ?>" class="form-control" style="width: 100px">

                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                                <a class="btn btn-primary btn-lg" style="margin-top: 20px;" href="<?php echo BASE_URL ?>/previred/revisor"> <i class="fa fa-chevron-left"></i> &nbsp; Volver </a>
                                <button class="btn btn-success btn-lg pull-right" style="margin-top: 20px;"> Guardar &nbsp; <i class="fa fa-floppy-o"></i> </button>

                            </form>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <form role="form" id="frmCrear" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_previred" />
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Seleccione Archivo</label>
                                        <input type="file" name="archivo_previred" class="form-control required">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-lg pull-left" style="margin-top: 18px;">Subir archivo y Revisar <i class="fa fa-upload"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>

                 </form>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->




<script>

$(document).ready(function(){

    $("input").focus(function(){
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
            $("#btnSubmit").prop('disabled',true);
            $("#frmCrear")[0].submit();
        }
    })   

    var table = $('#table-previred').DataTable( {
        scrollY:        ($(window).height()-350) + "px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            leftColumns: 4
        },
        autoWidth: false,
        searching: false,
        "LengthChange": false,
        "bFilter": false,
        "bSort": false,
        "bInfo": true,
        "bAutoWidth": false,
    });

})

<?php if( $revisor ):  ?>
$(window).load(function() {
    $(".overlay").fadeOut(400, function(){
        $(".overlay").remove();
    })
});
<?php endif; ?>


</script>