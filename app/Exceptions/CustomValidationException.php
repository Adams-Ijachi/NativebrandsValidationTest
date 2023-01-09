<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class CustomValidationException extends Exception
{

    public  $status = 422;
    /**
     * @var array|mixed
     */
    private mixed $errors;

    public function __construct($message = "", $code = 422, Throwable $previous = null, $errors = [])
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
        $this->code = $code;
    }

    final function getErrorResponse(): array
    {
        return [
            "message" => $this->getMessage(),
            "errors" => $this->errors
        ];
    }




}
