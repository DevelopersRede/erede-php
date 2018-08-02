<?php

namespace Rede;

use DateTime;

class Capture
{
    use CreateTrait;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var \DateTime
     */
    private $dateTime;

    /**
     * @var string
     */
    private $nsu;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     *
     * @return string
     */
    public function getNsu()
    {
        return $this->nsu;
    }

    /**
     * @param int $amount
     *
     * @return Capture
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param string $dateTime
     *
     * @return Capture
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = new DateTime($dateTime);
        return $this;
    }

    /**
     * @param string $nsu
     *
     * @return Capture
     */
    public function setNsu($nsu)
    {
        $this->nsu = $nsu;
        return $this;
    }
}