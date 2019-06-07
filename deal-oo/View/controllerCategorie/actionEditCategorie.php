<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Edition des catégories</h1>
    </div>
  </div>

  <?= ($affichageMessage) ? $affichageMessage : '' ; ?>

  <form method="post">
    <div class="row">
      <div class="col-sm-3 form-group">
        <label for="">Titre</label>
        <input type="text" name="titre" placeholder="Titre de la catégorie" value="<?= (!empty($affichage)) ? $affichage['titre'] : ''; ?>" class="form-control">
      </div>
      <div class="col-sm-6 form-group ">
        <label for="">Mots Clés</label>
        <textarea name="mots_cles" placeholder="Liste des mots clés (séparés par une virgule)" class="form-control"><?= (!empty($affichage)) ? $affichage['mots_cles'] : ''; ?></textarea>
      </div>
      <div class="col-sm-3">
        <button class="btn btn-primary pull-right" type="submit" name="button">Enregistrer</button>
        <a href="index.php?liste_categories" class="btn btn-default pull-right" type="cancel">Annuler</a>
      </div>
    </div>
  </form>

</div>
