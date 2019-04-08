<?php

namespace Rede;

use Psr\Log\LoggerInterface;
use Rede\Service\CancelTransactionService;
use Rede\Service\CaptureTransactionService;
use Rede\Service\CreateTransactionService;
use Rede\Service\GetTransactionService;

class eRede
{
    const USER_AGENT = 'eRede/4.2.0 (PHP; %s %s; %s)';

    /**
     * @var Store
     */
    private $store;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * eRede constructor.
     *
     * @param Store $store
     * @param LoggerInterface $logger
     */
    public function __construct(Store $store, LoggerInterface $logger = null)
    {
        $this->store = $store;
        $this->logger = $logger;
    }

    /**
     * @param Transaction $transaction
     *
     * @return Transaction
     * @see    eRede::create()
     */
    public function authorize(Transaction $transaction)
    {
        return $this->create($transaction);
    }

    /**
     * @param Transaction $transaction
     *
     * @return Transaction
     */
    public function create(Transaction $transaction)
    {
        $createTransactionService = new CreateTransactionService($this->store, $transaction, $this->logger);

        return $createTransactionService->execute();
    }

    /**
     * @param Transaction $transaction
     *
     * @return Transaction
     */
    public function cancel(Transaction $transaction)
    {
        $cancelTransactionService = new CancelTransactionService($this->store, $transaction, $this->logger);

        return $cancelTransactionService->execute();
    }

    /**
     * @param Transaction $transaction
     *
     * @return Transaction
     */
    public function capture(Transaction $transaction)
    {
        $captureTransactionService = new CaptureTransactionService($this->store, $transaction, $this->logger);

        return $captureTransactionService->execute();
    }

    /**
     * @param $tid
     *
     * @return Transaction
     * @see    eRede::get()
     */
    public function getById($tid)
    {
        return $this->get($tid);
    }

    /**
     * @param string $tid
     *
     * @return Transaction
     */
    public function get($tid)
    {
        $getTransactionService = new GetTransactionService($this->store, null, $this->logger);
        $getTransactionService->setTid($tid);

        return $getTransactionService->execute();
    }

    /**
     * @param $reference
     *
     * @return Transaction
     */
    public function getByReference($reference)
    {
        $getTransactionService = new GetTransactionService($this->store, null, $this->logger);
        $getTransactionService->setReference($reference);

        return $getTransactionService->execute();
    }

    /**
     * @param $tid
     *
     * @return Transaction
     */
    public function getRefunds($tid)
    {
        $getTransactionService = new GetTransactionService($this->store, null, $this->logger);
        $getTransactionService->setTid($tid);
        $getTransactionService->setRefund(true);

        return $getTransactionService->execute();
    }

    /**
     * @param Transaction $transaction
     *
     * @return Transaction
     */
    public function zero(Transaction $transaction)
    {
        $amount = (int)$transaction->getAmount();
        $capture = (bool)$transaction->getCapture();

        $transaction->setAmount(0);
        $transaction->capture();

        $transaction = $this->create($transaction);

        $transaction->setAmount($amount);
        $transaction->capture($capture);

        return $transaction;
    }
}
