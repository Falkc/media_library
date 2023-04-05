<?php
$myfile = fopen("data_glpk.dat", "w") or die("Unable to open file!");
$g = $usernb;
$njeux = $gamenb;
$qttjeux = $gamequantity;
$voeux = $wish;

$txt1 = "data;

param v : ";
for ($i = 1; $i <= $njeux; $i++) {
	$txt1 = $txt1 . strval($i) . " ";
}
$txt1 = $txt1 . ":=
	";

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
fwrite($myfile, $txt1);
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
