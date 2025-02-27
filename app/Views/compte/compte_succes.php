<!DOCTYPE html>
<html>

<head>
    <title>Compte Succès</title>
    <style>
        .success-message {
            text-align: center;
            background-color: white;
            /* Background color of the message container */
            padding: 10px;
            font-size: 18px;
        }

        .green-text {
            color: darkgreen;
            /* Text color in dark green */
        }

        .back-button {
            text-align: center;
            margin-top: 20px;
        }

        /* Styling for the red button */
        .red-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: red;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .red-button:hover {
            background-color: darkred;
        }
    </style>
</head>

<body>
    <div class="success-message">
        <span class="green-text">Bravo ! Formulaire rempli, le compte suivant a été ajouté :</span><br>
        <?php
        echo $le_compte;
        echo "<br>";
        echo "Nombre de compte : " . $le_total->Nb;
        ?>
    </div>

    <div class="back-button">
        <a class="red-button" href="<?= base_url() ?>">Retour à l'Accueil</a>
    </div>
</body>

</html>