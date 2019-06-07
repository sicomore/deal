<?php
namespace controller;

/**
*
*/
class ControllerMembre extends ControllerMaitre {

  public function actionConnexionMembre() {
  $this->startSession();

  $message = [];
  $user = [];


  if (!empty($_POST)) {
    // sanitizePost();

    if (empty($_POST['pseudo'])) {
    $message[] = 'Votre pseudo est obligatoire.';
    }
    if (empty($_POST['mdp'])) {
    $message[] = 'Le mot de passe est obligatoire.';
    }

    if (empty($message)) {

    $affichage = new \model\ModelMembre();
    $user = $affichage->selectMembre($_POST['pseudo'], $_POST['mdp']);
    var_dump('User : ',$user);

    if ($user == false) {
      $message[] = 'Le login et/ou le mot de passe n\'est pas reconnu';
    } else {
      if (password_verify($_POST['mdp'],$user['mdp'])) {
      $_SESSION['membre']['pseudo'] = $user['pseudo'];
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
  <p><?php echo $_POST; ?></p>
  </div>';

  $result = [
    'message' => $message,
    'affichageMessage' => $this->affichageMessage($message)
  ];

  $nomClasse = explode('\\', __CLASS__);
  $nomClasse = end($nomClasse);
  $dossier = lcfirst($nomClasse);
  $fichier = __FUNCTION__;
  $chemin = '../view/'.$dossier.'/'.$fichier.'.php';

  $this->render($result, $chemin);
  }



  public function actionListeMembres() {

  $this->startSession();

  $message = [];

  // Affichage des annonces (Pagination)
  // $annoncesParPage = 10;
  // $nbTotalAnnonces = $stmt->rowCount();
  // $nbPages = ceil($nbTotalAnnonces/$annoncesParPage);
  //
  // if(isset($_GET['p']) && !empty($_GET['p'])) {
  //   $pageChoisie = (int)$_GET['p'];
  //   if($pageChoisie > $nbPages) {
  //     $pageChoisie = $nbPages;
  //   }
  // } else {
  //   $pageChoisie = 1;
  // }
  //
  // if ($nbTotalAnnonces < 1) {
  //   $pageChoisie = 1;
  //   setFlashMessage('Aucune annonce disponible pour cette sélection', 'info');
  // }
  //
  // $premiereAnnonce = ($pageChoisie-1) * $annoncesParPage;
  //
  // Limitation des annonces à 10 par page
  // $req .= ' LIMIT '.$premiereAnnonce.', '.$annoncesParPage;
  // $stmt = $pdo->query($req);

  $affichage = new \model\ModelMembre();
  $listeUsers = $affichage->affichageMembres();

  if (!$listeUsers) {
    $message[] = 'Aucun membre n\'a été trouvé.';
  }

  $affichageMessage =
  '<div class="alert alert-info">
  <h5 class="alert-heading">Vous avez un message :</h5>
  <hr>
  <p>'.implode ('<br>', $message).'</p>
  </div>';

  $nomClasse = explode('\\', __CLASS__);
  $nomClasse = end($nomClasse);
  $dossier = lcfirst($nomClasse);
  $fichier = __FUNCTION__;
  $chemin = '../view/'.$dossier.'/'.$fichier.'.php';

  $result = [
    'affichageMessage' => $this->affichageMessage($message),
    'listeMembres' => $listeUsers
  ];

  $this->render($result, $chemin);
  }

}
