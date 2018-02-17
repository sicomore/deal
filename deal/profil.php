<?php
require_once __DIR__.'/include/init.php';

// Recueil des informations du vendeur
$req = <<<EOS
SELECT m.*, n.avis avis, AVG(n.note) note_moy, a.*, c.*
FROM membre m
JOIN annonce a ON a.membre_id = m.id
JOIN notes n ON n.membre_id2 = m.id
JOIN commentaire c ON c.annonce_id = a.id
WHERE m.id =
EOS
.$_GET['id'];
$stmt = $pdo->query($req);
$membreTout = $stmt->fetchAll();


// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__.('/layout/top.php');
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">
        Profil de <?= getUserFullName(); ?>
      </h1>
      <p>
        ID membre : <?= $_GET['id'] ?>
      </p>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <h2></h2>
    </div>

    <div class="col-lg-4">
      <h3>Note</h3>
      <p></p>

    </div>
  </div>

</div>

<?php
include __DIR__.('/layout/bottom.php');
?>
