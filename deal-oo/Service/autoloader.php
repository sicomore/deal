<?php
namespace service;
/**
* Classe autoloader des classes
*/
class Autoloader {

  public function spl_register() {
    spl_autoload_register([__CLASS__, 'chargementClasses']);
  }

  private function chargementClasses($classe) {

    // Si les classes sont contenues dans des namespaces : (ex: $classe = controller\ControllerMembre)
    $nomComplet = str_replace('\\', '/', $classe);  // controller/ControllerMembre
    $nomDecompose = explode('/', $nomComplet); // [controller, ControllerMembre]
    $classeSeule = end($nomDecompose);  // ControllerMembre

    $dossier = reset($nomDecompose);  // controller
    $fichier = lcfirst($classeSeule);  // controllerMembre

    include '../'.$dossier.'/'.$fichier.'.php';

  }
}
