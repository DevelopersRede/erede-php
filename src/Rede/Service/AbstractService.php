<?php

namespace Rede\Service;

use CurlHandle;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Rede\eRede;
use Rede\Exception\RedeException;
use Rede\Store;
use Rede\Transaction;
use RuntimeException;

abstract class AbstractService
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';

    /**
     * @var string|null
     */
    private ?string $platform = null;

    /**
     * @var string|null
     */
    private ?string $platformVersion = null;

    /**
     * AbstractService constructor.
     *
     * @param Store                $store
     * @param LoggerInterface|null $logger
     */
    public function __construct(protected Store $store, protected ?LoggerInterface $logger = null)
    {
    }

    /**
     * @param string|null $platform
     * @param string|null $platformVersion
     *
     * @return $this
     */
    public function platform(?string $platform, ?string $platformVersion): static
    {
        $this->platform = $platform;
        $this->platformVersion = $platformVersion;

        return $this;
    }

    /**
     * @return Transaction
     * @throws InvalidArgumentException
     * @throws RuntimeException
     * @throws RedeException
     */
    abstract public function execute(): Transaction;

    /**
     * @param string $body
     * @param string $method
     *
     * @return Transaction
     * @throws RuntimeException
     */
    protected function sendRequest(string $body = '', string $method = 'GET'): Transaction
    {
        $userAgent = $this->getUserAgent();
        $headers = [
            str_replace(
                '  ',
                ' ',
                $userAgent
            ),
            'Accept: application/json',
            'Transaction-Response: brand-return-opened'
        ];

        $curl = curl_init($this->store->getEnvironment()->getEndpoint($this->getService()));

        if (!$curl instanceof CurlHandle) {
            throw new RuntimeException('Was not possible to create a curl instance.');
        }

        curl_setopt(
            $curl,
            CURLOPT_USERPWD,
            sprintf('%s:%s', $this->store->getFiliation(), $this->store->getToken())
        );

        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        switch ($method) {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }

        if ($body !== '') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

            $headers[] = 'Content-Type: application/json; charset=utf8';
        } else {
            $headers[] = 'Content-Length: 0';
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $this->logger?->debug(
            trim(
                sprintf(
                    "Request Rede\n%s %s\n%s\n\n%s",
                    $method,
                    $this->store->getEnvironment()->getEndpoint($this->getService()),
                    implode("\n", $headers),
                    preg_replace('/"(cardHolderName|cardnumber|securitycode)":"[^"]+"/i', '"\1":"***"', $body)
                )
            )
        );

        $response = curl_exec($curl);
        $httpInfo = curl_getinfo($curl);

        $this->logger?->debug(
            sprintf(
                "Response Rede\nStatus Code: %s\n\n%s",
                $httpInfo['http_code'],
                $response
            )
        );

        $this->dumpHttpInfo($httpInfo);

        if (curl_errno($curl)) {
            throw new RuntimeException(sprintf('Curl error[%s]: %s', curl_errno($curl), curl_error($curl)));
        }

        if (!is_string($response)) {
            throw new RuntimeException('Error obtaining a response from the API');
        }

        curl_close($curl);

        return $this->parseResponse($response, $httpInfo['http_code']);
    }

    /**
     * Gets the User-Agent string.
     *
     * @return string
     */
    private function getUserAgent(): string
    {
        $userAgent = sprintf(
            'User-Agent: %s',
            sprintf(
                eRede::USER_AGENT,
                phpversion(),
                $this->store->getFiliation(),
                php_uname('s'),
                php_uname('r'),
                php_uname('m')
            )
        );

        if (!empty($this->platform) && !empty($this->platformVersion)) {
            $userAgent .= sprintf(' %s/%s', $this->platform, $this->platformVersion);
        }

        $curlVersion = curl_version();

        if (is_array($curlVersion)) {
            $userAgent .= sprintf(
                ' curl/%s %s',
                $curlVersion['version'] ?? '',
                $curlVersion['ssl_version'] ?? ''
            );
        }

        return $userAgent;
    }

    /**
     * @return string Gets the service that will be used on the request
     */
    abstract protected function getService(): string;

    /**
     * Dumps the httpInfo log
     *
     * @param array<mixed> $httpInfo The http info.
     * @return void
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    private function dumpHttpInfo(array $httpInfo): void
    {
        foreach ($httpInfo as $key => $info) {
            if (is_array($info)) {
                foreach ($info as $infoKey => $infoValue) {
                    $this->logger?->debug(sprintf('Curl[%s][%s]: %s', $key, $infoKey, implode(',', $infoValue)));
                }

                continue;
            }

            $this->logger?->debug(sprintf('Curl[%s]: %s', $key, $info));
        }
    }

    /**
     * @param string $response   Parses the HTTP response from Rede
     * @param int    $statusCode The HTTP status code
     *
     * @return Transaction
     */
    abstract protected function parseResponse(string $response, int $statusCode): Transaction;
}
