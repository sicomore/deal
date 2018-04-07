<?php

/**
 *
 */
class ModelMaitre extends Bdd {

  // function __construct(argument) {
  //   # code...
  // }

  public function connexionBdd() {

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $ids = $this->idBdd();

    $pdo = new PDO(
      'mysql:host='.$ids['hostname'].'; dbname='.$ids['dbname'], $ids['username'], $ids['password'], $options
    );

    return $pdo;

  }
}
