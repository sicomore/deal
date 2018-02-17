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
<h1>Gestion des Catégories</h1>
<?php
displayFlashMessage();
?>

<p><a href="categorie-edit.php">Ajouter une catégorie</a></p>

<!-- Lister toutes les catégories dans un tableau HTML -->
<table class="table table-bordered table-striped">
  <th colspan="4">
    Catégories
  </th>
  <tr>
    <th class="col-xs-1">ID</th>
    <th class="col-xs-auto">Nom</th>
    <th class="col-xs-auto">Mots Clés</th>
    <th class="col-xs-3">Options</th>
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

<?php
include __DIR__ .'/../layout/bottom.php';
?>
