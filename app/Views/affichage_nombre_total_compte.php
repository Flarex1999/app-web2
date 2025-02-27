<h2><?php echo $titre; ?></h2>
<?php
if (isset($Nb_compte)){
        $Nb_compte -> Nb;
    }
    else {
    echo ("Pas de compte !");
    }
?>