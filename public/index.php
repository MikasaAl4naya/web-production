<?php 
require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
require_once "../controllers/MainController.php"; 
require_once "../controllers/ObjectController.php";  
require_once "../controllers/Controller404.php";
require_once "../controllers/SearchController.php";
require_once "../controllers/BandsObjectCreateController.php";
require_once "../controllers/BandsTypeCreateController.php";
require_once "../controllers/DeleteController.php";
require_once "../controllers/UpdateController.php";
require_once "../middlewares/LoginRequiredMiddleware.php";
require_once "../controllers/SetWelcomeController.php";


$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());


$pdo = new PDO("mysql:host=localhost;dbname=favoritte_bands;charset=utf8", "root", "");

$router = new Router($twig, $pdo);
$router->add("/", MainController::class);

$router->add("/bands/(?P<id>\d+)", ObjectController::class); 
$router->add("/search", SearchController::class);
$router->add("/create", BandsObjectCreateController::class)
       ->middleware(new LoginRequiredMiddleware());
$router->add("/create_type", BandsTypeCreateController::class)
        ->middleware(new LoginRequiredMiddleware());
$router->add("/bands/delete", DeleteController::class)
->middleware(new LoginRequiredMiddleware());
$router->add("/edit/(?P<id>\d+)", UpdateController::class)
->middleware(new LoginRequiredMiddleware());
$router->add("/set-welcome/", SetWelcomeController::class);
$router->get_or_default(Controller404::class);




