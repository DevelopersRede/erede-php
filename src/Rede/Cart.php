<?php

namespace Rede;

class Cart implements RedeSerializable
{
    use SerializeTrait;

    /**
     * @var Address
     */
    private $billing;

    /**
     * @var Consumer
     */
    private $consumer;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var Iata
     */
    private $iata;

    /**
     * @var array[Item]
     */
    private $items;

    /**
     *
     * @var Address
     */
    private $shipping;

    /**
     * @param int $type
     *
     * @return Address
     */
    public function address($type = Address::BOTH)
    {
        $address = new Address();

        if ($type & Address::BILLING == Address::BILLING) {
            $this->setBillingAddress($address);
        }

        if ($type & Address::SHIPPING == Address::SHIPPING) {
            $this->setShippingAddress($address);
        }

        return $address;
    }

    /**
     * @param Address $address
     *
     * @return Cart
     */
    public function setBillingAddress(Address $address)
    {
        $this->billing = $address;
        return $this;
    }

    /**
     *
     * @param Address $address
     *
     * @return Cart
     */
    public function setShippingAddress(Address $address)
    {
        $this->shipping = [$address];
        return $this;
    }

    /**
     * @param Item $item
     *
     * @return Cart
     */
    public function addItem(Item $item)
    {
        if ($this->items == null) {
            $this->items = [];
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * @param Address $shippingAddress
     *
     * @return Cart
     */
    public function addShippingAddress(Address $shippingAddress)
    {
        if ($this->shipping == null) {
            $this->shipping = [];
        }

        $this->shipping[] = $shippingAddress;

        return $this;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $cpf
     *
     * @return Consumer
     */
    public function consumer($name, $email, $cpf)
    {
        $consumer = new Consumer($name, $email, $cpf);

        $this->setConsumer($consumer);

        return $consumer;
    }

    /**
     *
     * @return Address
     */
    public function getBillingAddress()
    {
        return $this->billing;
    }

    /**
     *
     * @return Consumer
     */
    public function getConsumer()
    {
        return $this->consumer;
    }

    /**
     *
     * @param Consumer $consumer
     *
     * @return Cart
     */
    public function setConsumer(Consumer $consumer)
    {
        $this->consumer = $consumer;
        return $this;
    }

    /**
     *
     * @return Iata
     */
    public function getIata()
    {
        return $this->iata;
    }

    /**
     *
     * @param Flight $flight
     *
     * @return $this
     */
    public function setIata(Flight $flight)
    {
        $this->iata = new Iata();
        $this->iata->setFlight($flight);
        return $this;
    }

    /**
     *
     * @return Address
     */
    public function getShippingAddress()
    {
        return $this->shipping;
    }

    /**
     * @param Environment $environment
     *
     * @return Cart
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
        return $this;
    }

}