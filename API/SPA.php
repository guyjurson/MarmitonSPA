<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Max-age: 3600");

 $ingr="";
foreach ($_POST as $key => $v) {
  $ingr= $ingr.$v."-";
}
$ingr=substr($ingr, 0, -1);

$adresse = "http://www.marmiton.org/recettes/recherche.aspx?type=all&aqt=".$ingr;
//$adresse = "http://www.marmiton.org/recettes/recherche.aspx?type=all&aqt=pomme-poire";

$page = file_get_contents ($adresse);

preg_match_all('#(<a  class="recipe-card" href=")(.*)">#', $page, $lien);

preg_match_all('#(<h4 class="recipe-card__title">)(.*)</h4>#', $page, $titre);


$reponse=array();
$i=0;
while ($i<count($lien[2])){
	if(strpos($lien[2][$i], "recettes/")){
    $resp=array();
    $resp['titre'] = $titre[2][$i];

    $resp['info'] = infoRequest($lien[2][$i]);

    $response[]=$resp;
    //echo $lien[2][$i];

    // <button ng-click="bool=!bool" ng-hide="!bool">Moins</button>
    //  <button ng-click="bool=!bool" ng-show="!bool">Plus</button>

	}
	$i+=1;
}

echo json_encode($response);


function infoRequest($ad){

    $adresse1 = "http://www.marmiton.org/".$ad;
    //echo '<BR><BR>'.$adresse1.'<BR><BR>';

    $cacheKey = md5($adresse1);
    $page1 = null;

    if (file_exists('/tmp/' . $cacheKey)) {
      $page1 = unserialize(file_get_contents('/tmp/' . $cacheKey));
    } else {
      $page1 = file_get_contents ($adresse1);
      file_put_contents('/tmp/' . $cacheKey, serialize($page1));
    }


    //Titre
    preg_match_all('#(<h1 class="main-title ">)(.*)(</h1>)#', $page1, $titre);
    //Temps de préparation
    preg_match_all('#(class="title-2 recipe-infos__total-time__value">)(.*)</span>#', $page1, $temps);
    //Difficulté
    preg_match_all('#(class="recipe-infos__item-title">)(.*)</span>#', $page1, $dif);
    //Nombre de personne
    preg_match_all('#(class="title-2 recipe-infos__quantity__value">)(.*)</span>#', $page1, $nbPer);
    //Quantité ingredient
    preg_match_all('#(<span class="recipe-ingredient-qt" data-base-qt=")(.*)(">)#', $page1, $qua);
    //Ingredient
    preg_match_all('#(<span class="ingredient">)(.*)</span><span#', $page1, $ing);
    //Recette
    preg_match_all('#(<h3 class="__secondary">)(.*)(</h3>)(.*)(</li>)#', $page1, $rec);
    $r1 = array();
    $r1['nbP'] = $nbPer[2][0];

    $resultat ="";
    //$resultat=$resultat."Pour faire ".$titre[2][0]." pour ".$nbPer[2][0]." personnes, il vous faut:";
    $j=0;
    $r2=array();
    while ($j<count($qua[2])-3){
        $r2[]=[
          "q" =>$qua[2][$j],
          "ing" => $ing[2][$j]
        ];
        //$resultat=$resultat."<li>".$qua[2][$j]." ".$ing[2][$j]."</li>";
        $j+=1;
    }
    $r1['recette']= $r2;
    $r1['prep']= $temps[2][0];
    $r1['dif']= $dif[2][2];
    $r1['cout']=$dif[2][3];
    //$resultat=$resultat."</br></br>Le temps de préparation est de ".$temps[2][0].".</br>
    //La difficulté est ".$dif[2][2]." et la coût est ".$dif[2][3].".</br>";

    //$resultat=$resultat."Pour effectuer cette recette, vous devez:";
    $r3=array();
    $j=0;
    $tmp ="";
    while ($j<count($rec[2])){
      $tmp = strip_tags($rec[4][$j]);
      //$tmp = str_replace("", "\t", $tmp);
      $tmp = substr($tmp, 3, -2);
        $r3[]=[
          "title"=>"Etape ".$j,
          "desc" =>$tmp];
        //$resultat=$resultat."<li>".$rec[2][$j].": ".strip_tags($rec[4][$j])."</li>";
        $j+=1;
    }
    $r1['etapes'] = $r3;
    //echo $resultat;
    return $r1;
}

//
