<?php

namespace Rede;

use ArrayIterator;
use DateTime;
use Exception;
use InvalidArgumentException;

class Transaction implements RedeSerializable, RedeUnserializable
{
    public const CREDIT = 'credit';
    public const DEBIT = 'debit';

    public const ORIGIN_EREDE = 1;
    public const ORIGIN_VISA_CHECKOUT = 4;
    public const ORIGIN_MASTERPASS = 6;

    /**
     * @var Additional|null
     */
    private ?Additional $additional = null;

    /**
     * @var Authorization|null
     */
    private ?Authorization $authorization = null;

    /**
     * @var string|null
     */
    private ?string $authorizationCode = null;

    /**
     * @var int|null
     */
    private ?int $brandTid = null;

    /**
     * @var Brand|null
     */
    private ?Brand $brand = null;

    /**
     * @var string|null
     */
    private ?string $cancelId = null;

    /**
     * @var bool|Capture|null
     */
    private bool|Capture|null $capture = null;

    /**
     * @var string|null
     */
    private ?string $cardBin = null;

    /**
     * @var string|null
     */
    private ?string $cardHolderName = null;

    /**
     * @var string|null
     */
    private ?string $cardNumber = null;

    /**
     * @var Cart|null
     */
    private ?Cart $cart = null;

    /**
     * @var DateTime|null
     */
    private ?DateTime $dateTime = null;

    /**
     * @var int|null
     */
    private ?int $distributorAffiliation = null;

    /**
     * @var int|string|null
     */
    private int|string|null $expirationMonth = null;

    /**
     * @var int|string|null
     */
    private int|string|null $expirationYear = null;

    /**
     * @var Iata|null
     */
    private ?Iata $iata = null;

    /**
     * @var int|null
     */
    private ?int $installments = null;

    /**
     * @var string|null
     */
    private ?string $kind = null;

    /**
     * @var string|null
     */
    private ?string $last4 = null;

    /**
     * @var string|null
     */
    private ?string $nsu = null;

    /**
     * @var int|null
     */
    private ?int $origin = null;

    /**
     * @var DateTime|null
     */
    private ?DateTime $refundDateTime = null;

    /**
     * @var string|null
     */
    private ?string $refundId = null;

    /**
     * @var array<Refund>
     */
    private array $refunds = [];

    /**
     * @var DateTime|null
     */
    private ?DateTime $requestDateTime = null;

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
    private ?string $securityCode = null;

    /**
     * @var string|null
     */
    private ?string $softDescriptor = null;

    /**
     * @var int|null
     */
    private ?int $storageCard = null;

    /**
     * @var bool
     */
    private ?bool $subscription = null;

    /**
     * @var ThreeDSecure|null
     */
    private ?ThreeDSecure $threeDSecure = null;

    /**
     * @var string|null
     */
    private ?string $tid = null;

    /**
     * @var array<Url>
     */
    private array $urls = [];

    /**
     * @var SubMerchant|null
     */
    private ?SubMerchant $subMerchant = null;

    /**
     * @var string|null
     */
    private ?string $paymentFacilitatorID = null;

    /**
     * @var int|null
     */
    private ?int $amount = null;

    /**
     * Transaction constructor.
     *
     * @param int|float|null $amount
     * @param string|null    $reference
     */
    public function __construct(int|float|null $amount = null, private ?string $reference = null)
    {
        if ($amount !== null) {
            $this->setAmount($amount);
        }
    }

    /**
     * @param string $url
     * @param string $kind
     *
     * @return $this
     */
    public function addUrl(string $url, string $kind = Url::CALLBACK): static
    {
        $this->urls[] = new Url($url, $kind);

        return $this;
    }

    /**
     * @param int|null $gateway
     * @param int|null $module
     *
     * @return $this
     */
    public function additional(?int $gateway = null, ?int $module = null): static
    {
        $this->additional = new Additional();

        if ($gateway !== null) {
            $this->additional->setGateway($gateway);
        }

        if ($module !== null) {
            $this->additional->setModule($module);
        }

        return $this;
    }

    /**
     * @param string     $cardNumber
     * @param string     $cardCvv
     * @param int|string $expirationMonth
     * @param int|string $expirationYear
     * @param string     $holderName
     *
     * @return $this this transaction
     */
    public function creditCard(
        string $cardNumber,
        string $cardCvv,
        int|string $expirationMonth,
        int|string $expirationYear,
        string $holderName
    ): static {
        return $this->setCard(
            $cardNumber,
            $cardCvv,
            $expirationMonth,
            $expirationYear,
            $holderName,
            Transaction::CREDIT
        );
    }

    /**
     * @param string     $cardNumber
     * @param string     $securityCode
     * @param int|string $expirationMonth
     * @param int|string $expirationYear
     * @param string     $cardHolderName
     * @param string     $kind
     *
     * @return $this this transaction
     */
    public function setCard(
        string $cardNumber,
        string $securityCode,
        int|string $expirationMonth,
        int|string $expirationYear,
        string $cardHolderName,
        string $kind
    ): static {
        $this->setCardNumber($cardNumber);
        $this->setSecurityCode($securityCode);
        $this->setExpirationMonth($expirationMonth);
        $this->setExpirationYear($expirationYear);
        $this->setCardHolderName($cardHolderName);
        $this->setKind($kind);

        return $this;
    }

    /**
     * @param string     $cardNumber
     * @param string     $cardCvv
     * @param int|string $expirationMonth
     * @param int|string $expirationYear
     * @param string     $holderName
     *
     * @return $this this transaction
     */
    public function debitCard(
        string $cardNumber,
        string $cardCvv,
        int|string $expirationMonth,
        int|string $expirationYear,
        string $holderName
    ): static {
        $this->capture();

        return $this->setCard(
            $cardNumber,
            $cardCvv,
            $expirationMonth,
            $expirationYear,
            $holderName,
            Transaction::DEBIT
        );
    }

    /**
     * @param bool $capture
     *
     * @return $this
     */
    public function capture(bool $capture = true): static
    {
        if (!$capture && $this->kind === Transaction::DEBIT) {
            throw new InvalidArgumentException('Debit transactions will always be captured');
        }

        $this->capture = $capture;
        return $this;
    }

    /**
     * @return mixed
     * @see          \JsonSerializable::jsonSerialize()
     * @noinspection PhpMixedReturnTypeCanBeReducedInspection
     */
    public function jsonSerialize(): mixed
    {
        $capture = null;

        if (is_bool($this->capture)) {
            $capture = $this->capture ? 'true' : 'false';
        }

        return array_filter(
            [
                'capture' => $capture,
                'cart' => $this->cart,
                'kind' => $this->kind,
                'threeDSecure' => $this->threeDSecure,
                'reference' => $this->reference,
                'amount' => $this->amount,
                'installments' => $this->installments,
                'cardHolderName' => $this->cardHolderName,
                'cardNumber' => $this->cardNumber,
                'expirationMonth' => $this->expirationMonth,
                'expirationYear' => $this->expirationYear,
                'securityCode' => $this->securityCode,
                'softDescriptor' => $this->softDescriptor,
                'subscription' => $this->subscription,
                'origin' => $this->origin,
                'distributorAffiliation' => $this->distributorAffiliation,
                'storageCard' => $this->storageCard,
                'urls' => $this->urls,
                'iata' => $this->iata,
                'additional' => $this->additional
            ],
            function ($value) {
                return !empty($value);
            }
        );
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|float $amount
     *
     * @return $this
     */
    public function setAmount(int|float $amount): static
    {
        $this->amount = (int)round($amount * 100);
        return $this;
    }

    /**
     * @return Authorization|null
     */
    public function getAuthorization(): ?Authorization
    {
        return $this->authorization;
    }

    /**
     * @return string|null
     */
    public function getAuthorizationCode(): ?string
    {
        return $this->authorizationCode;
    }

    /**
     * @return string|null
     */
    public function getCancelId(): ?string
    {
        return $this->cancelId;
    }

    /**
     * @return bool|Capture|null
     */
    public function getCapture(): bool|Capture|null
    {
        return $this->capture;
    }

    /**
     * @return string|null
     */
    public function getCardBin(): ?string
    {
        return $this->cardBin;
    }

    /**
     * @return string|null
     */
    public function getCardHolderName(): ?string
    {
        return $this->cardHolderName;
    }

    /**
     * @param string $cardHolderName
     *
     * @return $this
     */
    public function setCardHolderName(string $cardHolderName): static
    {
        $this->cardHolderName = $cardHolderName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     *
     * @return $this
     */
    public function setCardNumber(string $cardNumber): static
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     * @return Cart|null
     */
    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     *
     * @return $this
     */
    public function setCart(Cart $cart): static
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateTime(): ?DateTime
    {
        return $this->dateTime;
    }

    /**
     * @return int|null
     */
    public function getDistributorAffiliation(): ?int
    {
        return $this->distributorAffiliation;
    }

    /**
     * @param int $distributorAffiliation
     *
     * @return $this
     */
    public function setDistributorAffiliation(int $distributorAffiliation): static
    {
        $this->distributorAffiliation = $distributorAffiliation;
        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getExpirationMonth(): int|string|null
    {
        return $this->expirationMonth;
    }

    /**
     * @param int|string $expirationMonth
     *
     * @return $this
     */
    public function setExpirationMonth(int|string $expirationMonth): static
    {
        $this->expirationMonth = $expirationMonth;
        return $this;
    }

    /**
     * @return int|string|null
     */
    public function getExpirationYear(): int|string|null
    {
        return $this->expirationYear;
    }

    /**
     * @param int|string $expirationYear
     *
     * @return $this
     */
    public function setExpirationYear(int|string $expirationYear): static
    {
        $this->expirationYear = $expirationYear;
        return $this;
    }

    /**
     * @return Iata|null
     */
    public function getIata(): ?Iata
    {
        return $this->iata;
    }

    /**
     * @param string $code
     * @param string $departureTax
     *
     * @return $this
     */
    public function setIata(string $code, string $departureTax): static
    {
        $this->iata = new Iata();
        $this->iata->setCode($code);
        $this->iata->setDepartureTax($departureTax);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getInstallments(): ?int
    {
        return $this->installments;
    }

    /**
     * @param int $installments
     *
     * @return $this
     */
    public function setInstallments(int $installments): static
    {
        $this->installments = $installments;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getKind(): ?string
    {
        return $this->kind;
    }

    /**
     * @param string $kind
     *
     * @return $this
     */
    public function setKind(string $kind): static
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLast4(): ?string
    {
        return $this->last4;
    }

    /**
     * @return string|null
     */
    public function getNsu(): ?string
    {
        return $this->nsu;
    }

    /**
     * @return int|null
     */
    public function getOrigin(): ?int
    {
        return $this->origin;
    }

    /**
     * @param int $origin
     *
     * @return $this
     */
    public function setOrigin(int $origin): static
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return $this
     */
    public function setReference(string $reference): static
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getRefundDateTime(): ?DateTime
    {
        return $this->refundDateTime;
    }

    /**
     * @return string|null
     */
    public function getRefundId(): ?string
    {
        return $this->refundId;
    }

    /**
     * @return Refund[]
     */
    public function getRefunds(): array
    {
        return $this->refunds;
    }

    /**
     * @return DateTime|null
     */
    public function getRequestDateTime(): ?DateTime
    {
        return $this->requestDateTime;
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
     * @return string|null
     */
    public function getSecurityCode(): ?string
    {
        return $this->securityCode;
    }

    /**
     * @param string $securityCode
     *
     * @return $this
     */
    public function setSecurityCode(string $securityCode): static
    {
        $this->securityCode = $securityCode;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSoftDescriptor(): ?string
    {
        return $this->softDescriptor;
    }

    /**
     * @param string $softDescriptor
     *
     * @return $this
     */
    public function setSoftDescriptor(string $softDescriptor): static
    {
        $this->softDescriptor = $softDescriptor;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStorageCard(): ?int
    {
        return $this->storageCard;
    }

    /**
     * @param int $storageCard
     *
     * @return $this
     */
    public function setStorageCard(int $storageCard): static
    {
        $this->storageCard = $storageCard;
        return $this;
    }

    /**
     * @param string $code
     * @param string $departureTax
     *
     * @return $this
     */
    public function iata(string $code, string $departureTax): static
    {
        return $this->setIata($code, $departureTax);
    }

    /**
     * @return bool
     */
    public function isSubscription(): bool
    {
        return $this->subscription ?? false;
    }

    /**
     * @param bool $subscription
     *
     * @return $this
     */
    public function setSubscription(bool $subscription): static
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     * @return ThreeDSecure
     */
    public function getThreeDSecure(): ThreeDSecure
    {
        return $this->threeDSecure ?? new ThreeDSecure();
    }

    /**
     * @return string|null
     */
    public function getTid(): ?string
    {
        return $this->tid;
    }

    /**
     * @param string $tid
     *
     * @return $this
     */
    public function setTid(string $tid): static
    {
        $this->tid = $tid;
        return $this;
    }

    /**
     * @return ArrayIterator<int,Url>
     */
    public function getUrlsIterator(): ArrayIterator
    {
        return new ArrayIterator($this->urls);
    }

    /**
     * @param string      $softDescriptor
     * @param string      $paymentFacilitatorID
     * @param SubMerchant $subMerchant
     *
     * @return $this
     */
    public function mcc(string $softDescriptor, string $paymentFacilitatorID, SubMerchant $subMerchant): static
    {
        $this->setSoftDescriptor($softDescriptor);
        $this->setPaymentFacilitatorID($paymentFacilitatorID);
        $this->setSubMerchant($subMerchant);

        return $this;
    }

    /**
     * @return SubMerchant|null
     */
    public function getSubMerchant(): ?SubMerchant
    {
        return $this->subMerchant;
    }

    /**
     * @param SubMerchant $subMerchant
     *
     * @return $this
     */
    public function setSubMerchant(SubMerchant $subMerchant): static
    {
        $this->subMerchant = $subMerchant;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentFacilitatorID(): ?string
    {
        return $this->paymentFacilitatorID;
    }

    /**
     * @param string $paymentFacilitatorID
     *
     * @return $this
     */
    public function setPaymentFacilitatorID(string $paymentFacilitatorID): static
    {
        $this->paymentFacilitatorID = $paymentFacilitatorID;
        return $this;
    }

    /**
     * @param Device      $device
     * @param string      $onFailure
     * @param string      $mpi
     * @param string      $directoryServerTransactionId
     * @param string|null $userAgent
     * @param int         $threeDIndicator
     *
     * @return $this
     */
    public function threeDSecure(
        Device $device,
        string $onFailure = ThreeDSecure::DECLINE_ON_FAILURE,
        string $mpi = ThreeDSecure::MPI_REDE,
        string $directoryServerTransactionId = '',
        ?string $userAgent = null,
        int $threeDIndicator = 2
    ): static {
        $threeDSecure = new ThreeDSecure($device, $onFailure, $mpi, $userAgent);
        $threeDSecure->setThreeDIndicator($threeDIndicator);
        $threeDSecure->setDirectoryServerTransactionId($directoryServerTransactionId);

        $this->threeDSecure = $threeDSecure;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getBrandTid(): ?int
    {
        return $this->brandTid;
    }

    /**
     * @param int $brandTid
     *
     * @return $this
     */
    public function setBrandTid(int $brandTid): static
    {
        $this->brandTid = $brandTid;
        return $this;
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     *
     * @return $this
     */
    public function setBrand(Brand $brand): static
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @param string $serialized
     *
     * @return $this
     * @throws Exception
     */
    public function jsonUnserialize(string $serialized): static
    {
        $properties = json_decode($serialized);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(sprintf('JSON: %s', json_last_error_msg()));
        }

        foreach (get_object_vars($properties) as $property => $value) {
            if ($property == 'links') {
                continue;
            }

            match ($property) {
                'refunds' => $this->unserializeRefunds($property, $value),
                'urls' => $this->unserializeUrls($property, $value),
                'capture' => $this->unserializeCapture($property, $value),
                'authorization' => $this->unserializeAuthorization($property, $value),
                'additional' => $this->unserializeAdditional($property, $value),
                'threeDSecure' => $this->unserializeThreeDSecure($property, $value),
                'requestDateTime', 'dateTime', 'refundDateTime' => $this->unserializeRequestDateTime($property, $value),
                'brand' => $this->unserializeBrand($property, $value),
                default => $this->{$property} = $value,
            };
        }

        return $this;
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @return void
     * @throws Exception
     */
    private function unserializeRefunds(string $property, mixed $value): void
    {
        if ($property === 'refunds' && is_array($value)) {
            $this->refunds = [];

            foreach ($value as $refundValue) {
                /**
                 * @var Refund $refund
                 */
                $refund = Refund::create($refundValue);

                $this->refunds[] = $refund;
            }
        }
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @return void
     */
    private function unserializeUrls(string $property, mixed $value): void
    {
        if ($property === 'urls' && is_array($value)) {
            $this->urls = [];

            foreach ($value as $urlValue) {
                $this->urls[] = new Url($urlValue->url, $urlValue->kind);
            }
        }
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @return void
     * @throws Exception
     */
    private function unserializeCapture(string $property, mixed $value): void
    {
        if ($property === 'capture' && is_object($value)) {
            /**
             * @var Capture $capture
             */
            $capture = Capture::create($value);

            $this->capture = $capture;
        }
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @return void
     * @throws Exception
     */
    private function unserializeAuthorization(string $property, mixed $value): void
    {
        if ($property == 'authorization' && is_object($value)) {
            /**
             * @var Authorization $authorization
             */
            $authorization = Authorization::create($value);

            $this->authorization = $authorization;
        }
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @return void
     * @throws Exception
     */
    private function unserializeAdditional(string $property, mixed $value): void
    {
        if ($property == 'additional' && is_object($value)) {
            /**
             * @var Additional $additional
             */
            $additional = Additional::create($value);

            $this->additional = $additional;
        }
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @return void
     * @throws Exception
     */
    private function unserializeThreeDSecure(string $property, mixed $value): void
    {
        if ($property == 'threeDSecure' && is_object($value)) {
            /**
             * @var ThreeDSecure $threeDSecure
             */
            $threeDSecure = ThreeDSecure::create($value);

            $this->threeDSecure = $threeDSecure;
        }
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @return void
     * @throws Exception
     */
    private function unserializeRequestDateTime(string $property, mixed $value): void
    {
        if ($property == 'requestDateTime' || $property == 'dateTime' || $property == 'refundDateTime') {
            $value = new DateTime($value);
        }

        $this->{$property} = $value;
    }

    /**
     * @param string $property
     * @param mixed  $value
     * @return void
     * @throws Exception
     */
    private function unserializeBrand(string $property, mixed $value): void
    {
        if ($property == 'brand') {
            /**
             * @var Brand $brand
             */
            $brand = Brand::create($value);

            $this->brand = $brand;
        }
    }
}
