<?php

namespace App\crud;

use PDO;

class Crud
{
    public function __construct(protected PDO $pdo)
    {
    }
}
