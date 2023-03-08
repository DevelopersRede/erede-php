<?php

namespace Rede;

class Brand
{
    use CreateTrait;

    /**
     * @var string|null
     */
    private ?string $name = null;

    /**
     * @var string|null
     */
    private ?string $returnCode = null;
    /**
     * @var string|null
     */
    private ?string $returnMessage = null;
    
    /**
     * @var string
     */
    private $authorizationCode = null; 
    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Brand
     */
    public function setName(?string $name): Brand
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReturnCode(): ?string
    {
        return $this->returnCode;
    }

    /**
     * @param string|null $returnCode
     * @return Brand
     */
    public function setReturnCode(?string $returnCode): Brand
    {
        $this->returnCode = $returnCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReturnMessage(): ?string
    {
        return $this->returnMessage;
    }

    /**
     * @param string|null $returnMessage
     * @return Brand
     */
    public function setReturnMessage(?string $returnMessage): Brand
    {
        $this->returnMessage = $returnMessage;
        return $this;
    }
    /**
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @param string $AuthorizationCode
     *
     * @return Brand
     */
    public function setAuthorizationCode(string $returnMessage): Brand
    {
        $this->authorizationCode = $authorizationCode;
        return $this;
    }
}
