<?php

namespace App\controller;

use App\exception\AcceptedGenderException;
use App\exception\CreateActorException;
use App\exception\RessourceNotFoundException;
use App\exception\UpdateActorException;
use App\message\HTTPMessageCode;

class ActorsCrudController extends CrudController
{
    public string $table = "actor";
    public const ACCEPTED_GENDER = ["Male", "Female", "Other"];

    public function checkAndTraitementPostCollection($uri, $httpMethod, $pdo): void
    {
        if ($uri === "/$this->table" && $httpMethod === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);
            if (($this->table === "actor" && (!isset($data['firstname_a']) || !isset($data['name_a']) || !isset($data['gender_a'])))) {
                throw new CreateActorException();
            }
            if ($this->table === "actor" && !in_array(ucfirst(strtolower($data['gender_a'])), ActorsCrudController::ACCEPTED_GENDER)) {
                throw new AcceptedGenderException;
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
            if ($this->table === "actor" && (!isset($data['firstname_a']) || !isset($data['name_a']) || !isset($data['gender_a']))) {
                throw new UpdateActorException();
            }
            if ($this->table === "actor" && !in_array(ucfirst(strtolower($data['gender_a'])), ActorsCrudController::ACCEPTED_GENDER)) {
                throw new AcceptedGenderException();
            };
            $updated = $this->crud->update($data, $id);
            if ($updated === false) {
                throw new RessourceNotFoundException();
            }
            http_response_code(HTTPMessageCode::SUCCESS_WITHOUT_INFORMATION);
            exit;
        }
    }
}
