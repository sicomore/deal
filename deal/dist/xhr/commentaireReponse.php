<?php

require_once __DIR__.'/../../include/init.php';


// Requête pour insérer en BDD la réponse à un commentaire Client
if (empty($_POST['commentaire'])) {
  $error =  '<div class="alert alert-danger">'.
  '<strong>Le commentaire est vide et n\'a pas pu être enregistré.</strong>'.
  '</div>';
  echo $error;

} else {
  $commentaire = strip_tags(nl2br($_POST['commentaire']));
  $req = 'INSERT INTO commentaire(commentaire, membre_id, annonce_id) VALUES (:commentaire, :membre_id, :annonce_id)';
  $stmt = $pdo->prepare($req);
  $stmt->bindValue(':commentaire', $commentaire);
  $stmt->bindValue(':membre_id', $_POST['idMembre']);
  $stmt->bindValue(':annonce_id', $_POST['idAnnonce']);
  $stmt->execute();
  $success =  '<div class="alert alert-success">'.
                '<strong>Le commentaire a bien été enregistré.</strong>'.
              '</div>';
  echo $success;

}
