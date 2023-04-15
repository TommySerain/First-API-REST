<?php

namespace App\exception;

use App\message\HTTPMessageCode;

class UpdateActorException extends CrudException
{
    public function __construct()
    {
        http_response_code(HTTPMessageCode::UNPROCESSABLE_ENTITY);
        echo json_encode([
            'error' => "Le prénom, le nom et le genre sont requis"
        ]);
    }
}
