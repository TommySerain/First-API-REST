<?php

namespace App\controller;

use App\exception\CreateRoleException;
use App\exception\RessourceNotFoundException;
use App\exception\UpdateRoleException;
use App\message\HTTPMessageCode;

class RolesCrudController extends CrudController
{
    public string $table = "role";

    public function checkAndTraitementPostCollection($uri, $httpMethod, $pdo): void
    {
        if ($uri === "/$this->table" && $httpMethod === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);

            if ($this->table === "role" && !isset($data['name_r'])) {
                throw new CreateRoleException();
            }
            json_encode($this->crud->create($data));
            $insertId = $pdo->lastInsertId();
            http_response_code(HTTPMessageCode::CREATED);
            echo json_encode([
                'uri' => '/' . $this->table . '/' . $insertId
            ]);
            exit;
        }
    }

    public function checkAndUpateUnique($id, $uriPartsCount, $uriParts, $httpMethod): void
    {
        if ($uriPartsCount === 3 && $uriParts[1] === "$this->table" && $httpMethod === "PUT") {
            $data = json_decode(file_get_contents("php://input"), true);
            if ($this->table === "role" && !isset($data['name_r'])) {
                throw new UpdateRoleException();
            }
            $updated = $this->crud->update($data, $id);
            if ($updated === false) {
                throw new RessourceNotFoundException();
            }
            http_response_code(HTTPMessageCode::SUCCESS_WITHOUT_INFORMATION);
            exit;
        }
    }
}
