<?php

session_start();
define('SITE',"/~noecabl9901");
define('URL',"https://devbox.u-angers.fr/~noecabl9901/");
// define('SITE', "/media_library");
// define('URL', "/media_library/");
require_once('src/Lib/autoloader.php');
require_once('src/Lib/functions.php');

if(!isset($_SESSION['id'])){
    $controller = '\App\Controller\UserController';
    $action = 'login';
}else{
    if (isset($_GET['p'])) {
        $page = $_GET['p'];
    } else {
        $page = 'home/index';
    }
    
    $page = explode('/', $page); // sépare la chaine de caractère en deux éléments d'un tableaux
    if ($page[0] == "admin") {
        $controller = '\App\Controller\AdminController';
        if (count($page) >= 3) {
            $action = ucfirst($page[2]) . $page[1];
        } else if (count($page) >= 2) {
            $action = $page[1];
        } else $action = 'index';
    } else {
        $controller = '\App\Controller\\' . ucfirst($page[0]) . 'Controller';
        if (count($page) >= 2) {
            $action = $page[1];
        } else $action = 'index';
    }
    
    if (!class_exists($controller)) {
        $controller = '\App\Controller\HomeController';
    }
    if (!method_exists($controller, $action)) {
        $controller = '\App\Controller\HomeController';
        $action = 'index';
    }
}


$controller = new $controller();
$controller->$action();
