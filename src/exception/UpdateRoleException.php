<?php

namespace App\exception;

use App\message\HTTPMessageCode;

class UpdateRoleException extends CrudException
{
    public function __construct()
    {
        http_response_code(HTTPMessageCode::UNPROCESSABLE_ENTITY);
        echo json_encode([
            'error' => "Le nom du rôle et l'identifiant de l'acteur sont requis"
        ]);
    }
}
