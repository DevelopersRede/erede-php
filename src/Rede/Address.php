<?php

namespace Rede;

class Address implements RedeSerializable
{
    use SerializeTrait;

    public const BILLING = 1;
    public const SHIPPING = 2;
    public const BOTH = 3;

    public const APARTMENT = 1;
    public const HOUSE = 2;
    public const COMMERCIAL = 3;
    public const OTHER = 4;

    /**
     * @var string|null
     */
    private ?string $address = null;

    /**
     * @var string|null
     */
    private ?string $addresseeName = null;

    /**
     * @var string|null
     */
    private ?string $city = null;

    /**
     * @var string|null
     */
    private ?string $complement = null;

    /**
     * @var string|null
     */
    private ?string $neighbourhood = null;

    /**
     * @var string|null
     */
    private ?string $number = null;

    /**
     * @var string|null
     */
    private ?string $state = null;

    /**
     * @var int|null
     */
    private ?int $type = null;

    /**
     * @var string|null
     */
    private ?string $zipCode = null;

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return $this
     */
    public function setAddress(?string $address): static
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddresseeName(): ?string
    {
        return $this->addresseeName;
    }

    /**
     * @param string|null $addresseeName
     * @return $this
     */
    public function setAddresseeName(?string $addresseeName): static
    {
        $this->addresseeName = $addresseeName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return $this
     */
    public function setCity(?string $city): static
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getComplement(): ?string
    {
        return $this->complement;
    }

    /**
     * @param string|null $complement
     * @return $this
     */
    public function setComplement(?string $complement): static
    {
        $this->complement = $complement;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNeighbourhood(): ?string
    {
        return $this->neighbourhood;
    }

    /**
     * @param string|null $neighbourhood
     * @return $this
     */
    public function setNeighbourhood(?string $neighbourhood): static
    {
        $this->neighbourhood = $neighbourhood;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     * @return $this
     */
    public function setNumber(?string $number): static
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * @param string|null $state
     * @return $this
     */
    public function setState(?string $state): static
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * @param int|null $type
     * @return $this
     */
    public function setType(?int $type): static
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    /**
     * @param string|null $zipCode
     * @return $this
     */
    public function setZipCode(?string $zipCode): static
    {
        $this->zipCode = $zipCode;
        return $this;
    }
}
