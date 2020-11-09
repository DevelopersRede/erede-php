<?php

namespace Rede;

class Brand
{
    use CreateTrait;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $returnCode;

    /**
     * @var string
     */
    private $returnMessage;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Brand
     */
    public function setName(string $name): Brand
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnCode(): string
    {
        return $this->returnCode;
    }

    /**
     * @param string $returnCode
     *
     * @return Brand
     */
    public function setReturnCode(string $returnCode): Brand
    {
        $this->returnCode = $returnCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getReturnMessage(): string
    {
        return $this->returnMessage;
    }

    /**
     * @param string $returnMessage
     *
     * @return Brand
     */
    public function setReturnMessage(string $returnMessage): Brand
    {
        $this->returnMessage = $returnMessage;
        return $this;
    }


}