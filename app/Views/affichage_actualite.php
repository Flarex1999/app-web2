<h1><?php echo $titre;?></h1><br />
<?php
if (isset($news)){
echo $news->new_id;
echo(" -- ");
echo $news->new_intitule;
}
else {
echo ("Pas d'actualité !");
}
?>