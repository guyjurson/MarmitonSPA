<?php
header("Access-Control-Allow-Origin: *");
//echo "test";
$ingr="";
foreach ($_POST as $key => $v) {
  $ingr= $ingr.$v."-";
}
$ingr=substr($ingr, 0, -1);

//$ingr=$_GET['aqt'];
 
$adresse = "http://www.marmiton.org/recettes/recherche.aspx?type=all&aqt=".$ingr;
$page = file_get_contents ($adresse);
 
preg_match_all('#(<a  class="recipe-card" href=")(.*)">#', $page, $lien);

preg_match_all('#(<h4 class="recipe-card__title">)(.*)</h4>#', $page, $titre);
 
/*var_dump($lien[2]); // Le var_dump() du tableau $prix nous montre que $prix[0] contient l'ensemble du morceau trouvé et que $prix[1] contient le contenu de la parenthèse capturante
var_dump($titre[2]);*/

$i=0;



while ($i<count($lien[2])){
	if(strpos($lien[2][$i], "video/")==false){
		echo $adresse."<ul>".$titre[2][$i]."<li>".$lien[2][$i]."</li></ul>";
	}
	$i+=1;
}



//
