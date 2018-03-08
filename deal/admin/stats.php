<?php
require_once __DIR__.'/../include/init.php';
adminSecurity();

$errors = [];

// Requête des Annonceurs les plus actifs (avec le plus d'annonces)
$req = 'SELECT m.id idMembre, m.pseudo pseudo, COUNT(a.id) nbAnnonces '
.'FROM membre m JOIN annonce a ON a.membre_id = m.id GROUP BY idMembre '
.'ORDER BY nbAnnonces DESC LIMIT 5';
$stmt = $pdo->query($req);
$annonceursActifs = $stmt->fetchAll();


// Requête des Annonceurs les mieux notés
$req = 'SELECT m.id idMembre, m.pseudo pseudo, AVG(n.note) noteMoy, COUNT(n.avis) nbAvis '
.'FROM membre m JOIN notes n ON n.membre_id2 = m.id GROUP BY idMembre '
.'ORDER BY noteMoy DESC LIMIT 5';
$stmt = $pdo->query($req);
$annonceursNotes = $stmt->fetchAll();


// Requête des Catégories les plus représentées
$req = 'SELECT c.id idCategorie, c.titre titre, COUNT(a.id) nbAnnonces '
.'FROM categorie c JOIN annonce a ON a.categorie_id = c.id '
.'GROUP BY idCategorie '
.'ORDER BY nbAnnonces DESC LIMIT 5';
$stmt = $pdo->query($req);
$categoriesRepresentees = $stmt->fetchAll();


// Requête des Annonces les plus anciennes
$req = 'SELECT a.id idAnnonce, titre titre, m.id idMembre, pseudo, a.date_enregistrement dateParue '
.'FROM annonce a JOIN membre m ON m.id = a.membre_id '
.'ORDER BY a.date_enregistrement LIMIT 5';
$stmt = $pdo->query($req);
$annoncesAnciennes = $stmt->fetchAll();




// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__.('/../layout/top.php');

?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">
        Statistiques
      </h1>
    </div>
  </div>

  <!-- < ?php displayFlashMessage(); ?>

  < ?php
  // Affichage des messages d'alerte en cas de tableau d'erreur non vide

  // Messages en cas d'erreurs
  if (!empty($errors)) :
  ?>
  <div class="alert alert-danger">
  <p><strong>Le formulaire contient des erreurs</strong></p>
  < ?= implode ('<br>', $errors); ?>
</div>
< ?php
endif;

// Message en cas de succès
if (isset($success)) :
?>
<div class="alert alert-success">
<strong>La fiche membre a bien été créée ou modifiée.</strong>
</div>
< ?php endif; ?>
-->



<div class="row">
  <div class="col-sm-10 col-sm-offset-1" id="stats">
    <div class="row">
      <h2>Tops 5 des ...</h2>
      <div class="col-sm-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3>Annonceurs les plus actifs</h3>
          </div>
          <div class="panel-body">
            <?php foreach ($annonceursActifs as $annonceurActif) : ?>
              <div class="well">
                <span class="titre-stats"><?= $annonceurActif['pseudo'] ; ?></span>
                <span class="badge pull-right"><?= $annonceurActif['nbAnnonces']; ?> annonces</span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3>Annonceurs les mieux notés</h3>
          </div>
          <div class="panel-body">
            <?php foreach ($annonceursNotes as $annonceurNote) : ?>
              <div class="well">
                <span class="titre-stats"><?= $annonceurNote['pseudo'] ; ?></span>
                <span class="badge pull-right"><?= $annonceurNote['nbAvis'] ; ?> avis</span>
                <span class="badge pull-right">Note moyenne : <?= $annonceurNote['noteMoy'] ; ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3>Catégories les plus représentées</h3>
          </div>
          <div class="panel-body">
            <?php foreach ($categoriesRepresentees as $categorieRepresentee) : ?>
              <div class="well">
                <span class="titre-stats"><?= $categorieRepresentee['titre'] ; ?></span>
                <span class="badge pull-right"><?= $categorieRepresentee['nbAnnonces'] ; ?> annonces</span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3>Annonces les plus anciennes</h3>
          </div>
          <div class="panel-body">
            <?php foreach ($annoncesAnciennes as $annonceAncienne) : ?>
              <div class="well">
                <span class="titre-stats"><?= $annonceAncienne['titre'] ; ?></span>
                <p>
                  <span class="badge pull-right"><?= strftime('%d/%m/%Y', strtotime($annonceAncienne['dateParue'])) ; ?></span>
                  postée par : <?= $annonceAncienne['pseudo'] ; ?>
                </p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>


    <?php
    include __DIR__.('/../layout/bottom.php');
    ?>
