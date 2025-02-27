<?php
namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Compte extends BaseController
{
   public function __construct()
   {
      helper('form');
      $this->model = model(Db_model::class);
   }
   public function lister()
   {
      $model = model(Db_model::class);
      $data['titre'] = "Liste de tous les comptes";
      $data['logins'] = $model->get_all_compte();
      $data['Nb_total'] = $model->get_number_all_compte();
      return view('templates/haut', $data)
         . view('affichage_comptes')
         . view('templates/bas');
   }

   public function creer()
   {
      helper('form');
      $model = model(Db_model::class);
      // L’utilisateur a validé le formulaire en cliquant sur le bouton
      if ($this->request->getMethod() == "post") {
         if (
            !$this->validate([
               'nom' => 'required|min_length[2]|max_length[255]',
               'prenom' => 'required|min_length[2]|max_length[255]',
               'email' => 'required|valid_email|max_length[255]',
               'pseudo' => 'required|min_length[2]|max_length[255]',
               'mdp' => 'required|min_length[8]|max_length[255]',
               'confirmation_mdp' => 'required|matches[mdp]',
               'role' => 'required',
               'validite' => 'required'
            ], [
               'nom' => [
                  'required' => 'Veuillez entrer un nom !',
                  'min_length' => 'Le nom doit avoir au moins 2 caractères.',
                  'max_length' => 'Le nom ne doit pas dépasser 255 caractères.',
               ],
               'prenom' => [
                  'required' => 'Veuillez entrer un prénom !',
                  'min_length' => 'Le prénom doit avoir au moins 2 caractères.',
                  'max_length' => 'Le prénom ne doit pas dépasser 255 caractères.',
               ],
               'email' => [
                  'required' => 'Veuillez entrer une adresse email !',
                  'valid_email' => 'Veuillez entrer une adresse email valide !',
                  'max_length' => 'L\'adresse email ne doit pas dépasser 255 caractères.',
               ],
               'pseudo' => [
                  'required' => 'Veuillez entrer un pseudo pour le compte !',
                  'min_length' => 'Le pseudo doit avoir au moins 2 caractères.',
                  'max_length' => 'Le pseudo ne doit pas dépasser 255 caractères.',
               ],
               'mdp' => [
                  'required' => 'Veuillez entrer un mot de passe !',
                  'min_length' => 'Le mot de passe doit avoir au moins 8 caractères.',
                  'max_length' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
               ],
               'confirmation_mdp' => [
                  'required' => 'Veuillez confirmer le mot de passe !',
                  'matches' => 'Les mots de passe ne correspondent pas.',
               ],
               'role' => [
                  'required' => 'Veuillez entrez un role!',
               ],
               'validite' => [
                  'required' => 'Veuillez entrez la validite',
               ]
            ])
         ) {
            // La validation du formulaire a échoué, retour au formulaire !
            return view('templates/haut', ['titre' => 'Créer un compte'])
               . view('compte/compte_creer')
               . view('templates/bas');
         }
         // La validation du formulaire a réussi, traitement du formulaire
         $recuperation = $this->validator->getValidated();
         $result = $model->set_compte($recuperation);


         if ($result === "Pseudo existe déja !") {
            return redirect()->to('/compte/creer')->with('error', 'Pseudo existe déjà.');

         } elseif ($result === "Email existe déja !") {

            return redirect()->to('/compte/creer')->with('error', 'Email existe déjà.');

         } else {
            //$model->set_profil($recuperation);
            $data['le_compte'] = $recuperation['pseudo'];
            $data['le_message'] = "Nouveau nombre de comptes : ";
            //Appel de la fonction créée dans le précédent tutoriel :
            $data['le_total'] = $model->get_number_all_compte();
            return view('templates/haut', $data)
               . view('compte/compte_succes')
               . view('templates/bas');
         }

      }
      // L’utilisateur veut afficher le formulaire pour créer un compte
      return view('templates/haut', ['titre' => 'Créer un compte'])
         . view('menu_visiteur')
         . view('compte/compte_creer')
         . view('templates/bas');
   }




   public function creer_backend()
   {
      helper('form');
      $model = model(Db_model::class);
      // L’utilisateur a validé le formulaire en cliquant sur le bouton
      $session = session();

      if ($session->has('user')) {
         if ($this->request->getMethod() == "post") {
            if (
               !$this->validate([
                  'nom' => 'required|min_length[2]|max_length[255]',
                  'prenom' => 'required|min_length[2]|max_length[255]',
                  'email' => 'required|valid_email|max_length[255]',
                  'pseudo' => 'required|min_length[2]|max_length[255]',
                  'mdp' => 'required|min_length[8]|max_length[255]',
                  'confirmation_mdp' => 'required|matches[mdp]',
                  'role' => 'required',
                  'validite' => 'required'
               ], [
                  'nom' => [
                     'required' => 'Veuillez entrer un nom !',
                     'min_length' => 'Le nom doit avoir au moins 2 caractères.',
                     'max_length' => 'Le nom ne doit pas dépasser 255 caractères.',
                  ],
                  'prenom' => [
                     'required' => 'Veuillez entrer un prénom !',
                     'min_length' => 'Le prénom doit avoir au moins 2 caractères.',
                     'max_length' => 'Le prénom ne doit pas dépasser 255 caractères.',
                  ],
                  'email' => [
                     'required' => 'Veuillez entrer une adresse email !',
                     'valid_email' => 'Veuillez entrer une adresse email valide !',
                     'max_length' => 'L\'adresse email ne doit pas dépasser 255 caractères.',
                  ],
                  'pseudo' => [
                     'required' => 'Veuillez entrer un pseudo pour le compte !',
                     'min_length' => 'Le pseudo doit avoir au moins 2 caractères.',
                     'max_length' => 'Le pseudo ne doit pas dépasser 255 caractères.',
                  ],
                  'mdp' => [
                     'required' => 'Veuillez entrer un mot de passe !',
                     'min_length' => 'Le mot de passe doit avoir au moins 8 caractères.',
                     'max_length' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
                  ],
                  'confirmation_mdp' => [
                     'required' => 'Veuillez confirmer le mot de passe !',
                     'matches' => 'Les mots de passe ne correspondent pas.',
                  ],
                  'role' => [
                     'required' => 'Veuillez entrez un role!',
                  ],
                  'validite' => [
                     'required' => 'Veuillez entrez la validite',
                  ]])
            ) {
               // La validation du formulaire a échoué, retour au formulaire !
               return view('templates/haut', ['titre' => 'Créer un compte'])
                  . view('menu_administrateur_ad')
                  . view('connexion/creer_compte_backend')
                  . view('templates/bas');

            }
            // La validation du formulaire a réussi, traitement du formulaire
            $recuperation = $this->validator->getValidated();
            $result = $model->set_compte($recuperation);


            if ($result === "Pseudo existe déja !") {
               return redirect()->to('/compte/creer_compte_backend')->with('error', 'Pseudo existe déjà.');

            } elseif ($result === "Email existe déja !") {

               return redirect()->to('/compte/creer_compte_backend')->with('error', 'Email existe déjà.');

            } else {
               return redirect()->to('/compte/creer_compte_backend')->with('success', 'Compte a été créé avec succès');



            }

         }
         // L’utilisateur veut afficher le formulaire pour créer un compte
         return view('templates/haut', ['titre' => 'Créer un compte'])
            . view('menu_administrateur_ad')
            . view('connexion/creer_compte_backend')
            . view('templates/bas');
      } else {
         return redirect()->to(base_url());
         ;
      }
   }
   public function connecter()
   {
      $model = model(Db_model::class);
      // L’utilisateur a validé le formulaire en cliquant sur le bouton
      if ($this->request->getMethod() == "post") {
         if (
            !$this->validate([

               'pseudo' => 'required|min_length[2]|max_length[255]',
               'mdp' => 'required|min_length[8]|max_length[255]'
            ], [

               'pseudo' => [
                  'required' => 'Veuillez entrer un pseudo pour le compte !',
                  'min_length' => 'Pseudo incorrecte : Le pseudo doit avoir au moins 2 caractères.',
                  'max_length' => 'Pseudo incorrecte :Le pseudo ne doit pas dépasser 255 caractères.',
               ],
               'mdp' => [
                  'required' => 'Veuillez entrer un mot de passe !',
                  'min_length' => 'mot de passe incorrecte : Le mot de passe doit avoir au moins 8 caractères.',
                  'max_length' => 'mot de passe incorrecte : Le mot de passe ne doit pas dépasser 255 caractères.',
               ]])
         ) {
            return view('templates/haut', ['titre' => 'Se connecter'])
               . view('menu_visiteur')
               . view('connexion/compte_connecter')
               . view('templates/bas');
         }
         // La validation du formulaire a réussi, traitement du formulaire
         $username = $this->request->getVar('pseudo');
         $password = $this->request->getVar('mdp');
         $userEtat = $model->get_profil_etat($username);
         if ($model->connect_compte($username, $password) == true) {
            if ($userEtat == 'A') {
               $session = session();
               $session->set('user', $username);
               $userRole = $model->afficher_status($session->get('user'));
               if ($userRole === 'A') {
                  return view('templates/haut')
                     . view('menu_administrateur_ad')
                     . view('connexion/compte_accueil')
                     . view('templates/bas');
               } else {
                  return view('templates/haut')
                     . view('menu_administrateur')
                     . view('connexion/compte_accueil')
                     . view('templates/bas');
               }

            } else {
               session()->setFlashdata('error', "Ce compte a été désactivé !");
               return view('templates/haut', ['titre' => 'Se connecter'])
                  . view('connexion/compte_connecter')
                  . view('templates/bas');
            }

         } else {
            session()->setFlashdata('error', "Echec d'authentification, veuillez réessayez !");
            return view('templates/haut', ['titre' => 'Se connecter'])
               . view('connexion/compte_connecter')
               . view('templates/bas');
         }
      }
      // L’utilisateur veut afficher le formulaire pour se conncecter
      return view('templates/haut', ['titre' => 'Se connecter'])
         . view('menu_visiteur')
         . view('connexion/compte_connecter')
         . view('templates/bas');
   }


   public function afficher_profil()
   {
      $session = session();
      if ($session->has('user')) {
         $model = model(Db_model::class);
         $data['le_message'] = "Affichage des données du profil ici !!!";
         $data['afficher_pro'] = $model->afficher_profil($session->get('user'));
         $userRole = $model->afficher_status($session->get('user'));
         // A COMPLETER...
         if ($userRole === 'A') {
            return view('templates/haut')
               . view('menu_administrateur_ad', $data)
               . view('connexion/compte_profil')
               . view('templates/bas');
         } else {
            return view('templates/haut')
               . view('menu_administrateur', $data)
               . view('connexion/compte_profil')
               . view('templates/bas');
         }
      } else {
         return redirect()->to(base_url());

      }
   }
   public function afficher_les_profils()
   {
      $model = model(Db_model::class);
      $session = session();
      if ($session->has('user')) {

         $data['afficher_tp'] = $model->afficher_tableau_profils();
         return view('templates/haut')
            . view('menu_administrateur_ad', $data)
            . view('connexion/affichage_tableauP')
            . view('templates/bas');
      } else {
         return redirect()->to(base_url());
      }
   }

   public function gerer_etat_profil()
   {
      $model = model(Db_model::class);
      if ($this->request->getMethod() == "post") {
         $user_id = $this->request->getPost('profil_id');
         $action = $this->request->getPost('action');
         $model->changer_etat_profil($action, $user_id);
         return redirect()->back();

      }
   }

   public function afficher_les_scenario_backend()
   {
      $model = model(Db_model::class);
      $session = session();
      $userRole = $model->afficher_status($session->get('user'));
      if ($session->has('user') && $userRole === 'O') {
         $data['scenarios_backend'] = $model->get_all_scenarios_backend();
         return view('templates/haut')
            . view('menu_administrateur', $data)
            . view('connexion/afficher_scenarios_backend')
            . view('templates/bas');

      } else {
         return redirect()->to(base_url());
      }

   }
   public function copier_le_scenario_et_ces_etapes()
   {
      $session = session();
      if ($session->has('user')) {
         $model = model(Db_model::class);
         if ($this->request->getMethod() == "post") {
            $new_user_id = $this->request->getPost('id_user');
            $scenario_id_to_copie = $this->request->getPost('scenario_id');
            $cpt_id = $model->get_id_of_profil($new_user_id);

            $insert_new_scenario = $model->copier_un_scenario($cpt_id, $scenario_id_to_copie);

            if ($insert_new_scenario) {
               $last_scenario_id = $model->return_last_scenario_id();

               $insert_new_scenario_etapes = $model->copier_les_etapes_de_scenario($last_scenario_id, $scenario_id_to_copie);

               if ($insert_new_scenario_etapes) {
                  return redirect()->back();
               } else {
                  return redirect()->back();
               }
            } else {
               return redirect()->back();
            }
         }
      } else {
         return redirect()->to(base_url());
      }



   }

   public function supprimer_scenario_et_ces_etapes()
   {
      $session = session();
      if ($session->has('user')) {
         $model = model(Db_model::class);
         $scenario_id = $this->request->getPost('scenario_id');

         if ($this->request->getMethod() == "post") {
            $supprimer_indice_scenario = $model->delete_scenario_indice($scenario_id);
            if ($supprimer_indice_scenario) {
               $supprimer_etapes_scenario = $model->delete_scenario_etapes($scenario_id);
               if ($supprimer_etapes_scenario) {
                  $supprimer_reussite = $model->delete_reussite_scenario($scenario_id);
                  $supprimer_scenario = $model->delete_scenario($scenario_id);
                  if ($supprimer_scenario && $supprimer_reussite) {
                     return redirect()->back();
                  }
               }
            }

         }
      }
   }


   public function afficher_formulaire_mdp_backend()
   {
      $session = session();
      if ($session->has('user')) {
         $model = model(Db_model::class);
         $data['le_message'] = "Affichage des données du profil ici !!!";
         $data['afficher_pro'] = $model->afficher_profil($session->get('user'));
         $userRole = $model->afficher_status($session->get('user'));
         // A COMPLETER...
         if ($userRole === 'A') {
            return view('templates/haut')
               . view('menu_administrateur_ad', $data)
               . view('connexion/modifier_mdp_backend')
               . view('templates/bas');
         } else {
            return view('templates/haut')
               . view('menu_administrateur', $data)
               . view('connexion/modifier_mdp_backend')
               . view('templates/bas');
         }
      } else {
         return redirect()->to(base_url());
      }
   }

   public function modifierMotDePasse()
   {
      if ($this->request->getMethod() == 'post') {
         $model = model(Db_model::class);
         $session = session();

         if (!$session->has('user')) {
            return redirect()->to(base_url());
         }

         // Validation rules
         $validationRules = [
            'new_password' => 'required|min_length[8]|max_length[255]',
            'confirm_password' => 'required|matches[new_password]', // Updated the matches rule
         ];

         // Custom error messages
         $validationMessages = [
            'new_password' => [
               'required' => 'Veuillez entrer un mot de passe !',
               'min_length' => 'Le mot de passe doit avoir au moins 8 caractères.',
               'max_length' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
            ],
            'confirm_password' => [
               'required' => 'Veuillez confirmer le mot de passe !',
               'matches' => 'Les mots de passe ne correspondent pas.',
            ]
         ];

         if (!$this->validate($validationRules, $validationMessages)) {
            // Validation failed, redirect back with validation errors
            return redirect()->to('/compte/afficher_formulaire_mdp')->withInput();
         }

         // Get the new password from the form input
         $newPassword = $this->request->getPost('new_password');

         // Perform password update (you can adjust this part as needed)
         $user = $session->get('user');
         $result = $model->modifier_mdp($user, $newPassword);

         if ($result) {
            // Password change was successful, set a success flash message
            $session->setFlashdata('success_message', 'Mot de passe changé avec succès.');
         } else {
            // Password change failed, set an error flash message
            $session->setFlashdata('error_message', 'Échec du changement de mot de passe.');
         }

         // Redirect back to the profile page
         return redirect()->to('/compte/afficher_formulaire_mdp');
      }
   }

   public function afficher_les_details_scenario($code_scenario = null)
   {
      if ($code_scenario == null) {
         return redirect()->to("compte/affichage_scenarios_backend");
      }
      $session = session();
      if (!$session->has('user')) {
         return redirect()->to(base_url());
      } else {
         $model = model(Db_model::class);
         $scenario_id = $this->request->getPost('scenario_id');
         $scenario_exist = $model->check_if_scenario_exists($code_scenario);
         $scenario_id = $model->get_scenario_id_from_code($code_scenario);
         $data['scenario_info'] = $model->show_scenario_details($scenario_id);
         $scenario_own_info = $model->show_scenario_infos($scenario_id);
         if (!empty($scenario_id) && $scenario_exist) {
            $data['scenario_own_info'] = $model->show_scenario_infos($scenario_id);
            $data['error_message'] = "Pas d'étapes pour le moment !";
            return view('templates/haut')
               . view('menu_administrateur', $data)
               . view('connexion/afficher_detail_scenario')
               . view('templates/bas');

         } else if (!$scenario_exist) {
            $data['scenario_own_info'] = $model->show_scenario_infos($scenario_id);
            $data['error_message'] = "Scenario n'existe pas !";
            return view('templates/haut')
               . view('menu_administrateur', $data)
               . view('connexion/afficher_detail_scenario')
               . view('templates/bas');
         }
      }
   }
   public function afficher_formulaire_creer_scenario()
   {
      $session = session();
      $model = model(Db_model::class);

      if ($session->has('user')) {
         if ($this->request->getMethod() == "post") {
            $validationRules = [
               'intitule' => [
                  'rules' => 'required|min_length[6]|max_length[255]',
                  'errors' => [
                     'required' => 'Le champ intitulé est obligatoire.',
                     'min_length' => 'Intitulé doit avoir au moins 6 caractères.',
                     'max_length' => 'Intitulé pseudo ne doit pas dépasser 255 caractères.',
                  ]
               ],
               'validite' => [
                  'rules' => 'required',
                  'errors' => [
                     'required' => 'Le champ validité est obligatoire.'
                  ]
               ],
               'description' => [
                  'rules' => 'required|min_length[8]|max_length[255]',
                  'errors' => [
                     'required' => 'Le champ description est obligatoire.',
                     'min_length' => 'Description doit avoir au moins 8 caractères.',
                     'max_length' => 'Description ne doit pas dépasser 255 caractères.',
                  ]
               ],
               'fichier' => [
                  'label' => 'Fichier image',
                  'rules' => [
                     'uploaded[fichier]',
                     'is_image[fichier]',
                     'mime_in[fichier,image/jpg,image/jpeg,image/gif,image/png,image/webp]',
                     'max_size[fichier,1024]',
                     'max_dims[fichier,1920,1080]',
                  ],
                  'errors' => [
                     'uploaded' => 'Un fichier image doit être téléchargé.',
                     'is_image' => 'Le fichier doit être une image.',
                     'mime_in' => 'Le fichier doit être au format jpg, jpeg, gif, png ou webp.',
                     'max_size' => 'La taille maximale du fichier doit être de 1MB.',
                     'max_dims' => 'Les dimensions maximales de l’image doivent être de 1920x1080 pixels.'
                  ]
               ]
            ];
            if ($this->validate($validationRules)) {

               $intitule = $this->request->getVar('intitule');
               $description = $this->request->getVar('description');
               $validite = $this->request->getVar('validite');
               $imageFile = $this->request->getFile('fichier');
               if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                  $imageName = $imageFile->getName();
                  $cpt_id = $model->get_id_of_profil($session->get('user'));
                  if ($model->televerserFichier($imageFile, "uploads") && $model->set_scenario($intitule, $description, $validite, $imageName, $cpt_id)) {
                     return redirect()->to('/compte/ajouter_scenario')->with('success', 'Scénario créer avec succés !');
                  }
               }

            }

         }
      }



      return view('templates/haut')
         . view('menu_administrateur')
         . view('connexion/creer_scenario_backend')
         . view('templates/bas');
   }



   public function deconnecter()
   {
      $session = session();
      $session->destroy();
      return redirect()->to(route_to('compte/connecter'));
   }

}