<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Deal - Site de petites annonce</title>

  <!-- Bootstrap Core CSS -->
  <link href="<?= $sitePath ?>View/assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="<?= $sitePath;?>View/assets/css/metisMenu.min.css" rel="stylesheet">

  <!-- < ?php if (__FILE__ ==  $sitePath->sitePath().'assets/css/dmin/annonces.php') : ?> -->

  <!-- DataTables CSS -->
  <link href="<?= $sitePath;?>View/assets/css/dataTables.bootstrap.css" rel="stylesheet">

  <!-- DataTables Responsive CSS -->
  <link href="<?= $sitePath;?>View/assets/css/dataTables.responsive.css" rel="stylesheet">

  <!-- < ?php endif; ?> -->

  <!-- Custom CSS -->
  <link href="<?= $sitePath;?>View/assets/css/general.css" rel="stylesheet">
  <link href="<?= $sitePath;?>View/assets/css/lightbox.css" rel="stylesheet">

  <!-- Morris Charts CSS -->
  <!-- <link href="< ?= $sitePath->sitePath();?>View/assets/css/vendor/morrisjs/morris.css" rel="stylesheet"> -->

  <!-- Custom Fonts -->
  <link href="<?= $sitePath;?>View/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet" type="text/css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you View the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

  <div class="container-fluid" id="wrapper">

    <!--============================================ NAVBAR ADMIN ============================================-->

    <!-- < ?php if (isUserAdmin()) : ?> -->
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="nav navbar-brand" href="<?=  $sitePath; ?>index.php">Administration</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a class="btn btn-default" href="
              <?=  $sitePath; ?>admin/stats.php">
            Statistiques</a>
          </li>
          <li class="dropdown btn-default">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestion<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li>
                <a class="" href="index.php?gestion_annonces">
                  Annonces
                </a>
              </li>
              <li>
                <a class="" href="index.php?liste_categories">
                  Catégories
                </a>
              </li>
              <li>
                <a class="" href="index.php?liste_membres">
                  Membres
                </a>
              </li>
              <li>
                <a class="" href="<?=  $sitePath; ?>admin/commentaires.php">
                  Commentaires
                </a>
              </li>
              <li>
                <a class="" href="<?=  $sitePath; ?>admin/notes.php">
                  Notes & Avis
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <!-- < ?php endif; ?> -->


  <!--============================================ NAVBAR ============================================-->

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=  $sitePath; ?>www/index.php">Deal</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
        <ul class="nav navbar-nav">
          <li><a href="<?=  $sitePath.'contact.php'; ?>" title="Contactez-nous" data-toggle="tooltip" data-placement="bottom">Contact</a></li>

          <li data-toggle="<?= $popover; ?>" data-placement="bottom" data-content="Pour déposer une annonce, veuillez-vous connecter.">
            <a class="btn btn-primary <?= $disabled; ?>" href="<?= $sitePath;?>annonce-edit.php">
              Déposer une annonce
            </a>
          </li>
        </ul>


        <ul class="nav navbar-nav navbar-right">

          <form id="form-recherche" class="navbar-form navbar-left">
            <div class="form-group">
              <div class="input-group custom-search-form">
                <input type="text" name="search" id="input-recherche" class="form-control" placeholder="Recherche...">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button" id="bouton-search">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
              </div>
            </div>
          </form>


          <!-- < ?php if (isUserConnected()) : ?> -->

          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="fa fa-user fa-fw"></i>
              <!-- < ?= getPseudo() ; ?> -->
              <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
              <li>
                <a href="<?= $sitePath;?>profil.php">
                  <i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Mon profil</a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="<?= $sitePath;?>deconnexion.php"><i class="fa fa-sign-out fa-fw"></i> Déconnexion</a>
                </li>
              </ul>
            </li>

            <!-- < ?php else : ?> -->

            <li class="dropdown">
              <a class="dropdown-toggle btn btn-primary" data-toggle="dropdown" href="#">
                <i class="fa fa-sign-in"></i>&nbsp;
                Connexion / Inscription&nbsp;
                <i class="fa fa-caret-down"></i>
              </a>
              <ul class="dropdown-menu dropdown-user">
                <li>
                  <a class="btn btn-default" href="index.php?connexion_membre">Connexion</a>
                </li>
                <li class="divider"></li>
                <li>
                  <a class="btn btn-primary" href="<?= $sitePath;?>inscription.php">Inscription</a>
                </li>
              </ul>
            </li>

            <!-- < ?php endif; ?> -->

          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>


    <?php echo $vue; ?>


  </div> <!-- .container-fluid #wrapper -->

  <footer class="container-fluid">

    <ul class="list-inline">
      <li class="list-inline-item"><a class="btn" href="<?=  $sitePath.'index.php' ?>">Accueil</a></li>
      <li class="list-inline-item"><a class="btn" href="<?=  $sitePath.'mentions-legales.php' ?>">Mentions légales</a></li>
      <li class="list-inline-item"><a class="btn" href="<?=  $sitePath.'cgu.php'; ?> ">C.G.U.</a></li>
      <li class="list-inline-item"><a class="btn" href="<?=  $sitePath.'contact.php'; ?>">Contact</a></li>
    </ul>
  </footer>


  <!-- jQuery -->
  <script src="<?= $sitePath;?>View/assets/js/jquery.min.js"></script>

  <!-- Bootstrap Core JavaScript -->
  <script src="<?= $sitePath;?>View/assets/js/bootstrap.min.js"></script>

  <!-- Metis Menu Plugin JavaScript -->
  <script src="<?= $sitePath;?>View/assets/js/metisMenu.min.js"></script>


  <!-- Custom Theme JavaScript -->
  <script src="<?= $sitePath;?>View/assets/js/sb-admin-2.js"></script>
  <script src="<?= $sitePath;?>View/assets/js/lightbox.js"></script>

</body>

</html>
