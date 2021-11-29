<?php
@session_start();


include '../../libs/config.php';
include ROOT . '/libs/functions.php';
include ROOT . '/models/common.php';

if( $_SESSION[ PREFIX . 'logged'] && !$_SESSION[ PREFIX . 'is_trabajador'] ):

$json = array();

if( $_POST['ajax_action'] == 'procesar_liquidaciones' ){
    
    $mes = getMesMostrarCorte();
    $ano = getAnoMostrarCorte();


    /* 
    Validar que el proceso de sumar dias de vacaciones no se haya ejecutado antes
    por medio de la tabla m_parametros.
    Sino se ha hecho, Sumar 1.25 dias a las vacaciones de los trabajadores
    */
    
    $cierre_vacaciones = $db->where('param','cierre_vacaciones_' . $_SESSION[PREFIX . 'login_eid'])->where('value',$mes.'-'.$ano)->getOne('m_parametros');
    
    if(!$cierre_vacaciones){

        $trabajadores_todos = $db->where('empresa_id',$_SESSION[PREFIX . 'login_eid'])->where('tipocontrato_id',[3,4],'NOT IN')->get('m_trabajador',null,['id','diasVacaciones']);
        
        foreach($trabajadores_todos as $trabajdor){
            $vacaciones_current = $trabajdor['diasVacaciones'];
            $vacaciones_plus = ( $trabajdor['diasVacaciones'] + 1.25 );

            $db->where('id',$trabajdor['id'])->update('m_trabajador',[
                'diasVacaciones' => $vacaciones_plus
            ]);

        }

        $db->where('param','cierre_vacaciones_' . $_SESSION[PREFIX . 'login_eid'])->update('m_parametros',[
            'value' => $mes.'-'.$ano
        ]);
    }

    $db->where('mes',$mes);
    $db->where('ano',$ano);
    $res = $db->update('liquidacion',['terminada' => 1]);

    
    if( $res ){
        $json['status'] = 'success';
        $json['mensaje'] = 'OK';

    } else {
        $json['status'] = 'error';
        $json['mensaje'] = $db->getLastError();;   
    }



        
}

$json = json_encode($json);
echo $json;

endif;

?>