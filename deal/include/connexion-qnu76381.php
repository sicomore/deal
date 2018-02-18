<?php

$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$pdo = new PDO (
  'mysql:host=cl1-sql20; dbname=qnu76381',
  'qnu76381', 'OQ9WOt3OjmGt', $options
);

?>
