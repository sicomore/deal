<?php
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$triSelect = 'a.id desc';

if ($_GET) {
  extract($_GET);
}
var_dump($_GET);

// Select des tris
$req = 'SELECT * FROM tri';
$stmt = $pdo->query($req);
$tris = $stmt->fetchAll();

$req = 'SELECT a.*, m.pseudo, c.titre titre_categorie, r.nom nom_region FROM annonce a JOIN categorie c ON c.id = categorie_id JOIN membre m ON m.id = a.membre_id JOIN region r ON r.id = region_id ORDER BY '. $triSelect;
$stmt = $pdo->query($req);
$annonces = $stmt->fetchAll();

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





// =============================== Traitement de l'affichage ===============================
// =============================== Traitement de l'affichage ===============================
// =============================== Traitement de l'affichage ===============================

include __DIR__ .'/../layout/top.php';
?>

<div class="container-fluid" id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Gestion des annonces</h1>
    </div>
  </div>

  <?php displayFlashMessage(); ?>

  <div class="row">
    <!-- <div class="row"> -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <!-- Select de tri -->
        <form class="form-inline" method="get" action="annonces.php">
          <label for="">Trier par ...</label>
          <div class="form-group">
            <select class="form-control" name="triSelect" id="tri">
              <?php
              foreach ($tris as $tri) :
                $selected = ($tri['tri'] == $triSelect) ? 'selected' : '';
                echo '<option value="'.$tri['tri'].'" '.$selected.'>'.$tri['options'].
                '</option>';
              endforeach;
              ?>
            </select>
            <span class="form-group-btn">
              <button class="btn btn-primary form-group-btn pull-right" type="submit"><i class="fa fa-sort"></i> Trier</button>
            </span>
          </div>
        <!-- </form> -->
      </div>

      <div class="panel-body liste_annonces">

        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th>N°</th>
              <th>Photo</th>
              <th>Titre</th>
              <th>Catégorie</th>
              <th>Description courte</th>
              <th>Description longue</th>
              <th>Prix (€)</th>
              <th>Adresse</th>
              <th>Code Postal</th>
              <th>Ville</th>
              <th>Région</th>
              <th>Membre</th>
              <th>Date de parution</th>
              <th>Options</th>
            </tr>
          </thead>

          <tbody>
            <?php foreach ($annonces as $annonce) : ?>
              <tr>
                <td><?= $annonce['id'] ?></td>
                <td>
                  <a href="<?= PHOTO_WEB.$annonce['photo']; ?>" data-lightbox="lightbox">
                    <img src="<?= PHOTO_WEB.$annonce['photo']; ?>">
                  </a>
                </td>
                <td><?= $annonce['titre'] ?></td>
                <td><?= $annonce['titre_categorie'] ?></td>
                <td><?= substr($annonce['description_courte'],0, 30); ?> ...</td>
                <td><?= substr($annonce['description_longue'],0, 100); ?> ...</td>
                <td><?= number_format($annonce['prix'], 2, ',',' ') ?> €</td>
                <td><?= $annonce['adresse'] ?></td>
                <td><?= $annonce['code_postal'] ?></td>
                <td><?= $annonce['ville'] ?></td>
                <td><?= $annonce['nom_region'] ?></td>
                <td><?= $annonce['pseudo'] ?></td>
                <td><?= strftime('%d/%m/%Y',strtotime($annonce['date_enregistrement'])); ?></td>
                <td>
                  <a href="<?= SITE_PATH; ?>annonce-fiche.php?id=<?= $annonce['id'] ?>" class="btn btn-primary" title="Voir l'annonce" data-toggle="tooltip" data-placement="left">
                    <i class="fa fa-search"></i>
                  </a>
                  <?php if (isUserAdmin()) : ?>
                    <a href="<?= SITE_PATH ?>annonce-edit.php?id=<?= $annonce['id'] ?>" class="btn btn-warning" title="Modifier l'annonce" data-toggle="tooltip" data-placement="left">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="<?= SITE_PATH ?>admin/annonce-delete.php?id=<?= $annonce['id'] ?>" class="btn btn-danger" title="Supprimer l'annonce" data-toggle="tooltip" data-placement="left">
                      <i class="fa fa-trash"></i>
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>

        </table>
      </div>

    </div> <!-- end panel -->

    <nav aria-label="page navigation" id="pagination">
      <!-- <form method="get"> -->
        <ul class="pagination pagination-lg">
          <li <?= (($pageChoisie-1)<=0) ? 'class="disabled"' : '' ; ?>>
            <a type="submit" href="annonces.php?p=<?= (($pageChoisie-1)<=0) ? 1 : $pageChoisie-1 ; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <?php
          for($i = 1; $i <= $nbPages; $i++) {

            if($i == $pageChoisie) {

              echo '<li class="active" name="'.$i.'"><a type="submit" href="annonces.php?p='.$i.'">'.$i.'</a></li>';
            }	else {
              echo '<li name="'.$i.'"><a type="submit" href="annonces.php?p='.$i.'">'.$i.'</a></li>';
            }
          }
          ?>
          <li <?= ($pageChoisie >= $nbPages) ? 'class="disabled"' : '' ; ?>>
            <a type="submit" href="annonces.php?p=<?= ($pageChoisie > $nbPages) ? '' : $pageChoisie+1; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </form>
    </nav>

  </div>
</div> <!-- end container -->

<?php include __DIR__ .'/../layout/bottom.php'; ?>
