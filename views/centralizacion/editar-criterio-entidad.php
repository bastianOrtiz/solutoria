<!-- Content Wrapper. Contains page content -->    
<div class="content-wrapper">
    <section class="content-header">
        <h1> Editar Criterio por Entidad </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php include ROOT . '/views/comun/alertas.php';  ?>
    </section>
    <section class="content">
        <form role="form" id="frmCrear" method="post">
            <input type="hidden" name="action" value="edit_criterio_entidad" />
            <input type="hidden" name="regid" value="<?php echo $parametros[2] ?>" />
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Datos del Criterio</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nombreEmpresa">Empresa</label>
                                <input type="text" class="form-control" name="nombreEmpresa" value="<?php echo $_SESSION[PREFIX.'login_empresa'] ?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="nombreCriterio">Nombre del Criterio</label>
                                <input type="text" class="form-control required" name="nombreCriterio" value="<?php echo $criterio['criterio'] ?>" placeholder="Nombre Criterio" required />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="dh">Debe o Haber</label>
                                <select name="dh" class="form-control" required>
                                    <option value="">Seleccione una opcion</option>
                                    <option value="d">Debe</option>
                                    <option value="h">Haber</option>
                                </select>
                                <script> $("[name=dh]").val('<?php echo $criterio['DH'] ?>') </script>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="dh">Cuenta Contable <small>(Obtenida desde el ERP)</small></label>
                                <input type="hidden" name="nombreCuentaContable" value="<?php echo $criterio['nombre_cta'] ?>">
                                <select name="cuentaContable" class="form-control" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="12"> MAUPUTELEN EDO.MATTE</option>
                                    <option value="14"> P.P.M (P/RECUPER.AÑO ANTERIOR)</option>
                                    <option value="15"> ANTICIPOS AL PERSONAL</option>
                                    <option value="16"> PRESTAMOS AL PERSONAL</option>
                                    <option value="17"> ANTICIPO HONORARIOS</option>
                                    <option value="18"> EXISTENCIAS EN BODEGA</option>
                                    <option value="91"> FONDO MUTUOS CORPBANCA</option>
                                    <option value="96"> CHEQUE PROTESTADO</option>
                                    <option value="106">    FONDO MUTUO BCI</option>
                                    <option value="109">    BANCO SANTANDER</option>
                                    <option value="478">    PRODUCTOS GARANTIA OUTSOURCING</option>
                                    <option value="126">    BANCO SCOTIABANK</option>
                                    <option value="348">    BANCO DE CREDITO E INVERSIONES</option>
                                    <option value="353">    BANCO RABOBANK</option>
                                    <option value="519">    BANCO SECURITY</option>
                                    <option value="524">    BANCO ITAU</option>
                                    <option value="534">    BANCO ESTADO</option>
                                    <option value="539">    BANCO CORPBANCA</option>
                                    <option value="549">    BANCO BBVA</option>
                                    <option value="569">    BANCO CHILE CTA.CTE.DOLAR</option>
                                    <option value="644">    BANCO SECURITY DOLAR</option>
                                    <option value="686">    BANCO BICE</option>
                                    <option value="897">    CAJA CHICA OUTSOURCING</option>
                                    <option value="862">    EXISTENCIAS PRODUCTOS SOLARES</option>
                                    <option value="120">    IVA POR RECUPERAR</option>
                                    <option value="121">    PPM POR RECUPERAR</option>
                                    <option value="742">    CREDITO CAPACITACION</option>
                                    <option value="158">    FONDO MUTUO BANCO ESTADO</option>
                                    <option value="163">    BCO INTERNAC. CTA 01-03889 (1)</option>
                                    <option value="168">    DOCTO.GARAN.BCO. INTERNACIONAL</option>
                                    <option value="178">    BCO INTERNAC.CTA 01-03917 (2)</option>
                                    <option value="198">    FONDO MUTUOS BCO. INTERNACIONAL</option>
                                    <option value="213">    INVERSION PROYECTO CLONEWORKS</option>
                                    <option value="333">    CHEQUES EN GARANTIA</option>
                                    <option value="338">    PROYECTOS VARIOS</option>
                                    <option value="343">    GUIAS DE DESPACHO POR FACTURAR</option>
                                    <option value="358">    BOLETAS DE GARANTIA</option>
                                    <option value="458">    REPARAC. Y MANTENC. V.MANUEL</option>
                                    <option value="463">    INVERSION BULNES</option>
                                    <option value="473">    HERRAMIENTAS CAMIONETAS</option>
                                    <option value="483">    CTA. RELACIONADA MAPUTELEN</option>
                                    <option value="498">    BIEN RAIZ SANTO DOMINGO</option>
                                    <option value="503">    EXISTENCIA COM.EXT.</option>
                                    <option value="518">    DEPOSITO A PLAZO</option>
                                    <option value="544">    GASTOS DE MARKETING POR RECUP.</option>
                                    <option value="559">    PROYECTO ENLACE</option>
                                    <option value="564">    FONDO MUTUOS BANCHILE</option>
                                    <option value="669">    CUENTA PUENTE</option>
                                    <option value="687">    PROYECTO AIEP</option>
                                    <option value="692">    PROYECTO JUNAEB</option>
                                    <option value="722">    FONDO MUTUO BANCO PENTA</option>
                                    <option value="727">    PROYECTO PIZARRA INTERACTIVA</option>
                                    <option value="732">    PROYECTO SEP</option>
                                    <option value="737">    PROYECTO DIRECCION DEL TRABAJO</option>
                                    <option value="767">    PROYECTO S.I.I.</option>
                                    <option value="772">    PROYECTO MINISTERIO DE EDUCACION</option>
                                    <option value="777">    PROYECTO PODER JUDICIAL</option>
                                    <option value="787">    PROYECTO LAB. CARROS MOVIL (LCM-1)</option>
                                    <option value="792">    PROYECTO LAB. CARROS MOVIL (LCM-2)</option>
                                    <option value="760">    FONDOS A RENDIR</option>
                                    <option value="807">    ANTICIPOS COMISIONES</option>
                                    <option value="817">    PROV. EDUCACION (GTO.EVENT/PROM)</option>
                                    <option value="822">    FONDOS MUTUOS BBVA</option>
                                    <option value="847">    CAPACITACION BICENTENARIO</option>
                                    <option value="848">    PROY. HOSPITAL DE RANCAGUA</option>
                                    <option value="877">    PROYECTO DEF. PENAL PUBLICA</option>
                                    <option value="882">    PROYECTO LA PINTANA</option>
                                    <option value="892">    PROYECTO ALUSIN FLUXSOLAR</option>
                                    <option value="893">    PROYECTO DUOC</option>
                                    <option value="19"> BIEN RAIZ GUAYAQUIL 22 2A</option>
                                    <option value="20"> MEJORAS BIEN RAIZ</option>
                                    <option value="21"> EQUIPOS COMPUTACIONALES</option>
                                    <option value="22"> MUEBLES Y UTILES</option>
                                    <option value="23"> MAQUINAS DE OFICINA</option>
                                    <option value="24"> INSTALACIONES</option>
                                    <option value="25"> VEHICULOS</option>
                                    <option value="26"> DERECHO PLANTA TELEFONICA</option>
                                    <option value="27"> EQUIPOS COMPUTAC. LEASING</option>
                                    <option value="28"> INTERESES POR PAGAR LEASING</option>
                                    <option value="29"> REGISTRO DE MARCA</option>
                                    <option value="70"> FONDO DEPRECIACIONES</option>
                                    <option value="100">    INSTALACIONES SERVICIO TECNICO</option>
                                    <option value="127">    COMPUTADORES 2° LEASING</option>
                                    <option value="363">    ANTICIPO COMPRA CASA AV. PERU</option>
                                    <option value="368">    BIEN RAIZ AV. PERU #911-913-915</option>
                                    <option value="373">    MEJORAS BIEN RAIZ AV. PERU</option>
                                    <option value="112">    COSTO VENTA DIV. INSTACION</option>
                                    <option value="428">    COSTO VENTA ACTIVO FIJO</option>
                                    <option value="65"> SUELDOS</option>
                                    <option value="66"> LEYES SOCIALES</option>
                                    <option value="67"> COMISIONES</option>
                                    <option value="68"> HONORARIOS</option>
                                    <option value="69"> UTILES DE OFICINA</option>
                                    <option value="71"> MANTENCION ACTIVO FIJO</option>
                                    <option value="72"> COMBUSTIBLES</option>
                                    <option value="73"> ENERGIA ELECTRICA</option>
                                    <option value="74"> TELEFONOS</option>
                                    <option value="75"> PATENTE COMERCIAL</option>
                                    <option value="76"> SEMANA CORRIDA</option>
                                    <option value="77"> INTERESES CANCELADOS</option>
                                    <option value="697">    ASESORIAS</option>
                                    <option value="79"> GASTOS VARIOS</option>
                                    <option value="80"> GASTOS CHILECOMPRA</option>
                                    <option value="81"> GASTOS BANCARIOS</option>
                                    <option value="82"> SEGUROS</option>
                                    <option value="681">    COMISIONES BANCARIAS</option>
                                    <option value="92"> ARRIENDO</option>
                                    <option value="101">    GASTOS RENDICION SERV. TECNICO</option>
                                    <option value="103">    GASTOS RENDICION ADMINISTRACION</option>
                                    <option value="104">    GASTOS RENDICION COMERCIAL</option>
                                    <option value="842">    GASTOS RENDICION GERENCIA</option>
                                    <option value="113">    GASTOS RENDICION INSTALACION</option>
                                    <option value="115">    GASTOS INDIRECTOS SERVIC. TECNIC</option>
                                    <option value="832">    PATENTES VEHICUL. Y PERM. CIRCUL</option>
                                    <option value="837">    SEGUROS VEHICULOS</option>
                                    <option value="203">    INDEMNIZACIONES</option>
                                    <option value="433">    PROPORCIONALIDAD IVA</option>
                                    <option value="438">    GASTOS AGUA</option>
                                    <option value="443">    GASTOS LOCOMOCION</option>
                                    <option value="448">    GASTOS INTERNET</option>
                                    <option value="468">    ARRIENDO LEASING</option>
                                    <option value="508">    PREMIOS</option>
                                    <option value="513">    GASTOS ARRIENDO SISTEMA SOLAR</option>
                                    <option value="594">    GASTOS DE PUBLICIDAD</option>
                                    <option value="598">    CONSULTA DICOM</option>
                                    <option value="599">    FLETES</option>
                                    <option value="604">    GASTOS DE REPRESENTACION</option>
                                    <option value="609">    RENDICION CAJA ADMINISTRACION</option>
                                    <option value="614">    GASTOS AUTOPISTA</option>
                                    <option value="619">    RENDICION CONTABILIDAD</option>
                                    <option value="624">    GASTOS NOCHERO</option>
                                    <option value="629">    DONACIONES</option>
                                    <option value="634">    GASTOS IMPRENTA</option>
                                    <option value="639">    GASTOS NOTARIA, CORREO, CONSERVA</option>
                                    <option value="691">    REPARAC. TERREMOTO SECC. 1</option>
                                    <option value="696">    REPARAC. Y MANTENC. VEHICULOS</option>
                                    <option value="702">    REPARAC. EDIFICIO VICTOR MANUEL</option>
                                    <option value="707">    REPARAC. TERREMOTO SECC. 3</option>
                                    <option value="712">    ARRIENDO DE VEHICULOS</option>
                                    <option value="757">    CONSULTAS TELECHEQUE</option>
                                    <option value="762">    SOBREGIROS EN FINIQUITOS</option>
                                    <option value="887">    SERTEC - EXTERNOS</option>
                                    <option value="84"> CORRECCION MONETARIA ACTIVOS</option>
                                    <option value="85"> CORRECCION MONETARIA PASIVOS</option>
                                    <option value="86"> CORRECCION MONETARIA C/PROPIO</option>
                                    <option value="87"> DEPRECIACIONES</option>
                                    <option value="88"> REAJUSTE CREDITO IVA</option>
                                    <option value="89"> REAJUSTE DEVOLUCION PPM</option>
                                    <option value="90"> IMPUESTO 1RA CATEGORIA</option>
                                    <option value="93"> IMPTO TIMBRES Y ESTAMPILLAS</option>
                                    <option value="94"> MULTAS</option>
                                    <option value="95"> CAPACITACION</option>
                                    <option value="148">    REAJUSTE U.F Y $</option>
                                    <option value="188">    INTERESES GANADOS</option>
                                    <option value="853">    DIF. CAMBIO MONEDA EXTRANJERA</option>
                                    <option value="4">  ACTIVOS CIRCULANTE  N   N</option>
                                    <option value="8">  ACTIVO FIJO N   N</option>
                                    <option value="13"> PASIVO  N   N</option>
                                    <option value="50"> PASIVO EXIGIBLE N   N</option>
                                    <option value="55"> PATRIMONIO  N   N</option>
                                    <option value="56"> CUENTAS DE PATRIMONIO   N   N</option>
                                    <option value="63"> INGRESOS    N   N</option>
                                    <option value="64"> INGRESOS OPERACIONALES  N   N</option>
                                    <option value="105">    EGRESOS N   N</option>
                                    <option value="107">    COSTOS OPERACIONALES    N   N</option>
                                    <option value="116">    GASTOS OPERACIONALES    N   N</option>
                                    <option value="118">    GASTOS NO OPERACIONALES N   N</option>
                                    <option value="898">    PROYECTO SANTILLANA</option>
                                    <option value="674">    DISTRIBUCION DE DIVIDENDOS</option>
                                    <option value="899">    GASTO REPUESTO SERTEC</option>
                                    <option value="900">    PROYECTO CLINICA STA. MARIA</option>
                                    <option value="901">    SERVICIOS TECNICO CONTRATOS</option>
                                    <option value="902">    COSTO VENTA DIV.MARKETING</option>
                                    <option value="903">    PROYECTO INST.PREVISION SOCIAL</option>
                                    <option value="904">    ANTICIPO CLIENTES</option>
                                    <option value="905">    MULTAS COMERCIALES</option>
                                    <option value="906">    IMPORTACIONES EN TRANSITO</option>
                                    <option value="907">    DIFERENCIAS DE PESOS</option>
                                    <option value="908">    SISTEMA FACT. ELECTRONICAS</option>
                                    <option value="909">    PROYECTO ARAUCO MAIPU</option>
                                    <option value="910">    PROYECTO ARAUCO SAN ANTONIO</option>
                                    <option value="911">    PROYECTO ARAUCO KENNEDY</option>
                                    <option value="912">    PROYECTO EXPRESS DE SANTIAGO</option>
                                    <option value="913">    PROYECTO POSTA CENTRAL</option>
                                    <option value="914">    PROYECTO  CALAMA </option>
                                    <option value="915">    VENTAS POR BOLETAS</option>
                                    <option value="916">    PTMO.BCO.CONSORCIO BOL/GTIA.</option>
                                    <option value="917">    BCO.BICE BOL.GTIA.USD</option>
                                    <option value="918">    PTMO.BCO.CONSORCIO BOL.GTIA.USD</option>
                                    <option value="919">    PTMO.BCO.SANTANDER BOL.GTIA.USD</option>
                                    <option value="920">    BCO.CHILE BOL.GTIA.UF</option>
                                    <option value="921">    BCO.BCI BOL.GTIA.USD</option>
                                    <option value="922">    DIFERENCIAS DE PESOS</option>
                                    <option value="923">    PROYECTO GARDEN SCHOOL</option>
                                    <option value="925">    CAJA CHICA FINANZAS</option>
                                    <option value="926">    CERTIFICACION ISO</option>
                                    <option value="927">    GASTOS BODEGAS - MATERIALES VARIOS</option>
                                    <option value="928">    PROYECTOS VARIOS EN EJECUCION </option>
                                    <option value="929">    BCO.CHILE BOL.GTIA.USD</option>
                                    <option value="930">    PTMO.BCO.CORPBANCA BOL.GTIA.USD</option>
                                    <option value="931">    PROYECTO METRO TOBALABA</option>
                                    <option value="932">    PROYECTO D.G.M.N.</option>
                                    <option value="934">    PROYECTO CORP.MUNIC.CALAMA</option>
                                    <option value="935">    RECUPERACION DE GTOS.SAMSUNG</option>
                                    <option value="936">    PROYECTO LANZCO</option>
                                    <option value="937">    INVENTARIO REPUESTOS SERV.TECNICO</option>
                                    <option value="939">    REND.GTOS. SERVICIO TECNICO MELLAFE</option>
                                    <option value="940">    PTMO.BCO.INTERNAC.BOL.GTIA.$</option>
                                    <option value="941">    BCO BICE BOL.GTIA. UF</option>
                                    <option value="944">    PERDIDA VENTA ACTIVO FIJO</option>
                                    <option value="945">    PROYECTO ARAUCO TALCA</option>
                                    <option value="946">    PROYECTO TALCA </option>
                                    <option value="947">    PROYECTO LOREAL </option>
                                    <option value="948">    PROYECTO UC </option>
                                    <option value="949">    GASTO IMPLEMENTO DE SEGURIDAD</option>
                                    <option value="950">    CORRECCION MONETARIA PPM</option>
                                    <option value="951">    CUENTA RELACIONADA INNMEC</option>
                                    <option value="952">    CUENTA RELACIONADA FLUXSOLAR</option>
                                    <option value="953">    MUTUO INNMEC SPA</option>
                                    <option value="954">    MUTUO FLUX SOLAR ENERGIA RENOVABLES</option>
                                    <option value="955">    PROYECTO MINSAL - IBM</option>
                                    <option value="959">    BODEGA 2   N° 1660</option>
                                    <option value="960">    PROYECTO - THE BODY SHOP ( 10 TIENDAS )</option>
                                    <option value="961">    PROYECTO - LOREAL ( 10 TIENDAS STAND )</option>
                                    <option value="962">    PROYECTO - LOREAL ( SIS )</option>
                                    <option value="963">    PROYECTO - LANCOME FALABELLA</option>
                                    <option value="964">    PROYECTO - NATURA ( 21 TIENDAS )</option>
                                    <option value="965">    PROYECTO - HITES ( PANTALLAS + SOFTWARE )</option>
                                    <option value="966">    PROYECTO - VIÑAS CASA DEL BOSQUE</option>
                                    <option value="967">    PROYECTO - SEREMI RANCAGUA</option>
                                    <option value="968">    PROYECTO - CLUB HIPICO</option>
                                    <option value="969">    PROYECTO - DIRECCION DEL TRABAJO</option>
                                    <option value="970">    PROYECTO - TIENDAS NYX</option>
                                    <option value="971">    REND.GTOS.VARIOS - DIRECC.PROY.AUDIOVISUAL</option>
                                    <option value="972">    PROYECTO - BANCO RIPLEY</option>
                                    <option value="977">    AMPLIACION BODEGA</option>
                                    <option value="980">    ARRIENDO SOFTWARE</option>
                                    <option value="982">    DPTO.INFORMATICA-DESARROLO</option>
                                    <option value="983">    PROYECTO SPARTA</option>
                                    <option value="984">    PROYECTO - GMO</option>
                                    <option value="985">    PROYECTO EASY</option>
                                    <option value="987">    PROYECTO SANTO TOMAS</option>
                                    <option value="988">    PROYECTO CENCOSUD RETAIL S.A.</option>
                                    <option value="989">    BCO.BBVA BOL.GTIA.UF</option>
                                    <option value="991">    PROYECTO MALL PLAZA EGAÑA</option>
                                    <option value="992">    PROYECTO COMERCIAL VIA UNO</option>
                                    <option value="995">    PROYECTO CONSEJO NACIONAL DE TELEVISION</option>
                                    <option value="996">    INVENTARIO EQP.JUNAEB BACKAP SERV.TECNICO</option>
                                    <option value="997">    INVENTARIO IMPRESORAS BACKAP SERV.TECNICO</option>
                                    <option value="999">    BCO.SCOTIABANK BOL/GTIA.UF</option>
                                    <option value="1000">   BCO.SCOTIABANK BOL/GTIA.USD</option>
                                    <option value="1001">   PROYECTO CONAF - VALPARAISO</option>
                                    <option value="1004">   REMODELACION AREA VENTAS</option>
                                    <option value="1005">   GASTOS SERVICIOS MELLAFE</option>
                                    <option value="924">    DOCUMENTOS EN GARANTIA</option>
                                    <option value="933">    PROYECTO ADUANA</option>
                                    <option value="956">    FONDO MUTUO BANCO SANTANDER</option>
                                    <option value="973">    PROYECTO - VIA UNO</option>
                                    <option value="981">    PROYECTO SALMONES CAMANCHACA S.A.</option>
                                    <option value="986">    PRESTAMOS C/PLAZO BANCO ITAU</option>
                                    <option value="994">    PROYECTO FILTROS KPA</option>
                                    <option value="1002">   PROYECTO CINE HOYTS - ALTO DISEÑO CONTRUCC.LTDA.</option>
                                    <option value="1003">   PPROYECTO INFODEMA OBRAS ADICIONALES</option>
                                    <option value="1006">   PROYECTO JUNAEB 2019 SEGUNDA ETAPA</option>
                                    <option value="938">    CUENTA RELACIONADA MELLAFE SPA</option>
                                    <option value="975">    PROYECTO - BANCO BICE</option>
                                    <option value="978">    PROYECTO IPS</option>
                                    <option value="942">    PROYECTO INDAP</option>
                                    <option value="943">    PROYECTO COMPLEJ.ASIST.LOS ANGELES</option>
                                    <option value="957">    PTMO. C/PLAZO BCO. BBVA</option>
                                    <option value="974">    PROYECTO TANINO (AUDIO)</option>
                                    <option value="998">    PRODUCTOS ENTREGADOS POR FACTURAR</option>
                                    <option value="958">    PROYECTO JUNAEB 2018</option>
                                    <option value="979">    PROYECTO CELLA</option>
                                    <option value="990">    PROYECTO JUNAEB 2019</option>
                                    <option value="993">    PROYECTO COPEUCH</option>
                                    <option value="1">  CAJA</option>
                                    <option value="2">  BANCO DE CHILE</option>
                                    <option value="3">  FONDO MUTUO BANCO SECURITY</option>
                                    <option value="770">    CAJA CHICA SERTEC</option>
                                    <option value="5">  FACTURAS POR COBRAR</option>
                                    <option value="6">  DOCUMENTOS POR COBRAR</option>
                                    <option value="30"> FACTURAS POR PAGAR</option>
                                    <option value="35"> IMPUESTO IVA</option>
                                    <option value="7">  CHEQUES A FECHA EN CARTERA</option>
                                    <option value="9">  DINEROS POR RENDIR</option>
                                    <option value="10"> PRESTAMOS A TERCEROS</option>
                                    <option value="11"> ANTICIPOS A PROVEEDORES</option>
                                    <option value="453">    HERRAMIENTAS SERVICIO TECNICO</option>
                                    <option value="31"> DOCUMENTOS POR PAGAR</option>
                                    <option value="32"> PRESTAMO C/PLAZO BCO CHILE</option>
                                    <option value="33"> PRESTAMO L/CREDITO BCO. CHILE</option>
                                    <option value="34"> HONORARIOS POR PAGAR</option>
                                    <option value="36"> IMPUESTO 2° CATEGORIA</option>
                                    <option value="37"> IMPUESTO UNICO</option>
                                    <option value="38"> AFP POR PAGAR</option>
                                    <option value="39"> ISAPRES POR PAGAR</option>
                                    <option value="40"> OTRAS INS. PREV. P/PAGAR</option>
                                    <option value="41"> REMUNERACIONES POR PAGAR</option>
                                    <option value="42"> FINIQUITOS POR PAGAR</option>
                                    <option value="43"> PROVISION P.P.M</option>
                                    <option value="44"> OTRAS PROVISIONES</option>
                                    <option value="98"> PAGOS A TERCEROS</option>
                                    <option value="99"> INGRESOS POR FACTURAR</option>
                                    <option value="108">    PRESTAMO L/PLAZO BCO SANTANDER</option>
                                    <option value="110">    PRETMO L/CREDITO BCO SANTANDER</option>
                                    <option value="78"> PRESTAMO C/PLAZO BCO SANTANDER</option>
                                    <option value="119">    PTMO L/CREDITO BCO A. EDWARDS</option>
                                    <option value="123">    PTMO L/CREDITO BCO CHILE PREF</option>
                                    <option value="133">    PRESTAMO BANCO SANTIAGO L/PLAZ</option>
                                    <option value="124">    PRESTAMO C/PLAZO BCO SANTIAGO</option>
                                    <option value="173">    PTMO L/CREDITO BCO INTERNACIONAL</option>
                                    <option value="208">    PRESTAMO C/PLAZO BCO CORPBANCA</option>
                                    <option value="378">    FORWARD</option>
                                    <option value="383">    PTMO. LARGO PLAZO BCO CHILE</option>
                                    <option value="388">    BCO SCOTIABANK BOL/GTIA $</option>
                                    <option value="393">    PTMO CORPBANCA BOL/GARANTIA</option>
                                    <option value="398">    PRESTAMO C/PLAZO BCO BCI</option>
                                    <option value="403">    PRESTAMO L/CREDITO BCO BCI</option>
                                    <option value="408">    PRESTAMO L/CREDITO HNS</option>
                                    <option value="413">    PRESTAMO L/CREDITO BCO DESARROLLO</option>
                                    <option value="488">    PRESTAMO LARGO PLAZO BCO BCI</option>
                                    <option value="493">    PTMO BCO BCI BOL/GARANTIA</option>
                                    <option value="529">    PTMO L/CREDITO BANCO SECURITY</option>
                                    <option value="574">    PMO BCO SECURITY BOL/GARANTIA UF</option>
                                    <option value="579">    BCO CHILE BOL/GARANTIA $</option>
                                    <option value="584">    PTMO C/PLAZO BCO ESTADO</option>
                                    <option value="589">    BCO BBVA BOL/GARANTIA $</option>
                                    <option value="649">    PTMO BANCO BBVA</option>
                                    <option value="654">    PTMO BCO ESTADO BOL/GARANTIA</option>
                                    <option value="659">    PTMO BCO SECURITY BOL/GTIA.DOLAR</option>
                                    <option value="664">    PTMO BCO BCI DOLAR</option>
                                    <option value="679">    PTMO L/CREDITO BBVA</option>
                                    <option value="747">    BCO BICE BOL/GARANTIA $</option>
                                    <option value="752">    PTMO BCO SANTANDER BOL/GARANTIA</option>
                                    <option value="755">    CUENTAS POR PAGAR (VISA EMP.)</option>
                                    <option value="765">    PTMO C/PLAZO BCO PENTA</option>
                                    <option value="812">    PROVISION PRODUCTOS POR ENTREG</option>
                                    <option value="872">    CARTAS DE CREDITOS</option>
                                    <option value="45"> CAPITAL PAGADO</option>
                                    <option value="46"> APORTES POR ESCRITURA</option>
                                    <option value="47"> REVALORIZACION CAPITAL PROPIO</option>
                                    <option value="48"> UTILIDAD ACUMULADA</option>
                                    <option value="49"> GARANTIAS VARIAS</option>
                                    <option value="97"> FONDO DEPRECIACION</option>
                                    <option value="51"> VENTAS DIVISION ADMINISTRACION</option>
                                    <option value="52"> VENTAS DIVISION SER.TECNICO</option>
                                    <option value="53"> VENTAS DIVISION COMERCIAL</option>
                                    <option value="54"> VENTAS DIVISION INGENIERIA</option>
                                    <option value="57"> INGR. P/RECUPERACION DE GASTOS</option>
                                    <option value="111">    VENTAS DIVISION INSTALACION</option>
                                    <option value="418">    OTROS INGRESOS</option>
                                    <option value="423">    VENTAS ACTIVO FIJO</option>
                                    <option value="782">    INDEMNIZACIONES DE TERCEROS</option>
                                    <option value="827">    INGRESOS COMERC. EXTERIOR</option>
                                    <option value="114">    INTERESES PERCIBIDOS</option>
                                    <option value="59"> COSTO VENTA DIV. ADMINISTRACION</option>
                                    <option value="60"> COSTO VENTA DIV. SER. TECNICO</option>
                                    <option value="61"> COSTO VENTA DIV. COMERCIAL</option>
                                    <option value="62"> COSTO VENTA DIV. INGENIERIA</option>
                                    <option value="976">    PROYECTO - GERIATRICO</option>
                                </select>
                                <script> $("[name=cuentaContable]").val('<?php echo $criterio['ctacont'] ?>') </script>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="tablaEntidad">Tipo Entidad Previsional</label>
                                <select id="tablaEntidad" name="tablaEntidad" class="form-control" required>
                                    <option value="">Seleccione una opción</option>
                                    <option value="m_afp">AFP</option>
                                    <option value="m_isapre">ISAPRES</option>
                                    <option value="m_institucion">Instituciones Aseguradoras</option>
                                </select>
                                <script> $("[name=tablaEntidad]").val('<?php echo $criterio['tabla_entidad'] ?>') </script>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="entidad">Entidad</label>
                                <select name="entidad" class="form-control" required>
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success btn-lg">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>


<script>
loaded = false;
$(document).ready(function(){
    llenarEntidades('<?php echo $criterio['tabla_entidad'] ?>');
    setEntidad = setInterval(function(){ 
        $("[name=entidad]").val(<?php echo $criterio['id_entidad'] ?>); 
        if( loaded == true ){
            clearInterval(setEntidad);
        }
    }, 500);
});

$("[name=cuentaContable]").change(function(){
    var nombreCtaCont = $(this).find('option:selected').text();
    $("[name=nombreCuentaContable]").val(nombreCtaCont);
});

$("#tablaEntidad").change(function(){
    if( $(this).val() != "" ){
        nombre_tabla = $(this).val();
        llenarEntidades(nombre_tabla);
    }
})


function llenarEntidades(nombre_tabla){
    $.ajax({
        type: "POST",
        url: "<?php echo BASE_URL . '/controllers/ajax/centralizacion.ajax.php'?>",
        data: "ajax_action=get_entidades&nombre_tabla=" + nombre_tabla,
        dataType: 'json',
        beforeSend: function(){
            $(".overlayer").show();
        },
        success: function (json) {
            $('[name=entidad]').empty();
            $('[name=entidad]').append($('<option>', { 
                value: "",
                text : "Seleccione una opción"
            }));
            $.each(json.registros, function (i, item) {
                $('[name=entidad]').append($('<option>', { 
                    value: item.id,
                    text : item.nombre 
                }));
            });
            $(".overlayer").hide();
            loaded = true;
        }
    })
}


</script>
