<?php

namespace App\crud;

use PDO;

class ActorsCrud
{
    public function __construct(private PDO $pdo)
    {
    }

    public function readAllActors(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM actor");
        $actors = $stmt->fetchAll();
        $nbActors = count($actors);
        $actorsListe = ["actors" => $actors, "nb" => $nbActors];
        return ($actorsListe === false) ? [] : $actorsListe;
    }

    public function createActor(array $data): bool
    {
        if (!isset($data['firstname_a']) || !isset($data['name_a']) || !isset($data['gender_a'])) {
            http_response_code(422);
            echo json_encode([
                'error' => 'Firstname, name and gender or required'
            ]);
            exit;
        }
        $query = "INSERT INTO actor VALUES (null, :firstname_a, :name_a, :gender_a)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            "firstname_a" => $data['firstname_a'],
            "name_a" => $data['name_a'],
            "gender_a" => $data['gender_a']
        ]);
        return $stmt->rowCount() === 1;
    }
}
