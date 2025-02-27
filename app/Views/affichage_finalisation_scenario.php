<?php
// Assuming $scenario_intitule and $niveau are defined and hold the necessary values
$current_url = current_url();

$action_url = site_url('scenario/finaliser_scenario');
echo '<form method="post" action="' . $current_url . '" enctype="multipart/form-data">';
echo session()->getFlashdata('error');
echo form_open('scenario/finaliser_scenario');
echo '<div class="congratulations-message">';
echo '<p>Félicitation, vous avez réussi le scénario "' . $scenario_intitule . '" niveau ' . $niveau . '!</p>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="email">Email:</label>';
echo '<input  name="email">';
echo '</div>';
echo '<div style="color: red;">';
echo validation_show_error('email');
echo '</div>';


echo '<div class="form-group">';
echo '<button type="submit" style="background-color: green; color: white;">Envoyer</button>';
echo '</div>';
echo '</form>';
?>