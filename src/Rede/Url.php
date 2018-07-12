<?php

namespace Rede;

class Url implements RedeSerializable
{
    use SerializeTrait;

    const CALLBACK = 'callback';
    const THREE_D_SECURE_FAILURE = 'threeDSecureFailure';
    const THREE_D_SECURE_SUCCESS = 'threeDSecureSuccess';

    private $kind = Url::CALLBACK;
    private $url;

    public function __construct($url, $kind = Url::CALLBACK)
    {
        $this->setUrl($url);
        $this->setKind($kind);
    }

    /**
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * @param string $kind
     *
     * @return Url
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     *
     * @return Url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}
