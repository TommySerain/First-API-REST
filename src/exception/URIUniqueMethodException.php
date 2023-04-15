<?php

namespace App\exception;

use App\message\HTTPMessageCode;

class URIUniqueMethodException extends URIException
{
    public function __construct(null|array $ACCEPTED_RESOURCE_METHODS)
    {
        http_response_code(HTTPMessageCode::METHOD_NOT_ALLOWED);
        echo json_encode([
            'error' => 'Les méthodes accteptées pour les ressources uniques sont : ' . implode(" - ", $ACCEPTED_RESOURCE_METHODS)
        ]);
    }
}
