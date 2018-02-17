<?php
require_once __DIR__ .'/../include/init.php';
// adminSecurity();

$tri_annonces = '';

extract($_POST);
// var_dump($tri_annonces);
if (empty($_POST)) {
  $tri_annonces = 'a.id desc';
}
$req = 'SELECT a.*, m.pseudo, c.titre titre_categorie, r.nom nom_region FROM annonce a JOIN categorie c ON c.id = categorie_id JOIN membre m ON m.id = a.membre_id JOIN region r ON r.id = region_id ORDER BY '. $tri_annonces;
$stmt = $pdo->query($req);
$annonces = $stmt->fetchAll();


// $selected = 'selected';

// $tri_annonces = (isset($_POST['tri_annonces']))
// ? $_POST['tri_annonces']
// : 'a.id desc' ;

// $stmt->bindParam(':tri', $tri_annonces);
// $stmt->execute();


include __DIR__ .'/../layout/top.php';
?>
<div class="row">

<h1 class="col-sm-12">Gestion des annonces</h1>
<!-- <p class="col-sm-4"><a href="annonce-edit.php">Ajouter une annonce</a></p> -->
<?php
displayFlashMessage();

// function selected($tri_annonces, $value) {
//   echo $selected = ($tri_annonces == $value) ? '"'.$value.'" selected' : '"'.$value.'"';
//   return $selected;
// }
?>

<!-- Select de tri -->
<form class="form-inline" method="post">
  <label for="">Trier par ...</label>
  <select class="form-control" name="tri_annonces">
    <optgroup label="Date de parution">
      <!-- <option value="< ?php selected($tri_annonces, 'a.id desc'); ?>>les plus récentes</option> -->
      <option value= <?= ($tri_annonces == 'a.id desc') ? '"a.id desc" selected' : '"a.id desc"'; ?> >les plus récentes</option>
      <option value= <?= ($tri_annonces == 'a.id') ? '"a.id" selected' : '"a.id"'; ?> >les plus anciennes</option>
    </optgroup>
    <optgroup label="Prix">
      <option value= <?= ($tri_annonces == 'a.prix') ? '"a.prix" selected' : '"a.prix"'; ?> > prix croissant</i></option>
      <option value= <?= ($tri_annonces == 'a.prix desc') ? '"a.prix desc" selected' : '"a.prix desc"'; ?> > prix décroissant</option>
    </optgroup>
    <optgroup label="Catégorie">
      <option value= <?= ($tri_annonces == 'c.titre') ? '"c.titre" selected' : '"c.titre"'; ?> >Catégorie croissante</option>
      <option value= <?= ($tri_annonces == 'c.titre desc') ? '"c.titre desc" selected' : '"c.titre desc"'; ?> >Catégorie décroissante</option>
    </optgroup>
  </select>
  <button class="btn btn-primary" type="submit">Trier</button>
</form>
</div>

<table class="table table-bordered table-striped">
  <th colspan="6">
    Liste des annonces
  </th>
  <tr>
    <th>ID</th>
    <th>Photo</th>
    <th>Titre</th>
    <th>Catégorie</th>
    <th>Description courte</th>
    <th>Description longue</th>
    <th>Prix</th>
    <th>Adresse</th>
    <th>Code Postal</th>
    <th>Ville</th>
    <th>Région</th>
    <th>Membre</th>
    <th>Date de parution</th>
    <th>Options</th>
  </tr>

  <?php
  foreach ($annonces as $annonce) :
    ?>
    <tr>
      <td><?= $annonce['id'] ?></td>
      <td><img src='<?= PHOTO_WEB.$annonce['photo']; ?>' style="width: 100px;"></td>
      <td><?= $annonce['titre'] ?></td>
      <td><?= $annonce['titre_categorie'] ?></td>
      <td><?= $annonce['description_courte'] ?></td>
      <td><?= $annonce['description_longue'] ?></td>
      <td><?= number_format($annonce['prix'], 2, ',',' ') ?> €</td>
      <td><?= $annonce['adresse'] ?></td>
      <td><?= $annonce['code_postal'] ?></td>
      <td><?= $annonce['ville'] ?></td>
      <td><?= $annonce['nom_region'] ?></td>
      <td><?= $annonce['pseudo'] ?></td>
      <td><?= strftime('%d/%m/%Y',strtotime($annonce['date_enregistrement'])); ?></td>
      <!-- //number_format (chiffre, nb décimales, séparateur décimal, séparateur millier) -->
      <td>
        <a href="<?= SITE_PATH; ?>annonce-fiche.php?id=<?= $annonce['id'] ?>" class="btn btn-primary">Voir la fiche</a>
        <?php
        if (isUserAdmin()) :
        ?>
        <a href="<?= SITE_PATH ?>admin/annonce-edit.php?id=<?= $annonce['id'] ?>" class="btn btn-warning">Modifier</a>
        <a href="<?= SITE_PATH ?>admin/annonce-delete.php?id=<?= $annonce['id'] ?>" class="btn btn-danger">Supprimer</a>
        <?php
        ENDIF;
        ?>
      </td>
    </tr>
    <?php
  endforeach;
  ?>

</table>

<?php
include __DIR__ .'/../layout/bottom.php';
?>
