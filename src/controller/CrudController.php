<?php

namespace App\controller;

use App\crud\ActorsCrud;
use App\crud\RolesCrud;
use App\exception\AcceptedGenderException;
use App\exception\CreateActorException;
use App\exception\CreateRoleException;
use App\exception\RessourceNotFoundException;
use App\exception\UpdateActorException;
use App\exception\UpdateRoleException;
use App\exception\URICollectionMethodException;
use App\exception\URISizeException;
use App\exception\URIUniqueMethodException;
use App\message\HTTPMessageCode;
use PDO;

class CrudController
{
    protected const ACCEPTED_COLLECTION_METHODS = ["GET", "POST"];
    protected const ACCEPTED_RESOURCE_METHODS = ["GET", "PUT", "DELETE"];
    protected RolesCrud | ActorsCrud $crud;
    protected string $table;

    public function __construct(
        private PDO $pdo,
        private string $uri,
        private string $httpMethod,
        private array $uriParts,
        private int $uriPartsCount
    ) {

        $this->table = $this->uriParts[1];
        if ($this->table === "role") {
            $this->crud = new RolesCrud($pdo);
        } elseif ($this->table === "actor") {
            $this->crud = new ActorsCrud($pdo);
        } else {
            throw new RessourceNotFoundException();
        }

        $this->checkMethod();
        $this->checkURISize();
        $this->checkAndTraitementCollection();
        $id = intval($this->uriParts[2]);
        $this->checkURIId($id);
        $this->checkAndReadUnique($id);
        $this->checkAndUpateUnique($id);
        $this->checkAndDeleteUnique($id);
    }

    public function checkURISize()
    {
        if ($this->uriPartsCount > 3) {
            throw new URISizeException();
        }
    }

    public function checkMethod()
    {
        if ($this->uri === "/$this->table" && !in_array($this->httpMethod, self::ACCEPTED_COLLECTION_METHODS)) {
            throw new URICollectionMethodException(self::ACCEPTED_COLLECTION_METHODS);
        }

        if (str_contains($this->uri, "/$this->table/") && !in_array($this->httpMethod, self::ACCEPTED_RESOURCE_METHODS)) {
            throw new URIUniqueMethodException(self::ACCEPTED_RESOURCE_METHODS);
        }
    }
    // TODO: Séparer le GET et le POST
    // TODO: class abstraite pour pouvoir mieux séparer dans chaque Crud Controller le update et le create
    public function checkAndTraitementCollection()
    {
        if ($this->uri === "/$this->table" && $this->httpMethod === "GET") {
            echo json_encode($this->crud->readAll());
            exit;
        }

        if ($this->uri === "/$this->table" && $this->httpMethod === "POST") {
            $data = json_decode(file_get_contents('php://input'), true);

            if ($this->table === "role" && !isset($data['name_r'])) {
                throw new CreateRoleException();
            }
            if (($this->table === "actor" && (!isset($data['firstname_a']) || !isset($data['name_a']) || !isset($data['gender_a'])))) {
                throw new CreateActorException();
            }
            if ($this->table === "actor" && !in_array(ucfirst(strtolower($data['gender_a'])), ActorsCrudController::ACCEPTED_GENDER)) {
                throw new AcceptedGenderException;
            }
            json_encode($this->crud->create($data));
            $insertId = $this->pdo->lastInsertId();
            http_response_code(HTTPMessageCode::CREATED);
            echo json_encode([
                'uri' => '/' . $this->table . '/' . $insertId
            ]);
            exit;
        }
    }

    public function checkURIId($id)
    {
        if ($id === 0) {
            throw new RessourceNotFoundException();
        }
    }
    public function checkAndReadUnique($id)
    {
        if ($this->uriPartsCount === 3 && $this->uriParts[1] === "$this->table" && $this->httpMethod === "GET") {
            $find = $this->crud->readOne($id);
            if ($find === false) {
                throw new RessourceNotFoundException();
            }
            echo json_encode($find);
            http_response_code(HTTPMessageCode::SUCCESS);
        }
    }
    // TODO:class abstraite pour pouvoir mieux séparer dans chaque Crud Controller le update et le create
    public function checkAndUpateUnique($id)
    {
        if ($this->uriPartsCount === 3 && $this->uriParts[1] === "$this->table" && $this->httpMethod === "PUT") {
            $data = json_decode(file_get_contents("php://input"), true);
            if ($this->table === "role" && !isset($data['name_r'])) {
                throw new UpdateRoleException();
            }
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

    public function checkAndDeleteUnique($id)
    {
        if ($this->uriPartsCount === 3 && $this->uriParts[1] === "$this->table" && $this->httpMethod === "DELETE") {
            $deleted = $this->crud->delete($id);
            if ($deleted === false) {
                throw new RessourceNotFoundException();
            }
            http_response_code(HTTPMessageCode::SUCCESS_WITHOUT_INFORMATION);
        }
    }
}
