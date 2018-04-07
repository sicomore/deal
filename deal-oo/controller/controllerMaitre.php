<?php

class ControllerMaitre {

  public function startSession() {
    session_start();
  }

  public function redirect($session) {
    if (empty($session)) {
      header('Location: ../www/index.php');
    };
  }

  public function render($chemin, $donnees) {
    ob_start();

    extract($donnees);
    include $chemin;

    $vue = ob_get_clean();

    include '../views/template.php';
  }
}
