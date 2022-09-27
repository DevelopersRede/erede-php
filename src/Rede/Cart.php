<?php

namespace Rede;

class Cart implements RedeSerializable
{
    use SerializeTrait;

    /**
     * @var Address|null
     */
    private ?Address $billing = null;

    /**
     * @var Consumer|null
     */
    private ?Consumer $consumer = null;

    /**
     * @var Iata|null
     */
    private ?Iata $iata = null;

    /**
     * @var array<Item>
     */
    private array $items = [];

    /**
     * @var array<Address>
     */
    private array $shipping = [];

    /**
     * @param int $type
     *
     * @return Address
     */
    public function address(int $type = Address::BOTH): Address
    {
        $address = new Address();

        if (($type & Address::BILLING) == Address::BILLING) {
            $this->setBillingAddress($address);
        }

        if (($type & Address::SHIPPING) == Address::SHIPPING) {
            $this->setShippingAddress($address);
        }

        return $address;
    }

    /**
     * @param Item $item
     *
     * @return $this
     */
    public function addItem(Item $item): static
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param Address $shippingAddress
     *
     * @return $this
     */
    public function addShippingAddress(Address $shippingAddress): static
    {
        $this->shipping[] = $shippingAddress;

        return $this;
    }

    /**
     * @param Address $shippingAddress
     *
     * @return $this
     */
    public function setShippingAddress(Address $shippingAddress): static
    {
        $this->shipping = [$shippingAddress];

        return $this;
    }

    /**
     * @param Address $billingAddress
     *
     * @return $this
     */
    public function setBillingAddress(Address $billingAddress): static
    {
        $this->billing = $billingAddress;

        return $this;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $cpf
     *
     * @return Consumer
     */
    public function consumer(string $name, string $email, string $cpf): Consumer
    {
        $consumer = new Consumer($name, $email, $cpf);

        $this->setConsumer($consumer);

        return $consumer;
    }

    /**
     * @param Flight $flight
     *
     * @return $this
     */
    public function setFlight(Flight $flight): static
    {
        $this->iata = new Iata();
        $this->iata->setFlight($flight);
        return $this;
    }

    /**
     * @param Iata $iata
     *
     * @return $this
     */
    public function setIata(Iata $iata): static
    {
        $this->iata = $iata;

        return $this;
    }

    /**
     * @return Address[]
     */
    public function getShippingAddresses(): array
    {
        return $this->shipping;
    }

    /**
     * @return Address|null
     */
    public function getBilling(): ?Address
    {
        return $this->billing;
    }

    /**
     * @return Consumer|null
     */
    public function getConsumer(): ?Consumer
    {
        return $this->consumer;
    }

    /**
     * @param Consumer $consumer
     * @return Cart
     */
    public function setConsumer(Consumer $consumer): Cart
    {
        $this->consumer = $consumer;
        return $this;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
