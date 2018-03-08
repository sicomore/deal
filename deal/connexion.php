<?php
require_once __DIR__.'/include/init.php';

$errors = [];
$pseudo = '';

if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);
  // Extrait les valeurs à partir du tableau $_POST recueilli et renseigne les variables dédiées pour être retournée dans les values du formulaire afin de les garder en mémoire

  if (empty($_POST['pseudo'])) {
    $errors[] = 'Votre pseudo est obligatoire.';
  }
  if (empty($_POST['mdp'])) {
    $errors[] = 'Le mot de passe est obligatoire.';
  }

  if (empty($errors)) {
    $req = 'SELECT * FROM membre WHERE pseudo ='.$pdo->quote($pseudo);
    $stmt = $pdo->query($req);
    $user = $stmt->fetch();
    if (!empty($user)) {
      if (password_verify($mdp,$user['mdp'])) {
        $_SESSION['membre'] = $user;
        header('Location: index.php');
        die;
      }
    }
    $errors[] = "L'email ou le mot de passe est incorrect.";
  }
}

include __DIR__.('/layout/top.php');
?>

<div class="container-fluid" id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Connexion</h1>
    </div>
  </div>

  <?php
  if (!empty($errors)) :
    ?>
    <div class="alert alert-danger">
      <p><strong>Le formulaire contient des erreurs</strong></p>
      <?= implode('<br>', $errors); ?>
    </div>

    <?php
  endif;
  ?>


  <form method="post">
    <div class="container-fluid">

      <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4 form-group">
          <label for="">Votre pseudo</label>
          <input type="text" name="pseudo" value="<?= $pseudo ?>" class="form-control" autofocus>
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

<?php include __DIR__.('/layout/bottom.php'); ?>
