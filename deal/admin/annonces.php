<?php
require_once __DIR__ .'/../include/init.php';
// adminSecurity();

$triSelect = 'a.id desc';

if ($_POST) {
  extract($_POST);
}

// Select des tris
$req = 'SELECT * FROM tri';
$stmt = $pdo->query($req);
$tris = $stmt->fetchAll();

$req = 'SELECT a.*, m.pseudo, c.titre titre_categorie, r.nom nom_region FROM annonce a JOIN categorie c ON c.id = categorie_id JOIN membre m ON m.id = a.membre_id JOIN region r ON r.id = region_id ORDER BY '. $triSelect;
$stmt = $pdo->query($req);
$annonces = $stmt->fetchAll();

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
        <form class="form-inline" method="post">
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

      <div class="panel-body">

        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
            <tr>
              <th>ID</th>
              <th>Photo</th>
              <th>Titre</th>
              <th>Catégorie</th>
              <th>Description courte</th>
              <th>Description longue</th>
              <th>Prix</th>
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
                <td><img src='<?= PHOTO_WEB.$annonce['photo']; ?>' style="width: 100px;"></td>
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
                  <a href="<?= SITE_PATH; ?>annonce-fiche.php?id=<?= $annonce['id'] ?>" class="btn btn-primary">
                    Voir la fiche
                  </a>
                  <?php if (isUserAdmin()) : ?>
                    <a href="<?= SITE_PATH ?>admin/annonce-edit.php?id=<?= $annonce['id'] ?>" class="btn btn-warning">
                      Modifier
                    </a>
                    <a href="<?= SITE_PATH ?>admin/annonce-delete.php?id=<?= $annonce['id'] ?>" class="btn btn-danger">
                      Supprimer
                    </a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>

        </table>
      </div>

      <?php include __DIR__ .'/../layout/bottom.php'; ?>
    </div> <!-- end panel -->
    <!-- </div> -->
  </div>
</div> <!-- end container -->
