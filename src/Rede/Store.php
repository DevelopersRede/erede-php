<?php

namespace Rede;

class Store
{
    /**
     * Which environment will this store used for?
     * @var Environment
     */
    private $environment;

    /**
     * The unique identifier of the store
     * @var string
     */
    private $filiation;

    /**
     * The security token that will be used to guarantee the transaction integrity
     * @var string
     */
    private $token;

    /**
     * Creates a store.
     *
     * @param string $filiation
     * @param string $token
     * @param Environment $environment if none provided, production will be used.
     */
    public function __construct($filiation, $token, Environment $environment = null)
    {
        $environment = $environment != null ? $environment : Environment::production();

        $this->setFiliation($filiation);
        $this->setToken($token);
        $this->setEnvironment($environment);
    }

    /**
     * @return Environment
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param Environment $environment
     *
     * @return Store
     */
    public function setEnvironment(Environment $environment)
    {
        $this->environment = $environment;
        return $this;
    }

    /**
     * @return string
     */
    public function getFiliation()
    {
        return $this->filiation;
    }

    /**
     * @param string $filiation
     *
     * @return Store
     */
    public function setFiliation($filiation)
    {
        $this->filiation = $filiation;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return Store
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }
}
