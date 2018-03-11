<?php
require_once __DIR__.'/include/init.php';

if (!isUserConnected() || !isUserAdmin() && isset($_GET['id'])) {
  header('Location: index.php');
  die;
}

// var_dump($_POST);

if (isset($_GET['id'])) {
  $idMembre = (int)$_GET['id'];
} else {
  $idMembre = $_SESSION['membre']['id'];
}

$civilite = $role = $pseudo = $nom = $prenom = $email = $idAnnonce = $telephone = '';

if (!empty($_POST) && isset($_POST['infosSubmit'])) {
  sanitizePost();
  extract($_POST);

  // Toutes les vérifications des champs du formulaire "Informations personnelles " --------
  if (empty($_POST['pseudo'])) {
    $errors[] = 'Le pseudo est obligatoire.';
  } elseif (!preg_match ('#^[A-Za-z0-9_-]{3,20}$#', $_POST['pseudo'])) {
    $errors [] = 'Le pseudo doit contenir de 3 à 20 caractères';
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
  // Vérification du statut possible pour un utilisateur admin
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

  // Vérification des mots de passe : Possibilité de ne pas changer en cas de modification de profil
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

  // Si aucune erreur, MAJ en cas de modification
  if (empty($errors)) {
    $reqGet = $reqMdp = '';

    // Si le mot de passe a été renseigné, ajout dans la requête de mise à jour de la bdd
    if ((!empty($_POST['mdp'])) || (!empty($_POST['mdp-confirm']))) {
      $encodePassword = password_hash ($mdp, PASSWORD_BCRYPT);
      $reqMdp = ', mdp = :mdp ';
    }

    // S'il s'agit d'une modification de profil par un admin, attribution possible d'un statut admin ou user
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

// // MAJ de la disponibilité de l'annonce -----------------------------------------------
// if (isset($_POST['dispoSubmit'])) {
//   $req = 'UPDATE annonce SET dispo = :dispo WHERE id = :id';
//   $stmt = $pdo->prepare($req);
//   $stmt->bindValue(':dispo', $_POST['dispo']);
//   $stmt->bindValue(':id', $_POST['dispoIdAnnonce']);
//   $stmt->execute();
//   $success = true;
// }


// Recueil des informations du vendeur à afficher
$req = 'SELECT * FROM membre m WHERE m.id = '. $idMembre;
$stmt = $pdo->query($req);
$infosMembre = $stmt->fetch();
extract($infosMembre);

// Recueil des informations des annonces à afficher
$req = <<<EOS
SELECT a.id idAnnonce, dispo, a.titre titreAnnonce, a.photo photo,
description_courte, description_longue, ville, adresse, code_postal, a.membre_id idVendeur, ca.titre titreCategorie, r.nom nomRegion
FROM annonce a
JOIN categorie ca ON ca.id = a.categorie_id
JOIN region r ON r.id = a.region_id
WHERE a.membre_id = ?
EOS;
$stmt = $pdo->prepare($req);
$stmt->execute([$idMembre]);
$infosAnnonce = $stmt->fetchAll();
extract($infosAnnonce);

// Recueil des infos pour les commentaires
$req = <<<HD
SELECT c.id idCommentaire, c.annonce_id idAnnonce, c.commentaire, c.date_enregistrement dateCommentaire, a.membre_id idVendeur, c.membre_id idClient, m.pseudo pseudoClient
FROM commentaire c
JOIN membre m ON m.id = c.membre_id
JOIN annonce a ON a.id = c.annonce_id
WHERE c.membre_id != :idVendeur
AND (c.date_enregistrement >
(SELECT max(c.date_enregistrement)
FROM commentaire c
WHERE c.annonce_id = :idAnnonce AND c.membre_id = :idVendeur))
UNION
SELECT c.id idCommentaire, c.annonce_id idAnnonce, c.commentaire, c.date_enregistrement dateCommentaire, a.membre_id idVendeur, c.membre_id idClient, m.pseudo pseudoClient
FROM commentaire c
JOIN membre m ON m.id = c.membre_id
JOIN annonce a ON a.id = c.annonce_id
WHERE a.membre_id = :idVendeur AND c.annonce_id = :idAnnonce
AND a.membre_id NOT IN (SELECT membre_id FROM commentaire WHERE annonce_id = :idAnnonce)
ORDER BY dateCommentaire DESC
HD;
$stmtComment = $pdo->prepare($req);

// Requête pour obtenir la note moyenne du vendeur
$req = 'SELECT AVG(note) FROM notes n JOIN membre m ON n.membre_id2 = m.id
WHERE m.id = ' . $idMembre;
$stmt = $pdo->query($req);
$noteMoy = $stmt->fetchColumn();

// Requête pour obtenir les avis des acheteurs
$req = 'SELECT m.pseudo pseudo, n.avis avis FROM notes n JOIN membre m ON m.id = n.membre_id1 '
.'WHERE n.membre_id2 = ' . $idMembre;
$stmt = $pdo->query($req);
$lesAvis = $stmt->fetchAll();

// Requête pour insérer en BDD la réponse à un commentaire Client
if (!empty($commentaire)) {
  $commentaire = strip_tags(nl2br($commentaire));
  $req = 'INSERT INTO commentaire(commentaire, membre_id, annonce_id) VALUES (:commentaire, :membre_id, :annonce_id)';
  $stmt = $pdo->prepare($req);
  $stmt->bindValue(':commentaire', $commentaire);
  $stmt->bindValue(':membre_id', $idMembre);
  $stmt->bindValue(':annonce_id', $idAnnonce);
  $stmt->execute();
  $success = true;
}



// -------------------------- Traitement de l'affichage --------------------------------
// -------------------------- Traitement de l'affichage --------------------------------
// -------------------------- Traitement de l'affichage --------------------------------

include __DIR__.('/layout/top.php');
?>

<!--==================== Modal pour répondre au commentaire =====================-->

<div class="modal fade" id="modal_commentaire" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalLabel">Répondre au commentaire</h4>
      </div>

      <form method="post">
        <div class="modal-body">
          <div class="form-group">
            <h5>Commentaire</h5>
            <textarea name="commentaire" class="form-control" rows="5" id="commentaire" placeholder="Laisser un commentaire ou poser une question au vendeur à propos de l'annonce"></textarea>
          </div>

          <div class="row modal-footer">
            <!-- <input type="hidden" name="idAnnonce" name="idAnnonce" value=""> -->
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Annuler</button>
            <button type="submit" name="commentSubmit" id="commentSubmit" class="btn btn-primary">Envoyer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!--=========================== Fin du modal ===========================-->


<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">
        Profil de <?= $prenom.' '.$nom; ?>
      </h1>
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
      <strong>Vos modifications ont bien été prises en compte.</strong>
    </div>
    <?php
  endif;
  ?>

  <div id="dispoMAJ"></div>


  <div class="row">
    <div class="col-md-6" id="infosPersos">
      <h2>Informations personnelles</h2>
      <!-- <div class="row"> -->
      <h4>
        ID membre : <?= $idMembre; ?>
      </h4>
      <form class="profil" method="post">
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
            <span class="input-group-addon" id="basic-addon1">Prénom</span>
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
          <button type="submit" name="infosSubmit" class="btn btn-primary pull-right">Enregistrer</button>
        </div>
      </form>
      <!-- </div> -->
    </div>

    <div class="col-md-6">
      <div class="row" id="rating">
        <h3 class="col-sm-6 note">Note du vendeur</h3>
        <?php
        if (!$noteMoy) {
          echo '<p>Ce vendeur n\'a reçu aucune note</p>';
        } else {

          $star = '';
          for ($i=0; $i<round($noteMoy); $i++) {
            $star .= '<i class="fa fa-star note"></i>';
          }
          if ((round($noteMoy,1)*10)%10 != 0) {
            $star .= '<i class="fa fa-star-half note"></i>';
          }
          ?>
          <div class="col-sm-6">
            <div class="pull-right">
              <?= $star; ?>
            </div>
          </div>
        <?php } ?>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <h3>Avis des acheteurs</h3>
        </div>
        <?php if (!$lesAvis) : ?>
          <div class="col-sm-12 well">
            <p>Ce vendeur n'a reçu aucun avis</p>
          </div>
        <?php else :
          foreach ($lesAvis as $avis) : ?>
          <div class="col-sm-6">

            <div class="panel panel-info">
              <div class="panel-heading">
                <h4 class="panel-title">Avis de : <?= $avis['pseudo']; ?></h4>
              </div>
              <div class="panel-body">
                <?= $avis['avis']; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <h3>Mes annonces</h3>
  </div>

  <?php if (!$infosAnnonce) : ?>
    <div class="col-sm-12 well">
      <p>Ce vendeur n'a publié aucune annonce</p>
    </div>

  <?php else :
    foreach ($infosAnnonce as $infoAnnonce) : ?>
    <div class="row" id="listeAnnonces">
      <div class="row">

        <div class="col-sm-3">
          <a href="<?= SITE_PATH.'photos/'.$infoAnnonce['photo']; ?>" data-lightbox="lightbox">
            <img src="<?= SITE_PATH.'photos/'.$infoAnnonce['photo']; ?>" alt="photo de <?= $infoAnnonce['titreAnnonce']; ?>">
          </a>
        </div>

        <div class="col-sm-7">
          <h4 class=""><?= $infoAnnonce['titreAnnonce']; ?></h4>
          <h5 class="">N° Annonce : <?= $infoAnnonce['idAnnonce']; ?></h5>
          <h5 class="">Catégorie : <?= $infoAnnonce['titreCategorie']; ?></h5>
          <p class=""><?= $infoAnnonce['description_courte']; ?></p>
          <em class=""><h5>Adresse : <?= $infoAnnonce['adresse'].' '. $infoAnnonce['code_postal'].' '. $infoAnnonce['ville']; ?></h5></em>
          <p><a href=" <?= SITE_PATH.'annonce-fiche.php?id='.$infoAnnonce['idAnnonce'] ;?>">Modifier l'annonce</a></p>
        </div>

        <!-- Options d'activation / désactivation de l'annonce -->
        <div class="col-auto">
          <?php  if (isUserConnected() && $_SESSION['membre']['id'] == $infoAnnonce['idVendeur'] || isUserAdmin()) : ?>

            <form class="form" method="post">
              <input type="hidden" name="dispoIdAnnonce" value=" < ?= $infoAnnonce['idAnnonce']; ?> ">
              <div class="radio">
                <div class="btn-group btn-group-vertical">
                  <div class="btn btn-success">
                    <label>
                      <input class="<?php echo $infoAnnonce['idAnnonce']; ?>" type="radio" name="dispo" value= <?= ($infoAnnonce['dispo'] == 'active') ? '"active" checked' : '"active"' ;?>>Annonce activée
                    </label>
                  </div>
                  <div class="btn btn-danger">
                    <label>
                      <input class="<?php echo $infoAnnonce['idAnnonce']; ?>" type="radio" name="dispo" value=<?= ($infoAnnonce['dispo'] == 'inactive') ? '"inactive" checked' : '"inactive"' ;?>>Annonce désactivée
                    </label>
                  </div>
                  <!-- <input class="btn btn-primary" name="dispoSubmit" type="submit" value"Valider"> -->
                </div>
              </div>
            </form>
          <?php endif; ?>
        </div>

      </div>

      <?php
      $stmtComment->bindValue(':idVendeur', $idMembre);
      $stmtComment->bindValue(':idAnnonce', $infoAnnonce['idAnnonce']);
      $stmtComment->execute();
      $infosCommentaires = $stmtComment->fetchAll();
      // var_dump($infosCommentaires);

      foreach ($infosCommentaires as $infoCommentaire) :
        if (isset($infoCommentaire['idCommentaire'])) :
          if ($infoCommentaire['idAnnonce'] == $infoAnnonce['idAnnonce']) :
            ?>
            <!-- <div class="row"> -->
            <div class="row" id="commentairesAnnonces">
              <div class="panel panel-default">
                <div class="panel-heading col-sm-4">
                  <strong>
                    Commentaire laissé par <a href="<?= SITE_PATH.'profil.php?id='.$infoCommentaire['idClient'] ;?>">
                      <?= $infoCommentaire['pseudoClient'] ;?></a> le <?= strftime('%d/%m/%Y à %Hh%M', strtotime($infoCommentaire['dateCommentaire'])) ;?>
                    </strong>
                  </div>
                  <div class="panel-body col-sm-8">
                    <div>
                      <?= $infoCommentaire['commentaire'] ;?>
                    </div>
                    <?php
                    if (isUserConnected() && $infoCommentaire['idVendeur'] == $_SESSION['membre']['id']) :
                      ?>
                      <form>
                        <input type="hidden" name="idAnnonce" value="<?= $infoCommentaire['idAnnonce'] ;?>">
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal_commentaire" id="submitReponse" value="<?php echo $infoCommentaire['idAnnonce'] ;?>" data-idMembre="<?= $_SESSION['membre']['id'] ;?>">
                          Répondre au commentaire
                        </button>
                      </form>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

            <?php endif;
          endif;
        endforeach; ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>


  <!--========== Présetation sous forme de liste ==========-->

  <!-- <div class="row" id="listeAnnonces">
  <div class="col-sm-3">
  <img src="< ?= SITE_PATH.'photos/'.$infoAnnonce['photo']; ?>" alt="photo de < ?= $infoAnnonce['titreAnnonce']; ?>" style="max-width: 180px">
</div>

<div class="col-sm-10">
<h4 class="col-sm-8">< ?= $infoAnnonce['titreAnnonce']; ?></h4>
<h5 class="col-sm-4 pull-right">Catégorie : < ?= $infoAnnonce['titreCategorie']; ?></h5>
<p class="col-sm-12">< ?= $infoAnnonce['description_courte']; ?></p>
<em class="col-sm-12"><h5>Adresse : < ?= $infoAnnonce['adresse'].' '. $infoAnnonce['code_postal'].' '. $infoAnnonce['ville']; ?></h5></em>
</div>
</div> -->
</div>

</div>


<?php
include __DIR__.('/layout/bottom.php');
?>
