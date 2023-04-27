<?php

use App\Lib\DatabaseConnection;
use App\Model\InformationRepository;

function displayDiffTime($datetime)
{
    $diffDate = (new \DateTime())->diff($datetime);
    if ($diffDate->y != 0) return $diffDate->format('%y ans et %m mois');
    if ($diffDate->m != 0) return $diffDate->format('%m mois et %d jours');
    if ($diffDate->d != 0) return $diffDate->format('%d jours et %h heures');
    if ($diffDate->h != 0) return $diffDate->format('%h heures %i minutes');
    if ($diffDate->i != 0) return $diffDate->format('%i minutes et %s secondes');
    if ($diffDate->i == 0) return $diffDate->format('%s secondes');
    return 'ERROR';
}

function slugify($string)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
    return $slug;
}
function managePhase($phase)
{
    $informationRepository = new InformationRepository();
    $database = new DatabaseConnection();
    $informationRepository->connection = $database;

    $realPhase =  $informationRepository->getPhase();
    if ($realPhase != $phase) {
        header('Location:' . URL);
    }
    return $realPhase;
}
