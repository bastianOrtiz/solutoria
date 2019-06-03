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
    					<tr></tr>
    				</tbody>
    			</table>
    		<?php }else{?>
    			<form action="" method="post">
    				<div class="box box-primary">
    					<div class="box-body">
    						<div class="col-lg-4">
		    					<input type="date" class="form-control" name="fecha_ini" id="fecha_ini">
		    				</div>
		    				<div class="col-lg-4">
		    					<input type="date" class="form-control" name="fecha_fin" id="fecha_fin">
		    				</div>
    					</div>
    					<div class="box-footer">
    						<button type="button" class="btn btn-primary btn-lg pull-right">Enviar</button>
    					</div>
    				</div>
    			</form>
    		<?php }?>
    		</div>
    	</div>
    </section>
</div>