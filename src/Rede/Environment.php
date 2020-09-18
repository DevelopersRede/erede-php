<?php

namespace Rede;

use stdClass;

class Environment implements RedeSerializable
{
    const PRODUCTION = 'https://api.userede.com.br/erede';
    const SANDBOX = 'https://api.userede.com.br/desenvolvedores';
    const VERSION = 'v1';

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $sessionId;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * Creates a environment with its base url and version
     *
     * @param string $baseUrl
     * @param string $version
     */
    private function __construct($baseUrl, $version = Environment::VERSION)
    {
        $this->endpoint = sprintf('%s/%s/', $baseUrl, $version);
    }

    /**
     * @return Environment A preconfigured production environment
     */

    public static function production()
    {
        return new Environment(Environment::PRODUCTION);
    }

    /**
     * @return Environment A preconfigured sandbox environment
     */
    public static function sandbox()
    {
        return new Environment(Environment::SANDBOX);
    }

    /**
     * @param string $service
     *
     * @return string Gets the environment endpoint
     */
    public function getEndpoint($service)
    {
        return $this->endpoint . $service;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     *
     * @return Environment
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param $sessionId
     *
     * @return Environment
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        $consumer = new stdClass();
        $consumer->ip = $this->ip;
        $consumer->sessionId = $this->sessionId;

        return ['consumer' => $consumer];
    }
}
