<?php

namespace JrEnterprising\PhpEnv\Dtos;

class PayloadDto
{

    public function __construct(
        public string $functionSignature,
        public array $parameters
    )
    {}
}