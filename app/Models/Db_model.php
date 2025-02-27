<?php
namespace App\Models;

use CodeIgniter\Model;

class Db_model extends Model
{
    protected $db;
    public function __construct()
    {
        $this->db = db_connect(); //charger la base de données
        // ou
        // $this->db = \Config\Database::connect();
    }

    //fonction que retourne tous les comptes de la base de données
    public function get_all_compte()
    {
        $resultat = $this->db->query("SELECT cpt_login FROM t_compte_cpt;");
        return $resultat->getResultArray();
    }

    /* Fonction membre à ajouter sous le constructeur et get_all_compte() : */
    public function get_actualite($numero)
    {
        $requete = "SELECT * FROM t_news_new WHERE new_id=" . $numero . ";";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }

    /* Fonction qui permet d'afficher le nombre total des comptes*/
    public function get_number_all_compte()
    {
        $requete = "SELECT COUNT(*) as Nb FROM t_compte_cpt;";
        $resultat = $this->db->query($requete);
        return $resultat->getRow();
    }

    //fonction qui insère un compte et un profil dans la base 
    public function set_compte($saisie)
    {
        // Récupération des données du formulaire
        $nom = $saisie['nom'];
        $prenom = $saisie['prenom'];
        $email = $saisie['email'];
        $login = $saisie['pseudo'];
        $role = $saisie['role'];
        $validite = $saisie['validite'];
        $mot_de_passe_avant_traitement = $saisie['mdp'];

        // $sel = 'CeciEstMonSel12345!!';
        //$combinaison = $mot_de_passe_avant_traitement . $sel;


        $mot_de_passe = $mot_de_passe_avant_traitement;
        // Verifier si le cpt_login existe
        $check = "SELECT cpt_login FROM t_compte_cpt WHERE cpt_login = ?";
        $checkresult = $this->db->query($check, [$login]);
        $check2 = "SELECT pfl_email FROM t_profil_pfl WHERE pfl_email = ?";
        $checkresult2 = $this->db->query($check2, [$email]);
        if (count($checkresult->getResult()) === 0 && count($checkresult2->getResult()) === 0) {
            // Insertion de login et mot de passe d'une façon sécurisé (contre injection sql)
            $sql = "INSERT INTO t_compte_cpt (cpt_login, cpt_mdp) VALUES (?, ?)";
            $query = $this->db->query($sql, [$login, $mot_de_passe]);

            // recuperer cpt_id apres insertion
            $cpt_id_query = "SELECT cpt_id FROM t_compte_cpt WHERE cpt_login = ?";
            $cpt_id_result = $this->db->query($cpt_id_query, [$login]);
            $cpt_id_row = $cpt_id_result->getRow();
            $cpt_id = $cpt_id_row->cpt_id;



            // Insertion dans t_profil_pfl
            $sql2 = "INSERT INTO t_profil_pfl (cpt_id, pfl_nom, pfl_prenom, pfl_email, pfl_role, pfl_etat) VALUES (?, ?, ?, ?, ?, ?)";
            $query2 = $this->db->query($sql2, [$cpt_id, $nom, $prenom, $email, $role, $validite]);
            return $query2;

        } else if (count($checkresult->getResult()) > 0) {
            return "Pseudo existe déja !";
        } else if (count($checkresult2->getResult()) > 0) {
            return "Email existe déja !";
        }



    }

    //fonction qui récupère tous les actualitées activées
    public function get_news()
    {
        $requete = "SELECT * FROM t_news_new JOIN t_compte_cpt using(cpt_id) WHERE new_validite = 'A';";
        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();

    }

    //fonction qui recupère l'etat du profil
    public function get_profil_etat($username)
    {
        $sql = "SELECT pfl_etat from t_compte_cpt join t_profil_pfl using(cpt_id) where cpt_login =? ;";
        $resultat = $this->db->query($sql, [$username]);
        $row = $resultat->getRow();

        if ($row) {
            return $row->pfl_etat;
        }
    }

    //fonction qui recupère tous les scenarii activés
    public function get_all_scenarios()
    {
        $requete = "SELECT sce_intitule , sce_description , sce_image , sce_code , cpt_login from t_scenario_sce join t_compte_cpt using(cpt_id) WHERE sce_active = 'A';";
        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();
    }


    //fonction qui récupère la première etape d'un scenario
    public function get_first_etape_code($scenario_code, $niveau_difficulte)
    {
        $requete = "SELECT etp_intitule, etp_description,etp_code, idc_description, idc_hyperlien , sce_code
            FROM t_scenario_sce
            JOIN t_etape_etp USING(sce_id)
            LEFT JOIN t_indice_idc ON t_etape_etp.etp_id = t_indice_idc.etp_id AND idc_difficulte = '" . $niveau_difficulte . "'
            WHERE t_etape_etp.etp_ordre = 1
            AND sce_code = '" . $scenario_code . "';";

        $resultat = $this->db->query($requete);
        return $resultat->getRow();


    }

    //recupère tous le scénarii activés
    public function get_all_scenarios_backend()
    {
        $requete = "SELECT
        cpt_id,
        cpt_login,
        sce_intitule,
        sce_description,
        sce_image,
        sce_code,
        sce_id,
        COUNT(etp_id) AS etp_count
    FROM
        t_scenario_sce
    JOIN
        t_compte_cpt USING (cpt_id)
    LEFT JOIN  -- Changed to LEFT JOIN
        t_etape_etp USING (sce_id)
    WHERE
        sce_active = 'A'
    GROUP BY
        sce_id, cpt_login, sce_intitule, sce_description, sce_image, sce_code;";

        $resultat = $this->db->query($requete);
        return $resultat->getResultArray();
    }



    //fonction qui copie un scénario (pas demandée)
    public function copier_un_scenario($new_user_id, $id_scenario_to_copie)
    {
        $sql = "INSERT INTO t_scenario_sce (sce_intitule, sce_description, sce_active, sce_code, sce_image, cpt_id)
                SELECT sce_intitule, sce_description, sce_active, sce_code, sce_image, '" . $new_user_id . "'
                FROM t_scenario_sce
                WHERE sce_id = '" . $id_scenario_to_copie . "' ;";

        $resultat = $this->db->query($sql);
        if ($resultat) {
            return true;
        }
        return false;

    }

    //fonction qui copie les etapes d'un scénario(pas demandée)
    public function copier_les_etapes_de_scenario($new_scenario_id, $id_scenario_to_copie)
    {
        $sql = "INSERT INTO t_etape_etp (etp_code, etp_intitule, etp_description, etp_reponse, etp_ordre, sce_id, res_id)
        SELECT
        LPAD(FLOOR(RAND() * 99999999), 8, '0') AS etp_code, 
        etp_intitule,
        etp_description,
        etp_reponse,
        etp_ordre,
        '" . $new_scenario_id . "', 
        res_id
        FROM t_etape_etp
        WHERE sce_id = '" . $id_scenario_to_copie . "'";
        $resultat = $this->db->query($sql);
        if ($resultat) {
            return true;
        }
        return false;

    }

    //fonction qui retourne l'id du dernier scenario ( c'est pour copier les etapes du scenario copier (pas demandé))
    public function return_last_scenario_id()
    {
        $sql = "SELECT sce_id from t_scenario_sce order by sce_id desc limit 1";
        $resultat = $this->db->query($sql)->getRow();

        if ($resultat) {
            return $resultat->sce_id;
        } else {
            return null;
        }
    }


    //fonction pour se connecter à un compte
    public function connect_compte($u, $p)
    {
        $sel = 'CeciEstMonSel12345!!';
        $combinaison = $p . $sel;
        $mot_de_passe = hash('sha256', $combinaison);
        $sql = "SELECT cpt_login,cpt_mdp
                    FROM t_compte_cpt
                    WHERE cpt_login=?
                    AND cpt_mdp=?;";
        $resultat = $this->db->query($sql, [$u, $mot_de_passe]);
        if ($resultat->getNumRows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //fonction qui récupère les informations d'un scénario
    public function show_scenario_infos($scenario_id)
    {
        $sql = "SELECT  sce_image , sce_intitule, sce_description, sce_active, sce_code from t_scenario_sce where sce_id = ?";
        $resultat = $this->db->query($sql, [$scenario_id]);
        $row = $resultat->getRow();
        if ($row !== null) {
            return $row;
        } else {
            return null;
        }

    }

    //fonction qui affiche le profil de l'utilisateur connecté
    public function afficher_profil($u)
    {
        $sql = "SELECT pfl_nom , pfl_prenom, pfl_email, pfl_role , pfl_etat FROM t_compte_cpt join t_profil_pfl using(cpt_id) where cpt_login = '" . $u . "';";
        $resultat = $this->db->query($sql);
        return $resultat->getRow();
    }

    //fonction qui retourne le role d'un profil
    public function afficher_status($u)
    {
        $sql = "SELECT pfl_role FROM t_compte_cpt JOIN t_profil_pfl USING(cpt_id) WHERE cpt_login = ?;";
        $resultat = $this->db->query($sql, [$u]);
        $row = $resultat->getRow();

        if ($row) {
            return $row->pfl_role;
        }
    }

    //fonction qui retourn TOUS les profils dans la base
    public function afficher_tableau_profils()
    {
        $sql = "SELECT cpt_id , cpt_login ,pfl_nom, pfl_prenom , pfl_email,pfl_role,pfl_etat from t_compte_cpt join t_profil_pfl using(cpt_id) order by pfl_etat;";
        $resultat = $this->db->query($sql);
        return $resultat->getResultArray();
    }

    //fonction pour modifier le mot de passe d'un profil
    public function modifier_mdp($user, $new_password)
    {
        // verifier si le mot de passe n'est pas vide
        if (empty($new_password)) {
            return false;
        }
        // hashage du mot de passe
        $sel = 'CeciEstMonSel12345!!'; // le sel
        $combinaison = $new_password . $sel;
        $mot_de_passe = hash('sha256', $combinaison);
        $sql = "UPDATE t_compte_cpt SET cpt_mdp = '" . $mot_de_passe . "' where cpt_login = '" . $user . "';";
        $resultat = $this->db->query($sql);
        if ($resultat) {
            // update reussi
            return true;
        } else {
            // update échoué
            return false;
        }
    }

    //fonction qui active/desactive un profil (pas demandée)
    public function changer_etat_profil($value, $id)
    {
        $sql = "UPDATE t_profil_pfl SET pfl_etat = '" . $value . "' where cpt_id = '" . $id . "'";
        $resultat = $this->db->query($sql);
        return $resultat;
    }

    //fonctions qui recupère tous les details d'un scenario (+les etapes)
    public function show_scenario_details($id)
    {
        $sql = "SELECT sce_intitule , sce_description , sce_active , sce_code , sce_image , etp_intitule , etp_description , etp_reponse ,etp_code, etp_ordre from t_scenario_sce left join t_etape_etp using(sce_id) where sce_id = '" . $id . "' ;";
        $resultat = $this->db->query($sql);
        return $resultat->getResultArray();
    }


    //fonction qui supprime les indices des etapes scenario a partir de son id
    public function delete_scenario_indice($id)
    {
        $sql = "DELETE t_indice_idc FROM t_indice_idc 
                JOIN t_etape_etp ON t_indice_idc.etp_id = t_etape_etp.etp_id 
                JOIN t_scenario_sce ON t_etape_etp.sce_id = t_scenario_sce.sce_id 
                WHERE t_scenario_sce.sce_id = ?;";
        $resultat = $this->db->query($sql, [$id]);
        return $resultat;

    }

    //fonction qui supprime les etapes associés à un scenario à partir de son id
    public function delete_scenario_etapes($id)
    {
        $sql = "DELETE FROM t_etape_etp where sce_id = '" . $id . "';";
        $resultat = $this->db->query($sql);
        return $resultat;
    }
    //fonction qui appelle une procedure pour la suppression d'un scénario à partir de son id
    public function delete_scenario($id)
    {
        $sql = "CALL DeleteScenario(?)";
        $result = $this->db->query($sql, [$id]);
        return $result;


    }

    //fonction qui recupère l'id d'un profil ) partir de son login
    public function get_id_of_profil($user)
    {
        $sql = "SELECT cpt_id FROM t_compte_cpt WHERE cpt_login = ?";
        $resultat = $this->db->query($sql, [$user]);

        if ($row = $resultat->getRow()) {
            return $row->cpt_id;
        } else {
            return null;
        }
    }

    //fonction qui recupere tous les comptes .
    public function get_all_users()
    {
        $sql = "SELECT cpt_id from t_compte_cpt";
        $resultat = $this->db->query($sql);
        return $resultat->getResultArray();
    }


    //fonction qui crée un scénario
    public function set_scenario($intitule, $desciption, $validite, $nomFichier, $cpt_id)
    {
        $sce_code = "";
        $sql = "INSERT INTO t_scenario_sce (sce_intitule, sce_description ,sce_active, sce_code, sce_image, cpt_id) VALUES (?, ?, ?, ?, ?,?)";
        $query = $this->db->query($sql, [$intitule, $desciption, $validite, $sce_code, $nomFichier, $cpt_id]);

        return $query;
    }

    //fonction qui televerse une image d'un scénario créé
    public function televerserFichier($fichier, $cheminDestination)
    {
        $nomFichier = $fichier->getName();
        // Déplacez le fichier vers le répertoire de destination
        return $fichier->move($cheminDestination, $nomFichier);
    }

    //fonctions qui vérifie si la réponse de l'utilisateur est la bonne
    public function check_answer_etape($answer, $index)
    {

        $sql = "SELECT etp_reponse FROM t_etape_etp  WHERE etp_reponse = ? and etp_ordre = ? ";
        $resultat = $this->db->query($sql, [$answer, $index]);

        if ($resultat->getNumRows() > 0) {
            return true;
        }
        return false;
    }


    //fonction qui récupère l'ordre d'une etape
    public function index_etape($etp_code)
    {
        $sql = "SELECT etp_ordre from t_etape_etp where etp_code = ?;";
        $resultat = $this->db->query($sql, [$etp_code]);
        $row = $resultat->getRow();
        if ($row !== null && isset($row->etp_ordre)) {
            return (int) $row->etp_ordre;
        }

        return null;
    }

    //fonction qui récupère le nombre total des étapes
    public function count_etape($scenario_code)
    {
        $sql = "SELECT count(*) as nb_etape from t_scenario_sce join t_etape_etp using(sce_id) where sce_code = ?;";
        $resultat = $this->db->query($sql, [$scenario_code]);
        $row = $resultat->getRow();
        if ($row !== null && isset($row->nb_etape)) {
            return (int) $row->nb_etape;
        }

        return null;
    }

    //fonction qui récupère les informations de l'étape suivante
    public function next_etape_data($etape_code, $niveau_difficulte)
    {
        $sql = "SELECT etp_intitule, etp_description, idc_description, idc_hyperlien , etp_code , sce_code
            FROM t_scenario_sce
            JOIN t_etape_etp USING(sce_id)
            LEFT JOIN t_indice_idc ON t_etape_etp.etp_id = t_indice_idc.etp_id AND idc_difficulte = '" . $niveau_difficulte . "'
            WHERE etp_code = '" . $etape_code . "';";
        $resultat = $this->db->query($sql);
        return $resultat->getRow();

    }

    //fonction qui recupère le code de l'étape suivante
    public function get_next_etape_code($index, $scenario_code)
    {
        $sql = "SELECT etp_code
            FROM t_scenario_sce
            JOIN t_etape_etp USING(sce_id)
            LEFT JOIN t_indice_idc ON t_etape_etp.etp_id = t_indice_idc.etp_id
            WHERE t_etape_etp.etp_ordre = '" . $index . "'
            AND sce_code = '" . $scenario_code . "';";
        $resultat = $this->db->query($sql);
        $row = $resultat->getRow();
        if ($row !== null) {
            return $row->etp_code;
        } else {
            return null;
        }
    }

    //fonction qui recupère les informations d'une etape (pas utilisé)
    public function load_etape($niveau_difficulte, $etp_code)
    {
        $sql = "SELECT etp_intitule, etp_description, idc_description, idc_hyperlien , etp_code , sce_code
            FROM  t_scenario_sce join t_etape_etp using(sce_id)
            LEFT JOIN t_indice_idc using(etp_id) where idc_difficulte ='" . $niveau_difficulte . "'
            AND etp_code = '" . $etp_code . "'";
        $resultat = $this->db->query($sql);
        return $resultat->getRow();

    }

    //fonction qui recupère les information de l'étape suivante 
    public function get_the_following_etape($code_scenario, $niv, $index)
    {
        $sql = "SELECT * FROM t_scenario_sce 
            JOIN t_etape_etp USING(sce_id) 
            LEFT JOIN t_indice_idc USING(etp_id) 
            WHERE idc_difficulte = '" . $niv . "' 
            AND sce_code = '" . $code_scenario . "' 
            AND etp_ordre = '" . $index . "';";

        $resultat = $this->db->query($sql);
        return $resultat->getRow();
    }

    //fonction qui récupère le code d'un scénario à partir du code d'un étape assoccié
    public function get_scenario_from_etape_code($etp_code)
    {
        $sql = "SELECT sce_code from t_scenario_sce join t_etape_etp using(sce_id) where etp_code ='" . $etp_code . "';";
        $resultat = $this->db->query($sql);
        $row = $resultat->getRow();
        if ($row !== null) {
            return $row->sce_code;
        } else {
            return null;
        }
    }


    //fonction de vérification de l'existance d'un scénario à partir de son code
    public function check_if_scenario_exists($scenario_code)
    {
        $sql = "SELECT sce_code from t_scenario_sce where sce_code = '" . $scenario_code . "'";
        $resultat = $this->db->query($sql);
        $row = $resultat->getRow();
        if ($row !== null) {
            return true;
        } else {
            return null;
        }
    }

    //fonction qui vérifie si une etape existe
    public function check_if_etape_exists($etape_code)
    {
        $sql = "SELECT etp_code from t_etape_etp where etp_code = '" . $etape_code . "'";
        $resultat = $this->db->query($sql);
        $row = $resultat->getRow();
        if ($row !== null) {
            return true;
        } else {
            return null;
        }
    }

    //fonction qui récupère le nom d'un scénario à partir de son code
    public function get_scenario_name($scenario_code)
    {
        $sql = "SELECT sce_intitule from t_scenario_sce where sce_code = '" . $scenario_code . "'";
        $resultat = $this->db->query($sql);
        $row = $resultat->getRow();
        if ($row !== null) {
            return $row->sce_intitule;
        } else {
            return null;
        }
    }

    //fonction qui vérifie si un participant à déja participé
    public function check_if_exists($email_participant)
    {
        $sql = "SELECT par_adresse FROM t_participant_par where par_adress ='" . $email_participant . "'";
        $resultat = $this->db->query($sql);
        $row = $resultat->getRow();
        if ($row !== null) {
            return $row->par_adresse;
        } else {
            return null;
        }

    }

    //fonction qui insére la première participation d'un participant
    public function inserer_premiere_participation($email_participant)
    {
        $sql = "INSERT INTO t_participant_par(par_adresse) values(?)";
        $resultat = $this->db->query($sql, [$email_participant]);
        return $resultat;


    }

    //la fonction qui insére la première réussite d'un participant dans un scénario
    public function inserer_premiere_reussite($sce_id, $par_id, $niv)
    {
        $sql = "INSERT INTO t_reussite_reu(sce_id,par_id,reu_date_premiere,reu_date_derniere,reu_niveau_reussite) values(?,?,?,?,?);";
        $currentDateTime = date('Y-m-d H:i:s');
        $resultat = $this->db->query($sql, [$sce_id, $par_id, $currentDateTime, $currentDateTime, $niv]);
        return $resultat;

    }

    //la fonction qui mis à jour la date de la nouvelle réussite(participation) d'un participant dans le même scénario
    public function update_nouvelle_reussite($sce_id, $par_id, $niv)
    {
        $currentDateTime = date('Y-m-d H:i:s');
        $sql = "UPDATE t_reussite_reu SET reu_date_derniere = ?, reu_niveau_reussite = ? WHERE sce_id = ? AND par_id = ?";
        $resultat = $this->db->query($sql, [$currentDateTime, $niv, $sce_id, $par_id]);

        return $resultat;
    }

    //fonction qui récupère l'id d'un participant
    public function get_participant_id($email)
    {
        $sql = "SELECT par_id from t_participant_par where par_adresse ='" . $email . "' ";
        $resultat = $this->db->query($sql);
        $row = $resultat->getRow();
        if ($row != null) {
            return $row->par_id;
        } else {
            return null;
        }



    }

    //fonction qui récupère le nom d'un scénario à partir de son id
    public function get_nom_scenario_from_id($id_scenario)
    {
        $sql = "SELECT sce_intitule from t_scenario_sce where sce_id  = ?;";
        $resultat = $this->db->query($sql, [$id_scenario]);
        $row = $resultat->getRow();
        if ($row != null) {
            return $row->sce_intitule;
        } else {
            return false;
        }
    }

    //fonction qui vérifie si un participant a joué un scénario
    public function get_if_participant_played_scenario($scenario_id, $par_id)
    {
        $sql = "SELECT sce_id , par_id from t_reussite_reu where sce_id = ? and par_id = ?";
        $resultat = $this->db->query($sql, [$scenario_id, $par_id]);
        $row = $resultat->getRow();
        if ($row != null) {
            return true;
        } else {
            return false;
        }

    }

    //fonction qui récupère l'id d'un scénario à partir de son code
    public function get_scenario_id_from_code($scenario_code)
    {
        $sql = "SELECT sce_id FROM t_scenario_sce WHERE sce_code = ?";
        $resultat = $this->db->query($sql, [$scenario_code]);
        $row = $resultat->getRow();
        if ($row != null) {
            return (int) $row->sce_id;
        } else {
            return null;
        }
    }

    //fonction qui récupère la dernière date du réussite d'un participant dans un scénario 
    public function get_date_reussite_from_par_id($par_id, $sce_id)
    {
        $sql = "SELECT reu_date_derniere from t_reussite_reu where par_id = ? and sce_id = ?";
        $resultat = $this->db->query($sql, [$par_id, $sce_id]);
        $row = $resultat->getRow();
        if ($row != null) {
            return $row->reu_date_derniere;
        } else {
            return null;
        }
    }
    //fonction qui supprime tous les participations associés à un scénario
    public function delete_reussite_scenario($id_scenario)
    {
        $sql = "DELETE from t_reussite_reu where sce_id =  ? ;";
        $resultat = $this->db->query($sql, [$id_scenario]);
        return $resultat;


    }






}
