<h3>Les Scenarii</h3><br />


<?php
if (!empty($scenario) && is_array($scenario)) {
    foreach ($scenario as $sce) {
        echo ("<div class='scenario-card'>");

        // Display the scenario image using the full URL
        $imageUrl = base_url('uploads/' . $sce['sce_image']); // Adjust the path as needed
        echo ("<img src='$imageUrl' alt='{$sce['sce_image']}' class='scenario-image'>");

        echo ("<h4>" . $sce['sce_intitule'] . "</h4>");
        echo ("<p>" . $sce['sce_description'] . "</p>");
        echo ("<p> AUTEUR : " . $sce['cpt_login'] . "</p>");



        echo "<p>Niveau : <a href=\"" . site_url("scenario/afficher/{$sce['sce_code']}/1") . "\">facile</a></p>";
        echo "<p>Niveau : <a href=\"" . site_url("scenario/afficher/{$sce['sce_code']}/2") . "\">moyen</a></p>";
        echo "<p>Niveau : <a href=\"" . site_url("scenario/afficher/{$sce['sce_code']}/3") . "\">difficile</a></p>";

        echo ("</div>");
    }
} else {
    echo ("Aucun scénario pour l'instant !");
}
?>












<style>
    .scenario-card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        background-color: #fff;
        display: inline-block;
        width: calc(33.33% - 20px);
        /* Adjust the width as needed */
        transition: transform 0.3s ease;
        /* Add a transition for smooth scaling */
    }

    .scenario-card:hover {
        transform: scale(1.05);
        /* Scale up by 5% on hover */
    }

    .scenario-card h4 {
        font-size: 18px;
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    .scenario-card p {
        font-size: 16px;
        margin-bottom: 5px;
        font-family: Arial, sans-serif;
    }

    .scenario-image {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .image-name {
        font-size: 14px;
        font-weight: bold;
        margin-top: 5px;
    }
</style>