<?php

namespace Rede;

class Url implements RedeSerializable
{
    use SerializeTrait;

    public const CALLBACK = 'callback';
    public const THREE_D_SECURE_FAILURE = 'threeDSecureFailure';
    public const THREE_D_SECURE_SUCCESS = 'threeDSecureSuccess';

    public function __construct(private string $url, private string $kind = Url::CALLBACK)
    {
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getKind(): string
    {
        return $this->kind;
    }

    /**
     * @param string $kind
     * @return $this
     */
    public function setKind(string $kind): static
    {
        $this->kind = $kind;
        return $this;
    }
}
