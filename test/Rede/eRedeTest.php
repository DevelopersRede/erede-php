<?php

namespace Rede;

// Configuração da loja em modo produção
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * Class eRedeTest
 * @package Rede
 * @testdox eRede PHP SDK
 */
class eRedeTest extends TestCase
{
    /**
     * @var Store
     */
    private $store;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var integer
     */
    static private $sequence = 1;

    protected function setUp(): void
    {
        $filiation = getenv('REDE_PV');
        $token = getenv('REDE_TOKEN');
        $debug = getenv('REDE_DEBUG');

        if (empty($filiation) || empty($token)) {
            echo "Você precisa informar seu PV e Token para rodar os testes.\n";

            die;
        }

        if ((bool)$debug) {
            $this->logger = new Logger('eRede SDK Test');
            $this->logger->pushHandler(new StreamHandler('php://stdout'));
        }

        $this->store = new Store($filiation, $token, Environment::sandbox());
    }

    private function generateReferenceNumber()
    {
        return 'pedido' . (time() + eRedeTest::$sequence++);
    }

    public function testShouldAuthorizeACreditcardTransaction(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            date('Y') + 1,
            'John Snow'
        )->capture(false);

        $transaction = (new eRede($this->store, $this->logger))->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeAndCaptureACreditcardTransaction(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            date('Y') + 1,
            'John Snow'
        )->capture(true);

        $transaction = (new eRede($this->store, $this->logger))->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeACreditcardTransactionWithInstallments(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            date('Y') + 1,
            'John Snow'
        )->setInstallments(3);

        $transaction = (new eRede($this->store, $this->logger))->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeACreditcardTransactionWithSoftdescriptor(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            date('Y') + 1,
            'John Snow'
        )->setSoftDescriptor("Loja X");

        $transaction = (new eRede($this->store, $this->logger))->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeACreditcardTransactionWithAdditionalGatewayAndModuleInformation(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            date('Y') + 1,
            'John Snow'
        )->additional(1234, 56);

        $transaction = (new eRede($this->store, $this->logger))->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    /**
     * @testdox Should authorize a credit card transaction with dynamic MCC
     */
    public function testShouldAuthorizeACreditcardTransactionWithDynamicMCC(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            date('Y') + 1,
            'John Snow'
        )->mcc(
            'LOJADOZE',
            '22349202212',
            new SubMerchant(
                '1234',
                'São Paulo',
                'Brasil'
            )
        );

        $transaction = (new eRede($this->store, $this->logger))->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    /**
     * @testdox Should authorize a credit card transaction with IATA
     */
    public function testShouldAuthorizeACreditcardTransactionWithIATA(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            date('Y') + 1,
            'John Snow'
        )->iata('101010', '250');

        $transaction = (new eRede($this->store, $this->logger))->create($transaction);

        error_log(print_r($transaction, true));

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeAZeroDolarCreditcardTransaction(): void
    {
        $transaction = (new Transaction(0, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            date('Y') + 1,
            'John Snow'
        )->setSoftDescriptor("Loja X");

        $transaction = (new eRede($this->store, $this->logger))->zero($transaction);

        $this->assertEquals('174', $transaction->getReturnCode());
    }

    public function testShouldCreateADebitcardTransactionWithAuthentication(): void
    {
        $transaction = (new Transaction(25, $this->generateReferenceNumber()))->debitCard(
            '5277696455399733',
            '123',
            '12',
            date('Y') + 1,
            'John Snow'
        );

        $transaction->threeDSecure(ThreeDSecure::DECLINE_ON_FAILURE);
        $transaction->addUrl('https://redirecturl.com/3ds/success', Url::THREE_D_SECURE_SUCCESS);
        $transaction->addUrl('https://redirecturl.com/3ds/failure', Url::THREE_D_SECURE_FAILURE);

        $transaction = (new eRede($this->store, $this->logger))->create($transaction);

        $this->assertEquals('220', $transaction->getReturnCode());
        $this->assertNotEmpty($transaction->getThreeDSecure()->getUrl());

        printf("\tURL de autenticação: %s\n", $transaction->getThreeDSecure()->getUrl());
    }

    public function testShouldCaptureATransaction(): void
    {
        // First we create a new transaction
        $authorizedTransaction = (new eRede($this->store, $this->logger))->create(
            (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
                '5448280000000007',
                '235',
                '12',
                date('Y') + 1,
                'John Snow'
            )->capture(false)
        );

        // Them we capture the authorized transaction
        $capturedTransaction = (new eRede($this->store, $this->logger))
            ->capture($authorizedTransaction);

        $this->assertEquals('00', $authorizedTransaction->getReturnCode());
        $this->assertEquals('00', $capturedTransaction->getReturnCode());
    }

    public function testShouldCancelATransaction(): void
    {
        // First we create a new transaction
        $authorizedTransaction = (new eRede($this->store, $this->logger))->create(
            (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
                '5448280000000007',
                '235',
                '12',
                date('Y') + 1,
                'John Snow'
            )->capture(true)
        );

        $this->assertEquals('00', $authorizedTransaction->getReturnCode());

        // Them we capture the authorized transaction
        $canceledTransaction = (new eRede($this->store, $this->logger))
            ->cancel((new Transaction(20.99))
                ->setTid($authorizedTransaction->getTid()));

        $this->assertEquals('359', $canceledTransaction->getReturnCode());
    }

    /**
     * @testdox Should consult a transaction by its TID
     */
    public function testShouldConsultATransactionByItsTID()
    {
        // First we create a new transaction
        $authorizedTransaction = (new eRede($this->store, $this->logger))->create(
            (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
                '5448280000000007',
                '235',
                '12',
                date('Y') + 1,
                'John Snow'
            )->capture(true)
        );

        $contultedTransaction = (new eRede($this->store))->get($authorizedTransaction->getTid());

        $this->assertEquals($authorizedTransaction->getTid(), $contultedTransaction->getAuthorization()->getTid());
    }

    public function testShouldConsultATransactionByReference()
    {
        // First we create a new transaction
        $authorizedTransaction = (new eRede($this->store, $this->logger))->create(
            (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
                '5448280000000007',
                '235',
                '12',
                date('Y') + 1,
                'John Snow'
            )->capture(true)
        );

        $contultedTransaction = (new eRede($this->store))->getByReference($authorizedTransaction->getReference());

        $this->assertEquals($authorizedTransaction->getTid(), $contultedTransaction->getAuthorization()->getTid());
    }

    public function testShouldConsultTheTransactionRefunds()
    {
        // First we create a new transaction
        $authorizedTransaction = (new eRede($this->store, $this->logger))->create(
            (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
                '5448280000000007',
                '235',
                '12',
                date('Y') + 1,
                'John Snow'
            )->capture(true)
        );

        $this->assertEquals('00', $authorizedTransaction->getReturnCode());

        // Them we cancel the authorized transaction
        $canceledTransaction = (new eRede($this->store, $this->logger))
            ->cancel((new Transaction(20.99))
                ->setTid($authorizedTransaction->getTid()));

        $this->assertEquals('359', $canceledTransaction->getReturnCode());

        // Now we can consult the refunds
        $refundedTransactions = (new eRede($this->store))->getRefunds($authorizedTransaction->getTid());

        $this->assertCount(1, $refundedTransactions->getRefunds());

        foreach ($refundedTransactions->getRefunds() as $refund) {
            $this->assertEquals($canceledTransaction->getRefundId(), $refund->getRefundId());
        }
    }
}
