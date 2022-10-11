<?php

namespace Rede\Service;

use Exception;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Rede\Exception\RedeException;
use Rede\Store;
use Rede\Transaction;
use RuntimeException;

abstract class AbstractTransactionsService extends AbstractService
{
    /**
     * @var ?Transaction
     */
    protected ?Transaction $transaction;

    /**
     * @var string
     */
    private string $tid;

    /**
     * AbstractTransactionsService constructor.
     *
     * @param Store                $store
     * @param Transaction|null     $transaction
     * @param LoggerInterface|null $logger
     */
    public function __construct(Store $store, Transaction $transaction = null, LoggerInterface $logger = null)
    {
        parent::__construct($store, $logger);

        $this->transaction = $transaction;
    }

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

        return $this->sendRequest($json, AbstractService::POST);
    }

    /**
     * @return string
     */
    public function getTid(): string
    {
        return $this->tid;
    }

    /**
     * @param string $tid
     * @return $this
     */
    public function setTid(string $tid): static
    {
        $this->tid = $tid;
        return $this;
    }

    /**
     * @return string
     * @see    AbstractService::getService()
     */
    protected function getService(): string
    {
        return 'transactions';
    }

    /**
     * @param string $response
     * @param int    $statusCode
     *
     * @return Transaction
     * @throws RedeException
     * @throws InvalidArgumentException
     * @throws Exception
     * @see    AbstractService::parseResponse()
     */
    protected function parseResponse(string $response, int $statusCode): Transaction
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

        if ($statusCode >= 400) {
            throw new RedeException(
                $this->transaction->getReturnMessage() ?? 'Error on getting the content from the API',
                (int)$this->transaction->getReturnCode(),
                $previous,
                $this->transaction
            );
        }

        return $this->transaction;
    }
}
