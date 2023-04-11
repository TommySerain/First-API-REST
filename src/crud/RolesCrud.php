<?php

namespace App\crud;

use PDO;

class RolesCrud
{
    public function __construct(private PDO $pdo)
    {
    }
    // Collection
    // READ
    public function readAllRoles(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM role");
        $roles = $stmt->fetchAll();
        $nbRoles = count($roles);
        $rolesListe = ["roles" => $roles, "nb" => $nbRoles];
        return ($rolesListe === false) ? [] : $rolesListe;
    }

    // CREATE
    public function createRole(array $data): bool
    {
        $query = "INSERT INTO role VALUES (null, :name_r, :id_a)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "name_r" => $data['name_r'],
            "id_a" => $data['id_a']
        ]);
        return $stmt->rowCount() === 1;
    }
    // Unique
    // READ
    public function readOneRole(int $id): array|bool
    {
        $query = "SELECT * FROM role WHERE id_r=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // UPDATE
    public function updateRole(array $data, int $id): bool
    {
        $query = "UPDATE role SET name_r = :name_r, id_a = :id_a WHERE id_r = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(
            [
                "name_r" => $data['name_r'],
                "id_a" => $data['id_a'],
                'id' => $id
            ]
        );
        return ($stmt->rowCount() === 0) ? false : true;
    }

    // DELETE
    public function deleteRole($id): bool
    {
        $query = "DELETE FROM role WHERE id_r=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["id" => $id]);
        return ($stmt->rowCount() === 0) ? false : true;
    }
}
