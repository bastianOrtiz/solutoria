<?php
@session_start();
include '../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';
extract($_GET);

$db->where('id', $_SESSION[ PREFIX . 'login_uid' ]);
$menu_items = $db->getValue('m_usuario','roles');
$menu_items = json_decode( $menu_items );

if( $_SESSION && isAdmin() ){

    showDoc($docId);

} elseif( docOwnsTrabajador($_SESSION[PREFIX.'login_uid'],$docId) ){ // Si es trabajador
    
    showDoc($docId);

} elseif(isset($menu_items->trabajador->visualizar)) {
    
    showDoc($docId);


} else {
    echo "Acceso Denegado";
}


function showDoc($docId){
    global $db;

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
}



exit;
?>