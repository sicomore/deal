<?php
require_once __DIR__.'/include/init.php';

$errors = [];
$civilite = $pseudo = $nom = $prenom = $email = $telephone = '';
// initialise un valeur aux futures variables créées par extract


if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);
  // Extrait les valeurs à partir du tableau $_POST recueilli et renseigne les variables dédiées pour être retournée dans les values du formulaire afin de les garder en mémoire

  if (empty($_POST['civilite'])) {
    $errors[] = 'Choisir une civilité.';
  }
  if (empty($_POST['nom'])) {
    $errors[] = 'Le nom est obligatoire.';
  }
  if (empty($_POST['pseudo'])) {
    $errors[] = 'Le pseudo est obligatoire.';
  } else {
    $pseudoFiltre = $pdo->quote(strtolower($_POST['pseudo']));
    $req = 'SELECT COUNT(*) FROM membre WHERE pseudo = ' . $pseudoFiltre;
    $stmt = $pdo->query($req);
    $nb = $stmt->fetchColumn();
    var_dump($nb);
    if ($nb != 0) {
      $errors[] = 'Cet pseudo est déjà utilisé.';
    }
  }
  if (empty($_POST['email'])) {
    $errors[] = 'L\'email est obligatoire.';
  } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Passe la variable dans un filtre (filter_var) qui vérifie ou valide des données en fonction d'un type de filtre
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
    $stmt->execute();
    $success = true;
  }
}



// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__.('/layout/top.php');

?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Inscription</h1>
    </div>
  </div>


  <?php
  // Affichage des messages d'alerte en cas de tableau d'erreur non vide
  if (!empty($errors)) : // structure du "if" qui débute
    ?>
    <div class="alert alert-danger">
      <p><strong>Le formulaire contient des erreurs</strong></p>
      <?= implode ('<br>', $errors); ?>
    </div>
    <?php
  endif; // fin de la structure du "if"

  if (isset($success)) :
    ?>
    <div class="alert alert-success">
      <strong>Votre inscription a bien été enregistrée.</strong>
    </div>
    <?php
  endif;
  ?>

  <!--================= FORMULAIRE D'INSCRIPTION =================-->

  <div class="col-sm-10 col-sm-offset-1">
    <form class="inscription" method="post">
      <div class="row">

        <div class="form-group col-auto">
          <input name="pseudo" value="<?= $pseudo ;?>" type="text" class="form-control" id="pseudo" placeholder="Votre pseudo" autofocus>
        </div>

        <div class="row">
          <div class="btn-group col-sm-2" data-toggle="buttons">
            <label class="btn btn-default civilite <?php if ($civilite == 'Mme') {echo 'active';} ?>">
              <input type="radio" name="civilite" value="Mme" id="femme" <?php if ($civilite == 'Mme') {echo 'checked';}; ?>> Mme
            </label>
            <label class="btn btn-default civilite <?php if ($civilite == 'M.') {echo 'active';} ?>">
              <input type="radio" name="civilite" value="M." id="homme"<?php if ($civilite == 'M.') {echo 'checked';}; ?>> M.
            </label>
          </div>

          <div class="form-group col-sm-5">
            <input name="nom" value="<?= $nom ;?>" type="text" class="form-control" id="nom" aria-describedby="name" placeholder="Votre nom">
          </div>
          <div class="form-group col-sm-5">
            <input name="prenom" value="<?= $prenom ;?>" type="text" class="form-control" id="prenom" aria-describedby="forname" placeholder="Votre prénom">
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-4">
            <input name="telephone" value="<?= $telephone ;?>" type="text" class="form-control" id="telephone" aria-describedby="telephone" placeholder="Votre téléphone">
          </div>
          <div class="form-group col-sm-8">
            <input name="email" value="<?= $email ;?>" type="email" class="form-control" id="email" aria-describedby="email" placeholder="Votre email">
          </div>
        </div>

        <div class="row">
          <div class="form-group col-sm-6">
            <input name="mdp" value="" type="password" class="form-control" id="mdp" placeholder="Entrez un mot de passe">
          </div>
          <div class="form-group col-sm-6">
            <input name="mdp-confirm" value="" type="password" class="form-control" id="mdp" placeholder="Confirmez votre mot de passe">
          </div>
        </div>

        <div class="pull-right">
          <a href="index.php" class="btn btn-default" type="cancel">Annuler</a>
          <button type="submit" class="btn btn-primary pull-right">Valider</button>
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
< ?php
if (isset($success)) :
?>
<div class="alert alert-success">
<strong>Votre inscription a bien été enregistrée.</strong>
</div> -->
<!-- <h4 class="modal-title alert-success" id="ModalLabel">Votre inscription a bien été enregistrée.</h4>
</div>
<div class="modal-body row">
<div class="col-sm-6">
<a class="btn btn-primary" href="< ?=SITE_PATH;?>admin/annonce-edit.php">Déposer une annonce</a>
</div>
<div class="col-sm-5 col-sm-offset-1">
<a class="btn btn-default" href="< ?=SITE_PATH;?>index.php">Retour à l'accueil</a>
</div>
</div>
< ?php
endif;
?>
</div>
</div>
</div> -->

</div>


<?php
include __DIR__.('/layout/bottom.php');
?>
