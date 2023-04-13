<?php

namespace App\crud;

use PDO;

class ActorsCrud extends Crud
{

    // Collection
    // READ
    public function readAllActors(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM actor");
        $actors = $stmt->fetchAll();
        $nbActors = count($actors);
        $actorsListe = ["actors" => $actors, "nb" => $nbActors];
        return ($actorsListe === false) ? [] : $actorsListe;
    }

    // CREATE
    public function createActor(array $data): bool
    {
        $query = "INSERT INTO actor VALUES (null, :firstname_a, :name_a, :gender_a)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "firstname_a" => $data['firstname_a'],
            "name_a" => $data['name_a'],
            "gender_a" => $data['gender_a']
        ]);
        return $stmt->rowCount() === 1;
    }
    // Unique
    // READ
    public function readOneActor(int $id): array|bool
    {
        $query = "SELECT * FROM actor WHERE id_a=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // UPDATE
    public function updateActor(array $data, int $id): bool
    {
        $query = "UPDATE actor SET firstname_a=:firstname_a, name_a=:name_a, gender_a=:gender_a WHERE id_a=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(
            [
                "firstname_a" => $data['firstname_a'],
                "name_a" => $data['name_a'],
                "gender_a" => $data['gender_a'],
                'id' => $id
            ]
        );
        return ($stmt->rowCount() === 0) ? false : true;
    }

    // DELETE
    public function deleteActor($id): bool
    {
        $query = "DELETE FROM actor WHERE id_a=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["id" => $id]);
        return ($stmt->rowCount() === 0) ? false : true;
    }
}
