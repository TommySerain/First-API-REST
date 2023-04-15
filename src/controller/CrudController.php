<?php

namespace App\controller;

use App\crud\ActorsCrud;
use App\crud\RolesCrud;
use App\exception\RessourceNotFoundException;
use App\exception\URICollectionMethodException;
use App\exception\URISizeException;
use App\exception\URIUniqueMethodException;
use App\message\HTTPMessageCode;
use PDO;

abstract class CrudController
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
        $this->checkAndTraitementGetCollection();
        $this->checkAndTraitementPostCollection($this->uri, $this->httpMethod, $this->pdo);
        $id = intval($this->uriParts[2]);
        $this->checkURIId($id);
        $this->checkAndReadUnique($id);
        $this->checkAndUpateUnique($id, $this->uriPartsCount, $this->uriParts, $this->httpMethod);
        $this->checkAndDeleteUnique($id);
    }

    public function checkURISize(): void
    {
        if ($this->uriPartsCount > 3) {
            throw new URISizeException();
        }
    }

    public function checkMethod(): void
    {
        if ($this->uri === "/$this->table" && !in_array($this->httpMethod, self::ACCEPTED_COLLECTION_METHODS)) {
            throw new URICollectionMethodException(self::ACCEPTED_COLLECTION_METHODS);
        }

        if (str_contains($this->uri, "/$this->table/") && !in_array($this->httpMethod, self::ACCEPTED_RESOURCE_METHODS)) {
            throw new URIUniqueMethodException(self::ACCEPTED_RESOURCE_METHODS);
        }
    }

    public function checkAndTraitementGetCollection(): void
    {
        if ($this->uri === "/$this->table" && $this->httpMethod === "GET") {
            echo json_encode($this->crud->readAll());
            exit;
        }
    }

    public abstract function checkAndTraitementPostCollection(string $uri, string $httpMethod, PDO $pdo): void;

    public function checkURIId($id): void
    {
        if ($id === 0) {
            throw new RessourceNotFoundException();
        }
    }
    public function checkAndReadUnique($id): void
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

    public abstract function checkAndUpateUnique(int $id, int $uriPartsCount, array $uriParts, string $httpMethod): void;

    public function checkAndDeleteUnique($id): void
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
