<?php

namespace Rede\Service;

use InvalidArgumentException;
use Rede\Exception\RedeException;
use Rede\Store;
use Rede\Transaction;

abstract class AbstractTransactionsService extends AbstractService
{
    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * @var string
     */
    private $tid;

    /**
     * AbstractTransactionsService constructor.
     *
     * @param Store $store
     * @param Transaction $transaction
     */
    public function __construct(Store $store, Transaction $transaction = null)
    {
        parent::__construct($store);

        $this->transaction = $transaction;
    }

    /**
     * @return Transaction
     * @throws \InvalidArgumentException, \RuntimeException, RedeException
     */
    public function execute()
    {
        return $this->sendRequest(json_encode($this->transaction), AbstractService::POST);
    }

    /**
     * @see AbstractService::getService()
     * @return string
     */
    protected function getService()
    {
        return 'transactions';
    }

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param string $response
     * @param string $statusCode
     *
     * @return Transaction
     * @see AbstractService::parseResponse()
     * @throws RedeException, \InvalidArgumentException
     */
    protected function parseResponse($response, $statusCode)
    {
        $previous = null;

        if ($this->transaction === null) {
            $this->transaction = new Transaction();
        }

        try {
            $this->transaction->jsonUnserialize($response);
        } catch (InvalidArgumentException $e) {
            $previous = $e;
        }

        if ((int)$statusCode >= 400) {
            throw new RedeException(
                $this->transaction->getReturnMessage(),
                $this->transaction->getReturnCode(),
                $previous
            );
        }

        return $this->transaction;
    }

    /**
     * @param string $tid
     */
    public function setTid($tid)
    {
        $this->tid = $tid;
    }
}
