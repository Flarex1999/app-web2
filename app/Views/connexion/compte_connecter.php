<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $titre ?>
    </title>
    <style>
        h2 {
            color: #333;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }

        form {
            background-color: #befac0;
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            justify-content: center;
            align-items: center;

        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input[type="input"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 14px;
        }

        .form-group {
            text-align: left;
        }

        .form-group label {
            margin-bottom: 5px;
        }

        .error-message {
            margin-top: 4px;
        }

        .submit-button {
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
        }

        .submit-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h2>
        <?= $titre ?>
    </h2>
    <div class="error-message">
        <?= session()->getFlashdata('error') ?>
    </div>
    <?php echo form_open('/compte/connecter'); ?>
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="pseudo">Pseudo:</label>
        <input type="input" name="pseudo" value="<?= set_value('pseudo') ?>">
        <span class="error-message">
            <?= validation_show_error('pseudo') ?>
        </span>
    </div>
    <div class="form-group">
        <label for="mdp">Mot de passe:</label>
        <input type="password" name="mdp">
        <span class="error-message">
            <?= validation_show_error('mdp') ?>
        </span>
    </div>
    <button class="submit-button" type="submit" name="submit">Se connecter</button>
    </form>

</body>

</html>