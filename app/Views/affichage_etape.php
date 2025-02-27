<?php
if (isset($etape)) {

  $current_url = current_url();
  $action_url = site_url('scenario/franchir_etape');
  echo '<form method="post" action="' . $action_url . '" enctype="multipart/form-data">';
  echo "<p style='font-weight: bold; font-size: 20px;'>" . $etape->etp_intitule . "</p>";

  echo "<div style='margin: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;'>
        <h2 style='color: #333; font-family: Arial, sans-serif;'>QUESTION:</h2>
        <p style='font-size: 16px; color: #555; font-family: Arial, sans-serif; line-height: 1.5;'>
            " . $etape->etp_description . "
        </p>
      </div>";



  if ($etape->idc_hyperlien == null) {
    echo "<p style='font-size: 16px; color: #ff6c6c; font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif;'>Pas d'indice !</p>";
  } else {
    echo "<div style='padding: 15px; background-color: #eef2f7; border-left: 4px solid #5b9bd5; margin-bottom: 20px;'>
        <p style='font-size: 16px; color: #4a4a4a; font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif;'>
            " . $etape->idc_description . "
        </p>
      </div>";
    echo "<a href='" . $etape->idc_hyperlien . "' target='_blank' style='font-size: 16px; color: #337ab7; text-decoration: none; font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif; padding: 8px 15px; background-color: #f5f5f5; border: 1px solid #ddd; border-radius: 4px; display: inline-block; margin-top: 10px;'>
            Accéder au lien
          </a>";
  }

  echo "<br>";
  echo "<br>";
  echo "<input type='text' name='reponse' placeholder='Votre Réponse'>";
  echo '<div class="form-group">';
  echo '<input type="hidden" name="etape_code" value="' . $etape->etp_code . '">';
  echo '<input type="hidden" name="scenario_code" value="' . $etape->sce_code . '">';
  echo '<input type="hidden" name="current_url" value="' . $current_url . '">';
  echo '<input type="hidden" name="niveau" value="' . $niveau . '">';


  echo '<input type="hidden" name="niveau_difficulte" value="1">';
  echo '<button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; transition: background-color 0.3s ease;">
        Envoyez
      </button>';
  echo '</div>';
  echo '</form>';

} else {
  echo "<span style='color: red;'>" . $message_pas_etape . "</span>";

}
?>