<style>
.info-box-number{
    font-size: 28px;
}
.labeler{
    font-size: 11px;
    text-transform: uppercase;
    border: 1px solid gray;
    border-radius: 5px;
    float: right;
    padding: 10px;
}
.labeler strong{
    display: block;
}
.sex{
    display: block;
    font-size: 20px;
    position: absolute;
}

.sex .fa{
    font-size: 38px;
}

.sex.female{
    color: #F0629E;
    top: 10px;
    right: 10px;
}
.sex.male{
    color: #2085FF;
    bottom: 10px;
    left: 10px;
}

</style>
<div class="content-wrapper">
    <section class="content-header">    
        <h1> Bienvenido <?php echo $_SESSION[PREFIX.'login_name'] ?> </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo BASE_URL ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><?php echo ucfirst($entity) ?></a></li>            
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <!-- DONUT CHART -->
            <?php if( ! $_SESSION[PREFIX.'is_trabajador'] ){  ?>
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Empleados x Departamento</h3>                  
                </div>
                <div class="box-body">
                    <div class="labeler">
                    <?php 
                    $total_total = 0;
                    foreach( $arr_deptos_data as $item ){
                    $total_total +=  $item['total'];
                    ?> 
                        <strong style="color: <?php echo $item['color'] ?>;"><?php echo $item['departamento']; ?>: <?php echo $item['total']; ?></strong>
                    <?php } ?>                        
                        <strong style="border-top: 1px solid #333;">TOTAL: <?php echo $total_total; ?></strong>
                    </div>
                    <canvas id="pieChart" height="250"></canvas>                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            <?php } else { ?>
                <div class="box box-danger">
                    <div class="box-body">
                      <img src="<?php echo BASE_URL ?>/private/imagen.php?f=<?php echo base64_encode(base64_encode(date('Ymd')) . $_SESSION[PREFIX . 'login_uid']) ?>&t=<?php echo base64_encode('m_trabajador') ?>" style="display:block; margin: 79px auto" />
                    </div>
                </div>

            <?php } ?>
            </div><!-- /.col (LEFT) -->
            <div class="col-md-6">
                <?php if( $_SESSION[PREFIX.'is_trabajador'] ){  ?>
                <div class="box box-success">
                    <div class="box-header with-border">
                      <h3 class="box-title">Datos</h3>
                    </div>

                    <div class="box-body">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="ion ion-clock"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Total de minutos atrasos este mes</span>
                              <span class="info-box-number"><?php echo $atraso_acumulado['minutos'] ?></span>

                                  <span class="progress-description">
                                    (De un máximo de 30 min. permitidos, o 3 atrasos en el mes)
                                  </span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>

                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="ion ion-calendar"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Ausencias</span>
                              <span class="info-box-number"><?php echo $ausencias_total; ?></span>

                              <span class="progress-description">
                                (Se incluyen licencias y ausencias)
                              </span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>

                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="ion ion-document-text"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Descargar últma liquidacion</span>
                              <span class="info-box-number">
                                <a href="<?php echo BASE_URL . '/private/pdfgen.php?id=' . encrypt($liquidacion_trabajador['id']) ?>" target="_blank" class="btn btn-default">Descargar</a>
                              </span>
                              <span class="progress-description">
                              (Correspondiente al mes de <?php echo $mes_ultima_liquidacion; ?>)
                              </span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>

                        <div class="info-box bg-blue">
                            <span class="info-box-icon"><i class="ion ion-android-calendar"></i></span>

                            <div class="info-box-content">
                              <span class="info-box-text">Días de vacaciones tomadas este año</span>
                              <span class="info-box-number">
                                <?php echo $dias_vac ?>
                              </span>

                            </div>
                            <!-- /.info-box-content -->
                          </div>
                    </div>
                </div><!-- /.box -->
                <?php } ?>
              <!-- LINE CHART -->
              <?php if( ! $_SESSION[PREFIX.'is_trabajador'] ){  ?>
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Grafico Hombres v/s Mujeres</h3>
                </div>
                <div class="box-body">
                  <div class="chart">     
                    <div class="sex female"><i class="fa fa-female"></i>: <?php echo $sexos[0]['total'] ?></div>
                    <div class="sex male"><i class="fa fa-male"></i>: <?php echo $sexos[1]['total'] ?></div>             
                    <canvas id="sexChart" height="250"></canvas>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <?php } ?>

              <div class="row">
                <div class="col-lg-12">
                  <form method="post">
                    <input type="submit" name="backup" value="CREAR REPALDO DEL SISTEMA" class="btn btn-danger pull-right">
                  </form>
                </div>
              </div>
              <br><br>
               <div class="row">
                <div class="col-lg-12">
                    <button type="button" name="procesar_liquidaciones" class="btn btn-success pull-right">CERRAR PROCESO DE LIQUIDACIÓN DE ESTE MES</button>
                </div>
              </div>


            </div><!-- /.col (RIGHT) -->
        </div><!-- /.row -->    
        
    </section><!-- /.content -->
</div>

<script>

$(document).ready(function(){
    $("[name=procesar_liquidaciones]").click(function(e){
        procesarLiquidaciones();
    })
})

 $(function () {           
    
        <?php if( ! $_SESSION[PREFIX.'is_trabajador'] ){  ?>
        var areaChartData = {
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [
            {
              label: "Electronics",
              fillColor: "rgba(210, 214, 222, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
              label: "Digital Goods",
              fillColor: "rgba(60,141,188,0.9)",
              strokeColor: "rgba(60,141,188,0.9)",
              pointColor: "#3b8bba",
              pointStrokeColor: "rgba(60,141,188,1)",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(60,141,188,1)",
              data: [28, 48, 40, 19, 86, 27, 90]
            },
            {
              label: "My Stuff",              
              fillColor: "rgba(240,68,68,0.8)",
              strokeColor: "rgba(240,68,68,0.8)",
              pointColor: "#710202",
              pointStrokeColor: "rgba(240,68,68,0.8)",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(240,68,68,0.8)",
              data: [68, 58, 60, 59, 66, 57, 60]
            }
          ]
        };

        var areaChartOptions = {
          //Boolean - If we should show the scale at all
          showScale: true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines: false,
          //String - Colour of the grid lines
          scaleGridLineColor: "rgba(0,0,0,.05)",
          //Number - Width of the grid lines
          scaleGridLineWidth: 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines: true,
          //Boolean - Whether the line is curved between points
          bezierCurve: true,
          //Number - Tension of the bezier curve between points
          bezierCurveTension: 0.3,
          //Boolean - Whether to show a dot for each point
          pointDot: false,
          //Number - Radius of each point dot in pixels
          pointDotRadius: 4,
          //Number - Pixel width of point dot stroke
          pointDotStrokeWidth: 1,
          //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
          pointHitDetectionRadius: 20,
          //Boolean - Whether to show a stroke for datasets
          datasetStroke: true,
          //Number - Pixel width of dataset stroke
          datasetStrokeWidth: 2,
          //Boolean - Whether to fill the dataset with a color
          datasetFill: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true
        };





        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [        
          <?php echo $js_var_PieData; ?>
        ];
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 30,
          //String - Animation easing effect
          animationEasing: "easeOut",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: false,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
        

        var sexChartCanvas = $("#sexChart").get(0).getContext("2d");
        var sexChart = new Chart(sexChartCanvas);
        var sexData = [        
          <?php echo $js_var_sexos; ?>
        ];
        sexChart.Doughnut(sexData,pieOptions);
        

        <?php } ?>


      });




</script>
