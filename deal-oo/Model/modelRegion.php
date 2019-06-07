<?php
namespace model;

/**
* Modèle des régions
*/
class ModelRegion extends ModelMaitre {

  public function listeRegions($join = '') {

    $pdo = $this->connexionBdd();

    $req = 'SELECT distinct r.id id, r.nom nom FROM region r ' . $join . ' ORDER BY r.id';

    $stmt = $pdo->query($req);
    $toutesRegions = $stmt->fetchAll();

    if (!$toutesRegions) {
      return false;
    } else {
      if ($stmt->rowCount() == 0) {
        return false;
      } else {
        return $toutesRegions;
      }
    }
  }
  //
  //
  // public function selectCategorie($id = NULL, $titre = NULL) {
  //
  //   $pdo = $this->connexionBdd();
  //
  //   $req = 'SELECT titre, mots_cles FROM categorie WHERE id = :id OR titre = :titre';
  //
  //   $stmt = $pdo->prepare($req);
  //   $stmt->bindValue(':id', $id);
  //   $stmt->bindValue(':titre', $titre);
  //   $laCategorie = $stmt->execute();
  //
  //   if (!$laCategorie) {
  //     return false;
  //   } else {
  //     if ($stmt->rowCount() == 0) {
  //       return false;
  //     } else {
  //     	$laCategorie = $stmt->fetch();
  //       return $laCategorie;
  //     }
  //   }
  // }
  //
  //
  // public function addCategorie($titre, $mots_cles) {
  //
  //   $pdo = $this->connexionBdd();
  //
  //   $req = 'INSERT INTO categorie (titre, mots_cles) VALUES (:titre, :mots_cles)';
  //   $stmt = $pdo->prepare($req);
  //   $stmt->bindValue(':titre', $titre);
  //   $stmt->bindValue(':mots_cles', $mots_cles);
  //   $bool = $stmt->execute();
  //
  //   if (!$bool) {
  //     return false;
  //   } else {
  //     if ($stmt->rowCount() == 0) {
  //       return false;
  //     } else {
  //       return true;
  //     }
  //   }
  // }
  //
  //
  // public function updateCategorie($id, $titre, $mots_cles) {
  //
  //   $pdo = $this->connexionBdd();
  //
  //   if ($id && $titre && $mots_cles) {
  //
  //     $req = 'UPDATE categorie SET titre = :titre, mots_cles = :mots_cles WHERE id = :id';
  //     $stmt = $pdo->prepare($req);
  //
  //     $stmt->bindValue(':id', $id);
  //     $stmt->bindValue(':titre', $titre);
  //     $stmt->bindValue(':mots_cles', $mots_cles);
  //
  //     $bool = $stmt->execute();
  //
  //     if (!$bool) {
  //       return false;
  //     } else {
  //       if ($stmt->rowCount() == 0) {
  //         return false;
  //       } else {
  //         return true;
  //       }
  //     }
  //   }
  // }
  //
  //
  // public function deleteCategorie($id) {
  //
  //   $pdo = $this->connexionBdd();
  //
  //   $req = 'DELETE FROM categorie WHERE id = :id';
  //   $stmt = $pdo->prepare($req);
  //   $stmt->bindValue(':id', $id);
  //   $bool = $stmt->execute();
  //
  //   if (!$bool) {
  //     return false;
  //   } else {
  //     if ($stmt->rowCount() == 0) {
  //       return false;
  //     } else {
  //       return true;
  //     }
  //   }
  // }
}
