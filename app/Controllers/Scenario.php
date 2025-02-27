<?php
namespace App\Controllers;

use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;

class Scenario extends BaseController
{
  public function __construct()
  {

    helper('form');
    $this->model = model(Db_model::class);
  }

  public function afficher_sce($code_scenario = null, $niv = 0)
  {
    $model = model(Db_model::class);

    if ($code_scenario == null) {

      $data['scenario'] = $model->get_all_scenarios();
      return view('templates/haut')
        . view('menu_visiteur', $data)
        . view('affichage_scenario')
        . view('templates/bas');


    } else if ($niv == 0) {
      $data['message_pas_etape'] = "Cette information n'existe pas !";
      return view('templates/haut')
        . view('menu_visiteur', $data)
        . view('affichage_etape')
        . view('templates/bas');

    } else if ($niv > 3) {

      $data['message_pas_etape'] = "Ce niveau n'existe pas !";
      return view('templates/haut')
        . view('menu_visiteur', $data)
        . view('affichage_etape')
        . view('templates/bas');

    } else if ($niv != 0) {

      if ($model->check_if_scenario_exists($code_scenario)) {
        $data['niveau'] = $niv;
        $data['next_etape'] = $model->get_the_following_etape($code_scenario, $niv, 2);
        $data['etape'] = $model->get_first_etape_code($code_scenario, $niv);
        $data['message_pas_etape'] = "Pas d'étapes pour ce scénario ! ";
        return view('templates/haut')
          . view('menu_visiteur', $data)
          . view('affichage_etape')
          . view('templates/bas');
      } else {
        $data['message_pas_etape'] = "Ce scénario n'existe pas ! ";
        return view('templates/haut')
          . view('menu_visiteur', $data)
          . view('affichage_etape')
          . view('templates/bas');
      }

    }



  }
  public function next_etape($code_etape = null, $niv = 0)
  {

    $model = model(Db_model::class);

    if ($niv > 3) {
      $data['message_pas_etape'] = "Ce niveau n'existe pas !";
      return view('templates/haut')
        . view('menu_visiteur', $data)
        . view('affichage_etape')
        . view('templates/bas');

    }
    if ($this->request->getMethod() == "post") {

      $reponse = $this->request->getPost('reponse');
      $etp_code = $this->request->getPost('etape_code');
      $code_scenario = $this->request->getPost('scenario_code');
      $currentURL = $this->request->getPost('current_url');
      $niv = $this->request->getPost('niveau');




      $index_of_etape = $model->index_etape($etp_code);
      $index_of_next_etape = 0;
      $nb_etape = $model->count_etape($code_scenario);
      if (is_numeric($index_of_etape)) {
        $index_of_next_etape = $index_of_etape + 1;
      }
      //check si la réponse est la bonne : 
      if ($model->check_answer_etape($reponse, $index_of_etape)) {
        // Si on a fini le jeu
        if ($index_of_next_etape > $nb_etape) {
          //On a fini le jeu
          return redirect()->to(site_url("scenario/finaliser_scenario/{$code_scenario}/{$etp_code}/{$nb_etape}/{$niv}"));
        }
        //On a pas fini les etapes , on passe à l'etape prochaine
        $next_etape_code = $model->get_next_etape_code($index_of_next_etape, $code_scenario);
        return redirect()->to(site_url("scenario/franchir_etape/{$next_etape_code}/{$niv}"));

      } else if ($index_of_etape == 1) {
        return redirect()->to(site_url("scenario/afficher/{$code_scenario}/{$niv}"));
      } else {
        return redirect()->to(site_url("scenario/franchir_etape/{$etp_code}/{$niv}"));

      }

    }
    if ($code_etape != null) {
      $scenario_code = $model->get_scenario_from_etape_code($code_etape);
      if ($niv == 0) {
        $data['message_pas_etape'] = "Cette information n'existe pas ! ";
        return view('templates/haut')
          . view('menu_visiteur', $data)
          . view('affichage_etape')
          . view('templates/bas');
      }
      if (!$model->check_if_etape_exists($code_etape)) {
        $data['message_pas_etape'] = "Cette etape n'existe pas ! ";
        return view('templates/haut')
          . view('menu_visiteur', $data)
          . view('affichage_etape')
          . view('templates/bas');
      }

      $data['niveau'] = $niv;
      $data['etape'] = $model->next_etape_data($code_etape, $niv);
      return view('templates/haut', ['titre' => 'franchir étape'])
        . view('affichage_etape', $data)
        . view('templates/bas');

    } else if ($code_etape == null) {
      if ($niv == 0) {
        return redirect()->to(base_url(''));
      } else {
        if ($niv == 0) {
          $data['message_pas_etape'] = "Cette information n'existe pas ! ";
          return view('templates/haut')
            . view('menu_visiteur', $data)
            . view('affichage_etape')
            . view('templates/bas');
        }
      }

    }

  }


  public function finaliser_scenario($code_scenario = null, $code_etape = null, $nombre_etape = 0, $niv = 0)
  {
    $model = model(Db_model::class);




    if ($this->request->getMethod() == "post") {
      // Redirect if necessary parameters are not provided
      if (
        !$this->validate([

          'email' => 'required|valid_email|max_length[255]'
        ], [

          'email' => [
            'required' => 'Veuillez entrer une adresse email !',
            'valid_email' => 'Veuillez entrer une adresse email valide !',
            'max_length' => 'L\'adresse email ne doit pas dépasser 255 caractères.',
          ]])
      ) {

        $data['scenario_intitule'] = $model->get_scenario_name($code_scenario);
        $data['niveau'] = $niv;
        return view('templates/haut', $data)
          . view('affichage_finalisation_scenario')
          . view('templates/bas');
      }
      $email = $this->request->getPost('email');

      $scenario_id = $model->get_scenario_id_from_code($code_scenario);
      $par_id = $model->get_participant_id($email);
      $if_par_played_scenario = $model->get_if_participant_played_scenario($scenario_id, $par_id);
      if ($par_id != null && $if_par_played_scenario) {
        $model->update_nouvelle_reussite($scenario_id, $par_id, $niv);
        $data['date'] = $model->get_date_reussite_from_par_id($par_id, $scenario_id);
        $data['email'] = $email;
        $data['nom_scenario'] = $model->get_nom_scenario_from_id($scenario_id);
        $data['niveau'] = $niv;
        return view('templates/haut', $data)
          . view('affichage_message_reussite')
          . view('templates/bas');

      } else if ($par_id != null) {
        $model->inserer_premiere_reussite($scenario_id, $par_id, $niv);
        $data['date'] = $model->get_date_reussite_from_par_id($par_id, $scenario_id);
        $data['email'] = $email;
        $data['nom_scenario'] = $model->get_nom_scenario_from_id($scenario_id);
        $data['niveau'] = $niv;
        return view('templates/haut', $data)
          . view('affichage_message_reussite')
          . view('templates/bas');


      }
      $model->inserer_premiere_participation($email);
      $par_id = $model->get_participant_id($email);
      $model->inserer_premiere_reussite($scenario_id, $par_id, $niv);
      $data['date'] = $model->get_date_reussite_from_par_id($par_id, $scenario_id);
      $data['email'] = $email;
      $data['nom_scenario'] = $model->get_nom_scenario_from_id($scenario_id);
      $data['niveau'] = $niv;
      return view('templates/haut', $data)
        . view('affichage_message_reussite')
        . view('templates/bas');

    }
    if ($code_scenario == null || $code_etape == null || $niv <= 0 || $niv > 3 || $nombre_etape <= 0) {
      return redirect()->to('/scenario/afficher');
    }

    // Check if the étape and the scenario exist
    $etape_exist = $model->check_if_etape_exists($code_etape);
    $scenario_exist = $model->check_if_scenario_exists($code_scenario);

    if ($etape_exist && $scenario_exist) {
      // Get the index of the current étape and count the total number of étapes in the scenario
      $etape_index = $model->index_etape($code_etape);
      $nb_etape_scenario = $model->count_etape($code_scenario);

      // Check if the current étape is the last one
      if ($etape_index === $nb_etape_scenario) {
        $data['scenario_intitule'] = $model->get_scenario_name($code_scenario);
        $data['niveau'] = $niv;
        return view('templates/haut', $data)
          . view('affichage_finalisation_scenario')
          . view('templates/bas');
      } else {
        // If not the last étape, redirect
        return redirect()->to('/scenario/afficher');
      }
    } else {
      // If étape or scenario does not exist, redirect
      return redirect()->to('/scenario/afficher');
    }
  }






}






?>