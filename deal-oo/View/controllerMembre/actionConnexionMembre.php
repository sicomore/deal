<div class="container-fluid" id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Connexion</h1>
    </div>
  </div>

  <?= ($affichageMessage) ? $affichageMessage : '' ; ?>

  <form method="post">
    <div class="container-fluid">

      <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 form-group">
          <label for="">Votre pseudo</label>
          <input type="text" name="pseudo" value="<?= (!empty($_POST['pseudo'])) ? $_POST['pseudo'] : ''; ?>" class="form-control" autofocus>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6  col-sm-offset-3 col-md-4 col-md-offset-4 form-group">
          <label for="">Mot de passe</label>
          <input type="password" name="mdp" value="" class="form-control">
        </div>
      </div>
      <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6  col-sm-offset-3 col-md-4 col-md-offset-4 form-group">
          <button class="btn btn-primary pull-right" type="submit" name="button">Valider</button>
        </div>
      </div>
    </div>
  </form>

</div>
