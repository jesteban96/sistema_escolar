<?php

/**
 * Plantilla general de modelos
 * Versión 1.0.1
 *
 * Modelo de profesor
 */
class profesorModel extends Model {
  public static $t1   = 'usuarios'; // Nombre de la tabla en la base de datos;
  
  // Nombre de tabla 2 que talvez tenga conexión con registros
  //public static $t2 = '__tabla 2___'; 
  //public static $t3 = '__tabla 3___'; 

  function __construct()
  {
    // Constructor general
  }
  
  static function all()
  {
    // Todos los registros
    $sql = 'SELECT * FROM usuarios WHERE rol = "profesor" ORDER BY id DESC';
    return ($rows = parent::query($sql)) ? $rows : [];
  }

  static function all_paginated()
  {
    // Todos los registros
    $sql = 'SELECT * FROM usuarios WHERE rol="profesor" ORDER BY id DESC';
    return PaginationHandler::paginate($sql);
  }

  static function by_id($id)
  {
    // Un registro con $id
    $sql = 'SELECT * FROM usuarios WHERE rol="profesor" AND  id = :id LIMIT 1';
    return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : [];
  }

  static function by_numero($numero)
  {
    // Un registro con $numero
    $sql = 'SELECT * FROM usuarios WHERE rol="profesor" AND  numero = :numero LIMIT 1';
    return ($rows = parent::query($sql, ['numero' => $numero])) ? $rows[0] : [];
  }

  public function asignarMateria($id_profesores,$id_materias)
  {
    $data = 
    [
      'id_materias' => $id_materias,
      'id_profesores' => $id_profesores
    ];

    if(!$id=self::add('materiasxprofesores',$data)) return false;

    return $id;
  }
}

