<?php

require_once __DIR__.'/../../include/init.php';

// MAJ de la disponibilité de l'annonce -----------------------------------------------------------------


if (isset($_POST['dispo'])) {
  $req = 'UPDATE annonce SET dispo = :dispo WHERE id = :id';
  $stmt = $pdo->prepare($req);
  $stmt->bindValue(':dispo', $_POST['dispo']);
  $stmt->bindValue(':id', $_POST['idAnnonce']);
  $stmt->execute();
  $success =  '<div class="alert alert-success">'.
                '<strong>La disponibilité a bien été mise à jour.</strong>'.
              '</div>';
  echo $success;

} else {
  $error =  '<div class="alert alert-danger">'.
              '<strong>La disponibilité n\'a pas pu être mise à jour.</strong>'.
            '</div>';
  echo $error;
}
