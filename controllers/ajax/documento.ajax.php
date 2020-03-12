<?php
@session_start();
include '../../libs/config.php';
include ROOT . '/libs/class.upload.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$json = array();
extract($_POST);
sleep(1);

/*
$sourcePath = $_FILES['file']['tmp_name'];       // Storing source path of the file in a variable
$targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored
move_uploaded_file($sourcePath,$targetPath) ;    // Moving Uploaded file
*/

$return = upload_image('documentCustomImagen', ROOT . '/private/uploads/images/');            


$json = json_encode($return);
echo $json;

?>