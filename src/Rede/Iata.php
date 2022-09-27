<?php

namespace Rede;

use ArrayIterator;

class Iata implements RedeSerializable
{
    use SerializeTrait;

    /**
     * @var string|null
     */
    private ?string $code = null;

    /**
     * @var string|null
     */
    private ?string $departureTax = null;

    /**
     * @var array<Flight>
     */
    private array $flight = [];

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDepartureTax(): ?string
    {
        return $this->departureTax;
    }

    /**
     * @param string $departureTax
     *
     * @return $this
     */
    public function setDepartureTax(string $departureTax): static
    {
        $this->departureTax = $departureTax;
        return $this;
    }

    /**
     * @return ArrayIterator<int,Flight>
     */
    public function getFlightIterator(): ArrayIterator
    {
        return new ArrayIterator($this->flight);
    }

    /**
     * @param Flight $flight
     *
     * @return $this
     */
    public function setFlight(Flight $flight): static
    {
        $this->flight = [];
        $this->addFlight($flight);

        return $this;
    }

    /**
     * @param Flight $flight
     *
     * @return $this
     */
    public function addFlight(Flight $flight): static
    {
        $this->flight[] = $flight;

        return $this;
    }
}
