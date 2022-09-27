<?php

namespace Rede;

use DateTime;
use Exception;

class Refund
{
    use CreateTrait;

    /**
     * @var int|null
     */
    private ?int $amount = null;

    /**
     * @var DateTime|null
     */
    private ?DateTime $refundDateTime = null;

    /**
     * @var string|null
     */
    private ?string $refundId = null;

    /**
     * @var string|null
     */
    private ?string $status = null;

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return $this
     */
    public function setAmount(int $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getRefundDateTime(): ?DateTime
    {
        return $this->refundDateTime;
    }

    /**
     * @param string $refundDateTime
     *
     * @return $this
     * @throws Exception
     */
    public function setRefundDateTime(string $refundDateTime): static
    {
        $this->refundDateTime = new DateTime($refundDateTime);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getRefundId(): ?string
    {
        return $this->refundId;
    }

    /**
     * @param string $refundId
     *
     * @return $this
     */
    public function setRefundId(string $refundId): static
    {
        $this->refundId = $refundId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }
}
