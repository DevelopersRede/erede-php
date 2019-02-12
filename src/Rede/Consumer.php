<?php

namespace Rede;

use ArrayIterator;
use stdClass;

class Consumer implements RedeSerializable
{
    use SerializeTrait;

    const MALE = 'M';
    const FEMALE = 'F';

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var array
     */
    private $documents;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $gender;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var Phone
     */
    private $phone;

    /**
     * Consumer constructor.
     *
     * @param string $name
     * @param string $email
     * @param string $cpf
     */
    public function __construct($name, $email, $cpf)
    {
        $this->setName($name);
        $this->setEmail($email);
        $this->setCpf($cpf);
    }

    /**
     * @param string $type
     * @param string $number
     *
     * @return Consumer
     */
    public function addDocument($type, $number)
    {
        if ($this->documents === null) {
            $this->documents = [];
        }

        $document = new stdClass();
        $document->type = $type;
        $document->number = $number;

        $this->documents[] = $document;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     *
     * @return Consumer
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @return \ArrayIterator
     */
    public function getDocumentsIterator()
    {
        if ($this->documents === null) {
            $this->documents = [];
        }

        return new ArrayIterator($this->documents);
    }

    /**
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Consumer
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     *
     * @return Consumer
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     *
     * @return Consumer
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     *
     * @return Phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     *
     * @param Phone $phone
     *
     * @return Consumer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $ddd
     * @param string $number
     * @param int $type
     *
     * @return Consumer
     */
    public function phone($ddd, $number, $type = Phone::CELLPHONE)
    {
        return $this->setPhone(new Phone($ddd, $number, $type));
    }
}