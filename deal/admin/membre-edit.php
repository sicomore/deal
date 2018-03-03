<?php
require_once __DIR__.'/../include/init.php';
adminSecurity();

$errors = [];
$civilite = $pseudo = $nom = $prenom = $email = $telephone = $role = $mdp = '';

$req = 'SELECT * FROM membre';
$stmt = $pdo->query($req);
$mbs = $stmt->fetchAll();

if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);

  // Toutes les vérifications des champs du formulaire
  if (empty($_POST['pseudo'])) {
    $errors[] = 'Le pseudo est obligatoire.';
  } else {
    $req = 'SELECT COUNT(*) FROM membre WHERE pseudo = '.$pdo->quote($_POST['pseudo']);
    $stmt = $pdo->query($req);
    $nb = $stmt->fetchColumn();
    if (($nb != 0) && (!isset($_GET['id']))) {
      $errors[] = 'Ce pseudo existe déjà.';
    }
  }
  if (empty($_POST['civilite'])) {
    $errors[] = 'Choisir une civilité.';
  }
  if (empty($_POST['role'])) {
    $errors[] = 'Choisir un statut pour le membre.';
  }
  if (empty($_POST['nom'])) {
    $errors[] = 'Le nom est obligatoire.';
  }
  if (empty($_POST['prenom'])) {
    $errors[] = 'Le prénom est obligatoire.';
  }
  if (empty($_POST['telephone'])) {
    $errors[] = 'Le téléphone est obligatoire.';
  } elseif (!preg_match ('#^[0-9 .+]+$#', $_POST['telephone'])) {
    $errors[] = 'Le téléphone est invalide.';
  }
  if (empty($_POST['email'])) {
    $errors[] = 'L\'email est obligatoire.';
  } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'L\'email est invalide.';
  }

  // Vérification des mots de Passe
  // Possibilité de ne pas changer en cas de "modification"
  if ((!empty($_POST['mdp'])) XOR (!empty($_POST['mdp-confirm']))) {
    $errors[] = 'Les 2 mots de passe ne sont pas identiques.';
  }
  if ((!empty($_POST['mdp'])) && (!empty($_POST['mdp-confirm']))) {
    if (!preg_match ('#^[A-Za-z0-9_-]{6,20}$#', $_POST['mdp'])) {
      $errors [] = 'Le mot de passe doit contenir de 6 à 20 caractères';
    } elseif ($_POST['mdp-confirm'] != $_POST['mdp']) {
      $errors[] = 'Les 2 mots de passe ne sont pas identiques.';
    }
  }
  if ((empty($_POST['mdp'])) && (empty($_POST['mdp-confirm']))) {
    if (!isset($_GET['id'])) {
      $errors[] = 'Le mot de passe est obligatoire.';
    }
  }

  // Si aucune erreur, MAJ en cas de modification / Ajout à la bdd en cas de création
  if (empty($errors)) {
    $encodePassword = password_hash ($mdp, PASSWORD_BCRYPT);

    if (isset($_GET['id'])) {
      $req = 'UPDATE membre SET civilite = :civilite, pseudo = :pseudo, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, mdp = :mdp, role = :role WHERE id = '. $_GET['id'];
      $stmt = $pdo->prepare($req);

    } else {
      $req = 'INSERT INTO membre (civilite, pseudo, nom, prenom, telephone, email, mdp, role) VALUES (:civilite, :pseudo, :nom, :prenom, :telephone, :email, :mdp, :role)';
      $stmt = $pdo->prepare($req);
    }

    $stmt->bindValue(':civilite', $civilite);
    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->bindValue(':nom', $nom);
    $stmt->bindValue(':prenom', $prenom);
    $stmt->bindValue(':telephone', $telephone);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':mdp', $encodePassword);
    $stmt->bindValue(':role', $role);
    $stmt->execute();
    $success = true;

    setFlashMessage("Le membre $pseudo a bien été enregistré.");
    header('Location: membre-edit.php');
    die;
  }
}


// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__.('/../layout/top.php');

?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Gestion des membres</h1>
    </div>
  </div>

  <?php displayFlashMessage(); ?>

  <?php
  // Affichage des messages d'alerte en cas de tableau d'erreur non vide

  // Messages en cas d'erreurs
  if (!empty($errors)) :
    ?>
    <div class="alert alert-danger">
      <p><strong>Le formulaire contient des erreurs</strong></p>
      <?= implode ('<br>', $errors); ?>
    </div>
    <?php
  endif;

  // Message en cas de succès
  if (isset($success)) :
    ?>
    <div class="alert alert-success">
      <strong>La fiche membre a bien été créée ou modifiée.</strong>
    </div>
    <?php
  endif;
  ?>

  <!--===================== Tableau des membres =====================-->

  <table class="table table-bordered table-striped">
    <th colspan="10">
      <h4>Membres</h4>
    </th>
    <tr>
      <th class="col-xs-1">ID membre</th>
      <th class="col-xs-auto">Pseudo</th>
      <th class="col-xs-auto">Nom</th>
      <th class="col-xs-auto">Prénom</th>
      <th class="col-xs-auto">Email</th>
      <th class="col-xs-auto">Téléphone</th>
      <th class="col-xs-auto">Civilité</th>
      <th class="col-xs-auto">Statut</th>
      <th class="col-xs-auto">Date d'inscription</th>
      <th class="col-xs-1">Options</th>
    </tr>

    <?php
    foreach ($mbs as $mb) :
      ?>
      <tr>
        <td><?= $mb['id'] ?></td>
        <td><?= $mb['pseudo'] ?></td>
        <td><?= $mb['nom'] ?></td>
        <td><?= $mb['prenom'] ?></td>
        <td><?= $mb['email'] ?></td>
        <td><?= $mb['telephone'] ?></td>
        <td><?= $mb['civilite'] ?></td>
        <td><?= $mb['role'] ?></td>
        <td><?= strftime('%d/%m/%Y',strtotime($mb['date_enregistrement'])); ?></td>
        <!-- //number_format (chiffre, nb décimales, séparateur décimal, séparateur millier) -->
        <td>
          <a href="<?= SITE_PATH; ?>profil.php?id=<?= $mb['id'] ?>" class="btn btn-primary">Modifier</a>
          <a href="membre-delete.php?id=<?= $mb['id'] ?>" class="btn btn-danger">Supprimer</a>
        </td>
      </tr>
      <?php
    endforeach;
    ?>

  </table>



  <!--=========== FORMULAIRE D'INSCRIPTION et modification d'un membre ============-->

  <!-- < ?php
  if (!empty($_GET)) {
    $req = 'SELECT * FROM membre WHERE id =' . $_GET['id'];
    $stmt = $pdo->query($req);
    $membre = $stmt->fetch();
    extract($membre);
  }
  ?>

  <div class="row">
    <div class="col-xs-10 col-sm-offset-1">
      <form class="membre-edit" method="post">
        <div class="row">
          <div class="col-md-6">

            <!-- Input pseudo - ->
            <div class="form-group col">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Pseudo</span>
                <input name="pseudo" value="<?= $pseudo ;?>" type="text" class="form-control" id="pseudo" placeholder="">
              </div>
            </div>

            <div class="row">

              <!-- Select civilité - ->
              <div class="form-group col-sm-6">
                <select name="civilite" class="form-control selectpicker" id="civilite">
                  <option value=''>Civilité</option>
                  <option value="Mme" < ?= $civilite == 'Mme' ? 'selected' : ''; ?>>Femme</option>
                  <option value="M." < ?= $civilite == 'M.' ? 'selected' : ''; ?>>Homme</option>
                </select>
              </div>

              <!-- Select Statut - ->
              <div class="form-group col-sm-6">
                <select name="role" class="form-control selectpicker" id="role">
                  <option value=''>Statut</option>
                  <option value="user" < ?= $role == 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                  <option value="admin" < ?= $role == 'admin' ? 'selected' : ''; ?>>Administrateur</option>
                </select>
              </div>
            </div>

            <!-- Input nom du membre - ->
            <div class="form-group col">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Nom</span>
                <input name="nom" value="< ?= $nom ;?>" type="text" class="form-control" id="nom" aria-describedby="name" placeholder="">
              </div>
            </div>

            <!-- Input prénom du membre - ->
            <div class="form-group col">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Prenom</span>
                <input name="prenom" value="< ?= $prenom ;?>" type="text" class="form-control" id="prenom" aria-describedby="forname" placeholder="">
              </div>
            </div>
          </div>

          <div class="col-md-6">

            <!-- Input téléphone du membre - ->
            <div class="form-group col">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Téléphone</span>
                <input name="telephone" value="< ?= $telephone ;?>" type="text" class="form-control" id="telephone" aria-describedby="telephone" placeholder="">
              </div>

            </div>

            <!-- Input email du membre - ->
            <div class="form-group col">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Email</span>
                <input name="email" value="< ?= $email ;?>" type="email" class="form-control" id="email" aria-describedby="email" placeholder="">
              </div>
            </div>

            <!-- Input mot de passe du membre - ->
            <div class="form-group col">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Mot de passe</span>
                <input name="mdp" value="" type="password" class="form-control" id="mdp" placeholder="">
              </div>
            </div>

            <!-- Input confirmation du mot de passe du membre - ->
            <div class="form-group col">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">Confirmation</span>
                <input name="mdp-confirm" value="" type="password" class="form-control" id="mdp-confirm" placeholder="">
              </div>
            </div>

            <div class="pull-right">
              <button type="submit" class="btn btn-primary pull-right">Enregistrer</button>
            </div>

          </div>
        </div>
      </form>
    </div>
  </div> -->
</div>


<?php
include __DIR__.('/../layout/bottom.php');
?>
