<?php

namespace Rede;

use DateTime;

class Authorization
{
    use CreateTrait;

    /**
     * @var string|null
     */
    private ?string $affiliation = null;

    /**
     * @var int|null
     */
    private ?int $amount = null;

    /**
     * @var string|null
     */
    private ?string $authorizationCode = null;

    /**
     * @var string|null
     */
    private ?string $cardBin = null;

    /**
     * @var string|null
     */
    private ?string $cardHolderName = null;

    /**
     * @var DateTime|null
     */
    private ?DateTime $dateTime = null;

    /**
     * @var int|null
     */
    private ?int $installments = null;

    /**
     * @var string|null
     */
    private ?string $kind = null;

    /**
     * @var string|null
     */
    private ?string $last4 = null;

    /**
     * @var string|null
     */
    private ?string $nsu = null;

    /**
     * @var string|null
     */
    private ?string $origin = null;

    /**
     * @var string|null
     */
    private ?string $reference = null;

    /**
     * @var string|null
     */
    private ?string $returnCode = null;

    /**
     * @var string|null
     */
    private ?string $returnMessage = null;

    /**
     * @var string|null
     */
    private ?string $status = null;

    /**
     * @var string|null
     */
    private ?string $subscription = null;

    /**
     * @var string|null
     */
    private ?string $tid = null;

    /**
     * @return string|null
     */
    public function getAffiliation(): ?string
    {
        return $this->affiliation;
    }

    /**
     * @param string|null $affiliation
     * @return $this
     */
    public function setAffiliation(?string $affiliation): static
    {
        $this->affiliation = $affiliation;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     * @return $this
     */
    public function setAmount(?int $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAuthorizationCode(): ?string
    {
        return $this->authorizationCode;
    }

    /**
     * @param string|null $authorizationCode
     * @return $this
     */
    public function setAuthorizationCode(?string $authorizationCode): static
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardBin(): ?string
    {
        return $this->cardBin;
    }

    /**
     * @param string|null $cardBin
     * @return $this
     */
    public function setCardBin(?string $cardBin): static
    {
        $this->cardBin = $cardBin;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardHolderName(): ?string
    {
        return $this->cardHolderName;
    }

    /**
     * @param string|null $cardHolderName
     * @return $this
     */
    public function setCardHolderName(?string $cardHolderName): static
    {
        $this->cardHolderName = $cardHolderName;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateTime(): ?DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param DateTime|null $dateTime
     * @return $this
     */
    public function setDateTime(?DateTime $dateTime): static
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getInstallments(): ?int
    {
        return $this->installments;
    }

    /**
     * @param int|null $installments
     * @return $this
     */
    public function setInstallments(?int $installments): static
    {
        $this->installments = $installments;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getKind(): ?string
    {
        return $this->kind;
    }

    /**
     * @param string|null $kind
     * @return $this
     */
    public function setKind(?string $kind): static
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLast4(): ?string
    {
        return $this->last4;
    }

    /**
     * @param string|null $last4
     * @return $this
     */
    public function setLast4(?string $last4): static
    {
        $this->last4 = $last4;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNsu(): ?string
    {
        return $this->nsu;
    }

    /**
     * @param string|null $nsu
     * @return $this
     */
    public function setNsu(?string $nsu): static
    {
        $this->nsu = $nsu;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    /**
     * @param string|null $origin
     * @return $this
     */
    public function setOrigin(?string $origin): static
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string|null $reference
     * @return $this
     */
    public function setReference(?string $reference): static
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReturnCode(): ?string
    {
        return $this->returnCode;
    }

    /**
     * @param string|null $returnCode
     * @return $this
     */
    public function setReturnCode(?string $returnCode): static
    {
        $this->returnCode = $returnCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReturnMessage(): ?string
    {
        return $this->returnMessage;
    }

    /**
     * @param string|null $returnMessage
     * @return $this
     */
    public function setReturnMessage(?string $returnMessage): static
    {
        $this->returnMessage = $returnMessage;
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
     * @param string|null $status
     * @return $this
     */
    public function setStatus(?string $status): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubscription(): ?string
    {
        return $this->subscription;
    }

    /**
     * @param string|null $subscription
     * @return $this
     */
    public function setSubscription(?string $subscription): static
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTid(): ?string
    {
        return $this->tid;
    }

    /**
     * @param string|null $tid
     * @return $this
     */
    public function setTid(?string $tid): static
    {
        $this->tid = $tid;
        return $this;
    }
}
