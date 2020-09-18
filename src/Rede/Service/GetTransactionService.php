<?php

namespace Rede\Service;

use InvalidArgumentException;
use Rede\Exception\RedeException;
use Rede\Transaction;
use RuntimeException;

class GetTransactionService extends AbstractTransactionsService
{
    /**
     * @var string
     */
    private $reference;

    /**
     * @var bool
     */
    private $refund = false;

    /**
     * @return Transaction
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws RedeException
     */
    public function execute()
    {
        return $this->sendRequest(null, AbstractService::GET);
    }

    /**
     * @param string $reference
     *
     * @return GetTransactionService
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @param bool $refund
     *
     * @return GetTransactionService
     */
    public function setRefund($refund = true)
    {
        $this->refund = $refund;

        return $this;
    }

    /**
     * @return string
     */
    protected function getService()
    {
        if ($this->reference !== null) {
            return sprintf('%s?reference=%s', parent::getService(), $this->reference);
        }

        if ($this->refund) {
            return sprintf('%s/%s/refunds', parent::getService(), $this->getTid());
        }

        return sprintf('%s/%s', parent::getService(), $this->getTid());
    }
}
