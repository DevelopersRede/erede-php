<?php

namespace Rede;


class SubMerchant
{
    /**
     * @var string
     */
    private $mcc;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $country;

    /**
     * SubMerchant constructor.
     *
     * @param $mcc
     * @param $city
     * @param $country
     */
    public function __construct($mcc, $city, $country)
    {
        $this->setMcc($mcc);
        $this->setCity($city);
        $this->setCountry($country);
    }

    /**
     * @return string
     */
    public function getMcc()
    {
        return $this->mcc;
    }

    /**
     * @param string $mcc
     * @return SubMerchant
     */
    public function setMcc($mcc)
    {
        $this->mcc = $mcc;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return SubMerchant
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return SubMerchant
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

}