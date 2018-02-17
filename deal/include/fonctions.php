<?php
// ============== TOUTES LES FONCTIONS UTILISEES ==============

// Fonctions de nettoyage des données entrées par le membre dans le formulaire ------------------------
// Supprime les balises HTML des champs renseignés
function sanitizeValue (&$value) {
  $value = trim(strip_tags($value));
}

// Applique la fonction à toutes les valeurs du Tableau
function sanitizeArray (array &$array){
  array_walk($array, 'sanitizeValue');
}

// Nettoie toutes les données reçues depuis un form
function sanitizePost () {
  sanitizeArray($_POST);
}

// Fonction qui vérifie que le membre est bien connecté
function isUserConnected () {
  return isset($_SESSION['membre']);
}

// fonction qui renvoie le nom et prenom du membre
function getUserFullName () {
  if (isUserConnected()) {
    return $_SESSION['membre']['prenom'].' '.$_SESSION['membre']['nom'];
  }
  return '';
}

// fonction qui renvoie le pseudo du membre
function getPseudo () {
  if (isUserConnected()) {
    return $_SESSION['membre']['pseudo'];
  }
  return '';
}

// Fonction qui vérifie que le membre est bien un admin
function isUserAdmin () {
  return isUserConnected() && $_SESSION['membre']['role'] == 'admin';
}

// Fonction pour empêcher l'accès à une page sans droits admin
// A appeler en haut de toutes les pages d'accès admin
function adminSecurity () {
  if (!isUserAdmin()) {
    if (!isUserConnected()) {
      header('Location: '.SITE_PATH.'connexion.php');
    } else {
      header('HTTP/1.1 403 Forbidden');
      echo "<p>Vous ne pouvez accéder à cette page en tant qu'membre</p>";
      echo '<p><a href="'.SITE_PATH.'connexion.php">Me connecter</a></p>';
      die;
    }
  }
}

// Enregistre un message dans la session
function setFlashMessage ($message, $type='success') {
  $_SESSION['flashMessage'] = [
    'message' => $message,
    'type' => $type
  ];
}

// Change la class "alert-error" en "alert-danger" de Bootstrap
function displayFlashMessage () {
  if (isset($_SESSION['flashMessage'])) {
    $message = $_SESSION['flashMessage']['message'];
    $type = ($_SESSION['flashMessage']['type'] == 'error')
    ? 'danger'
    : $_SESSION['flashMessage']['type']
    ;
    echo '<div class="alert alert-'. $type .'">'.
    '<strong>'.$message.'</strong>'.
    '</div>';
    unset($_SESSION['flashMessage']);
  }
}
