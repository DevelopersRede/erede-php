<?php

namespace Rede\Service;

use InvalidArgumentException;
use Rede\Exception\RedeException;
use Rede\Transaction;
use RuntimeException;

class CaptureTransactionService extends AbstractTransactionsService
{
    /**
     * @return Transaction
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws RedeException
     */
    public function execute()
    {
        return $this->sendRequest(json_encode($this->transaction), AbstractService::PUT);
    }

    /**
     * @return string
     */
    protected function getService()
    {
        return sprintf('%s/%s', parent::getService(), $this->transaction->getTid());
    }
}
