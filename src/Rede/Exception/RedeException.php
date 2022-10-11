<?php

namespace Rede\Exception;

use Rede\Transaction;
use RuntimeException;
use Throwable;

class RedeException extends RuntimeException
{
    private ?Transaction $transaction = null;

    public function __construct(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null,
        ?Transaction $transaction = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->transaction = $transaction;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }
}
