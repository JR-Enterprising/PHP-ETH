<?php

namespace JrEnterprising\PhpEnv\Exceptions;

use Exception;

class EndpointFailedException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}