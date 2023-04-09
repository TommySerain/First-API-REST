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
    $query = "SELECT * FROM actor WHERE id_a=:id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $actor = $stmt->fetch();
    if ($actor === false) {
        http_response_code(404);
        echo json_encode(['error' => "Acteur non trouvé"]);
        exit;
    }
    echo json_encode($actor);
    http_response_code(201);
}
// modifier
if ($uriPartsCount === 3 && $uriParts[1] === "actor" && $httpMethod === "PUT") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['firstname_a']) || !isset($data['name_a']) || !isset($data['gender_a'])) {
        http_response_code(422);
        echo json_encode([
            'error' => 'Le prénom, le nom et le genre sont requis'
        ]);
        exit;
    }

    $query = "UPDATE actor SET firstname_a=:firstname_a, name_a=:name_a, gender_a=:gender_a WHERE id_a=:id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(
        [
            "firstname_a" => $data['firstname_a'],
            "name_a" => $data['name_a'],
            "gender_a" => $data['gender_a'],
            'id' => $id
        ]
    );

    if ($stmt->rowCount() === 0) {
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
    $query = "DELETE FROM actor WHERE id_a=:id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(["id" => $id]);
    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode([
            'error' => 'Acteur non trouvé'
        ]);
        exit;
    }
    http_response_code(204);
}
