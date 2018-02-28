<?php
/**
* Edition des annonces
*/
class Annonce {

  private $titre;
  private $description_courte;
  private $description_longue;
  private $prix;
  private $photoActuelle;
  private $ville;
  private $adresse;
  private $code_postal;
  private $categorie;
  private $region;

  // function __construct($prop) {
  //   foreach($prop as $key => $value){
  //     $methode = 'set' . ucfirst($key);
  //     $this->$methode($value);
  //   }
  // }

  // SETTERS
  public function __set($propriete, $valeur) {
    if (!property_exists($this, $propriete)) {
      echo '<p>La propriété '.$propriete.' n\'existe pas dans la classe '.get_class($this).'</p>';
    } else {
      echo '<p>Pour renseigner la propriété '.$propriete.' de la classe Voiture avec la valeur '.$valeur.' utiliser la méthode set.</p>';
    }
  }

  public function setTitre($arg) {
    if (!is_string($arg)) {
      return 'La propriété n\'a pas le bon format : chaine attendue';
    }
    $this->titre = $arg;
  }
  public function setDescription_courte($arg) {
    if (!is_string($arg)) {
      return 'La propriété '.$arg.' n\'a pas le bon format : chaine attendue';
    }
    $this->description_courte = $arg;
  }
  public function setDescription_longue($arg) {
    if (!is_string($arg)) {
      return 'La propriété '.$arg.' n\'a pas le bon format : chaine attendue';
    }
    $this->description_longue = $arg;
  }

  // public function setPhotoActuelle($arg) {
  //   if ($_FILES['photo']['size'] > 1000000) {
  //     return 'La photo doit avoir une taille inférieure à 1 Mo';
  //   }
  //   $allowedMimeType = ['image/jpeg', 'image/png', 'image/gif' ];
  //   if (!in_array($_FILES['photo']['type'], $allowedMimeType)) {
  //     return 'La photo doit être une photo de type jpg, jpeg, png ou gif.';
  //   }
  //
  //   $dotPosition = strrpos($_FILES['photo']['name'], '.');
  //   $extension = substr($_FILES['photo']['name'], $dotPosition);
  //   $reference = md5(time(10));
  //   $nomFichier = $reference . $extension;
  //
  //   // suppression de la photo initiale si on la modifie (écrase le fichier)
  //   if (!empty($photoActuelle)) {
  //     unlink(PHOTO_DIR . $photoActuelle);
  //   }
  //   move_uploaded_file(
  //     $_FILES['photo']['tmp_name'], PHOTO_DIR . $nomFichier
  //   );
  //   $this->photoActuelle = $arg;
  // }

  public function setPrix($arg) {
    if (!is_int($arg)) {
      return 'La propriété '.$arg.' n\'a pas le bon format : nombre attendu';
    }
    $this->prix = $arg;
  }

  public function setVille($arg) {
    if (!is_string($arg)) {
      return 'La propriété '.$arg.' n\'a pas le bon format : chaine attendue';
    }
    $this->ville = $arg;
  }
  public function setAdresse($arg) {
    if (!is_string($arg)) {
      return 'La propriété '.$arg.' n\'a pas le bon format : chaine attendue';
    }
    $this->adresse = $arg;
  }
  public function setCode_postal($arg) {
    if (strlen($arg) != 5 || !ctype_digit($arg)) {
      return 'La propriété '.$arg.' n\'a pas le bon format : nombre à 5 chiffres attendu';
    }
    $this->code_postal = $arg;
  }
  public function setCategorie($arg) {
    if (!is_string($arg)) {
      return 'La propriété '.$arg.' n\'a pas le bon format : chaine attendue';
    }
    $this->categorie = $arg;
  }
  public function setRegion($arg) {
    if (!is_string($arg)) {
      return 'La propriété '.$arg.' n\'a pas le bon format : chaine attendue';
    }
    $this->region = $arg;
  }


  // GETTERS
  public function __get($propriete) {
    if (!property_exists($this, $propriete)) {
      echo '<p>La propriété '.$propriete.' n\'existe pas dans la classe '.__CLASS__.'</p>';
    } else {
      echo '<p>Pour visualiser la propriété '.$propriete.' de la classe '.get_class($this).', utiliser la méthode get.</p>';
    }
  }

  public function getTitre() {
    if (empty($this->titre)) {
      return 'La propriété Titre est vide';
    }
    return $this->titre;
  }

  public function getDescription_courte() {
    if (empty($this->description_courte)) {
      return 'La propriété description_courte est vide';
    }
    return $this->description_courte;
  }

  public function getDescription_longue() {
    if (empty($this->description_longue)) {
      return 'La propriété Description_longue est vide';
    }
    return $this->description_longue;
  }

  public function getPhotoActuelle() {
    if (empty($this->PhotoActuelle)) {
      return 'La propriété PhotoActuelle est vide';
    }
    return $this->PhotoActuelle;
  }

  public function getPrix() {
    if (empty($this->prix)) {
      return 'La propriété Prix est vide';
    }
    return $this->prix;
  }

  public function getVille() {
    if (empty($this->ville)) {
      return 'La propriété Ville est vide';
    }
    return $this->ville;
  }

  public function getAdresse() {
    if (empty($this->adresse)) {
      return 'La propriété Adresse est vide';
    }
    return $this->adresse;
  }
  public function getCode_postal() {
    if (empty($this->codePostal)) {
      return 'La propriété CodePostal est vide';
    }
    return $this->codePostal;
  }
  public function getCategorie() {
    if (empty($this->categorie)) {
      return 'La propriété Categorie est vide';
    }
    return $this->categorie;
  }
  public function getRegion() {
    if (empty($this->region)) {
      return 'La propriété Region est vide';
    }
    return $this->region;
  }
}
