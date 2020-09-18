<?php

namespace Rede;

use DateTime;
use Exception;

class Refund
{
    use CreateTrait;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var DateTime
     */
    private $refundDateTime;

    /**
     * @var string
     */
    private $refundId;

    /**
     * @var string
     */
    private $status;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return Refund
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getRefundDateTime()
    {
        return $this->refundDateTime;
    }

    /**
     * @param string $refundDateTime
     *
     * @return Refund
     * @throws Exception
     */
    public function setRefundDateTime($refundDateTime)
    {
        $this->refundDateTime = new DateTime($refundDateTime);
        return $this;
    }

    /**
     * @return string
     */
    public function getRefundId()
    {
        return $this->refundId;
    }

    /**
     * @param string $refundId
     *
     * @return Refund
     */
    public function setRefundId($refundId)
    {
        $this->refundId = $refundId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return Refund
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
