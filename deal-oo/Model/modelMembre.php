<?php
namespace model;

// include 'ModelMaitre.php';
/**
 * Recherche du membre dans la BDD
 * $var string
 * return false || array
 */
class ModelMembre extends ModelMaitre {

  public function affichageMembres($join = '') {

    $pdo = $this->connexionBdd();

    $req = 'SELECT * FROM membre m ' . $join . ' ORDER BY m.id DESC';
    $stmt = $pdo->query($req);
    $tousMembres = $stmt->fetchAll();

    if (!$tousMembres) {
      return false;
    } else {
      if ($stmt->rowCount() == 0) {
        return false;
      } else {
        return $tousMembres;
      }
    }

  }

  public function distinctMembres($join = '', $order = 'id DESC')
  {
    $pdo = $this->connexionBdd();

    $req = 'SELECT distinct m.id id, m.pseudo pseudo, m.nom nom, m.prenom prenom, '
    .'m.email email FROM membre m ' . $join . ' ORDER BY m.' . $order;
    $stmt = $pdo->query($req);
    $tousMembres = $stmt->fetchAll();

    if (!$tousMembres) {
      return false;
    } else {
      if ($stmt->rowCount() == 0) {
        return false;
      } else {
        return $tousMembres;
      }
    }
  }


  public function selectMembre($pseudo) {

    $pdo = $this->connexionBdd();

    $req = 'SELECT pseudo, mdp FROM membre WHERE pseudo = :pseudo';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':pseudo', $pseudo);
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
