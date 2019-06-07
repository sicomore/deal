<div class="container-fluid" id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Accueil</h1>
    </div>
  </div>

  <form class="form-group">
    <div class="row">
      <div id="filtres">

        <div class="form-group">
          <label for="categories">Catégories</label>
          <select class="form-control selection-select" name="categorieSelect" id="categories">
            <option value="">Toutes les catégories</option>
            <?php
            foreach ($categories as $categorie) {
              $selected = ($selects['categorieSelect'] == $categorie['id']) ? 'selected' : '';
              echo '<option value="'.$categorie['id'].'" '.$selected.'>'.$categorie['titre'].
              '</option>';
            }; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="regions">Régions</label>
          <select class="form-control selection-select" name="regionSelect" id="regions">
            <option value="">Toutes les régions</option>
            <?php
            foreach ($regions as $region) {
              $selected = ($region['id'] == $selects['regionSelect']) ? 'selected' : '';
              echo '<option value="'.$region['id'].'" '.$selected.'>'.$region['nom'].
              '</option>';
            }; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="membres">Membres</label>
          <select class="form-control selection-select" name="membreSelect" id="membres">
            <option value="">Tous les membres</option>
            <?php foreach ($membres as $membre) {
              $selected = ($membre['id'] == $selects['membreSelect']) ? 'selected' : '';
              echo '<option value="'.$membre['id'].'" '.$selected.'>'.$membre['pseudo'].
              '</option>';
            }; ?>
          </select>
        </div>

        <div class="form-group col-sm-2">
          <label for="prixMin">Prix min.</label>
          <input class="form-control selection-input" type="text" name="prixMin" value="<?= $selects['prixMin']; ?>">
        </div>

        <div class="form-group col-sm-2">
          <label for="prixMax">Prix max.</label>
          <input class="form-control selection-input" type="text" name="prixMax" value="<?= $selects['prixMax']; ?>">
        </div>

        <div class="form-group">
          <label for="tri">Ordre</label>
          <select class="form-control selection-select" name="triSelect" id="tri">
            <!-- <option value="">les plus récentes</option> -->
            <?php foreach ($tris as $tri) {
              $selected = ($tri['tri'] == $selects['triSelect']) ? 'selected' : '';
              echo '<option value="'.$tri['tri'].'" '.$selected.'>'.$tri['options'].
              '</option>';
            }; ?>
          </select>
        </div>


        <div class="form-group">
          <label for=""> </label>
          <button class="col-xs-12 btn btn-primary pull-right" type="submit"><i class="fa fa-search"></i> Trier</button>
        </div>

      </div>


      <div class="container">
        <div class="row">
          <div class="col">
            <?= ($affichageMessage) ? $affichageMessage : '' ; ?>
          </div>
        </div>

        <?php foreach ($annonces as $annonce) : ?>
          <div class="row">

            <div class="panel panel-info" id="annonces-accueil">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-sm-8">
                    <h4><?= $annonce['titre'] ?></h4>
                  </div>
                  <div class="col-sm-4">
                    <div class="pull-right">
                      <strong>Catégorie</strong> : <?= $annonce['categorie']; ?>
                    </div>
                  </div>
                </div>
              </div>

              <div class="panel-body">
                <div class="row">

                  <div class="col-sm-2">
                    <a href="<?= $photoWeb.$annonce['photo']; ?>" data-lightbox="lightbox">
                      <img src="<?= $photoWeb.$annonce['photo']; ?>">
                    </a>
                  </div>

                  <div class="col-sm-2">
                    <div class="well">
                      <h3><strong><?= round($annonce['prix'],2); ?> €</strong></h3>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <p><b>Description :</b> <?= $annonce['description_courte']; ?></p>
                    <p><b>Région :</b> <?= $annonce['region']; ?></p>
                    <p><b>Date de parution :</b> <?= strftime('%d/%m/%Y',strtotime($annonce['date_enregistrement'])); ?></p>
                  </div>
                </div>
              </div>

              <div class="panel-footer">
                <div class="row">
                  <div class="col-sm-4">
                    <strong> Vendeur</strong> : <?= $annonce['pseudo']; ?>
                  </div>
                  <div class="col-sm-4">
                    <?php
                    $req = 'SELECT AVG(note) noteMoy FROM notes GROUP BY membre_id2 HAVING membre_id2 = '. $annonce['idMembre'];
                    $stmt = $pdo->query($req);
                    $notes = $stmt->fetchColumn();
                    $star = '';
                    for ($i=0; $i<round($notes); $i++) {
                      $star .= '<i class="fa fa-star"></i>';
                    }
                    if ((round($notes,1)*10)%10 != 0) {
                      $star .= '<i class="fa fa-star-half"></i>';
                    }
                    ?>
                    Note : <?= $star; ?>
                  </div>
                  <div class="col-sm-4">
                    <a href="<?= $sitePath ?>www/index.php?show_annonce&id=<?= $annonce['id']; ?>" class="btn btn-primary pull-right">Voir la fiche</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <nav aria-label="page navigation" id="pagination">

          <!-- <ul class="pagination pagination-lg">
            <li>
              <input class="btn btn-default < ?= (($pageChoisie-1)<=0) ? 'disabled' : '' ; ?>" type="submit" name="prev" value="< ?= $pageChoisie-1 ?>">
            </li>
            < ?php
            for($i = 1; $i <= $nbTotalPages; $i++) {
              if($i == $pageChoisie) {
                echo '<li class="active">'.
                '<input class="btn btn-primary" type="submit" value="'.$i.'" name="page">'.
                '</li>';

              }	else {
                echo '<li>'.
                '<input class="btn btn-default" type="submit" value="'.$i.'" name="page">'.
                '</li>';
              };
            };
            ?>
            <li>
              <input class="btn btn-default < ?= ($pageChoisie >= $nbTotalPages) ? 'disabled' : '' ; ?>" type="submit" name="next" value="< ?= $pageChoisie+1 ?>">
            </li>
          </ul> -->
          <?php if($annonces) : ?>
          <ul class="pagination liste_annonces">
            <?php
            $activeP = $activeN = '';
            $prev = $pageChoisie-1;
            $next = $pageChoisie+1;
            if($pageChoisie === 1) {
              $prev = 1;
              $activeP = 'disabled';
            }
            if ($pageChoisie>=$nbTotalPages){
              $next = $nbTotalPages;
              $activeN = 'disabled';
            } ?>
            <li class="<?= $activeP ?>">
              <a href="<?= $url.'&page='.$prev ?>" disabled><<</a>
            </li>
            <?php for ($i = 1; $i <= $nbTotalPages; $i++) : ?>
              <?php if ($i === $pageChoisie) : ?>
                <li class="active">
                  <a href="<?= $url.'&page='.$i ?>"><?= $i ?></a>
                </li>
              <?php else : ?>
                <li>
                  <a href="<?= $url.'&page='.$i ?>"><?= $i ?></a>
                </li>
              <?php endif ?>
            <?php endfor ?>
            <li class="<?= $activeN ?>">
              <a href="<?= $url.'&page='.$next ?>">>></a>
            </li>
          </ul>
          <?php endif ?>
        </nav>
      </div>
    </form>
  </div>
