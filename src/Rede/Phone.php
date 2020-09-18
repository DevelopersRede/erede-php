<?php

namespace Rede;

class Phone implements RedeSerializable
{
    use SerializeTrait;

    const CELLPHONE = 1;
    const HOME = 2;
    const WORK = 3;
    const OTHER = 4;

    /**
     * @var string
     */
    private $ddd;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $type;

    /**
     * Phone constructor.
     *
     * @param $ddd
     * @param $number
     * @param int $type
     */
    public function __construct($ddd, $number, $type = Phone::CELLPHONE)
    {
        $this->setDdd($ddd);
        $this->setNumber($number);
        $this->setType($type);
    }

    /**
     * @return string
     */
    public function getDdd()
    {
        return $this->ddd;
    }

    /**
     * @param string $ddd
     *
     * @return Phone
     */
    public function setDdd($ddd)
    {
        $this->ddd = $ddd;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     *
     * @return Phone
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Phone
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}