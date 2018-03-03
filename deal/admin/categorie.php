<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT * FROM categorie ORDER BY id';
$stmt = $pdo->query($req);
$categories = $stmt->fetchAll();


// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__ .'/../layout/top.php';
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header">Gestion des Catégories</h1>
    </div>
      <div class="col-xs-12">
        <a href="categorie-edit.php" class="btn btn-primary">Ajouter une catégorie</a>
    </div>
  </div>

  <?php displayFlashMessage(); ?>


  <!-- Lister toutes les catégories dans un tableau HTML -->
  <table class="table table-bordered table-striped">
    <th colspan="4">
      <h4>Catégories</h4>
    </th>
    <tr>
      <th class="col-xs-1">ID</th>
      <th class="col-xs-auto">Nom</th>
      <th class="col-xs-auto">Mots Clés</th>
      <th class="col-xs-1">Options</th>
    </tr>

    <?php
    foreach ($categories as $categorie) :
      ?>
      <tr>
        <td><?= $categorie['id'] ?></td>
        <td><?= $categorie['titre'] ?></td>
        <td><?= $categorie['mots_cles'] ?></td>
        <td>
          <a href="categorie-edit.php?id=<?= $categorie['id'] ?>" class="btn btn-primary">Modifier</a>
          <a href="categorie-delete.php?id=<?= $categorie['id'] ?>" class="btn btn-danger">Supprimer</a>
        </td>
      </tr>
      <?php
    endforeach;
    ?>

  </table>
</div>

<?php
include __DIR__ .'/../layout/bottom.php';
?>
