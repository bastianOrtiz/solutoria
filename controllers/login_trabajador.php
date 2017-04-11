<?php

if( ( $_POST ) || $parametros ){
    extract($_POST);
    
    if( @$action == 'req_pass' ){
        
        $new_hash = hash('md5',"hash de recuperacion de pass de $login_rut");
        

        if( ! checkMailTrabajador($login_rut) ){
            goBack('No existe un correo asociado al rut ingresado\\nPor favor, acuda a Recursos Humanos para solicitar su contraseña');
            exit();
        }
        
        if( editarUsuarioLogin( $login_rut , array( 'hash' => $new_hash ) ) ){
            logit( $login_rut,$_POST['action'],'login trabajador',0,$db->getLastQuery() );
            
            $db->where('rut',$login_rut);
            $usuario = $db->getOne('m_trabajador',array('nombres','email'));
            
            $trabajador_nombre = $usuario['nombres'];
            $trabajador_email = $usuario['email'];                                                    
            
            $currUrl = BASE_URL . '/login_trabajador/' . $trabajador_email . '/' . $new_hash;
            $body = "
            <table>
            <tr>
            <td> 
            <h2> Hola, $trabajador_nombre! </h2>
            <p>
            Seg&uacute;n su indicaci&oacute;n, ha olvidado su contrase&ntilde;a. Puede hacer clic en el siguiente enlace para volver al sistema y restablecer su contrase&ntilde;a:<br /> 
            <a href='".$currUrl."'>".$currUrl."</a>
            </p>
            
            <p>Si el link anterior no funciona, por favor copie y peguelo en su navegador web.</p>
            
            <p>Si usted no ha solicitado reestablecer su contrase&ntilde;a, puede simplemente ignorar o borrar este mensaje, su contrase&ntilde;a no va a cambiar, y podr&aacute; acceder a su cuenta.</p>
            <br /><br />
            
            Saludos<br />
            Tecnodata S.A.
            </td>
            </tr>
            </table>
            ";            
    
            $arr_query_post = array(
                'token' => 'cualquiertokensirve',
                'currUrl' => $currUrl,
                'mailto' => $trabajador_email,
                'nombre' => $trabajador_nombre,
                'new_hash' => $new_hash,
                'body' => $body,
                'subject' => 'Reestablecer Contraseña'
            );
                                    
            enviarMailExterno($arr_query_post);

            goBack('Hemos enviado instrucciones a su correo para reestablecer su contrase\u00f1a\n');
            exit();        
        }
    }
    
    if( (isset($parametros[0])) && ( $parametros[0] == 'logout' ) ){
        logit( $_SESSION[ PREFIX . 'login_name'],'logout','login trabajador',$_SESSION[ PREFIX . 'login_uid'] ,$db->getLastQuery() );
        $_SESSION[ PREFIX . 'logged'] = false;
        $_SESSION[ PREFIX . 'login_admin'] = '';
        $_SESSION[ PREFIX . 'login_uid'] = '';
        $_SESSION[ PREFIX . 'login_name'] = '';
        $_SESSION[ PREFIX . 'login_cid'] = ''; 
        $_SESSION['cuenta_id'] = '';
        $_SESSION[ PREFIX . 'login_cuenta'] = '';
        $_SESSION[ PREFIX . 'is_trabajador'] = '';
        $_SESSION[ PREFIX . 'is_jefe'] = '';
        $_SESSION[ PREFIX . 'is_god'] = '';
        session_unset();
        session_destroy();
        redirect(BASE_URL);
    }
    
    if( @$_POST['action'] == 'login' ){
        
        $db->where ('rut', $login_rut);
        $db->where ('password', md5($login_password));
        $valid_user = $db->getOne('m_trabajador');        
        
        if( $db->count > 0 ){
            /* SETEAR VARIABLES DE SESSION */
            $_SESSION[ PREFIX . 'logged'] = true;
            $_SESSION[ PREFIX . 'login_admin'] = 0;
            $_SESSION[ PREFIX . 'login_uid'] = $valid_user['id'];
            $_SESSION[ PREFIX . 'login_name'] = $valid_user['nombres'];
            $_SESSION[ PREFIX . 'login_cuenta'] = $login_cuenta;
            
            // CONSUTLAR ID DE LA CUENTA DEL USUARIO             
            $db->where ("nombre", $login_cuenta);          
            $cuenta_id = $db->getOne("m_cuenta",array('id'));
            $_SESSION[ PREFIX . 'login_cid'] = $cuenta_id['id'];            
            
            // CONSUTLAR EMPRESA DEL USUARIO
            $usuario_empresa = $db->rawQuery( "SELECT E.nombre, E.id as id_empresa FROM m_empresa E, m_trabajador U WHERE U.id = ".$valid_user['id']." AND U.empresa_id = E.id LIMIT 1" );            
            $usuario_empresa = $usuario_empresa[0];            
            $_SESSION[ PREFIX . 'login_eid'] = $usuario_empresa['id_empresa'];
            $_SESSION[ PREFIX . 'login_empresa'] = $usuario_empresa['nombre'];            
            
            $_SESSION[ PREFIX . 'is_trabajador'] = true;            
            $_SESSION[ PREFIX . 'is_jefe'] = $valid_user['revisaReloj'];
            $_SESSION[ PREFIX . 'is_god'] = $valid_user['fullJerarquia'];
            
            logit( $_SESSION[PREFIX.'login_name'],'login','login trabajador',$_SESSION[ PREFIX . 'login_uid'],$db->getLastQuery() );
                         
            redirect( BASE_URL );
            exit();                                                
        } else {
            $array_reponse = array();
            $array_reponse['status'] = 'error';
            $array_reponse['mensaje'] = 'El usuario no se encuentra en la base datos';
            $array_reponse['id'] = null;
        }        
    }
    
} else {
    if( ( isset($_SESSION[ PREFIX . 'logged']) ) && ( $_SESSION[ PREFIX . 'logged'] == true )  ){
        redirect( BASE_URL );
        exit();
    }
}


if( ( isset($parametros[0]) ) && ( isset($parametros[1]) ) ){
        
    $db->where('email',$parametros[0]);
    $db->where('hash',$parametros[1]);
    $result = $db->getOne('m_trabajador');
    
    if( $db->count > 0 ){
        $new_pass = uniqid();
        
        $db->where('email',$parametros[0]);
        $db->update('m_trabajador', array( 'password' => md5($new_pass), 'hash' => '' ));
        
        $trabajador_email = $parametros[0];
        $currUrl = BASE_URL . '/login_trabajador/' . $trabajador_email . '/' . $new_hash;
        $body = "
        <table>
        <tr>
        <td> 
        <h2> Hola, ".$result['nombres']."! </h2>
        <p>
        Hemos generado una nueva contrase&ntilde;a para que puedas accedeer a tu cuenta
        </p>
        
        <p>La nueva contrase&ntilde;a es: <pre style='font-size:20px'>$new_pass</pre></p>
        
        <p>Con esta contrase&ntilde;a puede acceder a tu cuenta en el sistema y despues cambiarla por una que te sea mas c&oacute;da para recordar</p>
        <br /><br />
        
        Saludos<br />
        Tecnodata S.A.
        </td>
        </tr>
        </table>
        ";    
        
        $arr_query_post = array(
            'token' => generateToken($trabajador_email),
            'currUrl' => $currUrl,
            'mailto' => $trabajador_email,
            'nombre' => $result['nombres'],
            'new_hash' =>'',
            'body' => $body,
            'subject' => 'Nueva contraseña generada'
        );
        
        enviarMailExterno($arr_query_post);
                
    }
    
    $array_reponse = array();
    $array_reponse['mensaje'] = 'Hemos generado una nueva contraseña y la hemos enviado a tu correo<br />';    
    include ROOT . '/views/' . $entity .'/required.php';
    exit();   
} else {
    include ROOT . '/views/' . $entity .'/index.php';
    exit();
}



?>