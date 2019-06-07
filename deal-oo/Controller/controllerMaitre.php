<?php
namespace controller;

class ControllerMaitre {

  const SITEPATH = '/PROJET-Back-End/deal-oo/';
  const PHOTOWEB = '/PROJET-Back-End/deal-oo/view/assets/photos/';


  public function sitePath() {
    return self::SITEPATH;
  }


  public function photoWeb() {
    return self::PHOTOWEB;
  }


  public function startSession() {
    session_start();
  }


  public function redirect($session) {
    if (empty($session)) {
      header('Location: ../www/index.php');
    };
  }


  public function render($result, $chemin) {
    ob_start();

    extract($result);
    include $chemin;

    $vue = ob_get_clean();

    $sitePath = $this->sitePath();
    include '../View/template.php';
  }


  public function cheminView($classe, $fonction)
  {
    $nomClasse = end(explode('\\', $classe));
    // $nomClasse = end($nomClasse);
    $dossier = lcfirst($nomClasse);
    $fichier = $fonction;
    $chemin = '../View/'.$dossier.'/'.$fichier.'.php';
    return $chemin;
  }


  public function affichageMessage($message) {
    if ($message) {
      $affichageMessage =
      '<div class="alert alert-info">
      <h5 class="alert-heading">Vous avez un message :</h5>
      <hr>
      <p>'.implode ('<br>', $message).'</p>
      </div>';
    } else {
      return false;
    }

    return $affichageMessage;
  }


  public function notFound()
  {
    if ($annonce === false) {
      header('HTTP/1.1 404 Not Found');
      die("La page n'existe pas ou plus");
    }
  }


  // Supprime les balises HTML des champs renseignés
  public function sanitizeValue (&$value) {
    $value = trim(strip_tags($value));
  }

  // Applique la fonction à toutes les valeurs du Tableau
  public function sanitizeArray (array &$array){
    array_walk($array, 'sanitizeValue');
  }

  // Nettoie toutes les données reçues depuis un form
  public function sanitizePost () {
    $this->sanitizeArray($_POST);
  }


  // Fonction qui vérifie que le membre est bien connecté
  public function isUserConnected () {
    return isset($_SESSION['membre']);
  }

  // fonction qui renvoie le nom et prenom du membre
  public function getUserFullName () {
    if ($this->isUserConnected()) {
      return $_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom'];
    }
    return '';
  }

  // fonction qui renvoie le pseudo du membre
  public function getPseudo () {
    if ($this->isUserConnected()) {
      return $_SESSION['membre']['pseudo'];
    }
    return '';
  }

  // Fonction qui vérifie que le membre est bien un admin
  public function isUserAdmin () {
    return $this->isUserConnected() && $_SESSION['membre']['role'] == 'admin';
  }

  // Fonction pour empêcher l'accès à une page sans droits admin
  // A appeler en haut de toutes les pages d'accès admin
  public function adminSecurity () {
    if (!$this->isUserAdmin()) {
      if (!$this->isUserConnected()) {
        header('Location: '.$this->sitePath().'connexion.php');
      } else {
        header('HTTP/1.1 403 Forbidden');
        echo "<p>Vous ne pouvez accéder à cette page en tant que membre.</p>";
        echo '<p><a href="'.$this->sitePath().'connexion.php">Me connecter</a></p>';
        die;
      }
    }
  }



}
