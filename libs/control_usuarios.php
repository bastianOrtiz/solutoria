<?php
/**
 * CONTROLS DE USUARIOS
 * ====================
 * Procesa el usuario logueado, lo compara con las entidades
 * y acciones y segun lo seteado en mantenedor de usuarios
 * permite o prohibe el acceso segun sea el caso.
 * 
 */

/** Definir arreglo con las entidades/acciones permitidas por el trabajador **/
$permisos_trabajador = array();
$permisos_trabajador['liquidacion']['listar_trabajador'] = 1;
$permisos_trabajador['anticipo']['solicitar'] = 1;
$permisos_trabajador['vacaciones']['mis_solicitudes'] = 1;
$permisos_trabajador['vacaciones']['solicitar'] = 1;
$permisos_trabajador['relojcontrol']['me'] = 1;
$permisos_trabajador['usuario']['perfil'] = 1;
 
/** Si el trabajador es jefe de area **/
if( $_SESSION[ PREFIX . 'is_jefe' ] ){
    $permisos_trabajador['relojcontrol']['listar'] = 1;
    $permisos_trabajador['relojcontrol']['editar'] = 1;
    $permisos_trabajador['relojcontrol']['listar_trabajadores'] = 1;
    $permisos_trabajador['vacaciones']['ver_solicitudes'] = 1;
    $permisos_trabajador['vacaciones']['calendario'] = 1;
}

if( $_SESSION[ PREFIX . 'login_admin'] != 1 ){
    
    /** Primero Obtener Roles de la BD **/
    $db->where('id', $_SESSION[ PREFIX . 'login_uid' ]);
    $menu_items = $db->getValue('m_usuario','roles');
    $menu_items = json_decode( $menu_items );
    
    if( ( $entity != "" ) && ( $entity != "dashboard" ) && ( $entity != "login" ) ){ /** Todos pueden ver el dashboard **/
        
        $allow_access = 0;
        if( $_SESSION[PREFIX.'is_trabajador'] ){
            if( !isset( $permisos_trabajador[$entity][$action] ) ){
                $allow_access = 0;
            } else {
                $allow_access = 1;
            }
        } else {        
            if( !isset($menu_items->$entity) ){ /** Checkear Si tiene permisos para la entidad **/
                $allow_access = 0;
            } else { /** Si tiene permiso para la entidad, ahora checkea las acciones **/
                if( !isset( $menu_items->$entity->$action ) ){
                    $allow_access = 0;
                } else {
                    $allow_access = 1;         
                }
            }
        }        
        
        if( !$allow_access ){
            redirect(BASE_URL,'',true,'Ud. no tiene permiso para esta secci\u00f3n');
            exit();   
        }        
    
    }
}

?>