<?php

namespace Rede;

class Flight implements RedeSerializable
{
    use SerializeTrait;

    /**
     * @var array<Passenger>
     */
    private array $passenger = [];

    public function __construct(private string $number, private string $from, private string $to, private string $date)
    {
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return $this
     */
    public function setDate(string $date): static
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $from
     *
     * @return $this
     */
    public function setFrom(string $from): static
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string $number
     *
     * @return $this
     */
    public function setNumber(string $number): static
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return array<Passenger>
     */
    public function getPassenger(): array
    {
        return $this->passenger;
    }

    /**
     * @param Passenger $passenger
     *
     * @return $this
     */
    public function setPassenger(Passenger $passenger): static
    {
        $this->passenger = [];
        $this->addPassenger($passenger);
        return $this;
    }

    /**
     * @param Passenger $passenger
     *
     * @return $this
     */
    public function addPassenger(Passenger $passenger): static
    {
        $this->passenger[] = $passenger;

        return $this;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @param string $to
     *
     * @return $this
     */
    public function setTo(string $to): static
    {
        $this->to = $to;
        return $this;
    }
}
