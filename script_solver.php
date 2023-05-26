<?php
//nombre d'exemplaires des jeux
for ($i = 0; $i < $gamenb; $i++) {
    $gamequantity[$i] = intval($gamequantity[$i]);
}

//initialisation tableau d'attribution
$attribution = [];
for ($i = 0; $i < $gamenb * $usernb; $i++) {
    $attribution[$i] = "x";
}
//nombre de valeur a remplacer dans le tableau
$nbVal = ($gamenb) * ($usernb);

//nombre de voeux de chaques personne
$nbWish = [];
for ($i = 0; $i < $usernb; $i++) {
    $nbWish[$i] = 0;
}
for ($i = 0; $i < $usernb; $i++) {
    for ($j = 0; $j < $gamenb; $j++) {
        if ($wish[$i * $gamenb + $j] == 1) {
            $nbWish[$i]++;
        }
    }
}

//nombre de voeux par colonnes
$nbWishCol = [];
for ($j = 0; $j < $gamenb; $j++) {
    $nbWishCol[$j] = 0;
    for ($i = 0; $i < $usernb; $i++) {
        if ($wish[$i * $gamenb + $j] == 1) {
            $nbWishCol[$j]++;
        }
    }
}

//espérance lignes
$rowEsperance = [];
for ($i = 0; $i < $usernb; $i++) {
    $sumCol = 0;
    for ($j = 0; $j < $gamenb; $j++) {
        if ($wish[$i * $gamenb + $j] == 1) {
            if ($nbWishCol[$j] != 0) {
                if ($nbWishCol[$j] <= $gamequantity[$j]) {
                    $sumCol++;
                } else {
                    $sumCol = $sumCol + $gamequantity[$j] / $nbWishCol[$j];
                }
            }
        }
    }
    $rowEsperance[$i] = 1000 * round(100 * $sumCol);
}

//on s'assure qu'il n'y ai pas 2 espérances identiques
for ($i = 1; $i < $usernb; $i++) {
    $rowEsperance[$i] = $rowEsperance[$i] + $i;
}

//espérance colonnes
$columnEsperance = [];
for ($j = 0; $j < $gamenb; $j++) {
    if ($nbWishCol[$j] != 0) {
        if ($nbWishCol[$j] <= $gamequantity[$j]) {
            $columnEsperance[$j] = 1;
        } else {
            $columnEsperance[$j] = $gamequantity[$j] / $nbWishCol[$j];
        }
    } else {
        $columnEsperance[$j] = 0;
    }
}
for ($j = 0; $j < $gamenb; $j++) {
    $columnEsperance[$j] = 1000 * intval(round(100 * $columnEsperance[$j]));
}

//on s'assure qu'il n'y ai pas 2 espérances identiques
for ($j = 1; $j < $gamenb; $j++) {
    $columnEsperance[$j] = $columnEsperance[$j] + $j;
}


//applique les contraintes
foreach ($constraints as $constraint) {
    $user = $constraint->user_id;
    $game = $constraint->game_id;
    $wish[($user - 1) * $gamenb + $game - 1] = "c";
    $nbVal--;
    $gamequantity[$game - 1]--;
    $rowEsperance[$user - 1] = $rowEsperance[$user - 1] + 70000;
}

//pré-tri lignes
for ($i = 0; $i < $usernb; $i++) {
    for ($j = 0; $j < $gamenb; $j++) {
        $rowMemo[$j] = $wish[$i * $gamenb + $j];
        $a = $j;
    }
    $rowEsperance[$i] = intval($rowEsperance[$i]);
    $rowSort[$rowEsperance[$i]] = [$i, $rowMemo];
}
ksort($rowSort);

//tri lignes wish
$a = 0;
foreach ($rowSort as $rowk => $val) {
    for ($j = 0; $j < $gamenb; $j++) {
        $wish[$a * $gamenb + $j] = $val[1][$j];
    }
    $a++;
}

//pré-tri colonnes
for ($j = 0; $j < $gamenb; $j++) {
    for ($i = 0; $i < $usernb; $i++) {
        $colMemo[$i] = $wish[$i * $gamenb + $j];
    }
    $columnSort[$columnEsperance[$j]] = [$j, $colMemo, $gamequantity[$j]];
}
krsort($columnSort);

//tri colonnes wish
$a = 0;
foreach ($columnSort as $colk => $val) {
    for ($i = 0; $i < $usernb; $i++) {
        $wish[$i * $gamenb + $a] = $val[1][$i];
    }
    $gamequantity[$a] = $val[2];
    $a++;
}

for ($i = 0; $i < $usernb; $i++) {
    for ($j = 0; $j < $gamenb; $j++) {
        if ($wish[$i * $gamenb + $j] === "c") {
            $attribution[$i * $gamenb + $j] = 1;
        }
    }
}


//Attribution
while ($nbVal != 0) {
    for ($i = 0; $i < $usernb; $i++) {
        for ($j = 0; $j < $gamenb; $j++) {
            if ($attribution[$i * $gamenb + $j] === "x") {
                if ($gamequantity[$j] > 0 && $wish[$i * $gamenb + $j] == 1) {
                    $attribution[$i * $gamenb + $j] = 1;
                    $nbVal--;
                    $gamequantity[$j]--;
                    if ($nbVal == 0) {
                        break 2;
                    }
                    break;
                } else {
                    $attribution[$i * $gamenb + $j] = 0;
                    $nbVal--;
                    if ($nbVal == 0) {
                        break 2;
                    }
                }
            }
        }
    }
}

//Pré-Tri inverse lignes
$unRowSort = [];
$a = 0;
foreach ($rowSort as $rowk => $val) {
    $rowMemo = [];
    for ($k = 0; $k < $gamenb; $k++) {
        $rowMemo[$k] = $attribution[$a * $gamenb + $k];
    }
    $unRowSort[$val[0]] = $rowMemo;
    $a++;
}
ksort($unRowSort);

//tri inverse lignes attribution
$a = 0;
foreach ($unRowSort as $rowk => $val) {
    for ($j = 0; $j < $gamenb; $j++) {
        $attribution[$a * $gamenb + $j] = $val[$j];
    }
    $a++;
}

//Pré-Tri inverse colonnes
$unColSort = [];
$a = 0;
foreach ($columnSort as $colk => $val) {
    $colMemo = [];
    for ($i = 0; $i < $usernb; $i++) {
        $colMemo[$i] = $attribution[$i * $gamenb + $a];
    }
    $unColSort[$val[0]] = $colMemo;
    $a++;
}

ksort($unColSort);
//tri inverse colonnes attribution
$a = 0;
foreach ($unColSort as $colk => $val) {
    for ($i = 0; $i < $usernb; $i++) {
        $attribution[$i * $gamenb + $a] = $val[$i];
    }
    $a++;
}

// Pour voir wish et attribution
// echo "<br>";
// for ($i = 0; $i < $usernb; $i++) {
//     for ($j = 0; $j < $gamenb; $j++) {
//         echo $wish[$i * $gamenb + $j];
//     }
//     echo "<br>";
// }
