<?php
include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);


if( $_POST['ajax_action'] == 'upload' ){
    
}

$json = json_encode($json);
echo $json;

?>