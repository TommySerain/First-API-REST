<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\config\DbInitializer;
use App\controller\ActorsCrudController;
use App\controller\RolesCrudController;
use App\exception\ExceptionHandler;
use Symfony\Component\Dotenv\Dotenv;


$dotenv = new Dotenv();
$dotenv->loadEnv('.env');
$pdo = DbInitializer::getPdoInstance();

header('Content-type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

ExceptionHandler::ExceptionHandler();

$uri = $_SERVER['REQUEST_URI'];
$httpMethod = $_SERVER['REQUEST_METHOD'];
$urisParts = explode("/", $uri);
$uriPartsCount = count($uriParts);
$resourceName = $uriParts[1];


// Crud Ressource actor
// collection
if (str_contains($uri, "/actor")) {
    $actorController = new ActorsCrudController($pdo, $uri, $httpMethod, $uriParts, $uriPartsCount);
}
if (str_contains($uri, "/role")) {
    $roleController = new RolesCrudController($pdo, $uri, $httpMethod, $uriParts, $uriPartsCount);
}
