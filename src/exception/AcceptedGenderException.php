<?php

namespace App\exception;

use App\controller\ActorsCrudController;
use App\message\HTTPMessageCode;

class AcceptedGenderException extends CrudException
{
    public function __construct()
    {
        http_response_code(HTTPMessageCode::UNPROCESSABLE_ENTITY);
        echo json_encode([
            'error' => 'Les genres accteptés sont : ' . implode(" - ", ActorsCrudController::ACCEPTED_GENDER)
        ]);
    }
}
