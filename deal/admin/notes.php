<?php  // -------- Traitement des données --------------
require_once __DIR__ .'/../include/init.php';
adminSecurity();

$req = 'SELECT n.id id, n.note note, n.avis avis, n.date_enregistrement date_enregistrement, mc.id idClient, mv.id idVendeur, mc.pseudo pseudoClient, mv.pseudo pseudoVendeur, mc.email mailClient, mv.email mailVendeur FROM notes n '
.'JOIN membre mc ON mc.id = n.membre_id1 '
.'JOIN membre mv ON mv.id = n.membre_id2 '
.'ORDER BY n.date_enregistrement DESC';
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
$notes = $stmt->fetchAll();


// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__ .'/../layout/top.php';
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Gestion des notes et avis</h1>
    </div>
  </div>

  <?php displayFlashMessage(); ?>

  <table class="table table-bordered table-striped">
    <th colspan="7">
      <h4>Notes et Avis</h4>
    </th>
    <tr>
      <th class="col-xs-1">ID</th>
      <th class="col-xs-auto">Vendeur</th>
      <th class="col-xs-auto">Note</th>
      <th class="col-xs-auto">Avis</th>
      <th class="col-xs-auto">Client</th>
      <th class="col-xs-auto">Date d'enregistrement</th>
      <th class="col-xs-1">Options</th>
    </tr>

    <?php
    foreach ($notes as $note) :
      ?>
      <tr>
        <td><?= $note['id']; ?></td>
        <td><?= $note['pseudoVendeur'].' - '.$note['idVendeur'].' - '. $note['mailVendeur']; ?></td>
        <td><?= $note['note'] ?></td>
        <td><?= $note['avis'] ?></td>
        <td><?= $note['pseudoClient'].' - '.$note['idClient'].' - '.$note['mailClient']; ?></td>
        <td><?= strftime('%d/%m/%Y',strtotime($note['date_enregistrement'])); ?></td>
        <td>
          <a href="note-edit.php?id=<?= $note['id'] ?>" class="btn btn-primary">Modifier</a>
          <a href="note-delete.php?id=<?= $note['id'] ?>" class="btn btn-danger">Supprimer</a>
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
          <a type="submit" href="notes.php?p=<?= (($pageChoisie-1)<=0) ? 1 : $pageChoisie-1 ; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        <?php
        for($i = 1; $i <= $nbPages; $i++) {

          if($i == $pageChoisie) {

            echo '<li class="active" name="'.$i.'"><a type="submit" href="notes.php?p='.$i.'">'.$i.'</a></li>';
          }	else {
            echo '<li name="'.$i.'"><a type="submit" href="notes.php?p='.$i.'">'.$i.'</a></li>';
          }
        }
        ?>
        <li <?= ($pageChoisie >= $nbPages) ? 'class="disabled"' : '' ; ?>>
          <a type="submit" href="notes.php?p=<?= ($pageChoisie > $nbPages) ? '' : $pageChoisie+1; ?>" aria-label="Next">
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
