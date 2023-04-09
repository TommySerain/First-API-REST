<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\config\DbInitializer;
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

if ($uri === "/actor" && $httpMethod === "GET") {
    $stmt = $pdo->query("SELECT * FROM actor");
    $actors = $stmt->fetchAll();
    $nbActors = count($actors);
    echo json_encode(["actor" => $actors, "nb" => $nbActors]);
}

if ($uri === "/actor" && $httpMethod === "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $query = "INSERT INTO actor VALUES (null, :firstname_a, :name_a, :gender_a)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        "firstname_a" => $data['firstname_a'],
        "name_a" => $data['name_a'],
        "gender_a" => $data['gender_a']
    ]);
    $actorId=$pdo->lastInsertId();
    http_response_code(201);
    echo json_encode([
        'uri' => '/actor/' . $actorId
    ]);
}
