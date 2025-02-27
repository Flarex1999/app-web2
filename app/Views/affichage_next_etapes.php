<?php
if(isset($etape)) {
    $current_url = current_url();
    $action_url = site_url('scenario/franchir_etape');
    echo '<form method="post" action="'.$action_url.'" enctype="multipart/form-data">';
    echo "<p style='font-weight: bold; font-size: 20px;'>".$etape->etp_intitule."</p>";
    echo "<p style='font-size: 16px;'>".$etape->etp_description."</p>";
    echo "<p style='font-size: 16px;'>".$etape->idc_description."</p>";
    echo "<a href='".$etape->idc_hyperlien."' target='_blank'>".$etape->idc_hyperlien."</a>";
    echo "<br>";
    echo "<input type='text' name='reponse' placeholder='Votre Réponse'>";
    echo '<div class="form-group">';
    echo '<input type="hidden" name="etape_code" value="'.$etape->etp_code.'">';
    echo '<input type="hidden" name="scenario_code" value="'.$etape->sce_code.'">';
    echo '<input type="hidden" name="current_url" value="'.$current_url.'">';

    echo '<input type="hidden" name="niveau_difficulte" value="1">';
    echo '<button type="submit" style="background-color: green; color: white;">Envoyez</button>';
    echo '</div>';
    echo '</form>';

} else {
    echo "ana hna  !";
}
?>