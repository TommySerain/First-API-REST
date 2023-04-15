<?php

namespace App\exception;

use App\message\HTTPMessageCode;

class URICollectionMethodException extends URIException
{
    public function __construct(null|array $ACCEPTED_COLLECTION_METHODS)
    {
        http_response_code(HTTPMessageCode::METHOD_NOT_ALLOWED);
        echo json_encode([
            'error' => 'Les méthodes accteptées pour les collections sont : ' . implode(" - ", $ACCEPTED_COLLECTION_METHODS)
        ]);
    }
}
