<?php
require_once __DIR__.'/include/init.php';

$categorieSelect = $regionSelect = $membreSelect = $reqC = $reqR = $reqM = '';
$triSelect = 'a.id desc';

// // Select des prix
// $req = 'SELECT id, prix FROM annonce';
// $stmt = $pdo->query($req);
// $categories = $stmt->fetchAll();

// Select des catégories
$req = 'SELECT * FROM categorie';
$stmt = $pdo->query($req);
$categories = $stmt->fetchAll();

// Select des régions
$req = 'SELECT * FROM region';
$stmt = $pdo->query($req);
$regions = $stmt->fetchAll();

// Select des membres
$req = 'SELECT * FROM membre';
$stmt = $pdo->query($req);
$membres = $stmt->fetchAll();

// // Notes moyennes
// $req = 'SELECT AVG(note), membre_id2 FROM notes GROUP BY membre_id2 ORDER BY 1 desc';
// $stmt = $pdo->query($req);
// $notes = $stmt->fetchAll();

// Select des tris
$req = 'SELECT * FROM tri';
$stmt = $pdo->query($req);
$tris = $stmt->fetchAll();

if ($_POST) {
  extract($_POST);

  $reqC = (!empty($categorieSelect)) ? 'AND a.categorie_id = '.$categorieSelect.' ' : '';
  $reqR = (!empty($regionSelect)) ? 'AND a.region_id = '.$regionSelect.' ' : '';
  $reqM = (!empty($membreSelect)) ? 'AND a.membre_id = '.$membreSelect.' ' : '';
  // $reqP = (!empty($prixSelect)) ? 'AND a.prix <= '.$prixSelect.' ' : '';
}
// var_dump($triSelect);
// var_dump($_POST);

$req = 'SELECT a.*, m.id idMembre, m.pseudo pseudo, c.id idCategorie, c.titre categorie, r.id idRegion, r.nom region FROM annonce a, categorie c, membre m, region r WHERE r.id = a.region_id AND m.id = a.membre_id AND c.id = a.categorie_id '
.$reqC.$reqR.$reqM
// .$reqP
.'ORDER BY '. $triSelect
// .' LIMIT 5'
;
$stmt = $pdo->query($req);
$annonces = $stmt->fetchAll();

// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__.'/layout/top.php';
?>

<div class="container-fluid" id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Accueil</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-9">
      <form class="form-group" method="post" id="filtres">

        <div class="col-sm-3 form-group">
          <label for="">Catégories</label>
          <!-- <div class="input-group"> -->
          <select class="form-control" name="categorieSelect" id="categories">
            <option value="">Toutes les catégories</option>
            <?php
            foreach ($categories as $categorie) {
              $selected = ($categorie['id'] == $categorieSelect) ? 'selected' : '';
              echo '<option value="'.$categorie['id'].'" '.$selected.'>'.$categorie['titre'].
              '</option>';
            };
            ?>
          </select>
        </div>

        <div class="col-sm-3 form-group">
          <label for="">Régions</label>
          <select class="form-control" name="regionSelect" id="regions">
            <option value="">Toutes les régions</option>
            <?php
            foreach ($regions as $region) :
              $selected = ($region['id'] == $regionSelect) ? 'selected' : '';
              echo '<option value="'.$region['id'].'" '.$selected.'>'.$region['nom'].
              '</option>';
            endforeach;
            ?>
          </select>
        </div>

        <div class="col-sm-3 form-group">
          <label for="">Membres</label>
          <select class="form-control" name="membreSelect" id="membres">
            <option value="">Tous les membres</option>
            <?php
            foreach ($membres as $membre) :
              $selected = ($membre['id'] == $membreSelect) ? 'selected' : '';
              echo '<option value="'.$membre['id'].'" '.$selected.'>'.$membre['pseudo'].
              '</option>';
            endforeach;
            ?>
          </select>
        </div>

        <!-- <div class="col-sm-3 form-group">
          <label for="">Membres</label>
          <select class="form-control" name="membreSelect" id="membres">
            <option value="">Tous les membres</option>
            <?php
            foreach ($membres as $membre) :
              $selected = ($membre['id'] == $membreSelect) ? 'selected' : '';
              echo '<option value="'.$membre['id'].'" '.$selected.'>'.$membre['pseudo'].
              '</option>';
            endforeach;
            ?>
          </select>
        </div> -->

        <div class="col-sm-3 form-group">
          <label for=""></label>
          <button class="col-xs-12 btn btn-primary pull-right" type="submit"><i class="fa fa-search"></i> Sélectionner</button>
        </div>
      </div>

      <div class="col-sm-3">
        <label for="">Trier par ...</label>
        <div class="input-group">
          <select class="form-control" name="triSelect" id="triSelect">
            <?php
            foreach ($tris as $tri) :
              $selected = ($tri['tri'] == $triSelect) ? 'selected' : '';
              echo '<option value="'.$tri['tri'].'" '.$selected.'>'.$tri['option'].
              '</option>';
            endforeach;
            ?>
          </select>
          <span class="input-group-btn">
            <button class="btn btn-primary form-group-btn pull-right" type="submit"><i class="fa fa-sort"></i> Trier</button>
          </span>
        </div>
      </form>
    </div>
  </div>


  <div class="container">
    <?php foreach ($annonces as $annonce) : ?>
      <div class="row">

        <div class="panel panel-info" id="annonces-accueil">
          <div class="panel-heading">
            <div class="row">
              <div class="col-sm-8">
                <h4><?= $annonce['titre'] ?></h4>
              </div>
              <div class="col-sm-4">
                <div class="pull-right">
                  <strong>Catégorie</strong> : <?= $annonce['categorie']; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="panel-body">
            <div class="row">
              <div class="col-sm-2">
                <img src='<?= PHOTO_WEB.$annonce['photo']; ?>' style="width: 100px;">
              </div>
              <div class="col-sm-2">
                <div class="well">
                  <h3><strong><?= round($annonce['prix'],2); ?> €</strong></h3>
                </div>
              </div>
              <div class="col-sm-8">
                <p><b>Description :</b> <?= $annonce['description_courte']; ?></p>
                <p><b>Région :</b> <?= $annonce['region']; ?></p>
                <p><b>Date de parution :</b> <?= strftime('%d/%m/%Y',strtotime($annonce['date_enregistrement'])); ?></p>
              </div>
            </div>
          </div>
          <div class="panel-footer">
            <div class="row">
              <div class="col-sm-4">
                <strong> Vendeur</strong> : <?= $annonce['pseudo']; ?>
              </div>
              <div class="col-sm-4">
                <?php
                $req = 'SELECT AVG(note) noteMoy FROM notes GROUP BY membre_id2 HAVING membre_id2 = '. $annonce['idMembre'];
                $stmt = $pdo->query($req);
                $notes = $stmt->fetchColumn();
                $star = '';
                for ($i=0; $i<round($notes); $i++) {
                  $star .= '<i class="fa fa-star"></i>';
                }
                if ((round($notes,1)*10)%10 != 0) {
                  $star .= '<i class="fa fa-star-half"></i>';
                }
                ?>
                Note : <?= $star; ?>
              </div>
              <div class="col-sm-4">
                <a href="<?= SITE_PATH; ?>annonce-fiche.php?id=<?= $annonce['id']; ?>" class="btn btn-primary pull-right">Voir la fiche</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php
include __DIR__.('/layout/bottom.php');
?>
