<?php

namespace Rede;

class Address implements RedeSerializable
{
    use SerializeTrait;

    const BILLING = 1;
    const SHIPPING = 2;
    const BOTH = 3;

    const APARTMENT = 1;
    const HOUSE = 2;
    const COMMERCIAL = 3;
    const OTHER = 4;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $addresseeName;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $complement;

    /**
     *
     * @var string
     */
    private $neighbourhood;

    /**
     *
     * @var string
     */
    private $number;

    /**
     *
     * @var string
     */
    private $state;

    /**
     *
     * @var int
     */
    private $type;

    /**
     *
     * @var string
     */
    private $zipCode;

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getAddresseeName()
    {
        return $this->addresseeName;
    }

    /**
     * @param string $addresseeName
     *
     * @return Address
     */
    public function setAddresseeName($addresseeName)
    {
        $this->addresseeName = $addresseeName;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getComplement()
    {
        return $this->complement;
    }

    /**
     * @param string $complement
     *
     * @return Address
     */
    public function setComplement($complement)
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getNeighbourhood()
    {
        return $this->neighbourhood;
    }

    /**
     * @param string $neighbourhood
     *
     * @return Address
     */
    public function setNeighbourhood($neighbourhood)
    {
        $this->neighbourhood = $neighbourhood;
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
     *
     * @param string $number
     *
     * @return Address
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @param string $state
     *
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param int $type
     *
     * @return Address
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     *
     * @param string $zipCode
     *
     * @return Address
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;

    }
}