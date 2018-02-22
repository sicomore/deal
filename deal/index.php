<?php
require_once __DIR__.'/include/init.php';

// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__.('/layout/top.php');
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Accueil</h1>
    </div>
  </div>

  <div class="row">
    <?php
    var_dump($_SESSION['membre']['id']);
    var_dump($_SESSION['membre']['pseudo']); 
     ?>
  </div>

  <div class="row">
    <div class="col-lg-8">
    </div>

    <div class="col-lg-4">
    </div>
  </div>

</div>

<?php
include __DIR__.('/layout/bottom.php');
?>
