<div class="container-fluid" id="page-wrapper">

  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Gestion des annonces</h1>
    </div>
  </div>

  <?= ($affichageMessage) ? $affichageMessage : '' ; ?>

  <div class="row">
    <!-- <div class="row"> -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <!-- Select de tri -->
        <!-- <form class="form-inline" method="post">
          <label for="">Trier par ...</label>
          <div class="form-group">
            <select class="form-control" name="triSelect" id="tri -->


              <?= $result['selectTri']; ?>

            <!-- </select>
            <span class="form-group-btn">
              <button class="btn btn-primary form-group-btn pull-right" type="submit"><i class="fa fa-sort"></i> Trier</button>
            </span>
          </div> -->
          <!-- </form> -->
        </div>

        <div class="panel-body liste_annonces">

          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th>N°</th>
                <th>Photo</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Description courte</th>
                <th>Description longue</th>
                <th>Prix (€)</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Ville</th>
                <th>Région</th>
                <th>Membre</th>
                <th>Date de parution</th>
                <th>Options</th>
              </tr>
            </thead>

            <tbody>

              <?= $result['affichageLigne']; ?>

            </tbody>

          </table>
        </div>

      </div> <!-- end panel -->

      <!-- <nav aria-label="page navigation" id="pagination">
        <ul class="pagination pagination-lg">
          <li < ?= (($pageChoisie-1)<=0) ? 'class="disabled"' : '' ; ?>>
            <a type="submit" href="annonces.php?p=< ?= (($pageChoisie-1)<=0) ? 1 : $pageChoisie-1 ; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          < ?php
          for($i = 1; $i <= $nbPages; $i++) {

            if($i == $pageChoisie) {

              echo '<li class="active" name="'.$i.'"><a type="submit" href="annonces.php?p='.$i.'">'.$i.'</a></li>';
            }	else {
              echo '<li name="'.$i.'"><a type="submit" href="annonces.php?p='.$i.'">'.$i.'</a></li>';
            }
          }
          ?>
          <li < ?= ($pageChoisie >= $nbPages) ? 'class="disabled"' : '' ; ?>>
            <a type="submit" href="annonces.php?p=< ?= ($pageChoisie > $nbPages) ? '' : $pageChoisie+1; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </form>
    </nav> -->

  </div>
</div> <!-- end container -->
