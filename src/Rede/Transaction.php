<?php /**
 * @noinspection MessDetectorValidationInspection
 */

namespace Rede;

use ArrayIterator;
use DateTime;
use Exception;
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
     * @var Additional
     */
    private $additional;

    /**
     * @var Authorization
     */
    private $authorization;

    /**
     * @var string
     */
    private $authorizationCode;

    /**
     * @var int
     */
    private $brandTid;

    /**
     * @var Brand
     */
    private $brand;

    /**
     * @var string
     */
    private $cancelId;

    /**
     * @var bool|Capture
     */
    private $capture;

    /**
     * @var string
     */
    private $cardBin;

    /**
     * @var string
     */
    private $cardHolderName;

    /**
     * @var string
     */
    private $cardNumber;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var int
     */
    private $distributorAffiliation;

    /**
     * @var int
     */
    private $expirationMonth;

    /**
     * @var int
     */
    private $expirationYear;

    /**
     * @var Iata
     */
    private $iata;

    /**
     * @var int
     */
    private $installments;

    /**
     * @var string
     */
    private $kind;

    /**
     * @var string
     */
    private $last4;

    /**
     * @var string
     */
    private $nsu;

    /**
     * @var int
     */
    private $origin;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $refundDateTime;

    /**
     * @var string
     */
    private $refundId;

    /**
     * @var array[Refund]
     */
    private $refunds;

    /**
     * @var DateTime
     */
    private $requestDateTime;

    /**
     * @var string
     */
    private $returnCode;

    /**
     * @var string
     */
    private $returnMessage;

    /**
     * @var string
     */
    private $securityCode;

    /**
     * @var string
     */
    private $softDescriptor;

    /**
     * @var int
     */
    private $storageCard;

    /**
     * @var bool
     */
    private $subscription;

    /**
     * @var ThreeDSecure
     */
    private $threeDSecure;

    /**
     * @var string
     */
    private $tid;

    /**
     * @var array
     */
    private $urls;

    /**
     * @var SubMerchant
     */
    private $subMerchant;

    /**
     * @var string
     */
    private $paymentFacilitatorID;

    /**
     * Transaction constructor.
     *
     * @param int $amount
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
     * @param integer $gateway
     * @param integer $module
     *
     * @return Transaction
     */
    public function additional($gateway = null, $module = null)
    {
        $this->additional = new Additional();
        $this->additional->setGateway($gateway);
        $this->additional->setModule($module);

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
            ], function ($value) {
            return !is_null($value);
        }
        );
    }

    /**
     * @param string $serialized
     *
     * @return Transaction
     * @throws Exception
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

            if ($property == 'additional' && is_object($value)) {
                $this->additional = Additional::create($value);

                continue;
            }

            if ($property == 'threeDSecure' && is_object($value)) {
                $this->threeDSecure = ThreeDSecure::create($value);

                continue;
            }

            if ($property == 'requestDateTime' || $property == 'dateTime' || $property == 'refundDateTime') {
                $value = new DateTime($value);
            }

            if ($property == 'brand') {
                $this->brand = Brand::create($value);

                continue;
            }

            $this->$property = $value;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = round($amount * 100);
        return $this;
    }

    /**
     * @return Authorization
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @return string
     */
    public function getAuthorizationCode()
    {
        return $this->authorizationCode;
    }

    /**
     * @return string
     */
    public function getCancelId()
    {
        return $this->cancelId;
    }

    /**
     * @return bool|Capture
     */
    public function getCapture()
    {
        return $this->capture;
    }

    /**
     * @return string
     */
    public function getCardBin()
    {
        return $this->cardBin;
    }

    /**
     * @return string
     */
    public function getCardHolderName()
    {
        return $this->cardHolderName;
    }

    /**
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
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
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
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
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
     * @return DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return int
     */
    public function getDistributorAffiliation()
    {
        return $this->distributorAffiliation;
    }

    /**
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
     * @return int
     */
    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    /**
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
     * @return int
     */
    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    /**
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
     * @return Iata
     */
    public function getIata()
    {
        return $this->iata;
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
     * @return int
     */
    public function getInstallments()
    {
        return $this->installments;
    }

    /**
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
     * @return string
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
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
     * @return string
     */
    public function getLast4()
    {
        return $this->last4;
    }

    /**
     * @return string
     */
    public function getNsu()
    {
        return $this->nsu;
    }

    /**
     * @return int
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
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
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
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
     * @return string
     */
    public function getRefundDateTime()
    {
        return $this->refundDateTime;
    }

    /**
     * @return string
     */
    public function getRefundId()
    {
        return $this->refundId;
    }

    /**
     * @return array
     */
    public function getRefunds()
    {
        return $this->refunds;
    }

    /**
     * @return DateTime
     */
    public function getRequestDateTime()
    {
        return $this->requestDateTime;
    }

    /**
     * @return string
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * @return string
     */
    public function getReturnMessage()
    {
        return $this->returnMessage;
    }

    /**
     * @return string
     */
    public function getSecurityCode()
    {
        return $this->securityCode;
    }

    /**
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
     * @return string
     */
    public function getSoftDescriptor()
    {
        return $this->softDescriptor;
    }

    /**
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
     * @return int
     */
    public function getStorageCard()
    {
        return $this->storageCard;
    }

    /**
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
     * @return bool
     */
    public function isSubscription()
    {
        return $this->subscription;
    }

    /**
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
     * @return string
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
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
     * @return ArrayIterator
     */
    public function getUrlsIterator()
    {
        return new ArrayIterator($this->urls);
    }

    /**
     * @param $softDescriptor
     * @param $paymentFacilitatorID
     * @param SubMerchant $subMerchant
     *
     * @return $this
     */
    public function mcc($softDescriptor, $paymentFacilitatorID, SubMerchant $subMerchant)
    {
        $this->setSoftDescriptor($softDescriptor);
        $this->setPaymentFacilitatorID($paymentFacilitatorID);
        $this->setSubMerchant($subMerchant);

        return $this;
    }

    /**
     * @return SubMerchant
     */
    public function getSubMerchant()
    {
        return $this->subMerchant;
    }

    /**
     * @param SubMerchant $subMerchant
     *
     * @return Transaction
     */
    public function setSubMerchant($subMerchant)
    {
        $this->subMerchant = $subMerchant;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentFacilitatorID()
    {
        return $this->paymentFacilitatorID;
    }

    /**
     * @param string $paymentFacilitatorID
     *
     * @return Transaction
     */
    public function setPaymentFacilitatorID($paymentFacilitatorID)
    {
        $this->paymentFacilitatorID = $paymentFacilitatorID;
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
    public function threeDSecure(
        $onFailure = ThreeDSecure::DECLINE_ON_FAILURE,
        $embed = true,
        $directoryServerTransactionId = "",
        $threeDIndicator = "1"
    ) {
        $threeDSecure = new ThreeDSecure();
        $threeDSecure->setOnFailure($onFailure);
        $threeDSecure->setEmbedded($embed);
        $threeDSecure->setThreeDIndicator($threeDIndicator);
        $threeDSecure->setDirectoryServerTransactionId($directoryServerTransactionId);

        $this->threeDSecure = $threeDSecure;

        return $this;
    }

    /**
     * @return int
     */
    public function getBrandTid()
    {
        return $this->brandTid;
    }

    /**
     * @param int $brandTid
     *
     * @return Transaction
     */
    public function setBrandTid(int $brandTid)
    {
        $this->brandTid = $brandTid;
        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     *
     * @return Transaction
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
        return $this;
    }
}
