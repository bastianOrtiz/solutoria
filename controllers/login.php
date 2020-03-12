<?php

if( ( $_POST ) || $parametros ){
    extract($_POST);
    
    if( @$_POST['action'] == 'req_pass' ){
        
        $new_hash = hash('md5',"hash de recuperacion de pass de $login_email");
        
        if( editarUsuarioLogin( $login_email , array( 'hash' => $new_hash ) ) ){
            logit( $login_email,$_POST['action'],'usuario',0,$db->getLastQuery() );
            
            $db->where('user',$login_email);
            $usuario = $db->getValue('m_usuario','nombre');            
            $body = "
            <table>
            <tr>
            <td> 
            <h2> Hola, $usuario! </h2>
            <p>
            Seg&uacute;n su indicaci&oacute;n, ha olvidado su contrase&ntilde;a. Puede hacer clic en el siguiente enlace para volver al sistema y restablecer su contrase&ntilde;a:<br /> 
            <a href='". BASE_URL . "/login/$login_email/$new_hash'>". BASE_URL . "/login/$login_email/$new_hash </a>
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
            $m = new Mail;
                    
            $m->From( "Robot <no-responder@tecnodatasa.cl>" );        
            $m->To( $login_email );
            $m->Subject( "Solicitud de nueva contraseña" );        
            $m->Body($body);
            $m->Priority(3) ;
            $sended = $m->Send();
            //mail($login_email,'test','Este es un mensaje de pruebas antes de enviar el correo con la Libreria LibMail');            
            goBack('Hemos enviado instrucciones a su correo para reestablecer su contrase\u00f1a');
            exit();        
        }
        
        
        
        
    }
    
    if( (isset($parametros[0])) && ( $parametros[0] == 'logout' ) ){
        
        logit( $_SESSION[PREFIX.'login_name'],'logout','usuario',$_SESSION[ PREFIX . 'login_uid'],$db->getLastQuery() );
        
        $redirect = BASE_URL;
        if( $_SESSION[ PREFIX . 'is_trabajador']  ){
            $redirect = BASE_URL.'/login_trabajador';
        } 
        $_SESSION[ PREFIX . 'logged'] = false;
        $_SESSION[ PREFIX . 'login_admin'] = '';
        $_SESSION[ PREFIX . 'login_uid'] = '';
        $_SESSION[ PREFIX . 'login_name'] = '';
        $_SESSION[ PREFIX . 'login_cid'] = ''; 
        $_SESSION['cuenta_id'] = '';
        $_SESSION[ PREFIX . 'login_cuenta'] = '';
        
        session_unset();
        session_destroy();        
        redirect($redirect);   
    }
    
    if( $action == 'login' ){
            

        // CONSUTLAR ID DE LA CUENTA DEL USUARIO
        $db->where ("nombre", $login_cuenta);
        $cuenta_id = $db->getOne("m_cuenta",array('id'));        
                
        $db->where ('user', $login_email);
        $db->where ('password', md5($login_password));
        $db->where('cuenta_id',$cuenta_id['id']);
        $valid_user = $db->getOne('m_usuario');
        
        
        if( $db->count > 0 ){
            /* SETEAR VARIABLES DE SESSION */
            $_SESSION[ PREFIX . 'logged'] = true;
            $_SESSION[ PREFIX . 'login_admin'] = $valid_user['administrador'];
            $_SESSION[ PREFIX . 'login_uid'] = $valid_user['id'];
            $_SESSION[ PREFIX . 'login_name'] = $valid_user['nombre'];
            $_SESSION[ PREFIX . 'login_cuenta'] = $login_cuenta;
                        
            $_SESSION[ PREFIX . 'login_cid'] = $cuenta_id['id'];            
            
            // CONSUTLAR EMPRESA DEL USUARIO
            $empresas = fnListaEmpresasXUsuario($_SESSION[PREFIX . 'login_uid']);
            $usuario_empresa = $empresas[0];                            
            
            $_SESSION[ PREFIX . 'login_eid'] = $usuario_empresa['id_empresa'];
            $_SESSION[ PREFIX . 'login_empresa'] = $usuario_empresa['nombre'];
            
            
            $_SESSION[ PREFIX . 'is_trabajador'] = false;            
            $_SESSION[ PREFIX . 'is_jefe'] = 0;
            $_SESSION[ PREFIX . 'is_god'] = 0;
            
            logit( $_SESSION[PREFIX.'login_name'],'login','usuario',$_SESSION[ PREFIX . 'login_uid'],$db->getLastQuery() );
                         
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
    
    $db->setTrace(true);
    $db->where('user',$parametros[0]);
    $db->where('hash',$parametros[1]);
    $result = $db->getOne('m_usuario');
    
    if( $db->count > 0 ){
        $new_pass = uniqid();
        
        $db->where('user',$parametros[0]);
        $db->update('m_usuario', array( 'password' => md5($new_pass), 'hash' => '' ));
        $body = "
        <table>
        <tr>
        <td> 
        <h2> Hola, ".$result['nombre']."! </h2>
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

        $m = new Mail;        
        $m->From( "Robot <no-responder@tecnodatasa.cl>" );        
        $m->To( $result['user'] );
        $m->Subject( "Nueva contraseña generada" );        
        $m->Body($body);
        $m->Priority(3) ;
        $sended = $m->Send();
    }
    
    $array_reponse = array();
    $array_reponse['mensaje'] = 'Hemos generado una nueva contraseña y la hemos enviado a tu correo';
    include ROOT . '/views/' . $entity .'/required.php';
    exit();   
} else {
    include ROOT . '/views/' . $entity .'/index.php';
    exit();
}



?>