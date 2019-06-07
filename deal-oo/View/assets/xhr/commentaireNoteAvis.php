<?php

require_once __DIR__.'/../../include/init.php';

$messages = [];

// Requête pour insérer en BDD la réponse à un commentaire Client
if (!empty($_POST['commentaire'])) {
  // Complément requête pour vérifier que le commentaire n'est pas posté 2x par le mm membre
  $reqDoublon = 'SELECT c.id idCommentaire, c.commentaire commentaire, c.membre_id idClient, '
  .'c.date_enregistrement date_enregistrement, c.annonce_id idAnnonce, m.pseudo pseudo, a.membre_id idVendeur '
  .'FROM commentaire c JOIN membre m ON m.id = c.membre_id '
  .'JOIN annonce a ON a.id = c.annonce_id '
  .'WHERE c.annonce_id = '.$_POST['idAnnonce']
  .' AND c.membre_id = '.$_SESSION['membre']['id']
  .' AND c.commentaire = '.$pdo->quote($_POST['commentaire']);

  $stmt = $pdo->query($reqDoublon);
  $stmt->fetchAll();
  $commentDoublon = $stmt->rowCount();

  if ($commentDoublon > 0) {
    $messages[] = 'Vous avez déjà laissé ce commentaire pour cette annonce.';

  } else {
    $req = 'INSERT INTO commentaire(commentaire, membre_id, annonce_id) VALUES (:commentaire, :membre_id, :annonce_id)';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':commentaire', $_POST['commentaire']);
    $stmt->bindValue(':membre_id', $_POST['idMembre']);
    $stmt->bindValue(':annonce_id', $_POST['idAnnonce']);
    $stmt->execute();
    $success =  '<div class="alert alert-success">'.
    '<strong>Le commentaire a bien été enregistré.</strong>'.
    '</div>';
    $messages[] = 'Votre commentaire a bien été enregistré.';

  }

}

// Requête pour insérer en BDD la note et l'avis sur un vendeur

if (!empty($_POST['avis']) || !empty($_POST['note'])) {

  $req = 'SELECT * FROM notes WHERE membre_id2 = '.$_POST['idVendeur'].' AND membre_id1 = '. $_SESSION['membre']['id'];
  $stmt = $pdo->query($req);
  $stmt->fetchAll();

  // Enregistrement de la note et de l'avis dans la table Note
  // membre_id1 = le notant
  // membre_id2 = le noté
  if ($stmt->rowCount() < 1) {

    $req = 'INSERT INTO notes(note, avis, membre_id1, membre_id2, date_enregistrement) '
    .'VALUES (:note, :avis, :membre_id1, :membre_id2, now())';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':note', $_POST['note']);
    $stmt->bindValue(':avis', $_POST['avis']);
    $stmt->bindValue(':membre_id1', $_SESSION['membre']['id']);
    $stmt->bindValue(':membre_id2', $_POST['idVendeur']);
    $stmt->execute();
    $messages[] = 'Votre note et/ou votre avis a bien été pris en compte.';

    // Mise à jour de la table notes
  } else {
    if (empty($_POST['note'])) {
      $MAJ = ' avis = '.$pdo->quote($_POST['avis']).',';

    } elseif (empty($_POST['avis'])) {
      $MAJ = ' note = '.$_POST['note'].',';

    } else {
      $MAJ = ' note = '.$_POST['note'].', avis = '.$pdo->quote($_POST['avis']).',';
    }

    $req = 'UPDATE notes SET'. $MAJ .' date_enregistrement = now() '
    .'WHERE membre_id1 = :idClient AND membre_id2 = :idVendeur';
    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':idClient', $_SESSION['membre']['id']);
    $stmt->bindValue(':idVendeur', $_POST['idVendeur']);
    $stmt->execute();
    $messages[] = 'Votre note et/ou votre avis a bien été pris en compte.';
  }
}

if (!empty($_POST['message'])) {
  sanitizePost();

  $req = 'INSERT INTO mail(message, membre_id1, membre_id2, annonce_id) '
  .'VALUES (:message, :membre_id1, :membre_id2, :annonce_id)';
  $stmt = $pdo->prepare($req);
  $stmt->bindValue(':message', $_POST['message']);
  $stmt->bindValue(':membre_id1', $_POST['idClient']);
  $stmt->bindValue(':membre_id2', $_POST['idVendeur']);
  $stmt->bindValue(':annonce_id', $_POST['idAnnonce']);
  $stmt->execute();
  $messages[] = 'Votre message a bien été envoyé au propriétaire de l\'annonce.';

}

if (!empty($messages)) {
echo '<div class="alert alert-info">'.
      '<strong>'.implode('<br>', $messages).'</strong>'
    .'</div>';
}
