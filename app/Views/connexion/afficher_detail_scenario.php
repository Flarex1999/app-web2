<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scenarios Backend</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        tr {
            border-bottom: 1px solid #ccc;
        }

        td {
            padding: 10px;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            padding: 10px;
            text-align: left;
        }

        .item-image {
            max-width: 80px;
            height: auto;
        }

        .small-eye {
            width: 20px;
            height: auto;
        }

        .add-scenario-icon {
            width: 30px;
            height: auto;
        }

        .card {
            background-color: #f2f2f2;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-content {
            margin-bottom: 10px;
        }

        .item-image {
            max-width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php
    $session = session();
    if ($scenario_own_info != null) {
        echo '<div class="card">';
        echo '<div class="card-header">Scenario Details</div>';
        echo '<div class="card-content"><strong>Image:</strong><br><img class="item-image" src="' . base_url('uploads/' . $scenario_own_info->sce_image) . '" alt="Scenario Image"></div>';
        echo '<div class="card-content"><strong>Intitule:</strong> ' . $scenario_own_info->sce_intitule . '</div>';
        echo '<div class="card-content"><strong>Description:</strong> ' . $scenario_own_info->sce_description . '</div>';
        echo '<div class="card-content"><strong>Etat:</strong> ' . $scenario_own_info->sce_active . '</div>';
        echo '<div class="card-content"><strong>Code:</strong> ' . $scenario_own_info->sce_code . '</div>';
        echo '</div>';
    }

    $shouldDisplayTable = false;
    foreach ($scenario_info as $sce_back) {
        if (isset($sce_back['etp_ordre']) && $sce_back['etp_ordre']) {
            $shouldDisplayTable = true;
            break;
        }
    }

    if ($shouldDisplayTable) {
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Etape Intitulé</th>';
        echo '<th>Etape Description</th>';
        echo '<th>Etape Réponse</th>';
        echo '<th>Etape Code</th>';
        echo '<th>Etape Ordre</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($scenario_info as $sce_back) {
            if (isset($sce_back['etp_ordre']) && $sce_back['etp_ordre'] != null) {
                echo '<tr>';

                echo '<td>' . $sce_back['etp_intitule'] . '</td>';
                echo '<td>' . $sce_back['etp_description'] . '</td>';
                echo '<td>' . $sce_back['etp_reponse'] . '</td>';
                echo '<td>' . $sce_back['etp_code'] . '</td>';
                echo '<td>' . $sce_back['etp_ordre'] . '</td>';
                echo '</tr>';
            }
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo $error_message;
    }
    ?>
</body>

</html>