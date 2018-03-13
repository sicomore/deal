<?php
require_once __DIR__.'/include/init.php';

$categorieSelect = $regionSelect = $membreSelect = $triSelect = $prixMin = $prixMax = '';
$pageChoisie = 0;


if (!empty($_POST)) {
  extract($_POST);
}

// Select des catégories
$req = 'SELECT distinct c.id id, c.titre titre FROM categorie c JOIN annonce a '
.' ON a.categorie_id IN (SELECT categorie_id FROM annonce)';
$stmt = $pdo->query($req);
$categories = $stmt->fetchAll();

// Select des régions
$req = 'SELECT distinct r.id id, r.nom nom FROM region r JOIN annonce a ON a.region_id = r.id WHERE r.id IN (SELECT region_id FROM annonce)';
$stmt = $pdo->query($req);
$regions = $stmt->fetchAll();

// Select des membres
$req = 'SELECT distinct m.id id, m.pseudo pseudo FROM membre m JOIN annonce a '
.'ON a.membre_id = m.id WHERE m.id IN (SELECT membre_id FROM annonce)';
$stmt = $pdo->query($req);
$membres = $stmt->fetchAll();

// Select des tris
$req = 'SELECT id, tri, options FROM tri';
$stmt = $pdo->query($req);
$tris = $stmt->fetchAll();


$reqC = (!empty($categorieSelect) ? 'AND a.categorie_id = '.$categorieSelect.' ' : '');
$reqR = (!empty($regionSelect) ? 'AND a.region_id = '.$regionSelect.' ' : '');
$reqM = (!empty($membreSelect) ? 'AND a.membre_id = '.$membreSelect.' ' : '');
$reqPm = (!empty($prixMin) ? 'AND a.prix >= '.$prixMin.' ' : '');
$reqPM = (!empty($prixMax) ? 'AND a.prix <= '.$prixMax.' ' : '');
$triPar = (!empty($triSelect) ? $triSelect : 'a.id DESC');

// Affichage de la liste des annonces en fonction des select catégories, régions, membres et du tri
$req = 'SELECT a.*, m.id idMembre, m.pseudo pseudo, c.id idCategorie, c.titre categorie, r.id idRegion, r.nom region '
.'FROM annonce a, categorie c, membre m, region r '
.'WHERE r.id = a.region_id AND m.id = a.membre_id AND c.id = a.categorie_id AND a.dispo = \'active\' '
.$reqC.$reqR.$reqM.$reqPm.$reqPM
.' ORDER BY '. $triPar;

$stmt = $pdo->query($req);
$annoncesToutes = $stmt->fetchAll();

// Affichage des annonces (Pagination)
$annoncesParPage = 5;
$nbTotalAnnonces = $stmt->rowCount();
$nbTotalPages = ceil($nbTotalAnnonces/$annoncesParPage);

if(isset($_POST['page']) && !empty($_POST['page'])) {
  $pageChoisie = $_POST['page'];
  // if(isset($_GET['p']) && !empty($_GET['p'])) {
  // $pageChoisie = (int)$_GET['p'];
  if($pageChoisie > $nbTotalPages) {
    $pageChoisie = $nbTotalPages;
  }

} elseif (isset($_POST['prev']) && !empty($_POST['prev'])) {
  ($pageChoisie-1)<=0 ? $pageChoisie = 1 : $pageChoisie = $pageChoisie-1 ;

} elseif (isset($_POST['next']) && !empty($_POST['next'])) {
  ($pageChoisie > $nbTotalPages) ? '' : $pageChoisie = $pageChoisie+1;

} else {
  $pageChoisie = 1;
}

if ($nbTotalAnnonces < 1) {
  $pageChoisie = 1;
  setFlashMessage('Aucune annonce disponible pour cette sélection', 'info');
}

$premiereAnnonce = ($pageChoisie-1) * $annoncesParPage;


// Limitation des annonces à 5 par page
$req .= ' LIMIT '.$premiereAnnonce.', '.$annoncesParPage;
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

  <?php displayFlashMessage(); ?>

  <form class="form-group" method="post">
    <div class="row">
      <div id="filtres">

        <div class="form-group">
          <label for="categories">Catégories</label>
          <select class="form-control" name="categorieSelect" id="categories">
            <option value="">Toutes les catégories</option>
            <?php
            foreach ($categories as $categorie) {
              $selected = ($categorieSelect == $categorie['id']) ? 'selected' : '';
              echo '<option value="'.$categorie['id'].'" '.$selected.'>'.$categorie['titre'].
              '</option>';
            }; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="regions">Régions</label>
          <select class="form-control" name="regionSelect" id="regions">
            <option value="">Toutes les régions</option>
            <?php
            foreach ($regions as $region) {
              $selected = ($region['id'] == $regionSelect) ? 'selected' : '';
              echo '<option value="'.$region['id'].'" '.$selected.'>'.$region['nom'].
              '</option>';
            }; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="membres">Membres</label>
          <select class="form-control" name="membreSelect" id="membres">
            <option value="">Tous les membres</option>
            <?php foreach ($membres as $membre) {
              $selected = ($membre['id'] == $membreSelect) ? 'selected' : '';
              echo '<option value="'.$membre['id'].'" '.$selected.'>'.$membre['pseudo'].
              '</option>';
            }; ?>
          </select>
        </div>

        <div class="form-group col-sm-2">
          <label for="prixMin">Prix min.</label>
          <input class="form-control" type="text" name="prixMin" value="<?= $prixMin; ?>">
        </div>

        <div class="form-group col-sm-2">
          <label for="prixMax">Prix max.</label>
          <input class="form-control" type="text" name="prixMax" value="<?= $prixMax; ?>">
        </div>

        <div class="form-group">
          <label for="tri">Ordre</label>
          <select class="form-control" name="triSelect" id="tri">
            <!-- <option value="">les plus récentes</option> -->
            <?php foreach ($tris as $tri) {
              $selected = ($tri['tri'] == $triSelect) ? 'selected' : '';
              echo '<option value="'.$tri['tri'].'" '.$selected.'>'.$tri['options'].
              '</option>';
            }; ?>
          </select>
        </div>


        <div class="form-group">
          <label for=""></label>
          <button class="col-xs-12 btn btn-primary pull-right" type="submit"><i class="fa fa-search"></i> Trier</button>
        </div>

      </div>


      <div class="container">
        <?php displayFlashMessage(); ?>
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
                    <a href="<?= PHOTO_WEB.$annonce['photo']; ?>" data-lightbox="lightbox">
                      <img src="<?= PHOTO_WEB.$annonce['photo']; ?>">
                    </a>
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

        <nav aria-label="page navigation" id="pagination">

          <ul class="pagination pagination-lg">
            <!-- <li>
              <input class="btn btn-default < ?= (($pageChoisie-1)<=0) ? 'disabled' : '' ; ?>" type="submit" name="prev" value="&laquo;">
            </li> -->
            <?php for($i = 1; $i <= $nbTotalPages; $i++) {
              if($i == $pageChoisie) {
                echo '<li class="active">'.
                '<input class="btn btn-primary" type="submit" value="'.$i.'" name="page">'.
                '</li>';

              }	else {
                echo '<li>'.
                '<input class="btn btn-default" type="submit" value="'.$i.'" name="page">'.
                '</li>';
              };
            };
            ?>
            <!-- <li>
              <input class="btn btn-default < ?= ($pageChoisie >= $nbTotalPages) ? 'disabled' : '' ; ?>" type="submit" name="next" value="&raquo;">
            </li> -->

          </ul>
        </nav>
      </div>
    </form>
  </div>

  <?php include __DIR__.('/layout/bottom.php'); ?>
