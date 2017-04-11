<?php
@session_start();
header('Content-Type: image/jpeg');
//header("Content-Disposition: attachment; filename=" . uniqid().".jpeg");
//header('Content-Transfer-Encoding: binary');
//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

$id_reg = base64_decode($_GET['f']);
$tabla = base64_decode($_GET['t']);
$pre = base64_encode(date('Ymd'));
$id_reg = str_replace($pre,'',$id_reg);

$db->where('id',$id_reg);
if( $tabla != "m_empresa" )
    $db->where('empresa_id',$_SESSION[PREFIX . 'login_eid']);
$foto = $db->getOne($tabla,'foto');

$img = @imagecreatefromjpeg( ROOT . '/private/uploads/images/' . $foto['foto'] );
imagejpeg($img);
imagedestroy($img);
exit();
?>