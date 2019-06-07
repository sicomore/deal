<?php

require_once __DIR__.'/../../include/init.php';

if (isset($_POST['triSelect'])) {

$req = 'SELECT a.*, m.pseudo, c.titre titre_categorie, r.nom nom_region FROM annonce a JOIN categorie c ON c.id = categorie_id JOIN membre m ON m.id = a.membre_id JOIN region r ON r.id = region_id ORDER BY '. $pdo->quote($_POST['triSelect']);
$stmt = $pdo->query($req);
$annonces = $stmt->fetchAll();

$reponse =
<?php foreach ($annonces as $annonce) : ?>
  <tr>
    <td><?= $annonce['id'] ?></td>
    <td>
      <a href="<?= PHOTO_WEB.$annonce['photo']; ?>" data-lightbox="lightbox">
        <img src="<?= PHOTO_WEB.$annonce['photo']; ?>">
      </a>
    </td>
    <td><?= $annonce['titre'] ?></td>
    <td><?= $annonce['titre_categorie'] ?></td>
    <td><?= substr($annonce['description_courte'],0, 30); ?> ...</td>
    <td><?= substr($annonce['description_longue'],0, 100); ?> ...</td>
    <td><?= number_format($annonce['prix'], 2, ',',' ') ?> €</td>
    <td><?= $annonce['adresse'] ?></td>
    <td><?= $annonce['code_postal'] ?></td>
    <td><?= $annonce['ville'] ?></td>
    <td><?= $annonce['nom_region'] ?></td>
    <td><?= $annonce['pseudo'] ?></td>
    <td><?= strftime('%d/%m/%Y',strtotime($annonce['date_enregistrement'])); ?></td>
    <td>
      <a href="<?= SITE_PATH; ?>annonce-fiche.php?id=<?= $annonce['id'] ?>" class="btn btn-primary" title="Voir l'annonce" data-toggle="tooltip" data-placement="left">
        <i class="fa fa-search"></i>
      </a>
      <?php if (isUserAdmin()) : ?>
        <a href="<?= SITE_PATH ?>annonce-edit.php?id=<?= $annonce['id'] ?>" class="btn btn-warning" title="Modifier l'annonce" data-toggle="tooltip" data-placement="left">
          <i class="fa fa-edit"></i>
        </a>
        <a href="<?= SITE_PATH ?>admin/annonce-delete.php?id=<?= $annonce['id'] ?>" class="btn btn-danger" title="Supprimer l'annonce" data-toggle="tooltip" data-placement="left">
          <i class="fa fa-trash"></i>
        </a>
      <?php endif; ?>
    </td>
  </tr>
<?php endforeach; ?>
;
<?php echo $reponse; ?>


};
