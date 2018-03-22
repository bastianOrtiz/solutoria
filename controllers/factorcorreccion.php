<?php

if( $_POST ){
    
    extract($_POST);
    
    if( $action == 'modify' ){
        foreach( $factor as $key => $f ){
            $data = array(
                'factor' => $f
            );
            $int_mes = ( $key + 1 );
            $db->where('mes',$int_mes);
            $db->where('ano',$parametros[1]);
            $db->update( 'm_factormonetario',$data );
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'] ,'m_factormonetario',0,$db->getLastQuery() );
        }
        
        $response = encrypt('status=success&mensaje=Los registros se han editado correctamente&id=null');
        redirect(BASE_URL . '/' . $entity . '/listar/' . $parametros[1] . '/response/' . $response );
        exit();
    }

    if( $action == 'crear_ano_factor' ){
        
        for($i=1; $i<=12; $i++){
            $data = array(
                'ano' => $anoFactor,
                'mes' => $i,
                'factor' => 1
            );
            $db->insert('m_factormonetario', $data);
        }
        
        $response = encrypt('status=success&mensaje=Los registros se han editado correctamente&id=null');
        redirect(BASE_URL . '/' . $entity . '/listar/' . $anoFactor );
        exit();
    }
    
                
}

if( $parametros ){    
    $sql = "SELECT DISTINCT(ano) as ano FROM `m_factormonetario`";
    $anos = $db->rawQuery($sql);
    
    if( $parametros[1] ){
        $facts = array();
        $db->where('ano',$parametros[1]);
        $factores = $db->get('m_factormonetario'); 
        foreach( $factores as $f ){
            $facts[$f['mes']] = $f['factor'];
        }        
    }
        
}

include ROOT . '/views/comun/header.php';
include ROOT . '/views/comun/menu_top.php';
include ROOT . '/views/comun/menu_sidebar.php';

if( isset($parametros[0]) ){
    if( file_exists(ROOT . '/views/' . strtolower($entity) . '/' . $parametros[0] . '.php') ){
        include ROOT . '/views/' . $entity . '/' . $parametros[0] . '.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> Not Found </h2> </section></div>';
    }
} else {
    if( file_exists( ROOT . '/views/' . strtolower($entity) . '/dashboard.php') ){
        include ROOT . '/views/' . $entity .  '/dashboard.php';
    } else {
        echo '<div class="content-wrapper"><section class="content-header"> <h2> '. strtoupper($entity) .' </h2> </section></div>';
    }    
}

include ROOT . '/views/comun/footer.php';

?>

