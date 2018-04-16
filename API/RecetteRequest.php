<?php
header("Access-Control-Allow-Origin: *");
$ingr = "";
foreach ($_POST as $key => $v) {
    $ingr = $ingr . $v . "-";
}
$ingr = substr($ingr, 0, -1);
$adresse = "http://www.marmiton.org/recettes/recherche.aspx?type=all&aqt=" . $ingr;
$page = file_get_contents($adresse);
preg_match_all('#(<a  class="recipe-card" href=")(.*)">#', $page, $lien);
preg_match_all('#(<h4 class="recipe-card__title">)(.*)</h4>#', $page, $titre);
$i = 0;

while ($i < count($lien[2])) {
    if (strpos($lien[2][$i], "video/") == false) {
        echo $adresse . "<ul>" . $titre[2][$i] . "<li>" . $lien[2][$i] . "</li></ul>";
    }
    $i += 1;
}
