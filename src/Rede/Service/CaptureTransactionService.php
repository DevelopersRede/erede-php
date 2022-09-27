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
    public function execute(): Transaction
    {
        $json = json_encode($this->transaction);

        if (!is_string($json)) {
            throw new RuntimeException('Problem converting the Transaction object to json');
        }

        return $this->sendRequest($json, AbstractService::PUT);
    }

    /**
     * @return string
     */
    protected function getService(): string
    {
        if ($this->transaction === null) {
            throw new RuntimeException('Transaction was not defined yet');
        }

        return sprintf('%s/%s', parent::getService(), $this->transaction->getTid());
    }
}
