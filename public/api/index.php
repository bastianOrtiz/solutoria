<?php  
include '../../libs/config.php';
include '../../libs/constantes.php';
include ROOT . '/models/common.php';

header("Referrer-Policy: no-referrer");
header('Content-type: application/json');

if( $_POST['secret'] == md5('arriba los que luchan') ){
    $db->where('rut',$_POST['rut']);
    $foto = $db->getValue('m_trabajador','foto');

    $path = ROOT . '/private/uploads/images/' . $foto;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

    $data = [
        'thumbnail' => $base64
    ];

    echo json_encode( $data );
} else {
    echo json_encode(['msg' => 'no permitido']);
}
?>