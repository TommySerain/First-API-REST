<?php

namespace App\exception;

use App\message\HTTPMessageCode;

class URISizeException extends URIException
{
    public function __construct()
    {
        http_response_code(HTTPMessageCode::URI_TO_LONG);
        echo json_encode([
            'error' => "Attention la requête n'accepte qu'un nom de ressource et un id"
        ]);
    }
}
