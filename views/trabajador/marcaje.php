<style>
	.no_marco_dia_completo td{
		background-color: #fbdddd;
	}
</style>

<div class="content-wrapper">  
    <section class="content-header">
        <h1> Marcaje </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
    </section>
    <section class="content">
    	<div class="row">
    		<div class="col-lg-12">
    			<?php if ($parametros[1]) { ?>
    			<table class="table table-bordered table-striped" style="background-color: #fff">
    				<thead>
    					<tr>
    						<th>Fecha</th>
    						<th>Existe</th>
    						<th>Tipo</th>
    						<th>Justificación</th>
    						<th>Horas Extras</th>
    						<th>Hora Entrada</th>
    						<th>Hora Salida</th>
    					</tr>
    				</thead>

    				<tbody>
    					<?php foreach ($super_arreglo as $registro) : ?>
    						<tr class="<?php if($registro['no_marco_dia_completo']){ echo "no_marco_dia_completo"; } ?>">
    							<td><?php echo $registro['fecha']; ?></td>
    							<td><?php echo $registro['existe']; ?></td>
    							<td><?php echo $registro['io']; ?></td>
    							<td><?php echo $registro['nombre_justif']; ?></td>
    							<td><?php echo $registro['horas']; ?></td>
								<td><?php echo $registro['hora_entrada']; ?></td>
    							<td><?php echo $registro['hora_salida']; ?></td>
    						</tr>
    					<?php endforeach; ?>
    				</tbody>

    				<tfoot>
    					<a class="btn btn-primary pull-right" href="<?php echo BASE_URL ?>/trabajador/marcaje">Volver</a>
    				</tfoot>
    			</table>
    		<?php }else{?>
    			<form action="" method="post" id="frmMarcaje">
    				<div class="box box-primary">
    					<div class="box-body">
    						<div class="col-lg-4">
		    					<select class="form-control" id="trabajadores" required>
		    						<option value="">Seleccione</option>
		    						<?php foreach ($lista_trabajadores as $trabajador): ?>
		    						<option value="<?php echo $trabajador['id']; ?>"><?php echo $trabajador['apellidoPaterno']; ?> <?php echo $trabajador['apellidoMaterno']; ?> <?php echo $trabajador['nombres']; ?></option>
		    						<?php endforeach; ?>
		    					</select>
		    				</div>
    						<div class="col-lg-4">
		    					<input type="text" value="<?php echo date('Y-m-d') ?>" name="fecha_ini" id="fecha_ini" class="form-control datepicker input-lg" readonly>
		    				</div>
		    				<div class="col-lg-4">
		    					<input type="text" value="<?php echo date('Y-m-d') ?>" name="fecha_fin" id="fecha_fin" class="form-control datepicker input-lg" readonly>
		    				</div>
    					</div>
    					<div class="box-footer">
    						<button type="submit" id="btnEnviarParametros" class="btn btn-primary btn-lg pull-right">Ver Marcaje</button>
    					</div>
    				</div>
    			</form>
    		<?php }?>
    		</div>
    	</div>
    </section>
</div>

<script>
	$("#frmMarcaje").submit(function(e){
		e.preventDefault();

		fecha_inicio = $("#fecha_ini").val();
		fecha_termino = $("#fecha_fin").val();
		trabajador_id = $("#trabajadores").val();

		$(".overlayer").show();

		url = "<?php echo BASE_URL ?>/trabajador/marcaje/"+trabajador_id+"/"+fecha_inicio+"/"+fecha_termino;

		location.href = url;
	})

	$(document).ready(function(){

		$(".datepicker").datepicker({
	        startView : 'year',
	        autoclose : true,
	        format : 'yyyy-mm-dd'
	    });
	});
</script>