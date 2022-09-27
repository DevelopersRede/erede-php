<?php

namespace Rede;

class Passenger implements RedeSerializable
{
    use SerializeTrait;

    /**
     * @var Phone|null
     */
    private ?Phone $phone = null;

    public function __construct(private string $name, private string $email, private string $ticket)
    {
    }

    /**
     * @return Phone|null
     */
    public function getPhone(): ?Phone
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     * @return $this
     */
    public function setPhone(Phone $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getTicket(): string
    {
        return $this->ticket;
    }

    /**
     * @param string $ticket
     * @return $this
     */
    public function setTicket(string $ticket): static
    {
        $this->ticket = $ticket;
        return $this;
    }
}
