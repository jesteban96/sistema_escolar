<?php 

/**
 * Regresa el rol del del usuario
 * 
 * @return mixed
 * 
 */

function get_user_rol(){
  return $rol=get_user('rol');
}

function get_defaul_roles(){
  return ['root','admin'];
}

function is_root($rol){
  return in_array($rol,['root']);
}

function is_admin($rol){
  return in_array($rol,['admin','root']);
}

function is_profesor($rol){
  return in_array($rol,['profesor','admin','root']);
}

function is_alumno($rol){
  return in_array($rol,['alumno','admin','root']);
}

// function is_admin($rol){
//   return in_array($rol,['admin']);
// }

function is_user($rol,$roles_aceptados){
  $defaul=get_defaul_roles();

  if(!is_array($roles_aceptados)){
    array_push($defaul,$roles_aceptados);
    return in_array($rol,$defaul);
  }

  return in_array($rol,array_merge($defaul,$roles_aceptados));
}

function getNotification($index=0)
{
  $notificaciones=
  [
    'Acceso no autorizado',
    'Acción no autorizada',
    'Error al borrar el registro.',
    'No existe registro'
  ];

  return isset($notificaciones[$index]) ? $notificaciones[$index] : $notificaciones[0];
}

function getEstadoUsuarios(){
  return[
    ['pendiente','Pendiente de Activación'],
    ['activo','Activo'],
    ['sustendido','Sustendido']
  ];
}

function formatEstadoUsuario($status)
{
  $placeholder ='<div class="badge %s"><i class="%s"></i> %s</div>';
  $clasess="";
  $icon='';
  $text='';

  switch ($status) {
    case 'pendiente':
      $clasess="badge-warning";
      $icon='fas fa-clock';
      $text='Pendiente';
      break;

    case 'activo':
      $clasess="badge-success";
      $icon='fas fa-check';
      $text='Activo';
      break;

    case 'suspendido':
      $clasess="badge-danger";
      $icon='fas fa-times';
      $text='Suspendido';
      break;
    
    default:
      $clasess="badge-danger";
      $icon='fas fa-question';
      $text='Desconocido';
      break;
  }

  return sprintf($placeholder,$clasess,$icon,$text);
}

