<?php
namespace models;
/**
*
*/
class ModelAnnonce extends ModelMaitre {

  public function selectAnnonce($reqC='',$reqR='',$reqM='',$reqPm='',$reqPM='', $triPar='a.id DESC') {

    $pdo->connexionBdd();

    $req = 'SELECT a.*, m.id idMembre, m.pseudo pseudo, c.id idCategorie, c.titre categorie, r.id idRegion, r.nom region '
    .'FROM annonce a, categorie c, membre m, region r '
    .'WHERE r.id = a.region_id AND m.id = a.membre_id AND c.id = a.categorie_id AND a.dispo = \'active\' '
    .$reqC.$reqR.$reqM.$reqPm.$reqPM
    .' ORDER BY '. $triPar;

    $stmt = $pdo->query($req);
    $annoncesToutes = $stmt->fetchAll();

    return $annoncesToutes;

  }


  public function addAnnonce($titre, $description_courte, $description_longue, $prix, $photo, $ville, $adresse, $code_postal, $membre_id, $categorie_id, $region_id) {

    $pdo->connexionBdd();

    $req = 'INSERT INTO annonce (titre, description_courte, description_longue, prix, photo, ville, adresse, code_postal, membre_id, categorie_id, region_id) '.
    'VALUES (:titre, :description_courte, :description_longue, :prix, :photo, :ville, :adresse, :code_postal, :membre_id, :categorie_id, :region_id)';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':titre', $titre);
    $stmt->bindValue(':description_courte', $description_courte);
    $stmt->bindValue(':description_longue', $description_longue);
    $stmt->bindValue(':prix', $prix);
    $stmt->bindValue(':ville', $ville);
    $stmt->bindValue(':adresse', $adresse);
    $stmt->bindValue(':code_postal', $code_postal);
    $stmt->bindValue(':membre_id', $membre_id);
    $stmt->bindValue(':categorie_id', $categorie_id);
    $stmt->bindValue(':region_id', $region_id);
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


  public function updateAnnonce($idAnnonce, $titre, $description_courte, $description_longue, $prix, $photo, $ville, $adresse, $code_postal, $membre_id, $categorie_id, $region_id) {

    $this->connexionBdd();

    if ($idAnnonce && $titre && $description_courte && $description_longue && $prix && $photo && $ville && $adresse && $code_postal && $membre_id && $categorie_id && $region_id) {

      $req = 'UPDATE annonce SET titre = :titre, description_courte = :description_courte, description_longue = :description_longue, prix = :prix, categorie_id = :categorie_id, photo = :photo, region_id = :region_id, ville = :ville, adresse = :adresse, code_postal = :code_postal WHERE id = :id';
      $stmt = $pdo->prepare($req);

      $stmt->bindValue(':idAnnonce', $idAnnonce);
      $stmt->bindValue(':titre', $titre);
      $stmt->bindValue(':description_courte', $description_courte);
      $stmt->bindValue(':description_longue', $description_longue);
      $stmt->bindValue(':prix', $prix);
      $stmt->bindValue(':ville', $ville);
      $stmt->bindValue(':adresse', $adresse);
      $stmt->bindValue(':code_postal', $code_postal);
      $stmt->bindValue(':categorie_id', $categorie_id);
      $stmt->bindValue(':region_id', $region_id);

      if (!empty($photo)) {
        $stmt->bindValue(':photo', $photo);
      } else {
        $stmt->bindValue(':photo', null, PDO::PARAM_NULL);
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
  }


  public function deleteAnnonce($idAnnonce) {

    $pdo->connexionBdd();

    $req = 'DELETE FROM annonce WHERE id = :idAnnonce';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':id', $idAnnonce);
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
