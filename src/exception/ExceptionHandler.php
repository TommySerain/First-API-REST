<?php

namespace App\exception;

use Throwable;

class ExceptionHandler
{
    public function __construct()
    {
    }
    public static function ExceptionHandler()
    {
        set_exception_handler(function (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'error' => 'Une erreur est survenue',
                'code' => $e->getCode(),
                'msg' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        });
    }
}
