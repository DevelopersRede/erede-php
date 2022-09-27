<?php

namespace Rede;

class Store
{
    /**
     * Which environment will this store used for?
     * @var Environment
     */
    private Environment $environment;

    /**
     * Creates a store.
     *
     * @param string           $filiation
     * @param string           $token
     * @param Environment|null $environment if none provided, production will be used.
     */
    public function __construct(private string $filiation, private string $token, ?Environment $environment = null)
    {
        $this->environment = $environment ?? Environment::production();
    }

    /**
     * @return Environment
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    /**
     * @param Environment $environment
     *
     * @return $this
     */
    public function setEnvironment(Environment $environment): static
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return string
     */
    public function getFiliation(): string
    {
        return $this->filiation;
    }

    /**
     * @param string $filiation
     *
     * @return $this
     */
    public function setFiliation(string $filiation): static
    {
        $this->filiation = $filiation;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken(string $token): static
    {
        $this->token = $token;
        return $this;
    }
}
