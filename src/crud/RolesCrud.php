<?php

namespace App\crud;

class RolesCrud extends Crud
{
    protected string $table = "role";
    protected string $columnId = "id_r";
    // Collection
    // READ
    public function readAll(): array
    {
        return parent::readALL();
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
