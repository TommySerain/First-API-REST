<?php

namespace App\config;

use Exception;
use PDO;

class DbInitializer
{
    public static function getPdoInstance(): PDO
    {
        if (
            !isset($_ENV['DB_HOST']) ||
            !isset($_ENV['DB_PORT']) ||
            !isset($_ENV['DB_NAME']) ||
            !isset($_ENV['DB_CHARSET']) ||
            !isset($_ENV['DB_USER']) ||
            !isset($_ENV['DB_PASSWORD'])
        ) {
            throw new Exception('Unable to load configuration, please load configuration via dotenv');
        }

        $dsn = "mysql:host" . $_ENV['DB_HOST'] .
            ";port=" . $_ENV['DB_PORT'] .
            ";dbname=" . $_ENV['DB_NAME'] .
            ";charset=" . $_ENV['DB_CHARSET'];

        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        return new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);
    }
}
