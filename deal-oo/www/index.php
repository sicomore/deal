<?php

include '../routing/routes.php';

if (!empty($_GET)) {

  foreach ($routes as $key => $value) {
    if ($_GET == $cle) {

      $classe = 'Controller'.$value['controller'];

      // A éliminer une fois l'autoloader mis en place
      include '../controllers/'.lcfirst($classe).'.php';

      $methode = 'action'.$value['action'];
      echo $methode;
      $action = new $classe();
      $action->$methode();

    }
  }

} else {
  include '../controllers/controllerMembre.php';
  $pageMembres = new controllers\ControllerMembre();
  $pageMembres->actionConnexionMembre();
}
