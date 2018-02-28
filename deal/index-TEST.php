<?php
require_once __DIR__.'/include/init.php';

$tri_annonces = '';

extract($_POST);
if (empty($_POST)) {
  // $tri_annonces = 'a.id desc';
}
// $tri_annonces = 'a.id desc';
var_dump($tri_annonces);
// $req = 'SELECT a.*, m.pseudo, c.titre titre_categorie, r.nom nom_region FROM annonce a JOIN categorie c ON c.id = categorie_id JOIN membre m ON m.id = a.membre_id JOIN region r ON r.id = region_id ORDER BY '. $tri_annonces. ' LIMIT 5';
// $stmt = $pdo->query($req);
// $annonces = $stmt->fetchAll();


// ----------------- Traitement de l'affichage -----------------------
// ----------------- Traitement de l'affichage -----------------------

include __DIR__.'/layout/top.php';
?>

<div class="container-fluid" id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Accueil</h1>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-3 form-group">
      <label>Catégories</label>
      <select name="categories" class="form-control">
        <option>Toutes les catégories</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
      </select>
    </div>
    <div class="col-sm-3 form-group">
      <label>Régions</label>
      <select name="regions" class="form-control">
        <option>Toutes les régions</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
      </select>
    </div>
    <div class="col-sm-3 form-group">
      <label>Membres</label>
      <select name="membres" class="form-control">
        <option>Tous les membres</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
        <option>5</option>
      </select>
    </div>

    <div class="col-sm-3 form-group">
      <form class="" method="post" id="tri-form">
        <label for="">Trier par ...</label>
        <select class="form-control" name="tri_annonces" id="tri_annonces">
          <optgroup label="Date de parution">
            <!-- <option value="< ?php selected($tri_annonces, 'a.id desc'); ?>>les plus récentes</option> -->
            <option value= <?= ($tri_annonces == 'a.id_desc') ? '"a.id_desc" selected' : '"a.id_desc"'; ?> >les plus récentes</option>
            <option value= <?= ($tri_annonces == 'a.id') ? '"a.id" selected' : '"a.id"'; ?> >les plus anciennes</option>
          </optgroup>
          <optgroup label="Prix">
            <option value= <?= ($tri_annonces == 'a.prix') ? '"a.prix" selected' : '"a.prix"'; ?> > prix croissant</i></option>
            <option value= <?= ($tri_annonces == 'a.prix_desc') ? '"a.prix_desc" selected' : '"a.prix_desc"'; ?> > prix décroissant</option>
          </optgroup>
          <optgroup label="Catégorie">
            <option value= <?= ($tri_annonces == 'c.titre') ? '"c.titre" selected' : '"c.titre"'; ?> >catégorie croissante</option>
            <option value= <?= ($tri_annonces == 'c.titre_desc') ? '"c.titre_desc" selected' : '"c.titre_desc"'; ?> >catégorie décroissante</option>
          </optgroup>
        </select>
        <!-- <button class="btn btn-primary" type="submit">Trier</button> -->
      </form>
    </div>
  </div>

  <div class="container">
    <?php foreach ($annonces as $annonce) : ?>
      <div class="row">

        <div class="panel panel-info" id="annonces-accueil">
          <div class="panel-heading">
            <div class="row">
              <div class="col-sm-10">
                <?= $annonce['titre'] ?>
              </div>
              <div class="col-sm-2 pull-right">
                Catégorie : <?= $annonce['titre_categorie']; ?>
              </div>
            </div>
          </div>

          <div class="panel-body">
            <div class="row">
              <div class="col-sm-2">
                <img src='<?= PHOTO_WEB.$annonce['photo']; ?>' style="width: 100px;">
              </div>
              <div class="col-sm-2">
                <div class="well">
                  <h4><?= round($annonce['prix'],2); ?> €</h4>
                </div>
              </div>
              <div class="col-sm-8">
                <p><b>Description :</b> <?= $annonce['description_courte']; ?></p>
                <p><b>Région :</b> <?= $annonce['nom_region']; ?></p>
                <p><b>Date de parution :</b> <?= strftime('%d/%m/%Y',strtotime($annonce['date_enregistrement'])); ?></p>
              </div>
            </div>
          </div>
          <div class="panel-footer">
            <div class="row">
              <div class="col-sm-10">
                Vendeur : <?= $annonce['pseudo']; ?>
              </div>
              <div class="col-sm-2 pull-right">
                <a href="<?= SITE_PATH; ?>annonce-fiche.php?id=<?= $annonce['id']; ?>" class="btn btn-primary col-sm-auto pull-right">Voir la fiche</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php
include __DIR__.('/layout/bottom.php');
?>
