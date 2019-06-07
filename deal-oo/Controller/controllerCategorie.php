<?php
namespace controller;

/**
*
*/
class ControllerCategorie extends ControllerMaitre {

  public function actionListeCategories($messages = []) {

    $this->startSession();

    $message = $messages;

    $affichage = new \model\ModelCategorie();
    $listeCategories = $affichage->listeCategories();

    if (!$listeCategories) {
      $message[] = 'Aucune catégorie n\'a été trouvée.';

    } else {
      $affichageLigne = '';
      foreach ($listeCategories as $categorie) {
        $affichageLigne .=
        '<tr>
        <td>'.$categorie['id'].'</td>
        <td>'.$categorie['titre'].'</td>
        <td>'.$categorie['mots_cles'].'</td>
        <td>'.
        '<a href="index.php?edit_categorie&id='.$categorie['id'].'" class="btn btn-warning" title="Modifier la catégorie" data-toggle="tooltip" data-placement="left">
        <i class="fa fa-edit"></i>
        </a>'.
        '<a href="index.php?delete_categorie&id='.$categorie['id'].'" class="btn btn-danger" title="Supprimer la catégorie" data-toggle="tooltip" data-placement="left">
        <i class="fa fa-trash"></i>
        </a>'.
        '</td>
        </tr>';
      }
    }

    $nomClasse = explode('\\', __CLASS__);
    $nomClasse = end($nomClasse);
    $dossier = lcfirst($nomClasse);
    $fichier = __FUNCTION__;
    $chemin = '../view/'.$dossier.'/'.$fichier.'.php';

    $result = [
      'affichageMessage' => $this->affichageMessage($message),
      'affichageLigne' => $affichageLigne
    ];

    $this->render($result, $chemin);

  }




  public function actionEditCategorie() {

    $this->startSession();

    $message = [];

    if (empty($_GET['id'])) {
      $message[] = "Aucune catégorie n'a été sélectionnée.";

    } else {
      $id = (int)$_GET['id'];

      $categorie = new \model\ModelCategorie();
      $laCategorie = $categorie->selectCategorie($id);

      if (!$laCategorie) {
        $message[] = "Cette catégorie n'existe pas.";

      } else {
        if ($_POST) {
          if (isset($_POST['titre']) && !empty($_POST['titre'])) {

            $titre = trim(strip_tags($_POST['titre']));
            $mots_cles = trim(strip_tags($_POST['mots_cles']));

            $categorie = new \model\ModelCategorie();
            $categorieMAJ = $categorie->updateCategorie($id, $titre, $mots_cles);

            if ($categorieMAJ) {
              $message[] = "La catégorie \"".$_POST['titre']."\" a bien été mise à jour.";

            } else {
              $message[] = "La catégorie \"".$_POST['titre']."\" n'a pas pu être mise à jour.";
            }

          } else {
            $message[] = "La catégorie doit contenir un titre.";
          }

          $this->actionListeCategories($message);
          die;
        }

        $nomClasse = explode('\\', __CLASS__);
        $nomClasse = end($nomClasse);
        $dossier = lcfirst($nomClasse);
        $fichier = __FUNCTION__;
        $chemin = '../view/'.$dossier.'/'.$fichier.'.php';

        $result = [
          'affichageMessage' => $this->affichageMessage($message),
          'affichage' => $laCategorie
        ];

        $this->render($result, $chemin);

      }
    }

    $this->actionListeCategories($message);

  }




  public function actionNewCategorie() {

    $this->startSession();

    $message = [];

    if ($_POST) {
      if (isset($_POST['titre']) && !empty($_POST['titre'])) {

        $titre = trim(strip_tags($_POST['titre']));
        $mots_cles = trim(strip_tags($_POST['mots_cles']));

        $categorie = new \model\ModelCategorie();
        $existCategorie = $categorie->selectCategorie(NULL, $titre);

        if ($existCategorie) {
          $message[] = 'La catégorie "'.$titre.'" existe déjà.';

        } else {
          $creationCategorie = $categorie->addCategorie($titre, $mots_cles);

          if ($creationCategorie) {
            $message[] = 'La catégorie "'.$titre.'" a bien été créée.';
          } else {
            $message[] = 'La catégorie "'.$titre.'" n\'a pas pu être créée.';
          }
        }


      } else {
        $message[] = 'La catégorie nécessite un titre pour être enregistrée.';
      }

      $this->actionListeCategories($message);
      die;
    }

    // $nomClasse = explode('\\', __CLASS__);
    // $nomClasse = end($nomClasse);
    // $dossier = lcfirst($nomClasse);
    // $fichier = __FUNCTION__;
    // $chemin = '../view/'.$dossier.'/'.$fichier.'.php';
    $chemin = '../view/controllerCategorie/actionEditCategorie.php';

    $result = [
      'affichageMessage' => $this->affichageMessage($message)
    ];

    $this->render($result, $chemin);

  }



  public function actionDeleteCategorie() {

    $this->startSession();

    $message = [];

    if ($_GET['id']) {

      $id = (int)$_GET['id'];
      $champ = 'categorie_id';

      $annonces = new \model\ModelAnnonce();
      $dansAnnonces = $annonces->countAnnonce($champ, $id);

      $categorie = new \model\ModelCategorie();
      $existCategorie = $categorie->selectCategorie($id);

      if (!$dansAnnonces) {
        if (!$existCategorie) {
          $message[] = 'Cette catégorie n\'existe pas ou plus.<br>Choisissez dans la liste.';

        } else {
          $categ = new \model\ModelCategorie();
          $delCategorie = $categ->deleteCategorie($id);

          $message[] = 'La catégorie "'.$existCategorie['titre'].'" a bien été supprimée.';
        }

      } else {
        $message[] = 'La catégorie "'.$existCategorie['titre'].'" ne peut être supprimée car elle contient des annonces.';
      }

    } else {
      $message[] = "La catégorie n'existe pas.";
    }

    $this->actionListeCategories($message);
    die;

  }

}
