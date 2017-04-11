<?php
ini_set('error_reporting', E_ALL); ini_set('display_errors', 1);
$db->where('cuenta_id', $_SESSION[PREFIX.'login_cid'] );
$registros = $db->get("m_usuario");

$db->where('cuenta_id', $_SESSION[PREFIX.'login_cid'] );
$db->orderBy("nombre","asc");
$all_empresas = $db->get("m_empresa");

$cuentas[] = array(
    'id' => 1,  
    'nombre' => 'TECNODATA'
);

if( $_POST ){
    
    extract($_POST);
    
    if( @$action == 'edit' ){
        
        $administradorUsuario = $administradorUsuario[0];
        
        if( $passwordUsuario != $rePasswordUsuario ){
            $response = encrypt('status=warning&mensaje=Las password no coinciden&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/editar/' . $usuario_id . '/response/' . $response );
            exit();
        }
        
        $empresasTodas = 1;
        if( !@$selecctall ){
            $empresasTodas = 0;                
        }                                
        
        // Si la password NO se modificó
        if( $passwordUsuario == "**********" ){
            $data = Array (
                "nombre" => $nombreUsuario,
                "user" => $emailUsuario,
                "empresasTodas" => $empresasTodas,
                "administrador" => $administradorUsuario,
                "cuenta_id" => $_SESSION[ PREFIX . 'login_cid'],
                'menuItem' => $json_menuitems
            );
        } else {
            $data = Array (
                "nombre" => $nombreUsuario,
                "user" => $emailUsuario,
                "empresasTodas" => $empresasTodas,
                "administrador" => $administradorUsuario,
                "password" => md5($passwordUsuario),                          
                "cuenta_id" => $_SESSION[ PREFIX . 'login_cid'],
                'menuItem' => $json_menuitems
            );
        }
        
        $json_roles = json_encode($roles);        
        $data['roles'] = $json_roles;
        
        
        $updateUser = editarUsuario($usuario_id, $data);
        if( $updateUser ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'usuario',$usuario_id,$db->getLastQuery() );
            if( !@$selecctall ){
                eliminarUsuarioEmpresa($usuario_id);
                if( $chkEmpresa ){
                    $SQL = "INSERT INTO m_usuarioempresa (usuario_id,empresa_id) VALUES ";
                    foreach( $chkEmpresa as $em ){
                        $SQL .= "($usuario_id,$em),";
                    }
                    $SQL = trim($SQL,",");
                    $SQL .= ";";
                    $db->rawQuery( $SQL );
                    logit( $_SESSION[PREFIX.'login_name'],'editar','empresas usuario',$usuario_id,$db->getLastQuery() );
                }                
            }
            
            $response = encrypt('status=success&mensaje=El registro se ha editado correctamente&id='.$usuario_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $usuario_id . '/response/' . $response );
            exit();
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$usuario_id);
            redirect(BASE_URL . '/' . $entity . '/editar/' . $usuario_id . '/response/' . $response );
            exit();
        }
    }
        
    if( @$action == 'edit_profile' ){
        
        if( $passwordUsuario != $rePasswordUsuario ){
            $response = encrypt('status=warning&mensaje=Las password no coinciden&id=NULL');
            redirect(BASE_URL . '/' . $entity . '/editar/' . $usuario_id . '/response/' . $response );
            exit();
        }
        
        // Si la password NO se modificó
        if( $passwordUsuario == "**********" ){
            $data = Array (
                "email" => $emailUsuario
            );
        } else {
            $data = Array (
                "email" => $emailUsuario,
                "password" => md5($passwordUsuario)
            );
        }
        
        $trabajador_id = $_SESSION[ PREFIX . 'login_uid' ];
        $updateUser = editarPerfil( $trabajador_id, $data);
        
        if( $updateUser ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'perfil',$trabajador_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Datos editados correctamente&id='.$usuario_id);            
        } else {
            $response = encrypt('status=warning&mensaje='.$db->getLastError().'&id='.$usuario_id);            
        }
        
        redirect(BASE_URL . '/' . $entity . '/perfil/response/' . $response );
        exit();
    }
    
    
    
    if( @$_POST['action'] == 'delete' ){
        $delete = eliminarUsuario( $usuario_id );
        if( $delete ){
            logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'usuario',$usuario_id,$db->getLastQuery() );
            $response = encrypt('status=success&mensaje=Registro eliminado correctamente&id='.$usuario_id);            
        } else {
            $response = encrypt('status=warning&mensaje=Hubo un error eliminado el registro' );
        } 
        redirect(BASE_URL . '/' . $entity . '/listar/response/' . $response );
        exit();
    }
    
    if( @$_POST['action'] == 'new' ){                        
        $administradorUsuario = $administradorUsuario[0];
        $exist = verificarExisteUsuario($emailUsuario);
        
        if($exist){
            $response = encrypt('status=warning&mensaje=El registro ya se encuentra en la base de datos&id=');
            redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
            exit();
        } else {
            if( $passwordUsuario != $rePasswordUsuario ){
                $response = encrypt('status=warning&mensaje=Las password no coinciden&id=');
                redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
                exit();
            }    
            
            $empresasTodas = 1;
            if( !@$selecctall ){
                $empresasTodas = 0;                
            }

            // Si la password NO se modificó
            if( $passwordUsuario == "**********" ){
                $data = Array (
                    "nombre" => $nombreUsuario,
                    "user" => $emailUsuario,
                    "empresasTodas" => $empresasTodas,
                    "administrador" => $administradorUsuario,
                    "cuenta_id" => $_SESSION[ PREFIX . 'login_cid'],
                    'menuItem' => $json_menuitems
                );
            } else {
                $data = Array (
                    "nombre" => $nombreUsuario,
                    "user" => $emailUsuario,
                    "empresasTodas" => $empresasTodas,
                    "administrador" => $administradorUsuario,    
                    "password" => md5($passwordUsuario),                          
                    "cuenta_id" => $_SESSION[ PREFIX . 'login_cid'],
                    'menuItem' => $json_menuitems
                );
            }
            
            $json_roles = json_encode($roles);        
            $data['roles'] = $json_roles;
                       
            
            $id = crearUsuario($data);
            if(!$id){                                                
                $response = encrypt('status=warning&mensaje=Error al crear el registro en la BD:'.$db->getLastError().'&id=NULL');
                redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
                exit();
            } else {
                if( !@$selecctall ){
                    if( $chkEmpresa ){
                        $SQL = "INSERT INTO m_usuarioempresa (usuario_id,empresa_id) VALUES ";
                        foreach( $chkEmpresa as $em ){
                            $SQL .= "($id,$em),";
                        }
                        $SQL = trim($SQL,",");
                        $SQL .= ";";
                        $db->rawQuery( $SQL );
                    }
                }
                
                logit( $_SESSION[PREFIX.'login_name'],$_POST['action'],'usuario',$id,$db->getLastQuery() );
                
                $response = encrypt('status=success&mensaje=El registro se ha creado correctamente&id='.$id);
                redirect(BASE_URL . '/' . $entity . '/ingresar/response/' . $response );
                exit();
            }  
        }           
    }      
}

if( $parametros ){
    /** Consultar datos de usuario **/
    if( isset($parametros[1]) ){
                
        $db->where ("id", $parametros[1]);
        $usuario = $db->getOne("m_usuario");                        
        
        $db->where ("usuario_id", $parametros[1]);
        $usuarioempresa = $db->get("m_usuarioempresa");
        
        $menu = mainMenu();
    }
    
    if( @$parametros[0] == 'perfil' ){
        $db->where ("id", $_SESSION[ PREFIX . 'login_uid' ]);
        $perfil = $db->getOne("m_trabajador",'email'); 
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