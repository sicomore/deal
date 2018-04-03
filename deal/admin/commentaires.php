<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT c.*, m.pseudo pseudo FROM commentaire c '
.'JOIN membre m ON m.id = c.membre_id ORDER BY c.date_enregistrement DESC';
$stmt = $pdo->query($req);

// Affichage des annonces (Pagination)
$annoncesParPage = 10;
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

// Limitation des annonces à 10 par page
$req .= ' LIMIT '.$premiereAnnonce.', '.$annoncesParPage;
$stmt = $pdo->query($req);
$commentaires = $stmt->fetchAll();



// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__ .'/../layout/top.php';
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Gestion des commentaires</h1>
    </div>
  </div>

  <?php displayFlashMessage(); ?>

  <table class="table table-bordered table-striped">
    <th colspan="6">
      <h4>Commentaires</h4>
    </th>
    <tr>
      <th class="col-xs-1">ID</th>
      <th class="col-xs-auto">Membre</th>
      <th class="col-xs-auto">Annonce</th>
      <th class="col-xs-auto">Commentaire</th>
      <th class="col-xs-auto">Date d'édition</th>
      <th class="col-xs-1">Options</th>
    </tr>

    <?php
    foreach ($commentaires as $commentaire) :
      ?>
      <tr>
        <td><?= $commentaire['id'] ?></td>
        <td><?= $commentaire['membre_id'].' - '.$commentaire['pseudo'] ?></td>
        <td><?= $commentaire['annonce_id'] ?></td>
        <td><?= $commentaire['commentaire'] ?></td>
        <td><?= strftime('%d/%m/%Y',strtotime($commentaire['date_enregistrement'])); ?></td>
        <td>
          <a href="commentaire-edit.php?id=<?= $commentaire['id'] ?>" class="btn btn-primary">Modifier</a>
          <a href="commentaire-delete.php?id=<?= $commentaire['id'] ?>" class="btn btn-danger">Supprimer</a>
        </td>
      </tr>
      <?php
    endforeach;
    ?>

  </table>

<nav aria-label="page navigation" id="pagination">
  <form method="get">
    <ul class="pagination pagination-lg">
      <li <?= (($pageChoisie-1)<=0) ? 'class="disabled"' : '' ; ?>>
        <a type="submit" href="commentaires.php?p=<?= (($pageChoisie-1)<=0) ? 1 : $pageChoisie-1 ; ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php
      for($i = 1; $i <= $nbPages; $i++) {

        if($i == $pageChoisie) {

          echo '<li class="active" name="'.$i.'"><a type="submit" href="commentaires.php?p='.$i.'">'.$i.'</a></li>';
        }	else {
          echo '<li name="'.$i.'"><a type="submit" href="commentaires.php?p='.$i.'">'.$i.'</a></li>';
        }
      }
      ?>
      <li <?= ($pageChoisie >= $nbPages) ? 'class="disabled"' : '' ; ?>>
        <a type="submit" href="commentaires.php?p=<?= ($pageChoisie > $nbPages) ? '' : $pageChoisie+1; ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </form>
</nav>

</div>

<?php
include __DIR__ .'/../layout/bottom.php';
?>
