<?php
$ad=$_GET['adr'];
 
$adresse = "http://www.marmiton.org/recettes/".$ad;
$page = file_get_contents ($adresse);

//Titre
preg_match_all('#(<h1 class="main-title ">)(.*)(</h1>)#', $page, $titre);
//Temps de préparation
preg_match_all('#(class="title-2 recipe-infos__total-time__value">)(.*)</span>#', $page, $temps);
//Difficulté
preg_match_all('#(class="recipe-infos__item-title">)(.*)</span>#', $page, $dif);
//Nombre de personne
preg_match_all('#(class="title-2 recipe-infos__quantity__value">)(.*)</span>#', $page, $nbPer);
//Quantité ingredient
preg_match_all('#(<span class="recipe-ingredient-qt" data-base-qt=")(.*)(">)#', $page, $qua);
//Ingredient
preg_match_all('#(<span class="ingredient">)(.*)</span><span#', $page, $ing);
//Recette
preg_match_all('#(<h3 class="__secondary">)(.*)(</h3>)(.*)(</li>)#', $page, $rec);


echo "Pour faire ".$titre[2][0]." pour ".$nbPer[2][0]." personnes, il vous faut:";
$i=0;
while ($i<count($qua[2])-3){
	echo "<li>".$qua[2][$i]." ".$ing[2][$i]."</li>";
	$i+=1;
}
echo "</br></br>Le temps de préparation est de ".$temps[2][0].".</br> 
La difficulté est ".$dif[2][2]." et la coût est ".$dif[2][3].".</br>";

echo "Pour effectuer cette recette, vous devez:";
$i=0;
while ($i<count($rec[2])){
	echo "<li>".$rec[2][$i].": ".strip_tags($rec[4][$i])."</li>";
	$i+=1;
}


