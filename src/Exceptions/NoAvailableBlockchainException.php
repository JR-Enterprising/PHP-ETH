<?php

namespace JrEnterprising\PhpEnv\Exceptions;

use Exception;

class NoAvailableBlockchainException extends Exception
{
    public function __construct()
    {
        parent::__construct("All the JSON-RPC url provided are not functional");
    }
}