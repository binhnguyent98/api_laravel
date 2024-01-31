<?php

namespace App\Exceptions;

use Exception;

class ApiErrorException extends Exception
{
    private $errorCode;
    private $statusCode;
    public function __construct( string $errorCode ,string $message = "", ?int $statusCode = 400)
    {
        $this->errorCode = $errorCode;
        $this->statusCode = $statusCode;

        parent::__construct($message, 0, null);
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
