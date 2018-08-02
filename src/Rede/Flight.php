<?php

namespace Rede;

class Flight implements RedeSerializable
{
    use SerializeTrait;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $number;

    /**
     * @var array[Passenger]
     */
    private $passenger;

    /**
     *
     * @var string
     */
    private $to;

    public function __construct($number, $from, $to, $date)
    {
        $this->setNumber($number);
        $this->setFrom($from);
        $this->setTo($to);
        $this->setDate($date);
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return Flight
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     *
     * @return Flight
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     *
     * @return Flight
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getPassenger()
    {
        return $this->passenger;
    }

    /**
     * @param Passenger $passenger
     *
     * @return Flight
     */
    public function setPassenger(Passenger $passenger)
    {
        $this->passenger = [];
        $this->addPassenger($passenger);
        return $this;
    }

    /**
     * @param Passenger $passenger
     *
     * @return Flight
     */
    public function addPassenger(Passenger $passenger)
    {
        if ($this->passenger === null) {
            $this->passenger = [];
        }

        $this->passenger[] = $passenger;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     *
     * @param string $to
     *
     * @return Flight
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }
}