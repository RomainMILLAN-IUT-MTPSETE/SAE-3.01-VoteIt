<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
use App\Covoiturage\Controller\ControllerVoiture;

if (isset($_GET['action'])) {
    $action = $_GET['action']; // $_GET['action'] récupère l'action saisie dans l'URL
} else {
    $action = 'readAll'; // $_GET['action'] récupère l'action saisie dans l'URL
}

if(isset($_GET['controller'])){
    $controller = $_GET['controller'];
}else {
    $controller = "voiture";
}

$controllerClassName = "App\VoteIt\Controller\Controller" . ucfirst($controller);

// instantiate the loader
$loader = new App\Covoiturage\Lib\Psr4AutoloaderClass();
// register the base directories for the namespace prefix
$loader->addNamespace('App\VoteIt', __DIR__ . '/../src');
// register the autoloader
$loader->register();

if(class_exists($controllerClassName)){
    if(in_array($action, get_class_methods($controllerClassName))){
        $controllerClassName::$action();
    }else{
        $controllerClassName::error("Hello");
    }
}else {
    ControllerVoiture::error("Class not found");
}
?>