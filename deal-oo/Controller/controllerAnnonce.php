<?php
namespace controller;

/**
* Controller gestion des annonces en admin
* @param void
*/
class ControllerAnnonce extends ControllerMaitre {

  public function actionGestionAnnonces() {

    $this->startSession();

    $message = [];
    $selected = '';
    $selectTri = '';
    $triSelect = 'a.id DESC';

    if ($_GET) {
      extract($_GET);
    }
    if ($_POST) {
      extract($_POST);
    }

    $triOrdre = new \model\ModelTri();
    $tris = $triOrdre->selectTri();

    foreach ($tris as $tri) {
      if (!empty($_POST)) {
        $selected = ($tri['tri'] == $_POST['triSelect'])
        ? 'selected'
        : ''
        ;
      }
      $selectTri .= '<option value="'.$tri['tri'].'" '.$selected.'>'.$tri['options'].
      '</option>';
    }
    $selectTri = '<form class="form-inline" method="post">'
    .'<label for="">Trier par ...</label>
    <div class="form-group">
    <select class="form-control" name="triSelect" id="tri">'.$selectTri.
    '</select>
    <span class="form-group-btn">
    <button class="btn btn-primary form-group-btn pull-right" type="submit"><i class="fa fa-sort"></i> Trier</button>
    </span>
    </div>'
    ;

    $affichage = new \model\ModelAnnonce();
    $GestionAnnonces = $affichage->selectAnnonce(null, null, null, null, null, $triSelect);

    if (!$GestionAnnonces) {
      $message[] = 'Aucune annonce n\'a été trouvée.';

    } else {
      $affichageLigne = '';
      foreach ($GestionAnnonces as $annonce) {
        $affichageLigne .=
        '<tr>
        <td>'.$annonce['id'].'</td>
        <td>
        <a href="'.$this->photoWeb().$annonce['photo'].'" data-lightbox="lightbox">
        <img src="'.$this->photoWeb().$annonce['photo'].'">
        </a>
        </td>
        <td>'.$annonce['titre'].'</td>
        <td>'.$annonce['categorie'].'</td>
        <td>'.substr($annonce['description_courte'],0, 30).' ...</td>
        <td>'.substr($annonce['description_longue'],0, 100).' ...</td>
        <td>'.number_format($annonce['prix'], 2, ',',' ').' €</td>
        <td>'.$annonce['adresse'].'</td>
        <td>'.$annonce['code_postal'].'</td>
        <td>'.$annonce['ville'].'</td>
        <td>'.$annonce['region'].'</td>
        <td>'.$annonce['pseudo'].'</td>
        <td>'.strftime('%d/%m/%Y',strtotime($annonce['date_enregistrement'])).'</td>
        <td>
        <a href="'.$this->sitePath().'annonce-fiche.php?id='.$annonce['id'].'" class="btn btn-primary" title="Voir l\'annonce" data-toggle="tooltip" data-placement="left">
        <i class="fa fa-search"></i>
        </a>'
        // .< ?php if (isUserAdmin()) : ? >
        .
        '<a href="'.$this->sitePath().'annonce-edit.php?id='.$annonce['id'].'" class="btn btn-warning" title="Modifier l\'annonce" data-toggle="tooltip" data-placement="left">
        <i class="fa fa-edit"></i>
        </a>'.
        '<a href="'.$this->sitePath().'admin/annonce-delete.php?id='.$annonce['id'].'" class="btn btn-danger" title="Supprimer l\'annonce" data-toggle="tooltip" data-placement="left">
        <i class="fa fa-trash"></i>
        </a>'.
        // < ?php endif; ? >
        '</td>
        </tr>';
      }
    }


    // // Affichage des annonces (Pagination)
    // $annoncesParPage = 5;
    // $nbTotalAnnonces = $stmt->rowCount();
    // $nbPages = ceil($nbTotalAnnonces/$annoncesParPage);
    //
    // if(isset($_GET['p']) && !empty($_GET['p'])) {
    //   $pageChoisie = (int)$_GET['p'];
    //   if($pageChoisie > $nbPages) {
    //     $pageChoisie = $nbPages;
    //   }
    // } else {
    //   $pageChoisie = 1;
    // }
    //
    // if ($nbTotalAnnonces < 1) {
    //   $pageChoisie = 1;
    //   setFlashMessage('Aucune annonce disponible pour cette sélection', 'info');
    // }
    //
    // $premiereAnnonce = ($pageChoisie-1) * $annoncesParPage;
    //
    // // Limitation des annonces à 5 par page
    // $req .= ' LIMIT '.$premiereAnnonce.', '.$annoncesParPage;
    // $stmt = $pdo->query($req);
    // $annonces = $stmt->fetchAll();

    $affichageMessage =
    '<div class="alert alert-info">
    <h5 class="alert-heading">Vous avez un message :</h5>
    <hr>
    <p>'.implode ('<br>', $message).'</p>
    </div>';

    $chemin = $this->cheminView(get_class($this), __FUNCTION__);

    // $nomClasse = explode('\\', __CLASS__);
    // $nomClasse = end($nomClasse);
    // $dossier = lcfirst($nomClasse);
    // $fichier = __FUNCTION__;
    // $chemin = '../view/'.$dossier.'/'.$fichier.'.php';

    $result = [
      'affichageMessage' => $this->affichageMessage($message),
      'affichageLigne' => $affichageLigne,
      'selectTri' => $selectTri,
      'tris' => $tris
    ];

    $this->render($result, $chemin);

  }


  /**
  * Controller liste des annonces (front)
  * @param void
  */
  public function actionListeAnnonces()
  {
    // var_dump($_GET);

    $selects =[
      'categorieSelect' => '',
      'regionSelect' => '',
      'membreSelect' => '',
      'triSelect' => '',
      'prixMin' => '',
      'prixMax' => ''
    ];
    // $categorieSelect = $regionSelect = $membreSelect = $triSelect = $prixMin = $prixMax = '';
    $pageChoisie = 1;
    $message = [];

    $url = parse_url($_SERVER['REQUEST_URI'])['path'];
    if (isset($_SERVER['REQUEST_URI']['query']) && !empty($_SERVER['REQUEST_URI']['query'])) {
      $url = parse_url($_SERVER['REQUEST_URI'])['query'];
      $page = explode('&', $url);
      foreach ($page as $key => $param) {
        if (stristr($param, 'page=')) {
          unset($page[$key]);
        }
      }
      $url = parse_url($_SERVER['REQUEST_URI'])['path'].'?'.implode('&', $page);
    }

    if (!empty($_GET)) {
      extract($_GET);

      $selects =[
        'categorieSelect' => $categorieSelect,
        'regionSelect' => $regionSelect,
        'membreSelect' => $membreSelect,
        'triSelect' => $triSelect,
        'prixMin' => $prixMin,
        'prixMax' => $prixMax
      ];

    }

    // Select des catégories
    $listeCategories = new \model\ModelCategorie();
    $categories = $listeCategories->listeCategories('JOIN annonce a ON a.categorie_id IN (SELECT categorie_id FROM annonce)');

    // Select des régions
    $listeRegions = new \model\ModelRegion();
    $regions = $listeRegions->listeRegions('JOIN annonce a ON a.region_id = r.id WHERE r.id IN (SELECT region_id FROM annonce)');

    // Select des membres
    $listeMembres = new \model\ModelMembre();
    $membres = $listeMembres->distinctMembres('JOIN annonce a ON a.membre_id = m.id WHERE m.id IN (SELECT membre_id FROM annonce)', 'pseudo ASC');

    // Select des tris
    $listeTris = new \model\ModelTri();
    $tris = $listeTris->selectTri();


    $reqC = (!empty($selects['categorieSelect']) ? 'AND a.categorie_id = '.$selects['categorieSelect'].' ' : '');
    $reqR = (!empty($selects['regionSelect']) ? 'AND a.region_id = '.$selects['regionSelect'].' ' : '');
    $reqM = (!empty($selects['membreSelect']) ? 'AND a.membre_id = '.$selects['membreSelect'].' ' : '');
    $reqPm = (!empty($selects['prixMin']) ? 'AND a.prix >= '.$selects['prixMin'].' ' : '');
    $reqPM = (!empty($selects['prixMax']) ? 'AND a.prix <= '.$selects['prixMax'].' ' : '');
    $triPar = (!empty($selects['triSelect']) ? $selects['triSelect'] : 'a.id DESC');

    // Affichage de la liste des annonces en fonction des select catégories, régions, membres et du tri
    $req = 'SELECT a.*, m.id idMembre, m.pseudo pseudo, c.id idCategorie, c.titre categorie, r.id idRegion, r.nom region '
    .'FROM annonce a, categorie c, membre m, region r '
    .'WHERE r.id = a.region_id AND m.id = a.membre_id AND c.id = a.categorie_id AND a.dispo = \'active\' '
    .$reqC.$reqR.$reqM.$reqPm.$reqPM
    .'ORDER BY '. $triPar;

    $bdd = new \model\ModelMaitre();
    $pdo = $bdd->connexionBdd();

    $stmt = $pdo->query($req);

    // Affichage des annonces (Pagination)
    $nbTotalAnnonces = $stmt->rowCount();
    $annoncesParPage = 5;
    $nbTotalPages = ceil($nbTotalAnnonces/$annoncesParPage);

    if (isset($_GET['page']) && !empty($_GET['page'])) {
      $pageChoisie = (int)$_GET['page'];
      if($pageChoisie > $nbTotalPages) {
        $pageChoisie = $nbTotalPages;
      }

    } elseif (isset($_GET['prev']) && !empty($_GET['prev'])) {
      ($pageChoisie-1)<=0 ? $pageChoisie = 1 : $pageChoisie = $pageChoisie-1 ;

    } elseif (isset($_GET['next']) && !empty($_GET['next'])) {
      ($pageChoisie > $nbTotalPages) ? '' : $pageChoisie = $pageChoisie+1;

    } else {
      $pageChoisie = 1;
    }

    if ($nbTotalAnnonces < 1) {
      $pageChoisie = 1;
      $message[] = 'Aucune annonce n\'est disponible pour cette sélection';
    }

    $premiereAnnonce = ($pageChoisie-1) * $annoncesParPage;


    // Limitation des annonces à 5 par page
    $req .= ' LIMIT '.$premiereAnnonce.', '.$annoncesParPage;
    $stmt = $pdo->query($req);
    $annonces = $stmt->fetchAll();


    $affichageMessage =
    '<div class="alert alert-info">
    <h5 class="alert-heading">Vous avez un message :</h5>
    <hr>
    <p>'.implode ('<br>', $message).'</p>
    </div>';

    $chemin = $this->cheminView(get_class($this), __FUNCTION__);

    // $nomClasse = explode('\\', __CLASS__);
    // $nomClasse = end($nomClasse);
    // $dossier = lcfirst($nomClasse);
    // $fichier = __FUNCTION__;
    // $chemin = '../view/'.$dossier.'/'.$fichier.'.php';

    $result = [
      'affichageMessage' => $this->affichageMessage($message),
      'categories' => $categories,
      'regions' => $regions,
      'membres' => $membres,
      'annonces' => $annonces,
      'tris' => $tris,
      'selects' => $selects,
      'pdo' => $pdo,
      'photoWeb' => $this->photoWeb(),
      'sitePath' => $this->sitePath(),
      'nbTotalPages' => $nbTotalPages,
      'pageChoisie' => $pageChoisie,
      'url' => $url
    ];

    $this->render($result, $chemin);

  }

  /**
  * Controller vue de l'annonce (front)
  * @param $id
  */
  public function actionShowAnnonce(EntityAnnonce $id)
  {
    $photoActuelle = $commentaire = $avis = $note = '';

    $errors = [];

    var_dump($_GET);


    if (!empty($_POST)) {
      $this->sanitizePost();
      extract($_POST);
    }


    // Requête de toutes les informations concernant l'annonce et le vendeur -----------------------------
    $req = <<<EOS
    SELECT m.id idVendeur, m.pseudo pseudo, telephone, a.*, r.nom region, c.titre titre_categorie
    FROM annonce a
    JOIN membre m ON m.id = a.membre_id
    JOIN region r ON r.id = a.region_id
    JOIN categorie c ON c.id = a.categorie_id
    WHERE a.id =
EOS

    .$id;
    $stmt = $pdo->query($req);
    $annonce = $stmt->fetch();


    // Requête d'affichage des commentaires de l'annonce -------------------------------------------------
    $reqCommentaires = 'SELECT c.id idCommentaire, c.commentaire commentaire, '.
    'c.membre_id idClient, c.date_enregistrement date_enregistrement, '.
    'c.annonce_id idAnnonce, m.pseudo pseudo, a.membre_id idVendeur '.
    'FROM commentaire c JOIN membre m ON m.id = c.membre_id '.
    'JOIN annonce a ON a.id = c.annonce_id '.
    'WHERE c.annonce_id = '. $id .
    ' ORDER BY c.id DESC';
    $stmt = $pdo->query($reqCommentaires);
    $commentTous = $stmt->fetchAll();


    // Requête pour afficher les "Autres annonces" (autre que celle affichée) ---------------------------------
    $req = <<<EOS
    SELECT a.*, a.titre titre_annonce
    FROM annonce a JOIN categorie c ON c.id = a.categorie_id
    WHERE a.id != :id AND c.id =
    (SELECT categorie_id FROM annonce WHERE id = :id)
    LIMIT 4
EOS;

    $stmt = $pdo->prepare($req);
    $stmt->bindValue(':id', $id);
    $toutesAnnonces = $stmt->fetchAll();


    // Message si l'annonce n'existe pas
    $this->notFound();


    // Attribution de la photo par défaut si aucune photo n'existe
    $src = (!empty($annonce['photo']))
    ? PHOTO_WEB . $annonce['photo']
    : PHOTO_DEFAUT
    ;


    // Accès aux commentaires, avis et note uniquement si connecté
    if (!$this->UserConnected()) {
      $disabled = 'disabled';
      $popover = 'popover';
    } else {
      $disabled = $popover = '';
    }


    $affichageMessage =
    '<div class="alert alert-info">
    <h5 class="alert-heading">Vous avez un message :</h5>
    <hr>
    <p>'.implode ('<br>', $message).'</p>
    </div>';

    $chemin = $this->cheminView(get_class($this), __FUNCTION__);

    // $nomClasse = explode('\\', __CLASS__);
    // $nomClasse = end($nomClasse);
    // $dossier = lcfirst($nomClasse);
    // $fichier = __FUNCTION__;
    // $chemin = '../view/'.$dossier.'/'.$fichier.'.php';

    $result = [
      'affichageMessage' => $this->affichageMessage($message),
      'annonce' => $annonce,
      'commentTous' => $commentTous,
      'toutesAnnonces' => $toutesAnnonces,
      'src' => $src,
      'disabled' => $disabled,
      'popover' => $popover,
      'sitePath' => $this->sitePath(),
      'isUserConnected()' => $this->isUserConnected(),
    ];

    $this->render($result, $chemin);

  }
}
