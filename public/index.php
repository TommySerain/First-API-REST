<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\config\DbInitializer;
use App\crud\ActorsCrud;
use Symfony\Component\Dotenv\Dotenv;


$dotenv = new Dotenv();
$dotenv->loadEnv('.env');
$pdo = DbInitializer::getPdoInstance();

header('Content-type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: http://127.0.0.1:5500');

set_exception_handler(function (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Une erreur est survenue',
        'code' => $e->getCode(),
        'msg' => $e->getMessage()
    ]);
});

$uri = $_SERVER['REQUEST_URI'];
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uriParts = explode("/", $uri);
$uriPartsCount = count($uriParts);
$resourceName = $uriParts[1];

$actorCrud = new ActorsCrud($pdo);

// Crud Ressource actor
// collection
if ($uri === "/actor" && $httpMethod === "GET") {
    echo json_encode($actorCrud->readAllActors());
    exit;
}

if ($uri === "/actor" && $httpMethod === "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    json_encode($actorCrud->createActor($data));

    $insertActorId = $pdo->lastInsertId();
    http_response_code(201);
    echo json_encode([
        'uri' => '/actor/' . $insertActorId
    ]);
    exit;
}


// unique
$id = intval($uriParts[2]);
if ($id === 0) {
    http_response_code(404);
    echo json_encode([
        'error' => 'Acteur non trouvé'
    ]);
    exit;
}

// lire
if ($uriPartsCount === 3 && $uriParts[1] === "actor" && $httpMethod === "GET") {
    $findActor = $actorCrud->readOneActor($id);
    if ($findActor === false) {
        http_response_code(404);
        echo json_encode(['error' => "Acteur non trouvé"]);
        exit;
    }
    echo json_encode($findActor);
    http_response_code(200);
}

// modifier
if ($uriPartsCount === 3 && $uriParts[1] === "actor" && $httpMethod === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);
    $updatedActor = $actorCrud->updateActor($data, $id);
    if ($updatedActor === false) {
        http_response_code(404);
        echo json_encode([
            'error' => 'Acteur non trouvé'
        ]);
        exit;
    }
    http_response_code(204);
    exit;
}

// supprimer
if ($uriPartsCount === 3 && $uriParts[1] === "actor" && $httpMethod === "DELETE") {
    $deletedActor=$actorCrud->deleteActor($id);
    if ($deletedActor === false) {
        http_response_code(404);
        echo json_encode([
            'error' => 'Acteur non trouvé'
        ]);
        exit;
    }
    http_response_code(204);
}
