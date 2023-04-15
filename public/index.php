<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\config\DbInitializer;
use App\controller\ActorsCrudController;
use App\controller\RolesCrudController;
use App\exception\CrudException;
use App\exception\ExceptionHandler;
use App\exception\RessourceNotFoundException;
use Symfony\Component\Dotenv\Dotenv;


$dotenv = new Dotenv();
$dotenv->loadEnv('.env');
$pdo = DbInitializer::getPdoInstance();

header('Content-type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

ExceptionHandler::ExceptionHandler();

$uri = $_SERVER['REQUEST_URI'];
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uriParts = explode("/", $uri);
$uriPartsCount = count($uriParts);
$resourceName = $uriParts[1];


if (str_contains($uri, "/actor")) {
    try {
        $actorController = new ActorsCrudController($pdo, $uri, $httpMethod, $uriParts, $uriPartsCount);
    } catch (CrudException $e) {
    }
}
if (str_contains($uri, "/role")) {
    try {
        $roleController = new RolesCrudController($pdo, $uri, $httpMethod, $uriParts, $uriPartsCount);
    } catch (CrudException $e) {
    }
}

if (!str_contains($uri, "/actor") && !str_contains($uri, "/role")) {
    $error = new RessourceNotFoundException;
}
