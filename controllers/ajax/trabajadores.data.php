<?php
@session_start();
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';


$query = '%' . $_GET['query'] . '%'; // add % for LIKE query later

// do query
$db->where('empresa_id',$_SESSION[ PREFIX . 'login_eid']);
$db->where('apellidoPaterno',$query,'LIKE');
$trabajadores = $db->get('m_trabajador',99999,array('id','apellidoPaterno','apellidoMaterno','nombres'));

// populate results
$results = array();
foreach( $trabajadores as $t ){    
    $results[]['id'] = $t['id'];
    $results[]['nombre'] = $t['apellidoPaterno'] . " " . $t['apellidoMaterno'] . " " . $t['nombres'];
}

// and return to typeahead
return json_encode($results);

?>