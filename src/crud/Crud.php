<?php

namespace App\crud;

use PDO;

abstract class Crud
{
    protected string $table;
    protected string $columnId;

    public function __construct(protected PDO $pdo)
    {
    }

    // Collection
    // Read
    public function readAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM $this->table");
        $lines = $stmt->fetchAll();
        $nbLines = count($lines);
        $linsListe = [$this->table . 's' => $lines, "nb" => $nbLines];
        return ($linsListe === false) ? [] : $linsListe;
    }

    // Create
    public function create(array $data): bool
    {
        $columns = array_keys($data);
        $values = array_values($data);

        $query = "INSERT INTO $this->table (" . implode(",", $columns) . ") VALUES (" . rtrim(str_repeat("?,", count($values)), ",") . ")";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($values);
        return $stmt->rowCount() === 1;
    }

    // Unique
    // Read
    public function readOne(int $id): array|bool
    {
        $query = "SELECT * FROM $this->table WHERE $this->columnId=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function update(array $data, int $id): bool
    {
        $setColumns = '';
        foreach ($data as $key => $key) {
            $setColumns .= "$key = :$key, ";
        }
        $setColumns = rtrim($setColumns, ', ');
        $query = "UPDATE $this->table SET $setColumns WHERE $this->columnId = :id";
        $data['id'] = $id;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);

        return ($stmt->rowCount() === 0) ? false : true;
    }

    // Delete
    public function deleteLine($id): bool
    {
        $query = "DELETE FROM $this->table WHERE $this->columnId=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(["id" => $id]);
        return ($stmt->rowCount() === 0) ? false : true;
    }
}
