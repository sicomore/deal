<?php
namespace model;

class Bdd {

  public function idBdd() {
    $ids = [
      'hostname' => 'localhost',
      'dbname' => 'deal',
      'username' => 'admin',
      'password' => ''
    ];
    return $ids;
  }
}
