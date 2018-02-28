<?php
// initialisation de la session
session_start();

// Définit le chemin vers la racine du site à partir de la racine du serveur (la racine du site se trouve dans SITE)
define('SITE_PATH','/PROJET-Back-End/deal/');
define('PHOTO_DIR', __DIR__ . '/../photos/');
define('PHOTO_WEB', SITE_PATH . 'photos/');
define('PHOTO_DEFAUT', "https://dummyimage.com/200x150/000222/f7f7f7.jpg&text=image+indisponible");
define('API_KEY', 'AIzaSyAcllUJdsDp2HGAEECXAXrnEpBL48MIG7I');

// Initialisation de la connexion à la PDO
require_once __DIR__.'/connexion-bdd.php';

// Initialisation des fonctions utilitaires
require_once __DIR__.'/fonctions.php';

require __DIR__.'/annonce.php';
