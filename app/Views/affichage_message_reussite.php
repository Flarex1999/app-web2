<?php
// Example values - replace these with actual data from your application
$user_email = $email;
$scenario_name = $nom_scenario;
$level = $niveau;
$date_de_reussite = $date;
echo '<div style="color: green;">Vos informations ont été enregistrées, bon jeu !</div>';

echo '<div>';
echo '<p>Email de l\'utilisateur : ' . $user_email . '</p>';
echo '<p>Scénario gagné : ' . $scenario_name . '</p>';
echo '<p>Niveau : ' . $level . '</p>';
echo '<p>Date et Heure : ' . $date_de_reussite . '</p>';

echo '</div>';
echo '<a href="https://obiwan.univ-brest.fr/~e22009459/index.php/scenario/afficher" class="button">Retour aux scénarios</a>';

?>

<style>
    .button {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 0;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }

    .button:hover {
        background-color: #45a049;
    }
</style>