<div id="page-wrapper">

  <div class="row">
    <div class="col-xs-12">
      <h1 class="page-header">Gestion des Catégories</h1>
    </div>
    <div class="col-xs-12">
      <a href="index.php?new_categorie" class="btn btn-primary">Ajouter une catégorie</a>
    </div>
  </div>

  <?= ($affichageMessage) ? $affichageMessage : ''; ?>

  <table class="table table-bordered table-striped">
    <th colspan="4">
      <h4>Catégories</h4>
    </th>
    <tr>
      <th class="col-xs-1">ID</th>
      <th class="col-xs-auto">Titre</th>
      <th class="col-xs-auto">Mots Clés</th>
      <th class="col-xs-1">Options</th>
    </tr>

    <?= $result['affichageLigne']; ?>

  </table>
</div>
