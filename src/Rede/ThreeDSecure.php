<?php

namespace Rede;

class ThreeDSecure implements RedeSerializable
{
    use CreateTrait;
    use SerializeTrait;

    public const CONTINUE_ON_FAILURE = 'continue';
    public const DECLINE_ON_FAILURE = 'decline';

    /**
     * @var string|null
     */
    private ?string $cavv = null;

    /**
     * @var string|null
     */
    private ?string $eci = null;

    /**
     * @var bool
     */
    private bool $embedded = true;

    /**
     * @var string
     */
    private string $onFailure = self::DECLINE_ON_FAILURE;

    /**
     * @var string|null
     */
    private ?string $url = null;

    /**
     * @var string
     */
    private string $userAgent;

    /**
     * @var string|null
     */
    private ?string $xid = null;

    /**
     * @var string
     */
    private string $threeDIndicator = '1';

    /**
     * @var string|null
     */
    private ?string $DirectoryServerTransactionId = null;

    /**
     * ThreeDSecure constructor.
     */
    public function __construct()
    {
        $userAgent = eRede::USER_AGENT;

        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
        }

        $this->setUserAgent($userAgent);
    }

    /**
     * @return string
     */
    public function getThreeDIndicator(): string
    {
        return $this->threeDIndicator;
    }

    /**
     * @param string $threeDIndicator
     *
     * @return $this
     */
    public function setThreeDIndicator(string $threeDIndicator): static
    {
        $this->threeDIndicator = $threeDIndicator;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDirectoryServerTransactionId(): ?string
    {
        return $this->DirectoryServerTransactionId;
    }

    /**
     * @param string $DirectoryServerTransactionId
     *
     * @return $this
     */
    public function setDirectoryServerTransactionId(string $DirectoryServerTransactionId): static
    {
        $this->DirectoryServerTransactionId = $DirectoryServerTransactionId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCavv(): ?string
    {
        return $this->cavv;
    }

    /**
     * @param string $cavv
     *
     * @return $this
     */
    public function setCavv(string $cavv): static
    {
        $this->cavv = $cavv;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEci(): ?string
    {
        return $this->eci;
    }

    /**
     * @param string $eci
     *
     * @return $this
     */
    public function setEci(string $eci): static
    {
        $this->eci = $eci;
        return $this;
    }

    /**
     * @return string
     */
    public function getOnFailure(): string
    {
        return $this->onFailure;
    }

    /**
     * @param string $onFailure
     *
     * @return $this
     */
    public function setOnFailure(string $onFailure): static
    {
        $this->onFailure = $onFailure;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
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
    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    /**
     * @param string $userAgent
     *
     * @return $this
     */
    public function setUserAgent(string $userAgent): static
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getXid(): ?string
    {
        return $this->xid;
    }

    /**
     * @param string $xid
     *
     * @return $this
     */
    public function setXid(string $xid): static
    {
        $this->xid = $xid;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEmbedded(): bool
    {
        return $this->embedded;
    }

    /**
     * @param bool $embedded
     *
     * @return $this
     */
    public function setEmbedded(bool $embedded): static
    {
        $this->embedded = $embedded;
        return $this;
    }
}
