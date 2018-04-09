<?php
namespace controllers;

include '../models/ModelMembre.php';
include '../controllers/controllerMaitre.php';

/**
*
*/
class ControllerMembre extends ControllerMaitre {

  public function actionConnexionMembre() {

    $message = [];
    $user = '';

    if (!empty($_POST)) {
      sanitizePost();
      extract($_POST);

      if (empty($_POST['pseudo'])) {
        $message[] = 'Votre pseudo est obligatoire.';
      }
      if (empty($_POST['mdp'])) {
        $message[] = 'Le mot de passe est obligatoire.';
      }

      if (empty($message)) {

        $affichage = new models\ModelMembre();
        $user = $affichage->selectMembre($_POST['pseudo'], $_POST['mdp']);

        if ($user == false) {
          $message[] = 'Le login et/ou le mot de passe n\'est pas reconnu';
        } else {
          if (password_verify($mdp,$user['mdp'])) {
            $_SESSION['membre'] = $user;
            $message[] = 'Vous êtes bien connecté.';
            // header('Location: index.php');
            // die;
          }
        }
      }
    }

    $affichageMessage =
    '<div class="alert alert-info">
      <h5 class="alert-heading">Vous avez un message :</h5>
      <hr>
      <p>'.implode ('<br>', $message).'</p>
    </div>';

    $result = [
      'affichageMessage' => $affichageMessage,
      'session' => $user
    ];

    $dossier = lcfirst(__CLASS__);
    $fichier = __FUNCTION__;
    $chemin = '../views/'.$dossier.'/'.$fichier.'.php';

    $this->render($chemin, $result);
  }


  // public function actionEditMembre() {
  //
  //
  //
  //   $this->render($chemin, $donnees);
  // }




}
