<?php

include '../config/routes.php';
include '../service/autoloader.php';

$autoload = new \service\Autoloader();
$autoload->spl_register();

if (!empty($_GET)) {

  foreach ($_GET as $cle => $valeur) {

    if (isset($cle) && !empty($cle) && empty($valeur)) {

      foreach ($routes as $key => $value) {
        if ($cle == $key) {
          // if ($_GET['page'] == $key) {

          $classe = '\controller\Controller'.$value['controller'];

          $methode = 'action'.$value['action'];
          $action = new $classe();
          $action->$methode();
        }
      }
    } else {
      include '../Controller/controllerAnnonce.php';
      $pageAnnonces = new \controller\ControllerAnnonce();
      $pageAnnonces->actionListeAnnonces();
      die();
    }
  }


} else {
  include '../controller/controllerAnnonce.php';
  $pageAnnonces = new \controller\ControllerAnnonce();
  $pageAnnonces->actionListeAnnonces();
}
