<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>

    </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }

        form {
            background-color: #ffffff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .select-container {
            position: relative;
        }

        /* Style for the select input */
        .select-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
            appearance: none;
            /* Remove default styles (e.g., arrow) */
        }

        /* Style for the select arrow */
        .select-arrow {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
            border-style: solid;
            border-width: 5px 5px 0;
            border-color: #888 transparent transparent transparent;
        }


        .error-message {
            color: red;
            font-weight: bold;
            background-color: #F8FF00;
            font-size: 1.2em;
        }

        .success-message {
            background-color: #0F3D11;
            color: greenyellow;
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>

<body>

    <div class="error-message">
        <?= session()->getFlashdata('error') ?>
    </div>
    <div class="success-message">
        <?= session()->getFlashdata('success') ?>
    </div>

    <?php echo form_open('/compte/creer_compte_backend'); ?>
    <?= csrf_field() ?>

    <label for="nom">Nom :</label>
    <input type="text" name='nom'>
    <span class="error-message">
        <?= validation_show_error('nom') ?>
    </span>

    <label for="prenom">Prénom :</label>
    <input type="text" name='prenom'>
    <span class="error-message">
        <?= validation_show_error('prenom') ?>
    </span>

    <label for="email">Email :</label>
    <input type="text" name='email'>
    <span class="error-message">
        <?= validation_show_error('email') ?>
    </span>

    <label for="pseudo">Pseudo :</label>
    <input type="text" name='pseudo'>
    <span class="error-message">
        <?= validation_show_error('pseudo') ?>
    </span>

    <label for="mdp">Mot de passe :</label>
    <input type="password" name='mdp'>
    <span class="error-message">
        <?= validation_show_error('mdp') ?>
    </span>

    <label for="confirmation_mdp">Confirmation de Mot de passe :</label>
    <input type="password" name='confirmation_mdp'>
    <span class="error-message">
        <?= validation_show_error('confirmation_mdp') ?>
    </span>

    <label for="role">Rôle :</label>
    <div class="select-container">
        <select id="role" name="role">
            <option value="A">Administrateur</option>
            <option value="O">Organisateur</option>
        </select>
        <span class="select-arrow"></span>
    </div>
    <span class="error-message">
        <?= validation_show_error('role') ?>
    </span>

    <label for="validite">Validité :</label>
    <div class="select-container">
        <select id="validite" name="validite">
            <option value="A">Activé</option>
            <option value="D">Désactivé</option>
        </select>
        <span class="select-arrow"></span>
    </div>
    <span class="error-message">
        <?= validation_show_error('role') ?>
    </span>

    <input type="submit" name="submit" value="Créer un nouveau compte">


    </form>
</body>

</html>