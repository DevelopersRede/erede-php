<?php

namespace Rede\Exception;

use RuntimeException;
use Throwable;

class RedeException extends RuntimeException
{
    private ?string $response = null;

    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null,
        ?string $response = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }
}
