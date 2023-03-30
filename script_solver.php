
<?php
$myfile = fopen("data_glpk.dat", "w") or die("Unable to open file!");
$g = $usernb;
$njeux = $gamenb;
$qttjeux = $gamequantity;
$voeux = $wish;
$contraintes = $constraints;



//début fichier data
$txt1 = "data;

param v : ";
for ($i = 1; $i <= $njeux; $i++) {
    $txt1 = $txt1 . strval($i) . " ";
}

$txt1 = $txt1 . ":=
    ";

for ($i = 0; $i < $g * $njeux; $i++) {
    if ($voeux[$i] == 0) {
        $voeux[$i] = -1;
    }
}

for ($i = 0; $i < $g; $i++) {
    $txt1 = $txt1 . strval($i + 1);
    for ($j = 0; $j < $njeux; $j++) {
        $txt1 = $txt1 . " " . strval($voeux[$i * $njeux + $j]) . " ";
    }
    $txt1 = $txt1 . "
    ";
}

$txt1 = $txt1 . ";

param g := " . $g . ";

param njeux := " . $njeux . ";

param qttjeux := ";

for ($i = 1; $i <= $njeux; $i++) {
    $txt1 = $txt1 . "
    " . strval($i) . " " . strval($qttjeux[$i]);
}

$txt1 = $txt1 . ";
end;";
//fin fichier data


fwrite($myfile, $txt1);
fclose($myfile);

$txt = "";


//Début du script
$beginning_script = fopen("script_glpk_1-1.txt", "r") or die("Unable to open file!");
while ($line = fgets($beginning_script)) {
    $txt = $txt . $line;
}
fclose($beginning_script);

//ajout des contraintes
$a = 10;
foreach ($contraintes as $contrainte) {
    $txt = $txt . "s.t. c" . strval($a) . " : x[" . $contrainte->user_id . "," . $contrainte->game_id . "] == 1;
";
    $a = $a + 1;
}






//On modifie Voeux[] pour que les contraintes soient considérées comme des voeux
foreach ($contraintes as $contrainte) {
    $user = $contrainte->user_id;
    $game = $contrainte->game_id;
    $voeux[($user - 1) * $njeux + $game - 1] == 1;
}


//on contraint tout
// foreach ($voeux as $voeu) {
//     $user=$contrainte->user_id;
//     $game=$contrainte->game_id;
// 	$voeux[$user*$njeux+$game]==1;
// }




/*
$b=1;
for($i=0; $i<$njeux; $i++) {
	


for ($i = 1; $i <= $njeux; $i++) {
    $txt1 = $txt1 . "
    " . strval($i) . " " . strval($qttjeux[$i]);
	
}
*/

for ($j = 1; $j <= $njeux; $j++) {
    $txt1 = $txt1 . "
    " . strval($j) . " " . strval($qttjeux[$j]);
}





//Fin du script
$finnish_script = fopen("script_glpk_2-1.txt", "r") or die("Unable to open file!");
while ($line = fgets($finnish_script)) {
    $txt = $txt . $line;
}
fclose($finnish_script);


//Ecriture script_glpk.mod
$myfile = fopen("script_glpk.mod", "w") or die("Unable to open file!");
fwrite($myfile, $txt);
fclose($myfile);



$results = shell_exec('glpsol --model script_glpk.mod --data data_glpk.dat');
//echo "<pre>" . $results . "</pre>";

$attribution = [];
$tok = strtok($results, "@");
while ($tok !== false) {
    $attribution[] = $tok;
    $tok = strtok("@");
}
unset($attribution[0]);
$element = "Model has been successfully processed\n";
unset($attribution[array_search($element, $attribution)]);

//echo json_encode($attribution), "\n";
