<?php

/**
 * Plantilla general de controladores
 * Versión 1.0.2
 *
 * Controlador de materias
 */
class materiasController extends Controller {
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
    $data = 
    [
      'title' => 'Todas las Materias',
      'slug'  => 'materias',
      'materias' => materiaModel::all_paginated(),
      'button'   => ['url'=>'materias/agregar','text'=>'<i class="fas fa-plus"></i> Agregar Materia']
    ];
    
    // Descomentar vista si requerida
    View::render('index', $data);
  }

  function ver($id)
  {
    if(!$materia=materiaModel::by_id($id)){
      Flasher::new('No existe la materia en la base de datos','danger');
      Redirect::to('materias');
    }

    $data = 
    [
      'title' => sprintf('Viendo %s',$materia['nombre']),
      'slug'  => 'materias',
      'button'   => ['url'=>'materias','text'=>'<i class="fas fa-table"></i>Materias'],
      'm' => $materia
    ];
    View::render('ver',$data);
  }

  function agregar()
  {
    $data = 
    [
      'title'=>'Agregar Materia',
      'slug'=>'materias',
      'button'   => ['url'=>'materias','text'=>'<i class="fas fa-table"></i>Materias'],
    ];
    View::render('agregar',$data);
  }

  function post_agregar()
  {
    try {
      if(!check_posted_data(['csrf','nombre','descripcion'],$_POST) || !Csrf::validate($_POST['csrf'])){
        throw new Exception(getNotification());
        Flasher::deny();
        Redirect::back();
      }

      //Validar rol
      if(!is_admin(get_user_rol())){
        throw new Exception(getNotification(1));
      }

      $nombre = clean($_POST['nombre']);
      $descripcion = clean($_POST['descripcion']);

      if(strlen($nombre)<5){
        throw new Exception('El nombre es muy corto');
      }

      //Validar que el nombre de la materia no exista en la base de datos
      $sql = 'SELECT * FROM materias WHERE nombre = :nombre LIMIT 1';
      if(materiaModel::query($sql,['nombre'=>$nombre])){
        throw new Exception(sprintf('Ya existe la materia <b>%s</b> en la base de datos', $nombre));
      }

      $data=
      [
        'nombre'=>$nombre,
        'descripcion'=>$descripcion,
        'creado'=>now()
      ];

      //insertar a la base de datos 
      if(!$id=materiaModel::add(materiaModel::$t1,$data)){
        throw new Exception('Error al guardar el registro.');
      }

      Flasher::new(sprintf('Materia <b>%s</b> agregada con exito.',$nombre),'success');
      Redirect::back();

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
      if(!check_posted_data(['csrf','id','nombre','descripcion'],$_POST) || !Csrf::validate($_POST['csrf'])){
        throw new Exception('Acceso no autorizado.');
        Flasher::deny();
        Redirect::back();
      }

      //Validar rol
      if(!is_admin(get_user_rol())){
        throw new Exception(getNotification(1));
      }

      $id = clean($_POST['id']);
      $nombre = clean($_POST['nombre']);
      $descripcion = clean($_POST['descripcion']);

      if(!$materia=materiaModel::by_id($id)){
        throw new Exception('No existe la materia en la base de datos.');
      }

      //Validar que el nombre de la materia no exista en la base de datos
      $sql = 'SELECT * FROM materias WHERE id!=:id and nombre = :nombre LIMIT 1';
      if(materiaModel::query($sql,['id'=>$id,'nombre'=>$nombre])){
        throw new Exception(sprintf('Ya existe la materia <b>%s</b> en la base de datos', $nombre));
      }

      if(strlen($nombre)<5){
        throw new Exception('El nombre es muy corto');
      }

      $data=
      [
        'nombre'=>$nombre,
        'descripcion'=>$descripcion,
        'button'   => ['url'=>'materias','text'=>'<i class="fas fa-table"></i>Materias'],
      ];

      //insertar a la base de datos 
      if(!materiaModel::update(materiaModel::$t1,['id'=>$id],$data)){
        throw new Exception('Error al actualizar el registro.');
      }

      Flasher::new(sprintf('Materia <b>%s</b> actualizada con exito.',$nombre),'success');
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

      if(!$materia=materiaModel::by_id($id)){
        throw new Exception('No existe la materia en la base de datos.');
      }

      //Eliminar el registro de la base de datos 
      if(!materiaModel::remove(materiaModel::$t1,['id'=>$id],1)){
        throw new Exception(getNotification(2));
      }

      Flasher::new(sprintf('Materia <b>%s</b> Borrada con exito.',$materia['nombre']),'success');
      Redirect::back();

    } catch (PDOException $e) {
      Flasher::new($e->getMessage(),'danger');
      Redirect::back();
    } catch (Exception $e) {
      Flasher::new($e->getMessage(),'danger');
      Redirect::back();
    }
  }
}