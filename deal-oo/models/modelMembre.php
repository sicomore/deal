<?php
namespace models;

include 'ModelMaitre.php';
/**
 * Recherche du membre dans la BDD
 * $var string
 * return false || array
 */
class ModelMembre extends ModelMaitre {

  public function selectMembre($pseudo, $mdp) {

    $pdo = $this->connexionBdd();

    $req = 'SELECT pseudo, mdp FROM membre WHERE pseudo = :pseudo AND mdp = :mdp';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->bindValue(':mdp', $mdp);
    $bool = $stmt->execute();

    if (!$bool) {
      return false;
    } else {
      if ($stmt->rowCount() == 0) {
        return false;
      } elseif ($stmt->rowCount() > 1) {
        return false;
      } else {
        $connex = $stmt->fetch();
        return $connex;
      }
    }
  }


  public function addMembre($civilite, $pseudo, $nom, $prenom, $mdp, $telephone, $email, $role) {

    $pdo->connexionBdd();

    $req = 'INSERT INTO membre (civilite, pseudo, nom, prenom, telephone, email, mdp) VALUES (:civilite, :pseudo, :nom, :prenom, :telephone, :email, :mdp)';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':civilite', $civilite);
    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->bindValue(':nom', $nom);
    $stmt->bindValue(':prenom', $prenom);
    $stmt->bindValue(':mdp', $mdp);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':telephone', $telephone);
    $result = $stmt->execute();

    if (!$bool) {
      return false;
    } else {
      if ($stmt->rowCount() == 0) {
        return false;
      } else {
        return true;
      }
    }

  }


  public function updateMembre($idMembre, $civilite, $pseudo, $nom, $prenom, $mdp = '', $telephone, $email, $role = '', $reqMdp = '', $reqGet = '') {

    $pdo->connexionBdd();

    $req = 'UPDATE membre SET civilite = :civilite, pseudo = :pseudo, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email '. $reqMdp . $reqGet .'WHERE id = :idMembre';

    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':id', $idMembre);
    $stmt->bindValue(':civilite', $civilite);
    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->bindValue(':nom', $nom);
    $stmt->bindValue(':prenom', $prenom);
    $stmt->bindValue(':telephone', $telephone);
    $stmt->bindValue(':email', $email);

    if (!empty($reqMdp)) {
      $stmt->bindValue(':mdp', $mdp);
    }
    if (!empty($reqGet)) {
      $stmt->bindValue(':role', $role);
    }
    $stmt->execute();

    if (!$bool) {
      return false;
    } else {
      if ($stmt->rowCount() == 0) {
        return false;
      } else {
        return true;
      }
    }
  }


  public function deleteMembre($idMembre) {

    $pdo->connexionBdd();

    $req = 'DELETE FROM membre WHERE id = :idMembre';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':idMembre', $idMembre);
    $bool = $stmt->execute();

    if (!$bool) {
      return false;
    } else {
      if ($stmt->rowCount() == 0) {
        return false;
      } else {
        return true;
      }
    }


  }
}
