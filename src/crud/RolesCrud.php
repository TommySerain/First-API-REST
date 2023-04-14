<?php

namespace App\crud;

use PDO;

class RolesCrud extends Crud
{
    protected string $table = "role";
    protected string $columnId = "id_r";
    // Collection
    // READ
    public function readAllRoles(): array
    {
        return parent::readALL();
    }


    // CREATE
    public function createRole(array $data): bool
    {
        return parent::create($data);
    }

    // Unique
    // READ
    public function readOneRole(int $id): array|bool
    {
        return parent::readOne($id);
    }

    // UPDATE
    public function updateRole(array $data, int $id): bool
    {
        return parent::update($data, $id);
    }

    // DELETE
    public function deleteRole($id): bool
    {
        return parent::deleteLine($id);
    }
}
