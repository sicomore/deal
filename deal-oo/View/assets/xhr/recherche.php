<?php

require_once __DIR__ .'/../../include/init.php';

$input = '#^'.$_POST['mot'].'.#';

echo $input;

$req = 'SELECT id, mots_cles FROM categorie ORDER BY id';
$stmt = $pdo->query($req);
$results = $stmt->fetchAll();

foreach ($results as $value) {
$unMot[] = explode(', ', $value['mots_cles']);
print_r($unMot);
// echo $unMot;
    if (preg_match($input, $value['mots_cles'])) {
      $listeMots[$value['id']][] = $unMot;

  }
}

// var_dump($listeMots);
// var_dump($tab);


// LIKE '.$_POST['mot'].'%\'';

echo json_encode($listeMots);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
</head>
<body>
  <p>
    <form id="form-recherche" method="post">
      <input type="text" name="mot" id="input-recherche" class="form-control" placeholder="Recherche...">
      <button type="submit" id="bouton-search">Envoyer
      </button>
    </form>
</p>
</body>
</html>
