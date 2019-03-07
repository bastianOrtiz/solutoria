<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1> Ingresar Renta no gravada </h1>
        <?php include ROOT . '/views/comun/breadcrumbs.php';  ?>
        <?php 
            if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
            $array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
            ?>          
        <div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
            <h4> <i class="icon fa fa-check"></i> Mensaje:</h4>
            <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
        </div>
        <?php } ?> 
    </section>
    <section class="content">
        <div class="box">
            <div class="box-body">
                <form id="frmCrear" method="post">
                    <input type="hidden" name="action" value="ingresar">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <div class="form-group">
                                <select class="form-control" name="trabajador_id" required>
                                    <option value="">Seleccione Trabajador</option>
                                    <?php foreach ($trabajadores_todos as $trabajador) { ?>
                                    <option value="<?php echo $trabajador['id'] ?>"><?php echo getNombreTrabajador($trabajador['id']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <div class="form-group">
                                <select class="form-control" name="ano" required>
                                    <option value="">Seleccione Año</option> 
                                    <?php for ($i=date('Y'); $i > 2015 ; $i--) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-12">
                            <div class="form-group">
                                <select class="form-control" name="mes" required>
                                    <option value="">Seleccione Mes</option> 
                                    <?php for ($i=1; $i<=12 ; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo getNombreMes($i); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <h3 class="box-title">Lista de items</h3>
                        </div>
                    </div>
                    <div class="row to_clone">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input type="text" placeholder="Glosa" name="glosa[]" class="form-control" required>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <input type="text" placeholder="Monto" name="monto[]" class="form-control" required>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <button type="button" class="btn btn-primary btnAdd" data-toggle="tooltip" title="Agregar fila"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="items_cloned"></div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                              <div class="input-group-addon">
                                Total <i class="fa fa-dollar"></i>
                              </div>
                              <input type="text" class="form-control" value="0" id="super_total" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <input type="submit" name="" value="Guardar" class="btn btn-success btn-lg pull-right" style="margin: 50px 0 0 0">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("[name=trabajador_id]").select2();    

    row_cloned = '<div class="row">' + 
    '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">' + 
    '    <input type="text" placeholder="Glosa" name="glosa[]" class="form-control" required>' + 
    '</div>' + 
    '<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">' + 
    '    <input type="text" placeholder="Monto" name="monto[]" class="form-control" required>' + 
    '</div>' + 
    '<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12"><button type="button" class="btn btn-danger btn-xs btnDelete" data-toggle="tooltip" title="Quitar fila"><i class="fa fa-minus"></i></button></div>' + 
    '</div>';

    $(".btnAdd").click(function(){
        $(".items_cloned").append(row_cloned);
    })

    $(document).on('click','.btnDelete', function(){
        $(this).closest('.row').remove();
        recalcular();
    })

    $(document).on('keyup',"[name='monto[]']",function(){
        recalcular();
    })


    function recalcular(){
        total = 0;
        $("[name='monto[]']").each(function(){
            total += parseInt($(this).val());
        })

        $("#super_total").val(total);
    }

})
</script>