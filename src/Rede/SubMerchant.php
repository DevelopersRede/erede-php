<?php

namespace Rede;

class SubMerchant
{
    /**
     * SubMerchant constructor.
     *
     * @param string $mcc
     * @param string $city
     * @param string $country
     */
    public function __construct(private string $mcc, private string $city, private string $country)
    {
    }

    /**
     * @return string
     */
    public function getMcc(): string
    {
        return $this->mcc;
    }

    /**
     * @param string $mcc
     * @return $this
     */
    public function setMcc(string $mcc): static
    {
        $this->mcc = $mcc;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): static
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry(string $country): static
    {
        $this->country = $country;
        return $this;
    }
}
