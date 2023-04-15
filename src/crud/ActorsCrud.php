<?php

namespace App\crud;

class ActorsCrud extends Crud
{
    protected string $table = "actor";
    protected string $columnId = "id_a";
    // Collection
    // READ
    public function readAll(): array
    {
        return parent::readAll();
    }



    // CREATE
    public function create(array $data): bool
    {
        return parent::create($data);
    }

    // Unique
    // READ
    public function readOne(int $id): array|bool
    {
        return parent::readOne($id);
    }

    // UPDATE
    public function update(array $data, int $id): bool
    {
        return parent::update($data, $id);
    }

    // DELETE
    public function delete($id): bool
    {
        return parent::deleteLine($id);
    }
}
