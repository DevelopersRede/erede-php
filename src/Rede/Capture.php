<?php

namespace Rede;

use DateTime;

class Capture
{
    use CreateTrait;

    /**
     * @var int|null
     */
    private ?int $amount = null;

    /**
     * @var DateTime|null
     */
    private ?DateTime $dateTime = null;

    /**
     * @var string|null
     */
    private ?string $nsu = null;

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     * @return Capture
     */
    public function setAmount(?int $amount): Capture
    {
        $this->amount = $amount;
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
     * @return Capture
     */
    public function setDateTime(?DateTime $dateTime): Capture
    {
        $this->dateTime = $dateTime;
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
     * @return Capture
     */
    public function setNsu(?string $nsu): Capture
    {
        $this->nsu = $nsu;
        return $this;
    }
}
