<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Accueil::afficher');
use App\Controllers\Accueil;

$routes->get('accueil/afficher', [Accueil::class, 'afficher']);
use App\Controllers\Compte;

$routes->get('compte/lister', [Compte::class, 'lister']);
$routes->get('compte/creer', [Compte::class, 'creer']);
$routes->post('compte/creer', [Compte::class, 'creer']);
$routes->get('compte/connecter', [Compte::class, 'connecter']);
$routes->post('compte/connecter', [Compte::class, 'connecter']);
$routes->get('compte/deconnecter', [Compte::class, 'deconnecter']);

$routes->get('compte/afficher_profil', [Compte::class, 'afficher_profil']);
$routes->post('compte/modifierMotDePasse', [Compte::class, 'modifierMotDePasse']);
$routes->get('compte/afficher_formulaire_mdp', [Compte::class, 'afficher_formulaire_mdp_backend']);
$routes->post('compte/afficher_formulaire_mdp', [Compte::class, 'modifierMotDePasse']);




$routes->get('compte/afficher_tableauP', [Compte::class, 'afficher_les_profils']);
$routes->post('compte/gerer_etat_profil', [Compte::class, 'gerer_etat_profil']);
$routes->get('compte/affichage_scenarios_backend', [Compte::class, 'afficher_les_scenario_backend']);

$routes->post('compte/copier_le_scenario_et_ces_etapes', [Compte::class, 'copier_le_scenario_et_ces_etapes']);
$routes->post('compte/supprimer_scenario', [Compte::class, 'supprimer_scenario_et_ces_etapes']);

$routes->get('compte/creer_compte_backend', [Compte::class, 'creer_backend']);
$routes->post('compte/creer_compte_backend', [Compte::class, 'creer_backend']);
$routes->post('compte/afficher_les_details_scenario/(:segment)', [Compte::class, 'afficher_les_details_scenario']);
$routes->get('compte/afficher_les_details_scenario/(:segment)', [Compte::class, 'afficher_les_details_scenario']);

$routes->get('compte/ajouter_scenario', [Compte::class, 'afficher_formulaire_creer_scenario']);
$routes->post('compte/ajouter_scenario', [Compte::class, 'afficher_formulaire_creer_scenario']);

use App\Controllers\Actualite;

$routes->get('actualite/afficher', [Actualite::class, 'afficher']);
$routes->get('actualite/afficher/(:num)', [Actualite::class, 'afficher']);
use App\Controllers\Scenario;


$routes->get('scenario/afficher', [Scenario::class, 'afficher_sce']);
$routes->get('scenario/afficher/(:segment)', [Scenario::class, 'afficher_sce']);
$routes->get('scenario/afficher/(:segment)/(:num)', [Scenario::class, 'afficher_sce']);
$routes->post('scenario/afficher/(:segment)/(:num)', [Scenario::class, 'afficher_sce']);


$routes->get('scenario/franchir_etape/', [Scenario::class, 'next_etape']);
$routes->get('scenario/franchir_etape/(:segment)', [Scenario::class, 'next_etape']);
$routes->get('scenario/franchir_etape/(:segment)/(:num)', [Scenario::class, 'next_etape']);
$routes->post('scenario/franchir_etape/', [Scenario::class, 'next_etape']);

$routes->get('scenario/finaliser_scenario/', [Scenario::class, 'finaliser_scenario']);
$routes->get('scenario/finaliser_scenario/(:segment)', [Scenario::class, 'finaliser_scenario']);
$routes->get('scenario/finaliser_scenario/(:segment)/(:segment)', [Scenario::class, 'finaliser_scenario']);
$routes->get('scenario/finaliser_scenario/(:segment)/(:segment)/(:num)', [Scenario::class, 'finaliser_scenario']);
$routes->get('scenario/finaliser_scenario/(:segment)/(:segment)/(:num)/(:num)', [Scenario::class, 'finaliser_scenario']);
$routes->post('scenario/finaliser_scenario/(:segment)/(:segment)/(:num)/(:num)', [Scenario::class, 'finaliser_scenario']);




