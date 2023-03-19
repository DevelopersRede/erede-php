<?php

namespace Rede;

class ThreeDSecure implements RedeSerializable
{
    use CreateTrait;
    use SerializeTrait;

    public const DATA_ONLY = 'DATA_ONLY';

    public const CONTINUE_ON_FAILURE = 'continue';
    public const DECLINE_ON_FAILURE = 'decline';

    public const MPI_REDE = 'mpi_rede';
    public const MPI_THIRD_PARTY = 'mpi_third_party';

    /**
     * @var string|null
     */
    private ?string $cavv = null;

    /**
     * @var string|null
     */
    private ?string $eci = null;

    /**
     * @var string|null
     */
    private ?string $url = null;

    /**
     * @var string|null
     */
    private ?string $xid = null;

    /**
     * @var int
     */
    private int $threeDIndicator = 2;

    /**
     * @var string|null
     */
    private ?string $DirectoryServerTransactionId = null;

    /**
     * @var string
     */
    private string $userAgent;

    /**
     * @var bool
     */
    private bool $embedded;

    /**
     * @var string|null
     */
    private ?string $returnCode = null;

    /**
     * @var string|null
     */
    private ?string $returnMessage = null;

    /**
     * @var string|null
     */
    private ?string $challengePreference = null;

    /**
     * ThreeDSecure constructor.
     *
     * @param Device|null $Device    User device data.
     * @param string      $onFailure What to do in case of failure.
     * @param string      $mpi       The MPI is from Rede or third party.
     * @param string|null $userAgent The user' user-agent.
     */
    public function __construct(
        private readonly ?Device $Device = null,
        private string $onFailure = self::DECLINE_ON_FAILURE,
        string $mpi = ThreeDSecure::MPI_REDE,
        string $userAgent = null
    ) {
        if ($userAgent === null) {
            $userAgent = eRede::USER_AGENT;

            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $userAgent = $_SERVER['HTTP_USER_AGENT'];
            }
        }

        $this->embedded = $mpi === ThreeDSecure::MPI_REDE;
        $this->userAgent = $userAgent;
    }

    /**
     * @return string|null
     */
    public function getReturnCode(): ?string
    {
        return $this->returnCode;
    }

    /**
     * @return string|null
     */
    public function getReturnMessage(): ?string
    {
        return $this->returnMessage;
    }

    /**
     * @return Device
     */
    public function getDevice(): Device
    {
        return $this->Device;
    }

    /**
     * @return int
     */
    public function getThreeDIndicator(): int
    {
        return $this->threeDIndicator;
    }

    /**
     * @param int $threeDIndicator
     *
     * @return $this
     */
    public function setThreeDIndicator(int $threeDIndicator): static
    {
        /**
         * Support for 3DS 1 will be discontinued.
         */
        if ($threeDIndicator < 2) {
            trigger_error(
                'Effective 15 October 2022, support for 3DS 1 and all related technology is discontinued.',
                time() > strtotime('2022-10-15') ? E_USER_ERROR : E_USER_DEPRECATED
            );
        }

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
     * @return string|null
     */
    public function getUserAgent(): ?string
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

    /**
     * @return string|null
     */
    public function getChallengePreference(): ?string
    {
        return $this->challengePreference;
    }

    /**
     * @param string|null $challengePreference
     * @return ThreeDSecure
     */
    public function setChallengePreference(?string $challengePreference): ThreeDSecure
    {
        $this->challengePreference = $challengePreference;
        return $this;
    }
}
