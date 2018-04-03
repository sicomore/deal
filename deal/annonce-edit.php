<?php
require_once __DIR__.'/include/init.php';

$errors = [];
$titre = $description_longue = $description_courte = $prix = $categorie = $photoActuelle = $region = $ville = $adresse = $code_postal = $reference = '';


if (!isUserConnected()) {
  setFlashMessage('Pour accéder à cette page, vous devez vous connecter.', 'warning');
  header('Location: '.SITE_PATH.'index.php');
  die;
}

// Requête pour select de la catégorie et de la région
$req = 'SELECT * FROM categorie';
$stmt = $pdo->query($req);
$cats = $stmt->fetchAll();

$req = 'SELECT * FROM region';
$stmt = $pdo->query($req);
$regs = $stmt->fetchAll();


if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);

  //conditions pour le titre
  if (empty($_POST['titre'])) {
    $errors[] = 'Renseigner un titre pour votre annonce';
  }

  // conditions pour les descriptions
  if (empty($_POST['description_courte'])) {
    $errors[] = 'Renseigner une courte description de l\'annonce';
  } elseif (strlen($_POST['description_courte']) > 100) {
    $errors[] = 'La description courte ne doit pas dépasser 100 caractères.';
  }

  if (empty($_POST['description_longue'])) {
    $errors[] = 'Renseigner une description détaillée de l\'annonce';
  }

  // Conditions pour le prix
  if (empty($_POST['prix'])) {
    $errors[] = 'Il manque le prix pour votre annonce.';
  }

  // Conditions pour le catégorie
  if (empty($_POST['categorie'])){
    $errors[] = 'Sélectionnez la catégorie pour votre annonce.';
  }

  // Conditions pour les photos à télécharger
  if (!empty($_FILES['photo']['tmp_name'])){
    if ($_FILES['photo']['size'] > 1000000) {
      $errors[] = 'La photo doit avoir une taille inférieure à 1 Mo';
    }
    $allowedMimeType = ['image/jpeg', 'image/png', 'image/gif' ];
    if (!in_array($_FILES['photo']['type'], $allowedMimeType)) {
      $errors[] = 'La photo doit être une photo de type jpg, jpeg, png ou gif.';
    }
  }

  // Conditions pour la région
  if (empty($_POST['region'])) {
    $errors[] = 'La region est obligatoire.';
  }
  // Conditions pour la ville
  if (empty($_POST['ville'])) {
    $errors[] = 'La ville est obligatoire.';
  }
  // Conditions pour l'adresse
  if (empty($_POST['adresse'])) {
    $errors[] = 'L\'adresse est obligatoire.';
  }
  // Conditions pour le code postal
  if (empty($_POST['code_postal'])) {
    $errors[] = 'Le code postal est obligatoire.';
  } elseif (strlen($_POST['code_postal']) != 5 || !ctype_digit($_POST['code_postal'])) {
    // Permet de valider le nb de chiffres dans le CP et de s'assurer que ce sont des chiffres (ctype_digit)
    $errors[] = 'Le code postal est invalide.';
  }

  if (empty($errors)) {
    // traitement de l'image
    if (!empty($_FILES['photo']['tmp_name'])){
      $dotPosition = strrpos($_FILES['photo']['name'], '.');
      $extension = substr($_FILES['photo']['name'], $dotPosition);
      $reference = md5(time(10));
      $nomFichier = $reference . $extension;
      // var_dump($nomFichier);

      // suppression de la photo initiale si on la modifie (écrase le fichier)
      if (!empty($photoActuelle)) {
        unlink(PHOTO_DIR . $photoActuelle);
      }

      move_uploaded_file(
        $_FILES['photo']['tmp_name'], PHOTO_DIR . $nomFichier
      );
    } else {
      $nomFichier = $photoActuelle;
    }


    if (isset($_GET['id'])) {
      // var_dump($_POST);
      $req = 'UPDATE annonce SET titre = :titre, description_courte = :description_courte, description_longue = :description_longue, prix = :prix, categorie_id = :categorie_id, photo = :photo, region_id = :region_id, ville = :ville, adresse = :adresse, code_postal = :code_postal WHERE id = :id';
      $stmt = $pdo->prepare($req);
      $stmt->bindValue(':id', $_GET['id']);
      $stmt->bindValue(':titre', $_POST['titre']);
      $stmt->bindValue(':description_courte', $_POST['description_courte']);
      $stmt->bindValue(':description_longue', $_POST['description_longue']);
      $stmt->bindValue(':prix', $_POST['prix']);
      $stmt->bindValue(':categorie_id', $_POST['categorie']);
      $stmt->bindValue(':region_id', $_POST['region']);
      $stmt->bindValue(':ville', $_POST['ville']);
      $stmt->bindValue(':adresse', $_POST['adresse']);
      $stmt->bindValue(':code_postal', $_POST['code_postal']);

      if (!empty($nomFichier)) {
        $stmt->bindValue(':photo', $nomFichier);
      } else {
        $stmt->bindValue(':photo', null, PDO::PARAM_NULL);
      }

      $stmt->execute();

    } else {
      $reqI = 'INSERT INTO annonce (titre, description_courte, description_longue, prix, categorie_id, photo, region_id, ville, adresse, code_postal, membre_id) VALUES (:titre, :description_courte, :description_longue, :prix, :categorie_id, :photo, :region_id, :ville, :adresse, :code_postal, :membre_id)';
      $stmt = $pdo->prepare($reqI);
      $stmt->bindValue(':titre', $_POST['titre']);
      $stmt->bindValue(':description_courte', $_POST['description_courte']);
      $stmt->bindValue(':description_longue', $_POST['description_longue']);
      $stmt->bindValue(':prix', $_POST['prix']);
      $stmt->bindValue(':categorie_id', $_POST['categorie']);
      $stmt->bindValue(':region_id', $_POST['region']);
      $stmt->bindValue(':ville', $_POST['ville']);
      $stmt->bindValue(':adresse', $_POST['adresse']);
      $stmt->bindValue(':code_postal', $_POST['code_postal']);
      $stmt->bindValue(':membre_id', $_SESSION['membre']['id']);

      if (!empty($nomFichier)) {
        $stmt->bindValue(':photo', $nomFichier);
      } else {
        $stmt->bindValue(':photo', null, PDO::PARAM_NULL);
      }
      $stmt->execute();
    }

    setFlashMessage("Votre annonce a bien été enregistrée.");
    header('Location: '.SITE_PATH.'profil.php');
    die;
  }


} elseif (isset($_GET['id']) && !empty($_GET['id'])) {
  if (!isUserAdmin()) {
    $req = 'SELECT id, membre_id FROM annonce WHERE id = '.(int)$_GET['id']
    .' AND membre_id = '.$_SESSION['membre']['id'];
    $stmt = $pdo->query($req);
    $stmt->fetch();

    if ($stmt->rowCount() == 0) {
      setFlashMessage("Vous ne pouvez pas accéder à cette annonce ou elle n'existe pas.", 'warning');
      header('Location: '.SITE_PATH.'profil.php');
      die;
    }

  } else {
    $req = 'SELECT titre, description_courte, description_longue, prix, categorie_id, photo, region_id, ville, adresse, code_postal FROM annonce WHERE id ='.(int)$_GET['id'];
    $stmt = $pdo->query($req);
    $annonces = $stmt->fetch();
    extract($annonces);
    $categorie = $annonces['categorie_id'];
    $photoActuelle = $annonces['photo'];
    $region = $annonces['region_id'];
  }

}



// ------------------------- Traitement de l'affichage -------------------------------
// ------------------------- Traitement de l'affichage -------------------------------
// ------------------------- Traitement de l'affichage -------------------------------

include __DIR__.('/layout/top.php');
?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Edition de l'annonce</h1>
    </div>
  </div>

  <?php
  if (!empty($errors)) :
    ?>
    <div class="alert alert-danger">
      <p><strong>Le formulaire contient des erreurs</strong></p>
      <?= implode ('<br>', $errors); ?>
    </div>
    <?php
  endif;
  ?>

  <div class="row">
    <div class="col-auto">
      <form method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-lg-6">

            <div class="col-auto form-group">
              <label for="">Titre</label>
              <input type="text" name="titre" value="<?= $titre ?>" placeholder="Titre de votre annonce" class="form-control">
            </div>

            <div class="col-auto form-group">
              <label for="">Description courte</label>
              <input type="text" name="description_courte" value="<?= $description_courte ?>" placeholder="Description courte de votre annonce" class="form-control">
            </div>

            <div class="col-auto form-group">
              <label for="">Description longue</label>
              <textarea name="description_longue" rows="8" value="<?= $description_longue; ?>" placeholder="Description détaillée de votre annonce" class="form-control"><?= $description_longue; ?></textarea>
            </div>

            <div class="col-auto form-group">
              <label for="">Prix</label>
              <input type="text" name="prix" value="<?= $prix ?>" placeholder="Prix figurant dans l'annonce" class="form-control">
            </div>

            <div class="col-auto form-group">
              <label for="">Catégorie</label>
              <select class="form-control" name="categorie">
                <option value="" >Toutes les catégories</option>
                <?php foreach ($cats as $cat):
                  $selected = ($cat['id'] == $categorie)
                  // $selected = ($cat['id'] == $_POST['categorie'])
                  ? 'selected'
                  : '' ;
                  ?>
                  <option value="<?= $cat['id']; ?>" <?= $selected; ?>><?= $cat['titre']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label for="">Photo</label>
              <input type="file" name="photo" value="" class="form-control-file">
            </div>
            <input type="hidden" name="photoActuelle" value="<?= $photoActuelle; ?>">
            <?php
            if (!empty($photoActuelle)) :
              ?>
              <p><img src="<?= PHOTO_WEB . $photoActuelle; ?>" alt="photo de l'annonce" height="150px"></p>

              <?php
              echo $photoActuelle;
            endif;
            ?>

            <div class="col-auto form-group">
              <label for="">Région</label>
              <select class="form-control" name="region">
                <option value="" >Toutes les régions</option>
                <?php foreach ($regs as $reg):
                  $selected = ($reg['id'] == $region)
                  ? 'selected'
                  : '' ;
                  ?>
                  <option value="<?= $reg['id']; ?>" <?= $selected; ?>><?= $reg['nom']; ?></option>
                <?php endforeach; ?>
              </select>

            </select>
          </div>
          <div class="col-auto form-group">
            <label for="">Ville</label>
            <input type="text" name="ville" value="<?= $ville; ?>" placeholder="Ville" class="form-control">
          </select>
        </div>
        <div class="col-auto form-group">
          <label for="">Adresse</label>
          <textarea placeholder="Adresse figurant dans l'annonce" class="form-control" name="adresse"><?= $adresse; ?></textarea>
        </div>
        <div class="col-auto form-group">
          <label for="">CP</label>
          <input type="text" name="code_postal" value="<?= $code_postal; ?>" placeholder="Code postal figurant dans l'annonce" class="form-control">
        </div>

      </div>
    </div>

    <button class="btn btn-primary pull-right" type="submit" name="button">Enregistrer</button>
  </form>
</div>
</div>
</div>




<?php
include __DIR__.('/layout/bottom.php');
?>
