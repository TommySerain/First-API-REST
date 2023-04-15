<?php

namespace App\controller;

use App\crud\RolesCrud;
use App\message\HTTPMessageCode;
use PDO;

class RolesCrudController
{
    private const ACCEPTED_COLLECTION_METHODS = ["GET", "POST"];
    private const ACCEPTED_RESOURCE_METHODS = ["GET", "PUT", "DELETE"];
    private RolesCrud $rolesCrud;
    public function __construct(
        private PDO $pdo,
        private string $uri,
        private string $httpMethod,
        private array $uriParts,
        private int $uriPartsCount
    ) {
        $this->rolesCrud = new RolesCrud($pdo);

        if ($uri === "/role" && !in_array($this->httpMethod, self::ACCEPTED_COLLECTION_METHODS)) {
            http_response_code(HTTPMessageCode::METHOD_NOT_ALLOWED);
            echo json_encode([
                'error' => 'Les méthodes accteptées pour les collections sont : ' . implode(" - ", self::ACCEPTED_COLLECTION_METHODS)
            ]);
            exit;
        }

        if (str_contains($uri, "/role/") && !in_array($this->httpMethod, self::ACCEPTED_RESOURCE_METHODS)) {
            http_response_code(HTTPMessageCode::METHOD_NOT_ALLOWED);
            echo json_encode([
                'error' => 'Les méthodes accteptées pour les ressources uniques sont : ' . implode(" - ", self::ACCEPTED_RESOURCE_METHODS)
            ]);
            exit;
        }

        if ($uriPartsCount>3){
            http_response_code(HTTPMessageCode::URI_TO_LONG);
            echo json_encode([
                'error' => "Attention la requête n'accepte qu'un nom de ressource et un id"
            ]);
            exit;
        }

        if ($uri === "/role" && $httpMethod === "GET") {
            echo json_encode($this->rolesCrud->readAllRoles());
            exit;
        }

        if ($uri === "/role" && $httpMethod === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!isset($data['name_r'])) {
                http_response_code(HTTPMessageCode::UNPROCESSABLE_ENTITY);
                echo json_encode([
                    'error' => 'Nom du role requis'
                ]);
                exit;
            }
            json_encode($this->rolesCrud->createRole($data));
            $insertRoleId = $pdo->lastInsertId();
            http_response_code(HTTPMessageCode::CREATED);
            echo json_encode([
                'uri' => '/role/' . $insertRoleId
            ]);
            exit;
        }

        // unique
        $id = intval($uriParts[2]);
        if ($id === 0) {
            http_response_code(HTTPMessageCode::RESSOURCE_NOT_FOUND);
            echo json_encode([
                'error' => 'Role non trouvé'
            ]);
            exit;
        }

        // lire
        if ($uriPartsCount === 3 && $uriParts[1] === "role" && $httpMethod === "GET") {
            $findRole = $this->rolesCrud->readOneRole($id);
            if ($findRole === false) {
                http_response_code(HTTPMessageCode::RESSOURCE_NOT_FOUND);
                echo json_encode(['error' => "Role non trouvé"]);
                exit;
            }
            echo json_encode($findRole);
            http_response_code(HTTPMessageCode::SUCCESS);
        }

        // modifier
        if ($uriPartsCount === 3 && $uriParts[1] === "role" && $httpMethod === "PUT") {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['name_r']) || !isset($data["id_a"])) {
                http_response_code(HTTPMessageCode::UNPROCESSABLE_ENTITY);
                echo json_encode([
                    'error' => "Le nom du rôle et l'identifiant de l'acteur sont requis"
                ]);
                exit;
            }
            $updatedRole = $this->rolesCrud->updateRole($data, $id);
            if ($updatedRole === false) {
                http_response_code(HTTPMessageCode::RESSOURCE_NOT_FOUND);
                echo json_encode([
                    'error' => 'Role non trouvé'
                ]);
                exit;
            }
            http_response_code(HTTPMessageCode::SUCCESS_WITHOUT_INFORMATION);
            exit;
        }

        // supprimer
        if ($uriPartsCount === 3 && $uriParts[1] === "role" && $httpMethod === "DELETE") {
            $deletedRole = $this->rolesCrud->deleteRole($id);
            if ($deletedRole === false) {
                http_response_code(HTTPMessageCode::RESSOURCE_NOT_FOUND);
                echo json_encode([
                    'error' => 'Role non trouvé'
                ]);
                exit;
            }
            http_response_code(HTTPMessageCode::SUCCESS_WITHOUT_INFORMATION);
        }
    }
}
