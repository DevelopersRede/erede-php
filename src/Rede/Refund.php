<?php

namespace Rede;

use DateTime;

class Refund
{
    use CreateTrait;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var \DateTime
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
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getRefundDateTime()
    {
        return $this->refundDateTime;
    }

    /**
     *
     * @return string
     */
    public function getRefundId()
    {
        return $this->refundId;
    }

    /**
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
     * @param string $refundDateTime
     *
     * @return Refund
     */
    public function setRefundDateTime($refundDateTime)
    {
        $this->refundDateTime = new DateTime($refundDateTime);
        return $this;
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
