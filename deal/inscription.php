<?php
require_once __DIR__.'/include/init.php';

$errors = [];
$civilite = $pseudo = $nom = $prenom = $email = $telephone = '';


if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);

  if (empty($_POST['civilite'])) {
    $errors[] = 'Choisir une civilité.';
  }
  if (empty($_POST['nom'])) {
    $errors[] = 'Le nom est obligatoire.';
  }
  if (empty($_POST['pseudo'])) {
    $errors[] = 'Le pseudo est obligatoire.';
  } elseif (!preg_match ('#^[A-Za-z0-9_-]{3,20}$#', $_POST['pseudo'])) {
    $errors [] = 'Le pseudo doit contenir de 3 à 20 caractères';
  } else {
    $pseudoFiltre = $pdo->quote(strtolower($_POST['pseudo']));
    $req = 'SELECT COUNT(*) FROM membre WHERE pseudo = ' . $pseudoFiltre;
    $stmt = $pdo->query($req);
    $nb = $stmt->fetchColumn();
    // var_dump($nb);
    if ($nb != 0) {
      $errors[] = 'Cet pseudo est déjà utilisé.';
    }
  }
  if (empty($_POST['email'])) {
    $errors[] = 'L\'email est obligatoire.';
  } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'L\'email est invalide.';
  } else {
    $req = 'SELECT COUNT(*) FROM membre WHERE email = '.$pdo->quote($_POST['email']);
    $stmt = $pdo->query($req);
    $nb = $stmt->fetchColumn();
    if ($nb != 0) {
      $errors[] = 'Cet email est déjà enregistré.';
    }
  }
  if (empty($_POST['mdp'])) {
    $errors[] = 'Le mot de passe est obligatoire.';
  } elseif (!preg_match ('#^[A-Za-z0-9_-]{6,20}$#', $_POST['mdp'])) {
    $errors [] = 'Le mot de passe doit contenir de 6 à 20 caractères';
  }
  if (empty($_POST['mdp-confirm'])) {
    $errors[] = 'La confirmation du mot de passe est obligatoire.';
  } elseif ($_POST['mdp-confirm'] != $_POST['mdp']) {
    $errors[] = 'Les 2 mots de passe ne sont pas identiques.';
  }

  if (empty($errors)) {
    $encodePassword = password_hash ($mdp, PASSWORD_BCRYPT);
    // encrypte le mot de passe
    $req = 'INSERT INTO membre (civilite, pseudo, nom, prenom, telephone, email, mdp) VALUES (:civilite, :pseudo, :nom, :prenom, :telephone, :email, :mdp)';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':civilite', $civilite);
    $stmt->bindValue(':nom', $nom);
    $stmt->bindValue(':prenom', $prenom);
    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':mdp', $encodePassword);
    $stmt->bindValue(':telephone', $telephone);
    $result = $stmt->execute();
    // $success = true;
    if ($result == false) {
      $errors[] = 'Un problème est survenu lors de l\'enregistrement de votre inscription. Merci de recommencer';
    } else {
      $req = 'SELECT id, pseudo, nom, prenom, role FROM membre WHERE pseudo ='.$pdo->quote($pseudo);
      $stmt = $pdo->query($req);
      $user = $stmt->fetch();

      if ($user == false) {
        $errors[] = 'Un problème est survenu lors de l\'enregistrement de votre inscription. Merci de recommencer';

      } else {
        setFlashMessage('Merci pour votre inscription. Elle a bien été validée.');
        $_SESSION['membre'] = $user;
        header('Location: index.php');
        die;
      }
    }
  }
}


// ------------------------------ Traitement de l'affichage ------------------------------------
// ------------------------------ Traitement de l'affichage ------------------------------------
// ------------------------------ Traitement de l'affichage ------------------------------------

include __DIR__.('/layout/top.php');

?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Inscription</h1>
    </div>
  </div>

  <?php if (isset($success)) : ?>
    <div class="alert alert-success">
      <strong>Votre inscription a bien été enregistrée.</strong>
      <button class="btn btn-primary" type="button">
        <span class="badge"><a href="index.php">Retour à l'accueil</a></span>
      </button>
    </div>
  <?php endif; ?>

  <?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
      <p><strong>Le formulaire contient des erreurs</strong></p>
      <?= implode ('<br>', $errors); ?>
    </div>
  <?php endif; ?>

  <!--================= FORMULAIRE D'INSCRIPTION =================-->

  <div class="col-sm-8 col-sm-offset-2">
    <form class="inscription" method="post">
      <div class="row">

        <div class="form-group col-auto">
          <input name="pseudo" value="<?= $pseudo ;?>" type="text" class="form-control" id="pseudo" placeholder="Votre pseudo (ex: 'janest')" autofocus>
        </div>

        <div class="row">
          <div class="btn-group col-sm-2" data-toggle="buttons">
            <label class="btn btn-default civilite <?= ($civilite == 'Mme') ? 'active' : ''; ?>">
              <input type="radio" name="civilite" value="Mme" id="femme" <?= ($civilite == 'Mme') ? 'checked' : '' ;?>> Mme
            </label>
            <label class="btn btn-default civilite <?= ($civilite == 'M.') ? 'active' : ''; ?>">
              <input type="radio" name="civilite" value="M." id="homme"<?= ($civilite == 'M.') ? 'checked' : '' ;?>> M.
            </label>
          </div>

          <div class="form-group col-sm-5">
            <input name="nom" value="<?= $nom ;?>" type="text" class="form-control" id="nom" aria-describedby="name" placeholder="Votre nom (ex: 'Anest')">
          </div>
          <div class="form-group col-sm-5">
            <input name="prenom" value="<?= $prenom ;?>" type="text" class="form-control" id="prenom" aria-describedby="forname" placeholder="Votre prénom (ex: 'Julien')">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-5">
            <input name="telephone" value="<?= $telephone ;?>" type="text" class="form-control" id="telephone" aria-describedby="telephone" placeholder="Votre téléphone (ex: '0654321098')">
          </div>
          <div class="form-group col-sm-7">
            <input name="email" value="<?= $email ;?>" type="email" class="form-control" id="email" aria-describedby="email" placeholder="Votre email (ex: 'janest@mail.com')">
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-6">
            <input name="mdp" value="" type="password" class="form-control" id="mdp" placeholder="Entrez un mot de passe (6 caractères min.)">
          </div>
          <div class="form-group col-sm-6">
            <input name="mdp-confirm" value="" type="password" class="form-control" id="mdp" placeholder="Confirmez votre mot de passe">
          </div>
        </div>

        <div class="pull-right">
          <a href="index.php" class="btn btn-default" type="cancel">Annuler</a>
          <button type="submit" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-inscription">Valider</button>
        </div>

      </div>
    </form>
  </div>


  <!-- ================= MODAL DE SUCCES D'INSCRIPTION ================= -->

  <!-- <div class="modal fade" id="modal-inscription" tabindex="-1" role="dialog" aria-labelledby="ModalLabel">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
</button>
<div class="alert alert-success">
<strong>Votre inscription a bien été enregistrée.</strong>
</div>
<h4 class="modal-title alert-success" id="ModalLabel">Votre inscription a bien été enregistrée.</h4>
</div>
<div class="modal-body row">
<div class="col-sm-6">
<a class="btn btn-primary" href="< ?=SITE_PATH;?>annonce-edit.php">Déposer une annonce</a>
</div>
<div class="col-sm-5 col-sm-offset-1">
<a class="btn btn-default" href="< ?=SITE_PATH;?>index.php">Retour à l'accueil</a>
</div>
</div>
< ?php endif; ?>
</div>
</div>
</div> -->

</div>


<?php
include __DIR__.('/layout/bottom.php');
?>
