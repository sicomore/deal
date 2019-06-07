<?php
namespace model;
// include 'modelMaitre.php';
/**
*
*/
class ModelTri extends ModelMaitre {

  public function selectTri() {

    $pdo = $this->connexionBdd();

    $req = 'SELECT * FROM tri';
    $stmt = $pdo->query($req);
    $tris = $stmt->fetchAll();

    if (!$tris) {
      return false;
    } else {
      if ($stmt->rowCount() == 0) {
        return false;
      } else {
        return $tris;
      }
    }
  }
}
