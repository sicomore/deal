<?php

$routes = [
  'liste_membres' => [
    'controller' => 'Membre',
    'action' => 'ListeMembres'
  ],

  'connexion_membre' => [
    'controller' => 'Membre',
    'action' => 'ConnexionMembre'
  ],

  'gestion_annonces' => [
    'controller' => 'Annonce',
    'action' => 'GestionAnnonces'
  ],

  'liste_annonces' => [
    'controller' => 'Annonce',
    'action' => 'ListeAnnonces'
  ],

  'show_annonce' => [
    'controller' => 'Annonce',
    'action' => 'ShowAnnonce'
  ],

  'liste_categories' => [
    'controller' => 'Categorie',
    'action' => 'listeCategories'
  ],

  'new_categorie' => [
    'controller' => 'Categorie',
    'action' => 'newCategorie'
  ],

  'edit_categorie' => [
    'controller' => 'Categorie',
    'action' => 'editCategorie'
  ],

  'delete_categorie' => [
    'controller' => 'Categorie',
    'action' => 'deleteCategorie'
  ]

];
