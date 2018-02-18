<?php
require_once __DIR__.'/include/init.php';

$errors = [];
$civilite = $pseudo = $nom = $prenom = $email = $telephone = '';

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
    $req = 'SELECT COUNT(*) FROM membre WHERE pseudo = '.$pdo->quote($_POST['pseudo']);
    $stmt = $pdo->query($req);
    $nb = $stmt->fetchColumn();
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
    // Affiche le message de confirmation dans HTML
  }
}

// Recueil des informations du vendeur
$req = <<<EOS
SELECT m.*, m.id idMembre, a.titre titreAnnonce, a.description_courte description_courte,  c.id idCommentaire, c.*
FROM membre m
JOIN annonce a ON a.membre_id = m.id
JOIN commentaire c ON c.annonce_id = a.id
WHERE m.id =
EOS
.(int)$_GET['id'];
$stmt = $pdo->query($req);
$membreTout = $stmt->fetchAll();

foreach ($membreTout as $ligne => $membre) {
}

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

  <div class="row">
    <div class="col-lg-8">
      <h2>Informations personnelles</h2>
      <p>
        ID membre : <?= $membre['idMembre'] ?>
      </p>
      <form method="post">
        <div class="form-group">
          <input name="pseudo" value="<?= $membre['pseudo'] ?>" type="text" class="form-control" id="pseudo" aria-describedby="name" placeholder="<?= $membre['pseudo'] ?>">
        </div>
        <div class="form-group">
          <input name="nom" value="<?= $membre['nom'] ;?>" type="text" class="form-control" id="nom" aria-describedby="name" placeholder="<?= $membre['nom'] ;?>">
        </div>
        <div class="form-group">
          <input name="prenom" value="<?= $membre['prenom'] ;?>" type="text" class="form-control" id="prenom" aria-describedby="name" placeholder="<?= $membre['prenom'] ;?>">
        </div>

        <div class="pull-right">
          <a href="index.php" class="btn btn-default" type="cancel">Annuler</a>
          <button type="submit" class="btn btn-primary pull-right">Valider</button>
        </div>


    </form>

    </div>

    <div class="col-lg-4">
      <h3>Note</h3>
      <p></p>

    </div>
  </div>

</div>

<?php
include __DIR__.('/layout/bottom.php');
?>
