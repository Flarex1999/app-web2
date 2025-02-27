<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Privé</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
        }

        .green-text {
            color: #018228;
        }

        .red-text {
            color: #ff0000;
        }

        .black-text {
            color: #000000;
        }
    </style>
</head>

<body>
    <h2>Espace Privé</h2>
    <h2 class="green-text">Session ouverte !<span class="red-text">
            <?php
            echo "<h2 class='black-text'>Bienvenue : <span class='red-text'>";
            ;
            $session = session();
            echo $session->get('user');
            ?>
        </span> !
    </h2>
</body>

</html>