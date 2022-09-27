<?php

namespace Rede;

use ArrayIterator;
use stdClass;

class Consumer implements RedeSerializable
{
    use SerializeTrait;

    public const MALE = 'M';
    public const FEMALE = 'F';

    /**
     * @var array<object>
     */
    private array $documents = [];

    /**
     * @var string|null
     */
    private ?string $gender = null;

    /**
     * @var Phone|null
     */
    private ?Phone $phone = null;

    /**
     * Consumer constructor.
     *
     * @param string $name
     * @param string $email
     * @param string $cpf
     */
    public function __construct(private string $name, private string $email, private string $cpf)
    {
    }

    /**
     * @param string $type
     * @param string $number
     *
     * @return $this
     */
    public function addDocument(string $type, string $number): static
    {
        $document = new stdClass();
        $document->type = $type;
        $document->number = $number;

        $this->documents[] = $document;

        return $this;
    }

    /**
     * @return ArrayIterator<int,object>
     */
    public function getDocumentsIterator(): ArrayIterator
    {
        return new ArrayIterator($this->documents);
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return Consumer
     */
    public function setGender(string $gender): Consumer
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return Phone|null
     */
    public function getPhone(): ?Phone
    {
        return $this->phone;
    }

    /**
     * @param string $ddd
     * @param string $number
     * @param int    $type
     * @return $this
     */
    public function setPhone(string $ddd, string $number, int $type = Phone::CELLPHONE): static
    {
        $this->phone = new Phone($ddd, $number, $type);
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
     * @return Consumer
     */
    public function setName(string $name): Consumer
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
     * @return Consumer
     */
    public function setEmail(string $email): Consumer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     * @return Consumer
     */
    public function setCpf(string $cpf): Consumer
    {
        $this->cpf = $cpf;
        return $this;
    }
}
