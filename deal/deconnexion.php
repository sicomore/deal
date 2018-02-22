<?php require_once __DIR__.'/include/init.php';

// session_destroy();
unset($_SESSION['membre']);
// Supprime l'entrée du membre dans la $_SESSION

$redirect = (!empty($_SERVER['HTTP_REFERER']))
  ?  $_SERVER['HTTP_REFERER']
  : 'index.php'
;

header('Location: '. $redirect);
die;
