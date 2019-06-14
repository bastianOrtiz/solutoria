<?php 
if( ( isset($parametros[ ( count($parametros) - 2 ) ]) ) && ($parametros[ ( count($parametros) - 2 ) ] == 'response') ){
$array_reponse = fnParseResponse($parametros[ ( count($parametros) - 1 ) ]);
?>
<div class="alert alert-<?php echo $array_reponse['status'] ?> alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <h4>	<i class="icon fa fa-check"></i> Mensaje:</h4>
    <?php echo $array_reponse['mensaje'] ?>. <?php if( $array_reponse['id'] ){ echo "ID: " . $array_reponse['id']; } ?>
</div>
<?php } ?> 