<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            background-color: #fff;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            color: #333;
            text-align: left;
            /* Center text */
        }

        h2 {
            color: #0021c7;
            text-align: center;
            /* Center text */
        }

        .profile-item {
            margin-bottom: 10px;

        }

        .profile-id {
            margin-bottom: 10px;
            color: #ff9866;
        }

        .state {
            margin-bottom: 10px;
            color: #039f3d;
        }

        label {
            font-weight: bold;
        }

        .password-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        .confirm-button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;

        }

        .annuler-button {
            background-color: #FF0000;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;

        }



        .success-message {
            color: #4caf50;
            font-weight: bold;
            margin-top: 10px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .character-limit {
            color: #888;
            /* Grey color */
            font-size: 12px;
            /* Small font size */
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <?php
        $session = session();
        if ($afficher_pro->pfl_role == 'A') {
            $role = "Administrateur";
        } else {
            $role = "Organisateur";
        }
        echo "<h2>" . $role . "</h2>";
        if ($afficher_pro->pfl_etat == "A") {
            $etat = "Activé";
        } else {
            $etat = "Désactivé";
        }
        //if($afficher_pro->)
        echo "<div class='profile-item'><label class='profile-id'>Nom:</label> " . $afficher_pro->pfl_nom . '</div>';
        echo "<div class='profile-item'><label class='profile-id'>Prenom:</label> " . $afficher_pro->pfl_prenom . '</div>';
        echo "<div class='profile-item'><label class='profile-id'>Email:</label> " . $afficher_pro->pfl_email . '</div>';
        echo "<div class='profile-item'><label class='profile-id'>Role:</label> " . $role . '</div>';
        echo "<div class='state'><label class='profile-id'>Etat:</label> " . $etat . '</div>';
        ?>
        <!-- Password modification section -->
        <?php echo form_open('/compte/modifierMotDePasse'); ?>
        <div class='profile-item'>
            <label for="new_password">Nouveau mot de passe :</label>
            <div class="character-limit">- 8 caractères minimum !</div>
            <input type="password" class="password-input" name="new_password" id="new_password">
            <div style="color: red;">
                <?= validation_show_error('new_password') ?>
            </div>
        </div>
        <div class='profile-item'>
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" class="password-input" name="confirm_password" id="confirm_password">
            <div style="color: red;">
                <?= validation_show_error('confirm_password') ?>
            </div>
        </div>
        <div class='profile-item'>
            <button class="confirm-button" type="submit">Modifier le mot de passe</button>
        </div>
        <?php echo form_close(); ?>
        <?php
        echo "<form action='" . site_url('compte/afficher_profil') . "' method='get'>";
        echo "<div class='profile-item'>";
        echo "<button class='annuler-button' type='submit'>Annuler</button>";
        echo "</div>";
        echo "</form>";
        ?>

        <!-- Display success message -->
        <?php if (session()->has('success_message')): ?>
            <div class="profile-item success-message">
                <?= session()->getFlashdata('success_message') ?>
            </div>
        <?php endif; ?>

        <!-- Display error message -->
        <?php if (session()->has('error_message')): ?>
            <div class="profile-item error-message">
                <?= session()->getFlashdata('error_message') ?>
            </div>
        <?php endif; ?>




    </div>

</body>

</html>