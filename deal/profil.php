<?php
require_once __DIR__.'/include/init.php';

if (!isUserConnected() || !isUserAdmin() && isset($_GET['id'])) {
  header('Location: index.php');
  die;
}
if (isset($_GET['id'])) {
  $idMembre = (int)$_GET['id'];
} else {
  $idMembre = $_SESSION['membre']['id'];
}
$civilite = $role = $pseudo = $nom = $prenom = $email = $telephone = '';

if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);

  // Toutes les vérifications des champs du formulaire
  if (empty($_POST['pseudo'])) {
    $errors[] = 'Le pseudo est obligatoire.';
  } else {
    $req = 'SELECT COUNT(*) FROM membre WHERE pseudo = :pseudo AND id != :id';
    $pseudoFiltre = strtolower($_POST['pseudo']);
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':id', $idMembre);
    $stmt->bindValue(':pseudo', $pseudoFiltre);
    $stmt->execute();
    $nb = $stmt->fetchColumn();
    if ($nb != 0) {
      $errors[] = 'Ce pseudo existe déjà.';
    }
  }
  if (empty($_POST['civilite'])) {
    $errors[] = 'Choisir une civilité.';
  }
  if (isUserAdmin()) {
    if (empty($_POST['role'])) {
      $errors[] = 'Choisir un statut pour le membre.';
    }
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

  // Vérification des mots de passe
  // Possibilité de ne pas changer en cas de modification de profil
  if ((!empty($_POST['mdp'])) XOR (!empty($_POST['mdp-confirm']))) {
    $errors[] = 'Le mot de passe doit être renseigné 2 fois.';
  }
  if ((!empty($_POST['mdp'])) && (!empty($_POST['mdp-confirm']))) {
    if (!preg_match ('#^[A-Za-z0-9_-]{6,20}$#', $_POST['mdp'])) {
      $errors [] = 'Le mot de passe doit contenir de 6 à 20 caractères';
    } elseif ($_POST['mdp-confirm'] != $_POST['mdp']) {
      $errors[] = 'Les 2 mots de passe ne sont pas identiques.';
    }
  }


  // Si aucune erreur : MAJ en cas de modification / Ajout à la bdd en cas de création
  if (empty($errors)) {
    $reqGet = $reqMdp = '';

    if ((!empty($_POST['mdp'])) || (!empty($_POST['mdp-confirm']))) {
      $encodePassword = password_hash ($mdp, PASSWORD_BCRYPT);
      $reqMdp = ', mdp = :mdp ';
    }

    if (isset($_GET['id'])) {
      $reqGet = ', role = :role ';
    }

    $req = 'UPDATE membre SET civilite = :civilite, pseudo = :pseudo, '
    .'nom = :nom, prenom = :prenom, telephone = :telephone, email = :email '
    . $reqMdp . $reqGet .'WHERE id = :id';

    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':id', $idMembre);
    $stmt->bindValue(':civilite', $civilite);
    $stmt->bindValue(':pseudo', $pseudo);
    $stmt->bindValue(':nom', $nom);
    $stmt->bindValue(':prenom', $prenom);
    $stmt->bindValue(':telephone', $telephone);
    $stmt->bindValue(':email', $email);

    if (!empty($reqMdp)) {
      $stmt->bindValue(':mdp', $encodePassword);
    }
    if (!empty($reqGet)) {
      $stmt->bindValue(':role', $role);
    }
    $stmt->execute();
    $success = true;
  }
}


// Recueil des informations du vendeur
$req = <<<EOS
SELECT m.id idMembre, pseudo, m.nom nom, prenom, email, a.id annonceId, a.titre titreAnnonce, a.photo photo,
description_courte, description_longue, ville, adresse, code_postal, co.id idCommentaire, commentaire, r.nom nomRegion
FROM membre m
JOIN annonce a ON a.membre_id = m.id
JOIN categorie ca ON ca.id = a.categorie_id
JOIN region r ON r.id = a.region_id
LEFT JOIN commentaire co ON co.annonce_id = a.id
WHERE m.id =
EOS
.$idMembre;

// Requête pour les infos du membre
$stmt = $pdo->query($req);
$infosToutes = $stmt->fetchAll();
// var_dump($infosToutes);

// Complément de requête pour les commentaires
$req .= ' GROUP BY annonceId';
$stmt = $pdo->query($req);
$infosMembre = $stmt->fetchAll();


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
    </div>
  </div>

  <!-- < ?php displayFlashMessage(); ?> -->

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
      <strong>Vos modifications ont bien été prises en compte.</strong>
    </div>
    <?php
  endif;
  ?>

  <div class="row">
    <div class="col-md-4">
      <h2>Informations personnelles</h2>
      <h3>
        ID membre : <?= $idMembre; ?>
      </h3>
      <form class="profil" method="post">
        <!-- <div class="row"> -->
        <!-- <div class="col-md-6"> -->
        <div class="row">

          <!-- Select civilité -->
          <div class="form-group col-sm-6">
            <select name="civilite" class="form-control selectpicker" id="civilite">
              <option value=''>Civilité</option>
              <option value="Mme" <?= $civilite == 'Mme' ? 'selected' : ''; ?>>Madame</option>
              <option value="M." <?= $civilite == 'M.' ? 'selected' : ''; ?>>Monsieur</option>
            </select>
          </div>

          <!-- Select Statut -->
          <?php
          if (isUserAdmin()):
            ?>

            <div class="form-group col-sm-6">
              <select name="role" class="form-control selectpicker" id="role">
                <option value=''>Statut</option>
                <option value="user" <?= $role == 'user' ? 'selected' : ''; ?>>Utilisateur</option>
                <option value="admin" <?= $role == 'admin' ? 'selected' : ''; ?>>Administrateur</option>
              </select>
            </div>
          <?php endif; ?>
        </div>

        <!-- Input pseudo -->
        <div class="form-group col">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Pseudo</span>
            <input name="pseudo" value="<?= $pseudo ;?>" type="text" class="form-control" id="pseudo" placeholder="">
          </div>
        </div>


        <!-- Input nom du membre -->
        <div class="form-group col">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Nom</span>
            <input name="nom" value="<?= $nom ;?>" type="text" class="form-control" id="nom" aria-describedby="name" placeholder="">
          </div>
        </div>

        <!-- Input prénom du membre -->
        <div class="form-group col">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Prenom</span>
            <input name="prenom" value="<?= $prenom ;?>" type="text" class="form-control" id="prenom" aria-describedby="forname" placeholder="">
          </div>
        </div>
        <!-- </div>

        <div class="col-md-6"> -->

        <!-- Input téléphone du membre -->
        <div class="form-group col">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Téléphone</span>
            <input name="telephone" value="<?= $telephone ;?>" type="text" class="form-control" id="telephone" aria-describedby="telephone" placeholder="">
          </div>

        </div>

        <!-- Input email du membre -->
        <div class="form-group col">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Email</span>
            <input name="email" value="<?= $email ;?>" type="email" class="form-control" id="email" aria-describedby="email" placeholder="">
          </div>
        </div>

        <!-- Input mot de passe du membre -->
        <div class="form-group col">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Mot de passe</span>
            <input name="mdp" value="" type="password" class="form-control" id="mdp" placeholder="">
          </div>
        </div>

        <!-- Input confirmation du mot de passe du membre -->
        <div class="form-group col">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">Confirmation</span>
            <input name="mdp-confirm" value="" type="password" class="form-control" id="mdp-confirm" placeholder="">
          </div>
        </div>

        <div class="pull-right">
          <button type="submit" class="btn btn-primary pull-right">Enregistrer</button>
        </div>

        <!-- </div> -->
        <!-- </div> -->
      </form>

    </div>

    <div class="col-md-8">
      <h3>Note</h3>
      <div class="progress">
        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?= $noteMoy; ?>"
          aria-valuemin="0" aria-valuemax="5" style="width:<?= $noteMoy/5*100; ?>%">
          Note moyenne : <?= (float)$noteMoy; ?> / 5
        </div>
      </div>
      <h3>Annonces</h3>
      <div class="row">
        <?php
        foreach ($infosMembre as $ligne => $infoMembre) :
        ?>
        <div class="col-sm-3">
          <img src="<?= SITE_PATH.'photos/'.$infoMembre['photo']; ?>" alt="">

        </div>
      <?php endforeach; ?>

      </div>

      <p></p>

    </div>
  </div>

</div>

<?php
include __DIR__.('/layout/bottom.php');
?>
