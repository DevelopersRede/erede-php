<?php
namespace Rede;

use Rede\Service\CancelTransactionService;
use Rede\Service\CaptureTransactionService;
use Rede\Service\CreateTransactionService;
use Rede\Service\GetTransactionService;

class eRede
{
    const USER_AGENT = 'eRede/1.0 (SDK; PHP;)';

    /**
     * @var Store
     */
    private $store;

    /**
     * eRede constructor.
     *
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @param Transaction $transaction
     *
     * @return Transaction
     * @see eRede::create()
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
    public function cancel(Transaction $transaction)
    {
        $cancelTransactionService = new CancelTransactionService($this->store, $transaction);

        return $cancelTransactionService->execute();
    }

    /**
     * @param Transaction $transaction
     *
     * @return Transaction
     */
    public function capture(Transaction $transaction)
    {
        $captureTransactionService = new CaptureTransactionService($this->store, $transaction);

        return $captureTransactionService->execute();
    }

    /**
     * @param Transaction $transaction
     *
     * @return Transaction
     */
    public function create(Transaction $transaction)
    {
        $createTransactionService = new CreateTransactionService($this->store, $transaction);

        return $createTransactionService->execute();
    }

    /**
     * @param string $tid
     *
     * @return Transaction
     */
    public function get($tid)
    {
        $getTransactionService = new GetTransactionService($this->store);
        $getTransactionService->setTid($tid);

        return $getTransactionService->execute();
    }

    /**
     * @param $tid
     *
     * @return Transaction
     * @see eRede::get()
     */
    public function getById($tid)
    {
        return $this->get($tid);
    }

    /**
     * @param $reference
     *
     * @return Transaction
     */
    public function getByReference($reference)
    {
        $getTransactionService = new GetTransactionService($this->store);
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
        $getTransactionService = new GetTransactionService($this->store);
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
