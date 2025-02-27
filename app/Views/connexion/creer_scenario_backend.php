<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Form</title>
    <style>
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin: 0 auto;
            display: block;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid transparent;
            border-radius: 4px;
            text-align: center;
        }

        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }

        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Créer un Scénario</h2>

        <!-- Display error message -->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- Display success message -->
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <!-- Start of the form -->
        <?php
        $session = session();
        $user = $session->get("user");
        echo '<form method="post" action="' . site_url('compte/ajouter_scenario') . '" enctype="multipart/form-data">';

        echo '<div class="form-group">';
        echo '<label for="intitule">Intitulé:</label>';
        echo '<input type="text" id="intitule" name="intitule" value="' . set_value('intitule') . '" >';
        echo '</div>';
        echo '<div style="color: red;">';
        echo ' <?= validation_show_error("intitule") ?>';
        echo '</div>';
        echo '<div style="color: red;">';
        echo validation_show_error('intitule');
        echo '</div>';

        echo '<div class="form-group">';
        echo '<label for="description">Description Scénario:</label>';
        echo '<input type="text" id="description" name="description" value="' . set_value('description') . '" >';
        echo '</div>';
        echo '<div style="color: red;">';
        echo validation_show_error('description');
        echo '</div>';


        echo '<div class="form-group">';
        echo '<label for="fichier">Image:</label>';
        echo '<input type="file" id="fichier" name="fichier" >';
        echo '</div>';
        echo '<div style="color: red;">';
        echo validation_show_error('fichier');
        echo '</div>';

        echo '<div class="form-group">';
        echo '<label for="validite">Validité:</label>';
        echo '<select id="validite" name="validite">';
        echo '<option value="A">Activé</option>';
        echo '<option value="D">Désactivé</option>';
        echo '</select>';
        echo '</div>';

        echo '<div class="form-group">';
        echo '<input type="submit" value="Valider">';
        echo '</div>';
        echo '</form>';
        ?>
        <?php if (session()->has('success')): ?>
            <div class="alert alert-success">
                <?= session('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger">
                <?= session('error'); ?>
            </div>
        <?php endif; ?>

    </div>
</body>

</html>