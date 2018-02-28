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
  <link href="<?=SITE_PATH;?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="<?=SITE_PATH;?>vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="<?=SITE_PATH;?>dist/css/general.css" rel="stylesheet">

  <!-- Morris Charts CSS -->
  <link href="<?=SITE_PATH;?>vendor/morrisjs/morris.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="<?=SITE_PATH;?>vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body>

  <div class="container-fluid" id="wrapper">

    <!--============================================ NAVBAR ADMIN ============================================-->

    <?php
    if (isUserAdmin()) :
      ?>
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="nav navbar-brand" href="<?= SITE_PATH; ?>index.php">Administration</a>
          </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li >
            <a class="btn btn-default" href="
            <?= SITE_PATH; ?>admin/membre-edit.php">
            Gestion Membres</a>
          </li>
          <li >
            <a class="btn btn-default" href="
            <?= SITE_PATH; ?>admin/categorie.php">
            Gestion Catégories</a>
          </li>
        </ul>
      </div>
      </div>
    </nav>

    <?php
  endif;
  ?>


  <!--============================================ NAVBAR ============================================-->

  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?= SITE_PATH; ?>index.php">Deal</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
        <ul class="nav navbar-nav">
          <li><a href="#">Contact</a></li>

          <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="#">Action</a></li>
          <li><a href="#">Another action</a></li>
          <li><a href="#">Something else here</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">Separated link</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="#">One more separated link</a></li>
        </ul>
      </li> -->
    </ul>
    <!-- <form class="navbar-form navbar-right">
    <div class="form-group">
    <input type="text" class="form-control" placeholder="Search">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form> -->

<ul class="nav navbar-nav navbar-right">

  <?php
  if (!isUserConnected()) {
    $disabled = 'disabled';
    $popover = 'popover';
  } else {
    $disabled = '';
    $popover = '';
  }
  ?>

  <li data-toggle="<?= $popover; ?>" data-placement="bottom" data-content="Pour déposer une annonce, veuillez-vous connecter.">
    <a class="btn btn-success <?= $disabled; ?>" href="<?=SITE_PATH;?>admin/annonce-edit.php">Déposer une annonce</a>
  </li>
  <li >
    <a class="btn btn-default" href="
    <?= SITE_PATH; ?>admin/annonces.php">
    Voir les Annonces</a>
  </li>


  <li class="sidebar-search">
    <div class="input-group custom-search-form">
      <input type="text" class="form-control" placeholder="Recherche...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button">
          <i class="fa fa-search"></i>
        </button>
      </span>
    </div>
  </li>

  <?php
  if (!isUserConnected()) :
    ?>
    <li>
      <a class="btn btn-default" href="<?=SITE_PATH;?>connexion.php">Connexion</a>
      <!-- <a class="btn" data-toggle="modal" data-target="#modal-connexion">Connexion</a> -->
    </li>
    <li>
      <a class="btn btn-primary" href="<?=SITE_PATH;?>inscription.php">Inscription</a>
      <!-- <a class="btn" data-toggle="modal" data-target="#modal-connexion">Connexion</a> -->
    </li>
  <?php endif; ?>

  <?php
  if (isUserConnected()) :
    ?>
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user fa-fw"></i>
        <?= getPseudo().'<br>'.$_SESSION['membre']['role']; ?>
        <i class="fa fa-caret-down"></i>
      </a>
      <ul class="dropdown-menu dropdown-user">
        <li>
          <a href="<?=SITE_PATH;?>profil.php"><i class="fa fa-user fa-fw"></i> Mon profil</a>
        </li>
        <li class="divider"></li>
        <li>
          <a href="<?=SITE_PATH;?>deconnexion.php"><i class="fa fa-sign-out fa-fw"></i> Déconnexion</a>
        </li>
      </ul>
      <!-- </li> -->
      <?php
      // else :
      ?>
      <!-- <li class="dropdown"> -->
      <!-- <a class="dropdown-toggle" data-toggle="dropdown" href="#">
      <i class="fa fa-user fa-fw"></i>
      Espace Membre
      <i class="fa fa-caret-down"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
    <li><a href="< ?=SITE_PATH;?>inscription.php"><i class="fa fa-user fa-fw"></i> Inscription</a>
  </li>
  <li class="divider"></li>
  <li><a href="< ?=SITE_PATH;?>connexion.php"><i class="fa fa-gear fa-fw"></i> Connexion</a>
</li>
</ul> -->
</li>
<?php
endif;
?>

<!-- <li><a href="#">Link</a></li>
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="#">Action</a></li>
<li><a href="#">Another action</a></li>
<li><a href="#">Something else here</a></li>
<li role="separator" class="divider"></li>
<li><a href="#">Separated link</a></li>
</ul>
</li> -->
</ul>
</div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
