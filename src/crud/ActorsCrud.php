<?php

namespace App\crud;

use PDO;

class ActorsCrud
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findAllActors(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM actor");
        $actors = $stmt->fetchAll();
        $nbActors = count($actors);
        $actorsListe = ["actors" => $actors, "nb" => $nbActors];
        return ($actorsListe === false) ? [] : $actorsListe;
    }
}
