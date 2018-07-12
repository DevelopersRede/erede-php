<?php

namespace Rede\Service;

class CancelTransactionService extends AbstractTransactionsService
{
    /**
     * @return string
     */
    protected function getService()
    {
        return sprintf('%s/%s/refunds', parent::getService(), $this->transaction->getTid());
    }
}
