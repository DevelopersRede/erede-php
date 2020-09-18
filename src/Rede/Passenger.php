<?php

namespace Rede;

class Passenger implements RedeSerializable
{
    use SerializeTrait;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Phone
     */
    private $phone;

    /**
     * @var string
     */
    private $ticket;

    public function __construct($name, $email, $ticket)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setTicket($ticket);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Passenger
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Passenger
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     *
     * @return Passenger
     */
    public function setPhone(Phone $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param string $ticket
     *
     * @return Passenger
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
        return $this;
    }
}