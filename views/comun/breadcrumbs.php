<ol class="breadcrumb">
    <li><a href="<?php echo BASE_URL ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo BASE_URL ?>/<?php echo $entity ?>/listar"><?php echo ucfirst($entity) ?></a></li>
    <?php if( isset($parametros[0]) ){ ?>            
    <li><a href="<?php echo BASE_URL ?>/<?php echo $entity ?>/<?php echo $parametros[0] ?>"><?php echo ucwords(str_replace("_"," ", $parametros[0])) ?></a></li>
    <?php } ?>
</ol>