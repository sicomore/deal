<?php
require_once __DIR__.'/include/init.php';

$categorieSelect = $regionSelect = $membreSelect = $reqC = $reqR = $reqM = '';
// $triPar = 'a.id DESC';
// $_SESSION['select'] = [];


// // Select des prix
// $req = 'SELECT id, prix FROM annonce';
// $stmt = $pdo->query($req);
// $categories = $stmt->fetchAll();
// var_dump($_POST);

if ($_POST) {
  extract($_POST);
  $_SESSION['select'] = $_POST;
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
$req = 'SELECT tri, options FROM tri';
$stmt = $pdo->query($req);
$tris = $stmt->fetchAll();


$reqC = (!empty($_SESSION['select']['categorieSelect']) ? 'AND a.categorie_id = '
.$_SESSION['select']['categorieSelect'].' ' : '');
$reqR = (!empty($_SESSION['select']['regionSelect']) ? 'AND a.region_id = '
.$_SESSION['select']['regionSelect'].' ' : '');
$reqM = (!empty($_SESSION['select']['membreSelect']) ? 'AND a.membre_id = '
.$_SESSION['select']['membreSelect'].' ' : '');
$triPar = (!empty($_SESSION['select']['triSelect']) ? $_SESSION['select']['triSelect'] : 'a.id DESC');


$req = 'SELECT a.*, m.id idMembre, m.pseudo pseudo, c.id idCategorie, c.titre categorie, r.id idRegion, r.nom region FROM annonce a, categorie c, membre m, region r WHERE r.id = a.region_id AND m.id = a.membre_id AND c.id = a.categorie_id '
.$reqC.$reqR.$reqM
// .$reqP
.' ORDER BY '. $triPar;

$stmt = $pdo->query($req);
$annoncesToutes = $stmt->fetchAll();

// Affichage des annonces (Pagination)
$annoncesParPage = 5;
$nbTotalAnnonces = $stmt->rowCount();
$nbPages = ceil($nbTotalAnnonces/$annoncesParPage);

if(isset($_GET['p']) && !empty($_GET['p'])) {
  $pageChoisie = (int)$_GET['p'];
  if($pageChoisie > $nbPages) {
    $pageChoisie = $nbPages;
  }
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

  <div class="row">
    <div class="col-sm-9">
      <form class="form-group" method="post" id="filtres">

        <div class="col-sm-3 form-group">
          <label for="categories">Catégories</label>
          <!-- <div class="input-group"> -->
          <select class="form-control" name="categorieSelect" id="categories">
            <option value="">Toutes les catégories</option>
            <?php
            foreach ($categories as $categorie) {
              $selected = ($categorie['id'] == $_SESSION['select']['categorieSelect']) ? 'selected' : '';
              echo '<option value="'.$categorie['id'].'" '.$selected.'>'.$categorie['titre'].
              // echo '<option value="'.$categorie['id'].'" '.$selected.'>'.$categorie['titre'].
              '</option>';
            };
            ?>
          </select>
        </div>

        <div class="col-sm-3 form-group">
          <label for="regions">Régions</label>
          <select class="form-control" name="regionSelect" id="regions">
            <option value="">Toutes les régions</option>
            <?php
            foreach ($regions as $region) :
              $selected = ($region['id'] == $_SESSION['select']['regionSelect']) ? 'selected' : '';
              echo '<option value="'.$region['id'].'" '.$selected.'>'.$region['nom'].
              '</option>';
            endforeach;
            ?>
          </select>
        </div>

        <div class="col-sm-3 form-group">
          <label for="membres">Membres</label>
          <select class="form-control" name="membreSelect" id="membres">
            <option value="">Tous les membres</option>
            <?php
            foreach ($membres as $membre) :
              $selected = ($membre['id'] == $_SESSION['select']['membreSelect']) ? 'selected' : '';
              echo '<option value="'.$membre['id'].'" '.$selected.'>'.$membre['pseudo'].
              '</option>';
            endforeach;
            ?>
          </select>
        </div>

        <div class="col-sm-3 form-group">
          <label for=""></label>
          <button class="col-xs-12 btn btn-primary pull-right" type="submit"><i class="fa fa-search"></i> Sélectionner</button>
        </div>
      </div>

      <div class="col-sm-3">
        <label for="">Trier par ...</label>
        <div class="input-group">
          <select class="form-control" name="triSelect" id="triSelect">
            <!-- <option value=''>les plus récentes</option> -->
            <?php
            $letri = [];
            foreach ($tris as $tri) :
              $selected = ($tri['tri'] == $_SESSION['select']['triSelect']) ? 'selected' : '';
              echo '<option value="'.$tri['tri'].'" '.$selected.'>'.$tri['options'].
              '</option>';
            endforeach;
            ?>
          </select>
          <span class="input-group-btn">
            <button class="btn btn-primary form-group-btn pull-right" type="submit"><i class="fa fa-sort"></i> Trier</button>
          </span>
        </div>
      </div>
    </form>
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

    <nav aria-label="page navigation" id="pagination">
      <form method="post">
        <ul class="pagination pagination-lg">
          <li <?= (($pageChoisie-1)<=0) ? 'class="disabled"' : '' ; ?>>
            <a href="index.php?p=<?= (($pageChoisie-1)<=0) ? 1 : $pageChoisie-1 ; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <?php
          for($i = 1; $i <= $nbPages; $i++) {

            if($i == $pageChoisie) {

              echo '<li class="active" name="'.$i.'"><a href="index.php?p='.$i.'">'.$i.'</a></li>';
            }	else {
              echo '<li name="'.$i.'"><a href="index.php?p='.$i.'">'.$i.'</a></li>';
              // echo '<li name="'.$i.'"><a href="index.php?p='.$i.'">'.$i.'</a></li>';
            }
          }
          ?>
          <li <?= ($pageChoisie >= $nbPages) ? 'class="disabled"' : '' ; ?>>
            <a href="index.php?p=<?= ($pageChoisie > $nbPages) ? '' : $pageChoisie+1; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </form>
    </nav>
  </div>
</div>

<?php
include __DIR__.('/layout/bottom.php');
?>
