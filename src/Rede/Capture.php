<?php

namespace Rede;

use DateTime;
use Exception;

class Capture
{
    use CreateTrait;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var DateTime
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
     * @return DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param string $dateTime
     *
     * @return Capture
     * @throws Exception
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = new DateTime($dateTime);
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
     * @return Capture
     */
    public function setNsu($nsu)
    {
        $this->nsu = $nsu;
        return $this;
    }
}