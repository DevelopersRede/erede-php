<?php /**
 * @noinspection MessDetectorValidationInspection
 */

namespace Rede;

use ArrayIterator;
use DateTime;
use InvalidArgumentException;

class Transaction implements RedeSerializable, RedeUnserializable
{
    const CREDIT = 'credit';
    const DEBIT = 'debit';

    const ORIGIN_EREDE = 1;
    const ORIGIN_VISA_CHECKOUT = 4;
    const ORIGIN_MASTERPASS = 6;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var Antifraud
     */
    private $antifraud;

    /**
     * @var bool
     */
    private $antifraudRequired;

    /**
     * @var Authorization
     */
    private $authorization;

    /**
     *
     * @var string
     */
    private $authorizationCode;

    /**
     *
     * @var string
     */
    private $cancelId;

    /**
     *
     * @var bool|Capture
     */
    private $capture;

    /**
     *
     * @var string
     */
    private $cardBin;

    /**
     *
     * @var string
     */
    private $cardHolderName;

    /**
     *
     * @var string
     */
    private $cardNumber;

    /**
     *
     * @var Cart
     */
    private $cart;

    /**
     *
     * @var \DateTime
     */
    private $dateTime;

    /**
     *
     * @var int
     */
    private $distributorAffiliation;

    /**
     *
     * @var int
     */
    private $expirationMonth;

    /**
     *
     * @var int
     */
    private $expirationYear;

    /**
     *
     * @var Iata
     */
    private $iata;

    /**
     *
     * @var int
     */
    private $installments;

    /**
     *
     * @var string
     */
    private $kind;

    /**
     *
     * @var string
     */
    private $last4;

    /**
     *
     * @var string
     */
    private $nsu;

    /**
     *
     * @var int
     */
    private $origin;

    /**
     *
     * @var string
     */
    private $reference;

    /**
     *
     * @var string
     */
    private $refundDateTime;

    /**
     *
     * @var string
     */
    private $refundId;

    /**
     *
     * @var array[Refund]
     */
    private $refunds;

    /**
     *
     * @var DateTime
     */
    private $requestDateTime;

    /**
     *
     * @var string
     */
    private $returnCode;

    /**
     *
     * @var string
     */
    private $returnMessage;

    /**
     *
     * @var string
     */
    private $securityCode;

    /**
     *
     * @var string
     */
    private $softDescriptor;

    /**
     *
     * @var int
     */
    private $storageCard;

    /**
     *
     * @var bool
     */
    private $subscription;

    /**
     *
     * @var ThreeDSecure
     */
    private $threeDSecure;

    /**
     *
     * @var string
     */
    private $tid;

    /**
     *
     * @var array
     */
    private $urls;

    /**
     * Transaction constructor.
     *
     * @param int    $amount
     * @param string $reference
     */
    public function __construct($amount = null, $reference = null)
    {
        $this->setAmount($amount);
        $this->setReference($reference);
    }

    /**
     * @param string $url
     * @param string $kind
     *
     * @return Transaction
     */
    public function addUrl($url, $kind = Url::CALLBACK)
    {
        if ($this->urls == null) {
            $this->urls = [];
        }

        $this->urls[] = new Url($url, $kind);

        return $this;
    }

    /**
     * @param Environment $environment
     *
     * @return Cart
     */
    public function antifraud(Environment $environment)
    {
        $cart = new Cart();
        $cart->setEnvironment($environment);

        $this->setAntifraudRequired(true);
        $this->setCart($cart);

        return $cart;
    }

    /**
     * @param bool $capture
     *
     * @return Transaction
     */
    public function capture($capture = true)
    {
        if (!$capture && $this->kind === Transaction::DEBIT) {
            throw new InvalidArgumentException('Debit transactions will always be captured');
        }

        $this->capture = $capture;
        return $this;
    }

    /**
     * @param $cardNumber
     * @param $cardCvv
     * @param $expirationYear
     * @param $expirationMonth
     * @param $holderName
     *
     * @return Transaction this transaction
     */
    public function creditCard($cardNumber, $cardCvv, $expirationMonth, $expirationYear, $holderName)
    {
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
     * @param $cardNumber
     * @param $cardCvv
     * @param $expirationYear
     * @param $expirationMonth
     * @param $holderName
     *
     * @return Transaction this transaction
     */
    public function debitCard($cardNumber, $cardCvv, $expirationMonth, $expirationYear, $holderName)
    {
        $this->capture(true);

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
     * @return array
     * @see    \JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        $capture = null;

        if (is_bool($this->capture)) {
            $capture = $this->capture ? 'true' : 'false';
        }

        return array_filter(
            [
            'capture' => $capture,
                'antifraudRequired' => $this->antifraudRequired,
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
            'iata' => $this->iata
            ], function ($value) {
                return !is_null($value);
        }
        );
    }

    /**
     *
     * @param string $serialized
     *
     * @return Transaction
     */
    public function jsonUnserialize($serialized)
    {
        $properties = json_decode($serialized);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(sprintf('JSON: %s', json_last_error_msg()));
        }

        foreach (get_object_vars($properties) as $property => $value) {
            if ($property == 'links') {
                continue;
            }

            if ($property == 'refunds' && is_array($value)) {
                $this->refunds = [];

                foreach ($value as $refundValue) {
                    $this->refunds[] = Refund::create($refundValue);
                }

                continue;
            }

            if ($property == 'urls' && is_array($value)) {
                $this->urls = [];

                foreach ($value as $urlValue) {
                    $this->urls[] = new Url($urlValue->url, $urlValue->kind);
                }

                continue;
            }

            if ($property == 'capture' && is_object($value)) {
                $this->capture = Capture::create($value);

                continue;
            }

            if ($property == 'authorization' && is_object($value)) {
                $this->authorization = Authorization::create($value);

                continue;
            }

            if ($property == 'threeDSecure' && is_object($value)) {
                $this->threeDSecure = ThreeDSecure::create($value);

                continue;
            }

            if ($property == 'antifraud' && is_object($value)) {
                $this->antifraud = Antifraud::create($value);

                continue;
            }

            if ($property == 'requestDateTime' || $property == 'dateTime' || $property == 'refundDateTime') {
                $value = new DateTime($value);
            }

            $this->$property = $value;
        }

        return $this;
    }

    /**
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     *
     * @return Antifraud
     */
    public function getAntifraud()
    {
        $antifraud = $this->antifraud;

        if ($antifraud === null) {
            $antifraud = new Antifraud();
        }

        return $antifraud;
    }

    /**
     *
     * @return Authorization
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     *
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     *
     * @return string
     */
    public function getCancelId()
    {
        return $this->cancelId;
    }

    /**
     *
     * @return bool|Capture
     */
    public function getCapture()
    {
        return $this->capture;
    }

    /**
     *
     * @return string
     */
    public function getCardBin()
    {
        return $this->cardBin;
    }

    /**
     *
     * @return string
     */
    public function getCardHolderName()
    {
        return $this->cardHolderName;
    }

    /**
     *
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     *
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     *
     * @return DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     *
     * @return int
     */
    public function getDistributorAffiliation()
    {
        return $this->distributorAffiliation;
    }

    /**
     *
     * @return int
     */
    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    /**
     *
     * @return int
     */
    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    /**
     *
     * @return Iata
     */
    public function getIata()
    {
        return $this->iata;
    }

    /**
     *
     * @return int
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     *
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     *
     * @return string
     */
    public function getLast4()
    {
        return $this->last4;
    }

    /**
     *
     * @return string
     */
    public function getNsu()
    {
        return $this->nsu;
    }

    /**
     *
     * @return int
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     *
     * @return string
     */
    public function getRefundDateTime()
    {
        return $this->refundDateTime;
    }

    /**
     *
     * @return string
     */
    public function getRefundId()
    {
        return $this->refundId;
    }

    /**
     *
     * @return array
     */
    public function getRefunds()
    {
        return $this->refunds;
    }

    /**
     *
     * @return DateTime
     */
    public function getRequestDateTime()
    {
        return $this->requestDateTime;
    }

    /**
     *
     * @return string
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     *
     * @return string
     */
    public function getReturnMessage()
    {
        return $this->returnMessage;
    }

    /**
     *
     * @return string
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }

    /**
     *
     * @return string
     */
    public function getSoftDescriptor()
    {
        return $this->softDescriptor;
    }

    /**
     *
     * @return int
     */
    public function getStorageCard()
    {
        return $this->storageCard;
    }

    /**
     *
     * @return bool
     */
    public function isAntifraudRequired()
    {
        return $this->antifraudRequired;
    }

    /**
     * @param $code
     * @param $departureTax
     *
     * @return Transaction
     */
    public function iata($code, $departureTax)
    {
        return $this->setIata($code, $departureTax);
    }

    /**
     *
     * @return bool
     */
    public function isSubscription()
    {
        return $this->subscription;
    }

    /**
     *
     * @return ThreeDSecure
     */
    public function getThreeDSecure()
    {
        $threeDSecure = $this->threeDSecure;

        if ($threeDSecure == null) {
            $threeDSecure = new ThreeDSecure();
        }

        return $threeDSecure;
    }

    /**
     *
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     *
     * @return \ArrayIterator
     */
    public function getUrlsIterator()
    {
        return new ArrayIterator($this->urls);
    }

    /**
     * @param string $code
     * @param string $departureTax
     *
     * @return Transaction
     */
    public function setIata($code, $departureTax)
    {
        $this->iata = new Iata();
        $this->iata->setCode($code);
        $this->iata->setDepartureTax($departureTax);

        return $this;
    }

    /**
     *
     * @param int $amount
     *
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = (int)($amount * 100);
        return $this;
    }

    /**
     *
     * @param bool $antifraudRequired
     *
     * @return Transaction
     */
    public function setAntifraudRequired($antifraudRequired)
    {
        $this->antifraudRequired = $antifraudRequired;
        return $this;
    }

    /**
     * @param $cardNumber
     * @param $securityCode
     * @param $expirationMonth
     * @param $expirationYear
     * @param $cardHolderName
     * @param $kind
     *
     * @return Transaction this transaction
     */
    public function setCard($cardNumber, $securityCode, $expirationMonth, $expirationYear, $cardHolderName, $kind)
    {
        $this->setCardNumber($cardNumber);
        $this->setSecurityCode($securityCode);
        $this->setExpirationMonth($expirationMonth);
        $this->setExpirationYear($expirationYear);
        $this->setCardHolderName($cardHolderName);
        $this->setKind($kind);

        return $this;
    }

    /**
     *
     * @param string $cardHolderName
     *
     * @return Transaction
     */
    public function setCardHolderName($cardHolderName)
    {
        $this->cardHolderName = $cardHolderName;
        return $this;
    }

    /**
     *
     * @param string $cardNumber
     *
     * @return Transaction
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
        return $this;
    }

    /**
     *
     * @param Cart $cart
     *
     * @return Transaction
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     *
     * @param int $distributorAffiliation
     *
     * @return Transaction
     */
    public function setDistributorAffiliation($distributorAffiliation)
    {
        $this->distributorAffiliation = $distributorAffiliation;
        return $this;
    }

    /**
     *
     * @param int $expirationMonth
     *
     * @return Transaction
     */
    public function setExpirationMonth($expirationMonth)
    {
        $this->expirationMonth = $expirationMonth;
        return $this;
    }

    /**
     *
     * @param int $expirationYear
     *
     * @return Transaction
     */
    public function setExpirationYear($expirationYear)
    {
        $this->expirationYear = $expirationYear;
        return $this;
    }

    /**
     *
     * @param int $installments
     *
     * @return Transaction
     */
    public function setInstallments($installments)
    {
        $this->installments = $installments;
        return $this;
    }

    /**
     *
     * @param string $kind
     *
     * @return Transaction
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
        return $this;
    }

    /**
     *
     * @param int $origin
     *
     * @return Transaction
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
        return $this;
    }

    /**
     *
     * @param string $reference
     *
     * @return Transaction
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     *
     * @param string $securityCode
     *
     * @return Transaction
     */
    public function setSecurityCode($securityCode)
    {
        $this->securityCode = $securityCode;
        return $this;
    }

    /**
     *
     * @param string $softDescriptor
     *
     * @return Transaction
     */
    public function setSoftDescriptor($softDescriptor)
    {
        $this->softDescriptor = $softDescriptor;
        return $this;
    }

    /**
     *
     * @param int $storageCard
     *
     * @return Transaction
     */
    public function setStorageCard($storageCard)
    {
        $this->storageCard = $storageCard;
        return $this;
    }

    /**
     *
     * @param bool $subscription
     *
     * @return Transaction
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     *
     * @param string $tid
     *
     * @return Transaction
     */
    public function setTid($tid)
    {
        $this->tid = $tid;
        return $this;
    }

    /**
     * @param string $onFailure
     * @param bool $embed
     * @param string $directoryServerTransactionId
     * @param string $threeDIndicator
     *
     * @return Transaction
     */
    public function threeDSecure($onFailure = ThreeDSecure::DECLINE_ON_FAILURE, $embed = true, $directoryServerTransactionId = "", $threeDIndicator = "1")
    {
        $threeDSecure = new ThreeDSecure();
        $threeDSecure->setOnFailure($onFailure);
        $threeDSecure->setEmbedded($embed);
        $threeDSecure->setThreeDIndicator($threeDIndicator);
        $threeDSecure->setDirectoryServerTransactionId($directoryServerTransactionId);

        $this->threeDSecure = $threeDSecure;

        return $this;
    }
}
