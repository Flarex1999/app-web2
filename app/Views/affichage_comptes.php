<h2><?php echo $titre; ?></h2>
<?php
if (! empty($logins) && is_array($logins))
{
echo("<h6>nombre total des comptes :</h6>");
echo $Nb_total->Nb;  //affichage du nombre total des comptes .

echo("<h6>Le nom des comptes :</h6>");
//boucle qui liste TOUS les cpt_logins
//-----------------------------------
foreach ($logins as $pseudos)
{
echo "<br />";
echo " -- ";
echo $pseudos["cpt_login"];
echo " -- ";
echo "<br />";
}
// ----------------------------------

}
else {
 echo("<h3>Aucun compte pour le moment</h3>");
}
?>