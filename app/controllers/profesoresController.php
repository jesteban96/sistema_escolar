<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de profesores
 */
class profesoresController extends Controller {
  function __construct()
  {
    // Validación de sesión de usuario, descomentar si requerida
    
    if (!Auth::validate()) {
      Flasher::new('Debes iniciar sesión primero.', 'danger');
      Redirect::to('login');
    }

  }
  
  function index()
  {

    if(!is_admin(get_user_rol())){
      Flasher::new(getNotification(),'danger');
      Redirect::back();
    }

    $data = 
    [
      'title' => 'Todos los Profesores',
      'slug'  => 'profesores',
      'profesores' => profesorModel::all_paginated(),
      'button'   => ['url'=>buildURL('profesores/agregar'),'text'=>'<i class="fas fa-plus"></i> Agregar Profesores']
    ];
    
    // Descomentar vista si requerida
    View::render('index', $data);
  }

  function ver($id)
  {
    if(!$profesor=profesorModel::by_numero($id)){
      Flasher::new('No existe el profesor en la base de datos','danger');
      Redirect::back();
    }

    $data = 
    [
      'tite'=>sprintf('Profesor #%s',$profesor['numero']),
      'p'=>$profesor,
      'slug'=>'profesores',
      'button'   => ['url'=>'profesores','text'=>'<i class="fas fa-table"></i> Profesores']
    ];
    View::render('ver',$data);
  }

  function agregar()
  {
    try {
      if(!check_get_data(['_t'],$_GET) || !Csrf::validate($_GET['_t'])){
        throw new Exception(getNotification());
        Flasher::deny();
        Redirect::back();
      }

      //Validar rol
      if(!is_admin(get_user_rol())){
        throw new Exception(getNotification(1));
      }

      $data = 
      [
        'numero'=>rand(111111,999999),
        'nombre'=>null,
        'apellidos'=>null,
        'nombre_completo'=>null,
        'email'=>null,
        'password'=>null,
        'telefono'=>null,
        'hash'=>generate_token(),
        'rol'=>'profesor',
        'status'=>'pendiente',
        'creado'=>now(),
      ];
      

      //insertar a la base de datos 
      if(!$id=profesorModel::add(profesorModel::$t1,$data)){
        throw new Exception('Error al guardar el registro.');
      }

      Flasher::new(sprintf('Profesor <b>%s</b> agregado con exito.',$data['numero']),'success');
      Redirect::to(sprintf('profesores/ver/%s',$data['numero']));

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(),'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(),'danger');
      Redirect::back();
    }
  }

  function post_editar()
  {
    try {
      if(!check_posted_data(['csrf','id','nombre','apellidos','email','telefono','password'],$_POST) || !Csrf::validate($_POST['csrf'])){
        throw new Exception(getNotification());
        Flasher::deny();
        Redirect::back();
      }

      //Validar rol
      if(!is_admin(get_user_rol())){
        throw new Exception(getNotification(1));
      }

      $id = clean($_POST['id']);
      $nombre = clean($_POST['nombre']);
      $apellidos = clean($_POST['apellidos']);
      $email = clean($_POST['email']);
      $telefono = clean($_POST['telefono']);
      $password = clean($_POST['password']);

      //validar que el correo sea valido
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        throw new Exception('Ingresa un correo electronico valido');
        
      }

      if(!$profesor=profesorModel::by_id($id)){
        throw new Exception(getNotification(3));
        
      }

      $data = 
      [
        'nombre'=>$nombre,
        'apellidos'=>$apellidos,
        'nombre_completo'=>sprintf('%s %s',$nombre,$apellidos),
        'email'=>$email,
        'telefono'=>$telefono
      ];

      //en caso de que se cambie el email
      if($profesor['email']!==$email && !in_array($profesor['status'],['pendiente','suspendido'])){
        $data['status'] = 'pendiente';
      }

      //en caso que se cabie la contraseña
      if(!empty($password) && !password_verify($password.AUTH_SALT,$profesor['password'])){
        $data['password'] = password_hash($password.AUTH_SALT, PASSWORD_BCRYPT);
      }

      //Update a la base de datos 
      if(!profesorModel::update(profesorModel::$t1,['id'=>$id],$data)){
        throw new Exception(getNotification(3));
      }

      //Cargar la información del profesor
      $profesor = profesorModel::by_id($id);

      Flasher::new(sprintf('Profesor <b>%s</b> actualizado con exito.',$profesor['nombre_completo']),'success');
      Redirect::back();

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(),'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(),'danger');
      Redirect::back();
    }
  }

  function borrar($id)
  {
    // Proceso de borrado
  }
}