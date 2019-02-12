<?php

namespace Rede;

use ArrayIterator;

class Iata implements RedeSerializable
{
    use SerializeTrait;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $departureTax;

    /**
     * @var array[Flight]
     */
    private $flight;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Iata
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDepartureTax()
    {
        return $this->departureTax;
    }

    /**
     * @param string $departureTax
     *
     * @return Iata
     */
    public function setDepartureTax($departureTax)
    {
        $this->departureTax = $departureTax;
        return $this;
    }

    /**
     *
     * @return ArrayIterator
     */
    public function getFlightIterator()
    {
        return new ArrayIterator($this->flight);
    }

    /**
     * @param Flight $flight
     *
     * @return Iata
     */
    public function setFlight($flight)
    {
        $this->flight = [];
        $this->addFlight($flight);

        return $this;
    }

    /**
     * @param Flight $flight
     *
     * @return Iata
     */
    public function addFlight(Flight $flight)
    {
        if ($this->flight === null) {
            $this->flight = [];
        }

        $this->flight[] = $flight;

        return $this;
    }
}