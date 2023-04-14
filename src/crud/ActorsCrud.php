<?php

namespace App\crud;

use PDO;

class ActorsCrud extends Crud
{
    protected string $table="actor";
    protected string $columnId="id_a";
    // Collection
    // READ
    public function readAllActors(): array
    {
        return parent::readAll();
    }



    // CREATE
    public function createActor(array $data): bool
    {
        return parent::create($data);
    }

    // Unique
    // READ
    public function readOneActor(int $id): array|bool
    {
        return parent::readOne($id);
    }

    // UPDATE
    public function updateActor(array $data, int $id): bool
    {
        return parent::update($data, $id);
    }

    // DELETE
    public function deleteActor($id): bool
    {
        return parent::deleteLine($id);
    }

}
