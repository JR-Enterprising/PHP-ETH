<?php

namespace JrEnterprising\PhpEnv\Dtos;

class SendTransactionDto
{
    public function __construct(
        public string $from,
        public ?string $to,
        public ?string $gas,
        public ?string $gasPrice,
        public ?string $value,
        public PayloadDto $data,
        public ?int $nonce,
    )
    {}
}