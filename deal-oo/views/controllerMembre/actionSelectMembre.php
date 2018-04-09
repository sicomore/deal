<?php
include '../../classes/sitePath.php';
$sitePath = new classes\SitePath();
 ?>

<div id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Gestion des membres</h1>
    </div>
  </div>

  <?= (!empty($result)) ? $result['affichageMessage'] : '' ?>

  <!--===================== Tableau des membres =====================-->

  <table class="table table-bordered table-striped">
    <th colspan="10">
      <h4>Membres</h4>
    </th>
    <tr>
      <th class="col-xs-1">ID membre</th>
      <th class="col-xs-auto">Pseudo</th>
      <th class="col-xs-auto">Nom</th>
      <th class="col-xs-auto">Prénom</th>
      <th class="col-xs-auto">Email</th>
      <th class="col-xs-auto">Téléphone</th>
      <th class="col-xs-auto">Civilité</th>
      <th class="col-xs-auto">Statut</th>
      <th class="col-xs-auto">Date d'inscription</th>
      <th class="col-xs-1">Options</th>
    </tr>

    <?php
    foreach ($mbs as $mb) :
      ?>
      <tr>
        <td><?= $mb['id'] ?></td>
        <td><?= $mb['pseudo'] ?></td>
        <td><?= $mb['nom'] ?></td>
        <td><?= $mb['prenom'] ?></td>
        <td><?= $mb['email'] ?></td>
        <td><?= $mb['telephone'] ?></td>
        <td><?= $mb['civilite'] ?></td>
        <td><?= $mb['role'] ?></td>
        <td><?= strftime('%d/%m/%Y',strtotime($mb['date_enregistrement'])); ?></td>
        <!-- //number_format (chiffre, nb décimales, séparateur décimal, séparateur millier) -->
        <td>
          <a href="<?= $sitePath->sitePath(); ?>profil.php?id=<?= $mb['id'] ?>" class="btn btn-primary">Modifier</a>
          <a href="membre-delete.php?id=<?= $mb['id'] ?>" class="btn btn-danger">Supprimer</a>
        </td>
      </tr>
      <?php
    endforeach;
    ?>

  </table>


  <!-- <nav aria-label="page navigation" id="pagination">
    <form method="get">
      <ul class="pagination pagination-lg">
        <li < ?= (($pageChoisie-1)<=0) ? 'class="disabled"' : '' ; ?>>
          <a type="submit" href="membre-edit.php?p=< ?= (($pageChoisie-1)<=0) ? 1 : $pageChoisie-1 ; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
        < ?php
        for($i = 1; $i <= $nbPages; $i++) {

          if($i == $pageChoisie) {

            echo '<li class="active" name="'.$i.'"><a type="submit" href="membre-edit.php?p='.$i.'">'.$i.'</a></li>';
          }	else {
            echo '<li name="'.$i.'"><a type="submit" href="membre-edit.php?p='.$i.'">'.$i.'</a></li>';
          }
        }
        ?>
        <li < ?= ($pageChoisie >= $nbPages) ? 'class="disabled"' : '' ; ?>>
          <a type="submit" href="membre-edit.php?p=< ?= ($pageChoisie > $nbPages) ? '' : $pageChoisie+1; ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </form>
  </nav> -->
