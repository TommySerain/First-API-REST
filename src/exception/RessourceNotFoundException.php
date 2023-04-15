<?php

namespace App\exception;

use App\message\HTTPMessageCode;

class RessourceNotFoundException extends CrudException
{
    public function __construct()
    {
        http_response_code(HTTPMessageCode::RESSOURCE_NOT_FOUND);
        echo json_encode([
            'error' => "Ressource non trouvé"
        ]);
    }
}
