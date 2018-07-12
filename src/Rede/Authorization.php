<?php

namespace Rede;

use DateTime;

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
     * @var \DateTime
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
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @return string
     */
    public function getCardBin()
    {
        return $this->cardBin;
    }

    /**
     * @return string
     */
    public function getCardHolderName()
    {
        return $this->cardHolderName;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return int
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @return string
     */
    public function getLast4()
    {
        return $this->last4;
    }

    /**
     * @return string
     */
    public function getNsu()
    {
        return $this->nsu;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return string
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * @return string
     */
    public function getReturnMessage()
    {
        return $this->returnMessage;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
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
     * @param string $dateTime
     *
     * @return Authorization
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = new DateTime($dateTime);
        return $this;
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