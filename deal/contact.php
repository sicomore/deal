<?php
require_once __DIR__.'/include/init.php';

$errors = [];
$civilite = $nom = $prenom = $email = $sujet = $message = '';

if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);

  if (empty($_POST['civilite'])) {
    $errors[] = 'Choisir une civilité.';
  }

  if (empty($_POST['nom'])) {
    $errors[] = 'Le nom est obligatoire.';
  }

  if (empty($_POST['email'])) {
    $errors[] = 'L\'email est obligatoire.';
  } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'L\'email est invalide.';
  }

  if (empty($_POST['sujet'])) {
    $errors[] = 'Merci de remplir le sujet de votre message.';
  }

  if (empty($_POST['message'])) {
    $errors[] = 'Votre message semble vide. Merci de le vérifier.';
  }

  if (empty($errors)) {
    $req = 'INSERT INTO message (civilite, nom, prenom, email, sujet, message) VALUES (:civilite, :nom, :prenom, :email, :sujet, :message)';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':civilite', $_POST['civilite']);
    $stmt->bindValue(':nom', $_POST['nom']);
    $stmt->bindValue(':prenom', $_POST['prenom']);
    $stmt->bindValue(':email', $_POST['email']);
    $stmt->bindValue(':sujet', $_POST['sujet']);
    $stmt->bindValue(':message', $_POST['message']);
    $requete = $stmt->execute();

    if (!$requete || ($stmt->rowCount() == 0)) {
      $errors[] = 'Un problème est survenu au moment de l\'enregistrement de votre message et n\'a pu être enregistré.';
    } else {
      $success = true;
    }
  }
}


// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__.('/layout/top.php');

?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Contact</h1>
    </div>
  </div>

  <?php if (isset($success)) : ?>
    <div class="alert alert-success">
      <strong>Votre message a bien été envoyé. Nous y répondrons au plus vite.</strong>
      <a class="badge btn btn-info" href="index.php">Retour à l'accueil</a>
    </div>
  <?php endif; ?>

  <?php if (!empty($errors)) : ?>
    <div class="alert alert-danger">
      <p><strong>Le formulaire contient des erreurs</strong></p>
      <?= implode ('<br>', $errors); ?>
    </div>
  <?php endif; ?>

  <!--================= FORMULAIRE D'INSCRIPTION =================-->

  <div class="col-sm-6 col-sm-offset-3">
    <form class="contact" method="post">
      <div class="row">

        <!-- <div class="form-group col-auto">
        <input name="pseudo" value="< ?= $pseudo ;?>" type="text" class="form-control" id="pseudo" placeholder="Votre pseudo (ex: 'janest')" autofocus>
      </div> -->

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
          <input name="nom" value="<?= $nom ;?>" type="text" class="form-control" id="nom" aria-describedby="name" placeholder="Votre nom * (ex: Anest)" autofocus>
        </div>
        <div class="form-group col-sm-5">
          <input name="prenom" value="<?= $prenom ;?>" type="text" class="form-control" id="prenom" aria-describedby="forname" placeholder="Votre prénom (ex: Julien)">
        </div>
      </div>
      <div class="row">
        <div class="form-group col-sm-12">
          <input name="email" value="<?= $email ;?>" type="email" class="form-control" id="email" aria-describedby="email" placeholder="Votre email * (ex: janest@mail.com)">
        </div>
      </div>
      <div class="row">
        <div class="form-group col-sm-12">
          <input name="sujet" value="<?= $sujet ;?>" type="text" class="form-control" id="sujet" aria-describedby="subject" placeholder="Sujet de votre demande * (ex: Demande d'informations)">
        </div>
      </div>
      <div class="row">
        <div class="form-group col-sm-12">
          <textarea name="message" class="form-control" rows="8" cols="80" placeholder="Votre message *"><?= $message ;?></textarea>
        </div>
      </div>

      <div class="pull-right">
        <a href="index.php" class="btn btn-default" type="cancel">Annuler</a>
        <button type="submit" class="btn btn-primary pull-right">Envoyer</button>
      </div>

    </div>
  </form>
</div>

</div>


<?php include __DIR__.('/layout/bottom.php'); ?>
