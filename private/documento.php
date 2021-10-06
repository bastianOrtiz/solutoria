<?php
@session_start();
include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';
extract($_GET);

if( $_SESSION && isAdmin() ){

    $db->where('id',$docId);
    $filename = $db->getValue('t_documentotrabajador','filename');
    $pathinfo = pathinfo($filename); 
    header("Content-type:application/" . $pathinfo['extension']);
    
    if( strtoupper($pathinfo['extension']) != 'PDF' ){
        header("Content-Disposition:attachment;filename=descarga_".uniqid().".".$pathinfo['extension']);
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    } 
    $url = ROOT . '/private/uploads/docs/' . $filename;
    
    $fp = fopen($url, 'rb');
    fpassthru($fp);

} elseif( docOwnsTrabajador($_SESSION[PREFIX.'login_uid'],$docId) ){ // Si es trabajador
    
    $db->where('id',$docId);
    $filename = $db->getValue('t_documentotrabajador','filename');
    $pathinfo = pathinfo($filename); 
    header("Content-type:application/" . $pathinfo['extension']);
    
    if( strtoupper($pathinfo['extension']) != 'PDF' ){
        header("Content-Disposition:attachment;filename='descarga_".uniqid().".".$pathinfo['extension']."'");
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    } 
    $url = ROOT . '/private/uploads/docs/' . $filename;
    
    $fp = fopen($url, 'rb');
    fpassthru($fp);

} else {
    echo "Acceso Denegado";
}
exit;
?>