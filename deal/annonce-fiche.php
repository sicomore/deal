<?php
require_once __DIR__.'/include/init.php';

$photoActuelle = $commentaire = $avis = $note = '';

$errors = [];

if (!empty($_POST)) {
  sanitizePost();
  extract($_POST);


}

// Requête de toutes les informations concernant l'annonce et le vendeur -----------------------------
$req = <<<EOS
SELECT m.id idVendeur, m.pseudo pseudo, telephone, a.*, r.nom region, c.titre titre_categorie
FROM annonce a
JOIN membre m ON m.id = a.membre_id
JOIN region r ON r.id = a.region_id
JOIN categorie c ON c.id = a.categorie_id
WHERE a.id =
EOS
.(int)$_GET['id'];
$stmt = $pdo->query($req);
$annonce = $stmt->fetch();

// Requête d'affichage des commentaires de l'annonce -------------------------------------------------
$reqCommentaires = 'SELECT c.id idCommentaire, c.commentaire commentaire, c.membre_id idClient, '
.'c.date_enregistrement date_enregistrement, c.annonce_id idAnnonce, m.pseudo pseudo, a.membre_id idVendeur '
.'FROM commentaire c JOIN membre m ON m.id = c.membre_id '
.'JOIN annonce a ON a.id = c.annonce_id '
.'WHERE c.annonce_id = '.(int)$_GET['id']
.' ORDER BY c.id DESC';
$stmt = $pdo->query($reqCommentaires);
$commentTous = $stmt->fetchAll();




// Requête pour afficher les "Autres annonces" (autre que celle affichée) ---------------------------------
$req = <<<EOS
SELECT a.*, a.titre titre_annonce
FROM annonce a JOIN categorie c ON c.id = a.categorie_id
WHERE a.id != ? AND c.id =
      (SELECT categorie_id FROM annonce WHERE id = ?)
LIMIT 4
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
// ------------------------- Traitement de l'affichage -------------------------------

include __DIR__.('/layout/top.php');
?>

<!--======== Modal pour laisser un commentaire, une note et un avis ========-->

<div class="modal fade" id="modal_commentaire" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalLabel">Laisser un message</h4>
      </div>

      <form method="post">
        <div class="modal-body">

          <div class="form-group">
            <label>Laisser un commentaire à propos de l'annonce</label>
            <textarea name="commentaire" class="form-control" rows="5" id="commentaire" placeholder="Déposer ou répondez à un commentaire à propos de l'annonce"></textarea>
          </div>

          <?php  if (isUserConnected() && $_SESSION['membre']['id'] != $annonce['idVendeur']) : ?>

            <hr>
            <label>Attribuez une note ou un avis au vendeur</label>
            <div class="form-group">
              <h5>Note</h5>

              <div class="col-sm-12">
                <fieldset class="rating">
                  <input type="radio" id="star5" name="note" value="5" /><label class = "full" for="star5" title="5 étoiles"></label>
                  <input type="radio" id="star4" name="note" value="4" /><label class = "full" for="star4" title="4 étoiles"></label>
                  <input type="radio" id="star3" name="note" value="3" /><label class = "full" for="star3" title="3 étoiles"></label>
                  <input type="radio" id="star2" name="note" value="2" /><label class = "full" for="star2" title="2 étoiles"></label>
                  <input type="radio" id="star1" name="note" value="1" /><label class = "full" for="star1" title="1 étoiles"></label>
                </fieldset>
              </div>
            </div>

            <div class="form-group">
              <h5>Avis</h5>
              <textarea name="avis" class="form-control" rows="5" id="avis" placeholder="Laisser un avis sur le vendeur"></textarea>
            </div>

          <?php endif; ?>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Annuler</button>
            <button type="submit" name="commentSubmit" id="commentSubmit" class="btn btn-primary">Envoyer</button>
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
        <h4 class="modal-title" id="modalLabel">Contacter <?= $annonce['pseudo']; ?></h4>
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
                <textarea name="message" class="form-control" rows="5" id="message" placeholder="Laisser un message au vendeur" autofocus></textarea>
              </div>
            </div>
          </div>

          <input type="hidden" name="idClient" value="<?= $_SESSION['membre']['id']; ?>">
          <input type="hidden" name="idAnnonce" value="<?= $annonce['id']; ?>">
          <input type="hidden" name="idVendeur" value="<?= $annonce['idVendeur']; ?>">

          <div class="row modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">Annuler</button>
            <button type="submit" name="messageSubmit" id="messageSubmit" class="btn btn-success">Envoyer</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!--========================= Fin du modal tél et mail =========================-->

<div class="container-fluid" id="page-wrapper">


  <?php
  displayFlashMessage();

  // Messages en cas de succès
  if (isset($success)) :
    ?>
    <div class="alert alert-success">
      <strong>Votre opération a bien été pris en compte.</strong>
    </div>
    <?php
  endif;
  ?>

  <div id="dispoMAJ"></div>

  <div class="row page-header">
    <div class="col-sm-4">
      <h1 class="">
        <?= $annonce['titre'];  ?>
      </h1>
      <h4><strong>Catégorie :</strong> <?= $annonce['titre_categorie'];  ?></h4>
    </div>

    <div class="col-sm-4">
    </div>

    <div class="col-sm-4 pull-right">
      <?php  if (isUserConnected() && $_SESSION['membre']['id'] == $annonce['idVendeur'] || isUserAdmin()) : ?>
        <form class="form" method="post">
          <div class="form-group pull-right">
            <div class="radio">
              <div class="input-group">
                <div class="btn-group btn-group-vertical">
                  <div class="btn btn-success">
                    <label>
                      <input class="<?php echo (int)$_GET['id']; ?>" type="radio" name="dispo" value= <?= ($annonce['dispo'] == 'active') ? '"active" checked' : '"active"' ;?>>Annonce activée
                    </label>
                  </div>
                  <div class="btn btn-danger">
                    <div class="input-group">
                      <label>
                        <input class="<?php echo (int)$_GET['id']; ?>" type="radio" name="dispo" value=<?= ($annonce['dispo'] == 'inactive') ? '"inactive" checked' : '"inactive"' ;?>>Annonce désactivée
                      </label>
                    </div>
                  </div>
                </div>
                <!-- <input class="btn btn-primary" type="submit" id="dispoSubmit" value"Valider"> -->
              </div>
            </div>
          </div>
        </form>

      <?php else : ?>
        <!-- Bouton Déposer un commentaire accessible uniquement pour membre connecté -->
        <form>
          <div class="btn-group btn-group-vertical pull-right" data-toggle="<?= $popover; ?>" data-placement="left" data-content="Pour laisser un commentaire ou contacter le membre, veuillez-vous connecter.">
            <a type="submit" class="btn btn-primary boutonComment <?= $disabled; ?>" data-toggle="modal" data-target="#modal_commentaire" value="<?php echo (int)$_GET['id'] ;?>" data-idMembre="<?= $_SESSION['membre']['id'] ;?>" data-idVendeur="<?= $annonce['idVendeur'] ;?>">
              Déposer un commentaire ou une note
            </a>
            <!-- Bouton contacter le vendeur uniquement pour membre connecté -->
            <a class="btn btn-success <?= $disabled; ?>" data-toggle="modal" data-target="#telMail">
              Contacter le vendeur
            </a>
          </div>
        </form>

      <?php endif; ?>
    </div>


  </div>  <!-- END Page Header -->

  <div class="row" id="description">
    <div class="col-sm-4">
      <a href="<?= SITE_PATH.'photos/'.$annonce['photo']; ?>" data-lightbox="lightbox">
        <img src="<?= SITE_PATH.'photos/'.$annonce['photo']; ?>" alt="photo de <?= $annonce['titre']; ?>">
      </a>
    </div>

    <div class="col-sm-8">
      <h3>Description</h3>

      <div class="row">
        <div class="col-md-6">
          <div class="">
            <h4>Prix : <?= $annonce['prix']; ?> €</h4>
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
        <form>
          <div class="pull-right" data-toggle="<?= $popover; ?>" data-placement="top" data-content="Pour laisser un commentaire, veuillez-vous connecter.">
            <a class="btn btn-primary boutonComment <?= $disabled; ?>" data-toggle="modal" data-target="#modal_commentaire" value="<?php echo (int)$_GET['id'] ;?>" data-idMembre="<?= $_SESSION['membre']['id'] ;?>" data-idVendeur="<?= $annonce['idVendeur'] ;?>">
              <i class="fa fa-arrow-right"></i> Laisser un commentaire
            </a>
          </div>
        </form>
      </div>
      <?php
      else :

        foreach ($commentTous as $comment): ?>
        <div class="panel panel-default">

          <div class="panel-heading">
            <b>
              <a href="<?= SITE_PATH.'profil.php?id='.$comment['idClient'] ;?>">
                <?= $comment['pseudo']?></a> a laissé un message le <?= strftime('%d/%m/%Y à %Hh%M', strtotime($comment['date_enregistrement'])); ?>
              </b>
            </div>

            <div class="panel-body">
              <?= $comment['commentaire'] ;?>

              <?php if (isUserConnected() && $_SESSION['membre']['id'] == $comment['idVendeur']): ?>
                <div class="pull-right">
                  <a class="btn btn-primary boutonComment <?= $disabled; ?>" data-toggle="modal" data-target="#modal_commentaire" value="<?php echo (int)$_GET['id'] ;?>" data-idMembre="<?= $_SESSION['membre']['id'] ;?>" data-idVendeur="<?= $annonce['idVendeur'] ;?>">

                    Répondre au commentaire
                  </a>
                </div>
              <?php endif; ?>

            </div>
          </div>

        <?php endforeach; endif; ?>
      </div>

      <div class="row" id="autres">
        <h3>Autres annonces (Catégorie : <?= $annonce['titre_categorie']; ?>)</h3>
        <?php
        if (empty($toutesAnnonces)) :
          ?>
          <div class="col-xs-3">
            <p>Aucune autre annonce n'est disponible dans cette catégorie</p>
          </div>

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
