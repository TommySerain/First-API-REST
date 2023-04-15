<?php

namespace App\exception;

use App\message\HTTPMessageCode;

class CreateRoleException extends CrudException
{
    public function __construct()
    {
        http_response_code(HTTPMessageCode::UNPROCESSABLE_ENTITY);
        echo json_encode([
            'error' => "Le nom du rôle est requis"
        ]);
    }
}
