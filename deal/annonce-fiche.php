<?php
require_once __DIR__.'/include/init.php';

$photoActuelle = $commentaire = $avis = $note = '';

// var_dump($_POST);

$errors = [];

extract($_POST);

// Requête de toutes les informations concernant l'annonce et le vendeur
$req = <<<EOS
SELECT m.pseudo pseudo, telephone, a.*, r.nom region, c.titre titre_categorie
FROM annonce a
JOIN membre m ON m.id = a.membre_id
JOIN region r ON r.id = a.region_id
JOIN categorie c ON c.id = a.categorie_id
WHERE a.id =
EOS
.(int)$_GET['id'];
$stmt = $pdo->query($req);
$annonce = $stmt->fetch();

// Requête d'affichage des commentaires de l'annonce
$reqCommentaires = 'SELECT c.*, m.pseudo pseudo, a.membre_id idVendeur '
.'FROM commentaire c JOIN membre m ON m.id = c.membre_id '
.'JOIN annonce a ON a.id = c.annonce_id '
.'WHERE annonce_id = '.(int)$_GET['id']
.' ORDER BY c.id DESC';
$stmt = $pdo->query($reqCommentaires);
$commentTous = $stmt->fetchAll();
foreach ($commentTous as $comment) {

  // Requête d'affichage des 5 premiers commentaires de l'annonce
  // $reqCommentaires .= ' ORDER BY c.id DESC LIMIT 5';
  // $stmt = $pdo->query($reqCommentaires);
  // $commentAffiches = $stmt->fetchAll();

  // Enregistrement du commentaire dans la table éponyme
  if (!empty($commentaire) && $commentaire != $comment['commentaire']) {
    $req = 'INSERT INTO commentaire(commentaire, membre_id, annonce_id) VALUES (:commentaire, :membre_id, :annonce_id)';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':commentaire', $commentaire);
    $stmt->bindValue(':membre_id', $_SESSION['membre']['id']);
    $stmt->bindValue(':annonce_id', $annonce['id']);
    $stmt->execute();
    $success = true;
  }
}

// Requête sur la table notes
if (!empty($avis) || !empty($note)) {

  $req = 'SELECT n.*, m.pseudo pseudo FROM notes n JOIN membre m ON m.id = n.membre_id1';
  $stmt = $pdo->query($req);
  $noteToutes = $stmt->fetchAll();

  $req .= ' WHERE membre_id2 = '.$annonce['membre_id'].' AND membre_id1 = '. $_SESSION['membre']['id'];
  $stmt = $pdo->query($req);
  $noteLaissee = $stmt->fetchColumn();

  // Enregistrement de la note et de l'avis dans la table Note
  // membre_id1 = le notant
  // membre_id2 = le noté
  if ($noteLaissee == 0) {
    $req = 'INSERT INTO notes(note, avis, membre_id1, membre_id2, date_enregistrement) VALUES (:note, :avis, :membre_id1, :membre_id2, now())';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':note', $note);
    $stmt->bindValue(':avis', $avis);
    $stmt->bindValue(':membre_id1', $_SESSION['membre']['id']);
    $stmt->bindValue(':membre_id2', $annonce['membre_id']);
    $stmt->execute();
    $success = true;

    // Mise à jour de la table notes
  } else {
    if (empty($note)) {
      $MAJ = ' avis = \''.$avis.'\',';
      setFlashMessage('Votre avis sur le vendeur a bien été mis à jour');
    } elseif (empty($avis)) {
      $MAJ = ' note = '.$note.',';
      setFlashMessage('Votre note sur le vendeur a bien été mise à jour');
    } else {
      $MAJ = ' note = '.$note.', avis = \''.$avis.'\',';
      setFlashMessage('Votre note et votre avis sur le vendeur ont bien été mis à jour');
    }

    $req = 'UPDATE notes SET '. $MAJ .' date_enregistrement = now() WHERE membre_id1 = ' .$_SESSION['membre']['id']. ' AND membre_id2 = '.$annonce['membre_id'];
    $stmt = $pdo->exec($req);
  }
}

// Requête pour afficher les "Autres annonces" autre que celle affichée
$req = <<<EOS
SELECT a.*, a.titre titre_annonce FROM annonce a JOIN categorie c ON c.id = a.categorie_id WHERE a.id != ? AND c.id = (SELECT categorie_id FROM annonce WHERE id = ?) LIMIT 4
EOS;
$stmt = $pdo->prepare($req);
$stmt->bindValue(1, $_GET['id']);
$stmt->bindValue(2, $_GET['id']);
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

// Accès aux commentaires, avis et note uniquement si connecté
if (!isUserConnected()) {
  $disabled = 'disabled';
  $popover = 'popover';
} else {
  $disabled = $popover = '';
}


// ------------------------- Traitement de l'affichage -------------------------------
// ------------------------- Traitement de l'affichage -------------------------------

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

                <fieldset class="rating">
                  <input type="radio" id="star5" name="note" value="5" /><label class = "full" for="star5" title="5 étoiles"></label>
                  <input type="radio" id="star4" name="note" value="4" /><label class = "full" for="star4" title="4 étoiles"></label>
                  <input type="radio" id="star3" name="note" value="3" /><label class = "full" for="star3" title="3 étoiles"></label>
                  <input type="radio" id="star2" name="note" value="2" /><label class = "full" for="star2" title="2 étoiles"></label>
                  <input type="radio" id="star1" name="note" value="1" /><label class = "full" for="star1" title="1 étoiles"></label>
                </fieldset>

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

<!--==================== Fin du modal commentaires, notes, avis ====================-->

<!--======================== Modal de numéro de tél et mail ========================-->

<div class="modal fade" id="telMail" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalLabel">Contacter le vendeur</h4>
      </div>

      <form method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>Par téléphone</label>
            <h4><?= $annonce['telephone']; ?></h4>
          </div>

          <hr>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <label for="message">Par mail</label>
                <textarea name="message" class="form-control" rows="5" id="message" placeholder="Laisser un message au vendeur"></textarea>
              </div>
            </div>
          </div>

          <div class="row modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Annuler</button>
            <button type="submit" class="btn btn-success">Envoyer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!--=========================== Fin du modal tél et mail ===========================-->

<div class="container-fluid" id="page-wrapper">

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

  <div class="row page-header">
    <div class="col-sm-3">
      <h1 class="">
        <?= $annonce['titre'];  ?>
      </h1>
    </div>

    <div class="col-sm-2">
      <p>Catégorie : <?= $annonce['titre_categorie'];  ?></p>
    </div>

    <div class="col-sm-7">
      <!-- Bouton Déposer un commentaire accessible uniquement pour membre connecté -->
      <div class="btn-group btn-group-vertical pull-right" data-toggle="<?= $popover; ?>" data-placement="left" data-content="Pour laisser un commentaire, veuillez-vous connecter.">
        <a class="btn btn-primary <?= $disabled; ?>" data-toggle="modal" data-target="#flipFlop">
          Déposer un commentaire ou une note
        </a>
        <!-- Bouton contacter le vendeur uniquement pour membre connecté -->
        <a class="btn btn-success <?= $disabled; ?>" data-toggle="modal" data-target="#telMail">
          Contacter le vendeur
        </a>
      </div>
    </div>

  </div>

  <div class="row" id="description">
    <div class="col-sm-4">
      <img src="<?= SITE_PATH.'photos/'.$annonce['photo']; ?>" alt="photo de <?= $annonce['titre']; ?>" style="max-height: 250px">
    </div>

    <div class="col-sm-8">
      <h3>Description</h3>
      <div class="row">
        <div class="col-md-6">
          <div class="">
            <h3>Prix : <?= $annonce['prix']; ?> €</h3>
          </div>
          <p>
            <?= $annonce['description_longue']; ?>
          </p>
          <p>
            <b>Date de publication :</b>
            <?= strftime('%d/%m/%Y', strtotime($annonce['date_enregistrement'])); ?>
          </p>
          <p>
            <b>Membre :</b>
            <?= $annonce['pseudo']; ?>
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
            <?= $annonce['ville'];  ?>" style="width: 100%">
          </iframe>
        </div>
      </div>
    </div>
  </div>

  <div class="row" id="commentaires">
    <h3>Commentaires laissés pour cette annonce</h3>

    <?php if (empty($commentTous)) : ?>
      <div class="col-xs-3">
        <p>Aucun commentaire laissé pour cette annonce</p>
        <p>Soyez le premier à en laisser un !</p>
      </div>
      <div class="col-xs-3">
        <div class="pull-right" data-toggle="<?= $popover; ?>" data-placement="top" data-content="Pour laisser un commentaire, veuillez-vous connecter.">
          <button type="button" class="btn btn-primary <?= $disabled; ?>" data-toggle="modal" data-target="#flipFlop">
            <i class="fa fa-arrow-right"></i> Laisser un commentaire
          </button>
        </div>
      </div>
      <?php
      else :
        foreach ($commentTous as $commentAffiche):
          ?>
          <!-- <div class="row"> -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <b><a href="<?= SITE_PATH.'profil.php?id='.$commentAffiche['membre_id'] ;?>">
                <?= $commentAffiche['pseudo']?></a> a laissé un message le <?= strftime('%d/%m/%Y à %Hh%M', strtotime($commentAffiche['date_enregistrement'])); ?></b>
              </div>
              <div class="panel-body">
                <?= $commentAffiche['commentaire'] ;?>

                <?php
                if (isUserConnected() && $commentAffiche['idVendeur'] == $_SESSION['membre']['id']):
                  ?>
                  <div class="pull-right">
                    <button type="button" class="btn btn-primary <?= $disabled; ?>" data-toggle="modal" data-target="#flipFlop">
                      Répondre au commentaire
                    </button>
                    <!-- <button type="button" name="reponse" formaction="">
                    Répondre
                  </button> -->
                </div>
              <?php endif; ?>
            </div>
          </div>

          <?php
        endforeach;
      endif;
      ?>
      <!-- </div> -->
    </div>

    <div class="row" id="autres">
      <h3>Autres annonces (Catégorie : <?= $annonce['titre_categorie']; ?>)</h3>
      <?php
      if (empty($toutesAnnonces)) :
        ?>
        <div class="col-xs-3">
          <p>Aucune autre annonce n'est disponible dans cette catégorie</p>
        </div>
        <!-- <div class="col-xs-3">
        <div class="pull-right" data-toggle="<?= $popover; ?>" data-placement="top" data-content="Pour déposer une annonce, veuillez-vous connecter.">
        <button href="<?= SITE_PATH.'admin/annonce-edit.php';?>" type="button" class="btn btn-primary <?= $disabled; ?>">
        <i class="fa fa-arrow-right"></i> Déposer une annonce
      </button>
    </div>
  </div> -->

<?php else : ?>

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
<?php endif; ?>

</div> <!-- Fin container -->

<?php
include __DIR__.('/layout/bottom.php');
?>
