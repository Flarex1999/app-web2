<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scenarios Backend</title>
    <style>
        /* Style for the table */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        /* Style for table rows */
        tr {
            border-bottom: 1px solid #ccc;
        }

        /* Style for table cells */
        td {
            padding: 10px;
            vertical-align: top;
        }

        /* Style for table headers */
        th {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: left;
        }

        /* Style for the item image */
        .item-image {
            max-width: 80px;
            /* Adjust the maximum width as needed */
            height: auto;
        }

        /* Style for the little eye icon */
        .little-eye {
            display: inline-block;
        }

        .small-eye {
            width: 20px;
            /* Adjust the width as needed */
            height: auto;
        }

        .add-scenario-icon {
            width: 30px;
            /* Adjust the width as needed */
            height: auto;
        }
    </style>
</head>

<body>
    <?php
    $session = session();

    if (!empty($scenarios_backend) && is_array($scenarios_backend)) {
        echo '<td>';
        echo '<div class="little-eye">';
        echo '<form method="get" action="' . site_url('/compte/ajouter_scenario') . '">';
        echo '<button class="submit-button" type="submit" name="submit">';
        echo '<img src="' . base_url('uploads/add-scenario.png') . '" alt="Eye Icon" class="small-eye">';
        echo '</button>';
        echo '</form>';
        echo '</div>';
        echo '</td>';
        echo '<br>';
        echo '<br>';

        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Image</th>';
        echo '<th>Intitule</th>';
        echo "<th>Nombre D'étapes</th>";
        echo '<th>Login</th>';
        echo '<th>Visualiser</th>';
        echo '<th>Copier</th>';
        echo '<th>Remise à 0</th>';
        echo '<th>Supprimer</th>';
        echo '<th>Modifier</th>';
        echo '<th>Activer</th>';
        echo '<th>Desactiver</th>';
        echo '<th</th>';


        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $id_user = $session->get('user');



        foreach ($scenarios_backend as $sce_back) {
            if ($sce_back['cpt_login'] == $session->get('user')) {
                $nb_etape;
                if ($sce_back['etp_count'] == 0) {
                    $nb_etape = "Aucune étape !";
                } else {
                    $nb_etape = $sce_back['etp_count'];
                }
                echo '<tr style="background-color: #cefad0;">';
                echo '<td>';
                echo '<img class="item-image" src="' . base_url('uploads/' . $sce_back['sce_image']) . '" alt="Scenario Image">';
                echo '</td>';
                echo '<td>';
                echo $sce_back['sce_intitule'];
                echo '</td>';
                echo '<td>';
                echo $nb_etape;
                echo '</td>';
                echo '<td>';
                echo $sce_back['cpt_login'];
                echo '</td>';

                echo '<td>';
                echo '<div class="little-eye">';
                echo '<form method="post" action="' . site_url('/compte/afficher_les_details_scenario/' . $sce_back['sce_code']) . '" target="_blank">';
                echo '<input type="hidden" name="scenario_id" value="' . $sce_back['sce_id'] . '">';
                echo '<input type="hidden" name="scenario_code" value="' . $sce_back['sce_code'] . '">';
                echo '<button class="submit-button" type="submit" name="submit">';
                echo '<img src="' . base_url('uploads/little-eye.png') . '" alt="Eye Icon" class="small-eye">';
                echo '</button>';
                echo '</form>';
                echo '</div>';
                echo '</td>';

                echo '<td>';
                //pas de bouton creer 
                echo '</td>';

                echo '<td>';
                echo '<div class="little-eye">';

                echo '<input type="hidden" name="scenario_id" value="' . $sce_back['sce_id'] . '">';
                echo '<button class="submit-button" type="submit" name="submit">';
                echo '<img src="' . base_url('uploads/remise0.png') . '" alt="Eye Icon" class="small-eye">';
                echo '</button>';
                echo '</form>';
                echo '</div>';
                echo '</td>';

                echo '<td>';
                echo '<div class="little-eye">';
                echo '<form method="post" action="' . site_url('compte/supprimer_scenario') . '" onsubmit="return confirmDeletion();">';
                echo '<input type="hidden" name="scenario_id" value="' . $sce_back['sce_id'] . '">';
                echo '<button class="submit-button" type="submit" name="submit">';
                echo '<img src="' . base_url('uploads/trash.png') . '" alt="Eye Icon" class="small-eye">';
                echo '</button>';
                echo '</form>';
                echo '</div>';
                echo '</td>';
                echo '<script>';
                echo 'function confirmDeletion() {';
                echo '    return confirm("Êtes-vous sûr de vouloir supprimer ' . addslashes($sce_back['sce_intitule']) . ' de ' . $sce_back['cpt_login'] . ', les étapes associées et les participations ?");';
                echo '}';
                echo '</script>';


                echo '<td>';
                echo '<div class="little-eye">';
                echo '<input type="hidden" name="scenario_id" value="' . $sce_back['sce_id'] . '">';
                echo '<button class="submit-button" type="submit" name="submit">';
                echo '<img src="' . base_url('uploads/edit.png') . '" alt="Eye Icon" class="small-eye">';
                echo '</button>';
                echo '</form>';
                echo '</div>';
                echo '</td>';

                echo '<td>';
                echo '<div class="little-eye">';
                echo '<input type="hidden" name="scenario_id" value="' . $sce_back['sce_id'] . '">';
                echo '<button class="submit-button" type="submit" name="submit">';
                echo '<img src="' . base_url('uploads/turn-on.png') . '" alt="Eye Icon" class="small-eye">';
                echo '</button>';
                echo '</form>';
                echo '</div>';
                echo '</td>';

                echo '<td>';
                echo '<div class="little-eye">';
                echo '<input type="hidden" name="scenario_id" value="' . $sce_back['sce_id'] . '">';
                echo '<button class="submit-button" type="submit" name="submit">';
                echo '<img src="' . base_url('uploads/turn-off.png') . '" alt="Eye Icon" class="small-eye">';
                echo '</button>';
                echo '</form>';
                echo '</div>';
                echo '</td>';







            }


            echo '</tr>';
        }

        foreach ($scenarios_backend as $sce_back) {
            if ($sce_back['cpt_login'] != $session->get('user')) {
                $nb_etape;
                if ($sce_back['etp_count'] == 0) {
                    $nb_etape = "Aucune étape !";
                } else {
                    $nb_etape = $sce_back['etp_count'];
                }
                echo '<tr>';
                echo '<td>';
                echo '<img class="item-image" src="' . base_url('uploads/' . $sce_back['sce_image']) . '" alt="Scenario Image">';
                echo '</td>';
                echo '<td>';
                echo $sce_back['sce_intitule'];
                echo '</td>';
                echo '<td>';
                echo $nb_etape;
                echo '</td>';
                echo '<td>';
                echo $sce_back['cpt_login'];
                echo '</td>';
                echo '<td>';
                echo '<div class="little-eye">';
                echo '<form method="post" action="' . site_url('/compte/afficher_les_details_scenario/' . $sce_back['sce_code']) . '" target="_blank">';
                echo '<input type="hidden" name="scenario_id" value="' . $sce_back['sce_id'] . '">';
                echo '<input type="hidden" name="scenario_code" value="' . $sce_back['sce_code'] . '">';
                echo '<button class="submit-button" type="submit" name="submit">';
                echo '<img src="' . base_url('uploads/little-eye.png') . '" alt="Eye Icon" class="small-eye">';
                echo '</button>';
                echo '</form>';
                echo '</div>';
                echo '</td>';

                echo '<td>';
                echo '<div class="little-eye">';
                echo '<form method="post" action="' . site_url('compte/copier_le_scenario_et_ces_etapes') . '">';
                echo '<input type="hidden" name="scenario_id" value="' . $sce_back['sce_id'] . '">';
                echo '<input type="hidden" name="id_user" value="' . $id_user . '">';
                echo '<button class="submit-button" type="submit" name="submit">';
                echo '<img src="' . base_url('uploads/copy-icon.png') . '" alt="Eye Icon" class="small-eye">';
                echo '</button>';
                echo '</form>';
                echo '</div>';
                echo '</td>';



            }



            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'Pas de scénario pour le moment ! ';
    }
    ?>
</body>

</html>