<?php

namespace App\message;

class HTTPMessageCode
{
    public const SUCCESS = 200;
    public const CREATED = 201;
    public const SUCCESS_WITHOUT_INFORMATION = 204;
    public const RESSOURCE_NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const URI_TO_LONG = 414;
    public const UNPROCESSABLE_ENTITY = 422;
}
