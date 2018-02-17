<?php
require_once __DIR__.'/include/init.php';

$photoActuelle = $commentaire = $avis = $note = '';

// var_dump($_POST);

$errors = [];

extract($_POST);

// Requête de toutes les informations concernant l'annonce et le vendeur
$req = <<<EOS
SELECT m.pseudo pseudo, a.*, r.nom region, c.titre titre_categorie
FROM annonce a
JOIN membre m ON m.id = a.membre_id
JOIN region r ON r.id = a.region_id
JOIN categorie c ON c.id = a.categorie_id
WHERE a.id =
EOS
.(int)$_GET['id'];
$stmt = $pdo->query($req);
$annonce = $stmt->fetch();

// $req = 'SELECT COUNT(*) FROM commentaire WHERE membre_id = '.$_SESSION['membre']['id'].' AND annonce_id = '.$_GET['id'];
// $stmt = $pdo->query($req);
// $dejaCommente = $stmt->fetchColumn();
// var_dump($dejaCommente);

// Requête d'affichage des commentaires de l'annonce
$req = 'SELECT c.*, m.pseudo pseudo FROM commentaire c JOIN membre m ON m.id = c.membre_id WHERE annonce_id ='.$_GET['id'];
$stmt = $pdo->query($req);
$commentTous = $stmt->fetchAll();

foreach ($commentTous as $membreCommente) {
  $reqM = $req .' AND membre_id ='. $annonce['membre_id'];
}

$req .= ' ORDER BY id DESC LIMIT 5';
$stmt = $pdo->query($req);
$commentAffiches = $stmt->fetchAll();

// Enregistrement du commentaire dans la table éponyme
if (!empty($commentaire)) {
  $req = 'INSERT INTO commentaire(commentaire, membre_id, annonce_id) VALUES (:commentaire, :membre_id, :annonce_id)';
  $stmt = $pdo->prepare($req);
  $stmt->bindValue(':commentaire', $commentaire);
  $stmt->bindValue(':membre_id', $annonce['membre_id']);
  $stmt->bindValue(':annonce_id', $annonce['id']);
  $stmt->execute();
  $success = true;
}

// Requête sur la table note
if (!empty($avis) || !empty($note)) {

  $req = 'SELECT n.*, m.pseudo pseudo FROM note n JOIN membre m ON m.id = n.membre_id1';
  $stmt = $pdo->query($req);
  $noteToutes = $stmt->fetchAll();

  $req .= ' WHERE membre_id2 = '.$annonce['membre_id'].' AND membre_id1 = '. $_SESSION['membre']['id'];
  $stmt = $pdo->query($req);
  $noteJamaisLaissee = $stmt->fetchColumn();

  // $reqN = $req . ' WHERE membre_id2 = '.

  // $reqS = $req. ' AND membre_id = '.$_SESSION['membre']['id'];
  // $stmt = $pdo->query($reqS);
  // $dejaCommente = $stmt->fetchColumn();


  // Enregistrement de la note et de l'avis dans la table Note
  // membre_id1 = le notant
  // membre_id2 = le noté
  if ($noteJamaisLaissee == 0) {
    $req = 'INSERT INTO note(note, avis, membre_id1, membre_id2) VALUES (:note, :avis, :membre_id1, :membre_id2)';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':note', $note);
    $stmt->bindValue(':avis', $avis);
    $stmt->bindValue(':membre_id1', $_SESSION['membre']['id']);
    $stmt->bindValue(':membre_id2', $annonce['membre_id']);
    $stmt->execute();
    $success = true;
  }
}

// Requête pour afficher les "Autres annonces" autre que celle affichée
$req = 'SELECT a.*, a.titre titre_annonce FROM annonce a JOIN categorie c ON c.id = a.categorie_id WHERE a.id != '.$_GET['id'].' AND c.id = (SELECT categorie_id FROM annonce WHERE id = '.$_GET['id'].') LIMIT 4';
$stmt = $pdo->query($req);
$toutesAnnonces = $stmt->fetchAll();


// Message si l'annonce n'existe pas
if ($annonce === false) {
  header('HTTP/1.1 404 Not Found');
  die("La page n'existe pas ou plus");
}

// Attribution de la photo par défaut si aucune photo n'existe
$src = (!empty($annonce['photo']))
? PHOTO_WEB . $annonce['photo']
: PHOTO_DEFAUT
;




// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__.('/layout/top.php');
?>

<!--======== Modal pour laisser un commentaire, une note et un avis ========-->
<div class="modal fade" id="flipFlop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalLabel">Déposer un commentaire ou une note</h4>
      </div>

      <form method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="">A propos de l'annonce ...</label>
            <h5>Commentaire</h5>
            <textarea name="commentaire" class="form-control" rows="5" id="commentaire" placeholder="Laisser un commentaire ou poser une question au vendeur à propos de l'annonce"></textarea>
          </div>

          <hr>
          <div class="row">
            <!-- Attribution de la note -->
            <div class="col-xs-6">
              <div class="form-group">
                <label for="">A propos du vendeur ...</label>
                <p>Attribuez une note ou un avis au vendeur</p>
                <h5>Note</h5>
                <div class="rating pull-left">
                  <a href="#" value="5" title="Donner 5 étoiles">☆</a>
                  <a href="#" value="4" title="Donner 4 étoiles">☆</a>
                  <a href="#" value="3" title="Donner 3 étoiles">☆</a>
                  <a href="#" value="2" title="Donner 2 étoiles">☆</a>
                  <a href="#" value="1" title="Donner 1 étoile">☆</a>
                  <input type="text" name="note" value="" hidden>
                </div>
              </div>
            </div>

            <div class="col-xs-12">
              <div class="form-group">
                <h5>Avis</h5>
                <textarea name="avis" class="form-control" rows="5" id="avis" placeholder="Laisser un avis sur le vendeur"></textarea>
              </div>
            </div>
          </div>

          <div class="row modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Annuler</button>
            <button type="submit" class="btn btn-primary">Envoyer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!--=========================== Fin du modal ===========================-->

<div id="page-wrapper">

  <div class="row page-header">
    <?php
    displayFlashMessage();

    // Message en cas de succès
    if (isset($success)) :
      ?>
      <div class="alert alert-success">
        <strong>Votre commentaire ou votre avis a bien été pris en compte.</strong>
      </div>
      <?php
    endif;
    ?>

    <div class="col-sm-3">
      <h1 class="">
        <?= $annonce['titre'];  ?>
      </h1>
    </div>

    <div class="col-sm-2">
      <p>Catégorie : <?= $annonce['titre_categorie'];  ?></p>
    </div>

    <?php
    if (!isUserConnected()) {
      $disabled = 'disabled';
      $popover = 'popover';
    } else {
      $disabled = '';
      $popover = '';
    }
    ?>

    <div class="col-sm-7 pull-right">
      <!-- Bouton Déposer un commentaire accessible uniquement pour membre connecté -->
      <div class="pull-right" data-toggle="<?= $popover; ?>" data-placement="left" data-content="Pour laisser un commentaire, veuillez-vous connecter.">
        <button type="button" class="btn btn-primary <?= $disabled; ?>" data-toggle="modal" data-target="#flipFlop">
          Déposer un commentaire ou une note
        </button>
      </div>
    </div>
  </div>

  <div class="row" id="description">
    <div class="col-sm-4">
      <img src="<?= SITE_PATH.'photos/'.$annonce['photo']; ?>" alt="photo de <?= $annonce['titre']; ?>" style="max-height: 250px">
    </div>

    <div class="col-sm-8">
      <h3>Description</h3>
      <p>
        <?= $annonce['description_longue']; ?>
      </p>
      <div class="row">
        <div class="col-md-6">
          <p>
            <b>Date de publication :</b>
            <?= strftime('%d/%m/%Y', strtotime($annonce['date_enregistrement'])); ?>
          </p>
          <p>
            <b>Membre :</b>
            <?= $annonce['pseudo']; ?>
          </p>
          <p>
            <?= $annonce['prix']; ?> €
          </p>
          <p>
            <b>Région :</b>
            <?= $annonce['region']; ?>
          </p>
          <p>
            <b>Adresse :</b>
            <?= $annonce['adresse']; ?>,
            <?= $annonce['code_postal']; ?>
            <?= $annonce['ville']; ?>
          </p>
        </div>
        <div class="col-md-6">

          <iframe  src="https://www.google.com/maps/embed/v1/place?key=<?= API_KEY; ?>&q= <?= $annonce['adresse']; ?>,
            <?= $annonce['code_postal']; ?>
            <?= $annonce['ville'];  ?>" style="width: 100%"></iframe>
          </div>
        </div>
      </div>
    </div>

    <div class="row" id="autres">
      <h3>Autres annonces (Catégorie : <?= $annonce['titre_categorie']; ?>)</h3>
      <?php foreach ($toutesAnnonces as $toutesAnnonce): ?>
        <div class="col-sm-3" style="text-align: center">
          <a href="<?= SITE_PATH.'annonce-fiche.php?id='.$toutesAnnonce['id'] ;?>">
            <img src="<?= SITE_PATH.'photos/'.$toutesAnnonce['photo'];?>" alt="Photo de <?=$toutesAnnonce['titre_annonce'];?>" style="max-height: 150px">
            <p><b> <?= $toutesAnnonce['titre_annonce']; ?></b></p>
            <p><b><?= $toutesAnnonce['prix']; ?> €</b></p>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="row" id="commentaires">
      <h3>Commentaires laissés pour cette annonce</h3>

      <div class="container">
        <?php foreach ($commentAffiches as $commentAffiche): ?>
          <div class="panel panel-default">
            <div class="panel-heading">
              <b><a href="<?= SITE_PATH.'profil.php?id='.$commentAffiche['membre_id'] ;?>">
                <?= $commentAffiche['pseudo']?></a> a laissé un message le <?= strftime('%d/%m/%Y', strtotime($commentAffiche['date_enregistrement'])); ?></b>
              </div>
              <div class="panel-body">
                <?= $commentAffiche['commentaire'] ;?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>

    <?php
    include __DIR__.('/layout/bottom.php');
    ?>
