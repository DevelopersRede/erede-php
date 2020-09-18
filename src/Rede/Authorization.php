<?php

namespace Rede;

use DateTime;
use Exception;

class Authorization
{
    use CreateTrait;

    /**
     * @var string
     */
    private $affiliation;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var string
     */
    private $authorizationCode;

    /**
     * @var string
     */
    private $cardBin;

    /**
     * @var string
     */
    private $cardHolderName;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var int
     */
    private $installments;

    /**
     * @var string
     */
    private $kind;

    /**
     * @var string
     */
    private $last4;

    /**
     * @var string
     */
    private $nsu;

    /**
     * @var string
     */
    private $origin;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $returnCode;

    /**
     * @var string
     */
    private $returnMessage;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $subscription;

    /**
     * @var string
     */
    private $tid;

    /**
     * @return string
     */
    public function getAffiliation()
    {
        return $this->affiliation;
    }

    /**
     * @param string $affiliation
     *
     * @return Authorization
     */
    public function setAffiliation($affiliation)
    {
        $this->affiliation = $affiliation;
        return $this;
    }

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
     * @return Authorization
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param string $authorizationCode
     *
     * @return Authorization
     */
    public function setAuthorizationCode($authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardBin()
    {
        return $this->cardBin;
    }

    /**
     * @param string $cardBin
     *
     * @return Authorization
     */
    public function setCardBin($cardBin)
    {
        $this->cardBin = $cardBin;
        return $this;
    }

    /**
     * @return string
     */
    public function getCardHolderName()
    {
        return $this->cardHolderName;
    }

    /**
     * @param string $cardHolderName
     *
     * @return Authorization
     */
    public function setCardHolderName($cardHolderName)
    {
        $this->cardHolderName = $cardHolderName;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param string $dateTime
     *
     * @return Authorization
     * @throws Exception
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = new DateTime($dateTime);
        return $this;
    }

    /**
     * @return int
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * @param int $installments
     *
     * @return Authorization
     */
    public function setInstallments($installments)
    {
        $this->installments = $installments;
        return $this;
    }

    /**
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @param string $kind
     *
     * @return Authorization
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     * @return string
     */
    public function getLast4()
    {
        return $this->last4;
    }

    /**
     * @param string $last4
     *
     * @return Authorization
     */
    public function setLast4($last4)
    {
        $this->last4 = $last4;
        return $this;
    }

    /**
     * @return string
     */
    public function getNsu()
    {
        return $this->nsu;
    }

    /**
     * @param string $nsu
     *
     * @return Authorization
     */
    public function setNsu($nsu)
    {
        $this->nsu = $nsu;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param string $origin
     *
     * @return Authorization
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return Authorization
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * @param string $returnCode
     *
     * @return Authorization
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnMessage()
    {
        return $this->returnMessage;
    }

    /**
     * @param string $returnMessage
     *
     * @return Authorization
     */
    public function setReturnMessage($returnMessage)
    {
        $this->returnMessage = $returnMessage;
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
     * @return Authorization
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param string $subscription
     *
     * @return Authorization
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @param string $tid
     *
     * @return Authorization
     */
    public function setTid($tid)
    {
        $this->tid = $tid;
        return $this;
    }
}