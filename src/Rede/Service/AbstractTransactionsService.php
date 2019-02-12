<?php

namespace Rede\Service;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
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
     * @param LoggerInterface $logger
     */
    public function __construct(Store $store, Transaction $transaction = null, LoggerInterface $logger = null)
    {
        parent::__construct($store, $logger);

        $this->transaction = $transaction;
    }

    /**
     * @return Transaction
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @throws \Rede\Exception\RedeException
     */
    public function execute()
    {
        return $this->sendRequest(json_encode($this->transaction), AbstractService::POST);
    }

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     *
     * @param string $tid
     */
    public function setTid($tid)
    {
        $this->tid = $tid;
    }

    /**
     * @see    AbstractService::getService()
     * @return string
     */
    protected function getService()
    {
        return 'transactions';
    }

    /**
     * @param string $response
     * @param string $statusCode
     *
     * @return Transaction
     * @see    AbstractService::parseResponse()
     * @throws \Rede\Exception\RedeException
     * @throws \InvalidArgumentException
     * @throws \Exception
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
}
