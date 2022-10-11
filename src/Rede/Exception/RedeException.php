<?php

namespace Rede\Exception;

use RuntimeException;

class RedeException extends RuntimeException
{
    private string $response;

    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null,
        string $response
    ) {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    public function getResponse(): string
    {
        return $this->response;
    }
}
