<?php

namespace Rede;

// Configuração da loja em modo produção
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;

/**
 * Class eRedeTest
 * @package Rede
 * @testdox eRede PHP SDK
 * phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
 */
class eRedeTest extends TestCase
{
    /**
     * @var Store|null
     */
    private ?Store $store = null;

    /**
     * @var LoggerInterface|null
     */
    private ?LoggerInterface $logger = null;

    /**
     * @var int
     */
    private static int $sequence = 1;

    protected function setUp(): void
    {
        $filiation = getenv('REDE_PV');
        $token = getenv('REDE_TOKEN');
        $debug = (int)getenv('REDE_DEBUG');

        if (empty($filiation) || empty($token)) {
            throw new RuntimeException('Você precisa informar seu PV e Token para rodar os testes');
        }

        $this->logger = new Logger('eRede SDK Test');
        $this->logger->pushHandler(new StreamHandler('php://stdout', $debug ? Level::Debug : Level::Error));

        $this->store = new Store($filiation, $token, Environment::sandbox());
    }

    private function generateReferenceNumber(): string
    {
        return 'pedido' . (time() + eRedeTest::$sequence++);
    }

    public function testShouldAuthorizeACreditcardTransaction(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            (int)date('Y') + 1,
            'John Snow'
        )->capture(false);

        $transaction = $this->createERede()->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeAndCaptureACreditcardTransaction(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            (int)date('Y') + 1,
            'John Snow'
        )->capture();

        $transaction = $this->createERede()->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeACreditcardTransactionWithInstallments(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            (int)date('Y') + 1,
            'John Snow'
        )->setInstallments(3);

        $transaction = $this->createERede()->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeACreditcardTransactionWithSoftdescriptor(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            (int)date('Y') + 1,
            'John Snow'
        )->setSoftDescriptor('Loja X');

        $transaction = $this->createERede()->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeACreditcardTransactionWithAdditionalGatewayAndModuleInformation(): void
    {
        $transaction = (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            (int)date('Y') + 1,
            'John Snow'
        )->additional(1234, 56);

        $transaction = $this->createERede()->create($transaction);

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
            (int)date('Y') + 1,
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

        $transaction = $this->createERede()->create($transaction);

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
            (int)date('Y') + 1,
            'John Snow'
        )->iata('101010', '250');

        $transaction = $this->createERede()->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }

    public function testShouldAuthorizeAZeroDolarCreditcardTransaction(): void
    {
        $transaction = (new Transaction(0, $this->generateReferenceNumber()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            (int)date('Y') + 1,
            'John Snow'
        )->setSoftDescriptor('Loja X');

        $transaction = $this->createERede()->zero($transaction);

        $this->assertEquals('174', $transaction->getReturnCode());
    }

    public function testShouldCreateADebitcardTransactionWithAuthentication(): void
    {
        $transaction = (new Transaction(25, $this->generateReferenceNumber()))->debitCard(
            '5277696455399733',
            '123',
            '12',
            (int)date('Y') + 1,
            'John Snow'
        );

        $transaction->threeDSecure(
            new Device(
                ColorDepth: 1,
                DeviceType3ds: 'BROWSER',
                JavaEnabled: false,
                Language: 'BR',
                ScreenHeight: 500,
                ScreenWidth: 500,
                TimeZoneOffset: 3
            ),
            ThreeDSecure::DECLINE_ON_FAILURE
        );

        $transaction->addUrl('https://redirecturl.com/3ds/success', Url::THREE_D_SECURE_SUCCESS);
        $transaction->addUrl('https://redirecturl.com/3ds/failure', Url::THREE_D_SECURE_FAILURE);

        $transaction = $this->createERede()->create($transaction);
        $returnCode = $transaction->getReturnCode();

        $this->assertContains($returnCode, ['220', '201']);

        if ($returnCode === '220') {
            $this->assertNotEmpty($transaction->getThreeDSecure()->getUrl());

            printf("\tURL de autenticação: %s\n", $transaction->getThreeDSecure()->getUrl());
        }
    }

    public function testShouldCaptureATransaction(): void
    {
        // First we create a new transaction
        $authorizedTransaction = $this->createERede()->create(
            (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
                '5448280000000007',
                '235',
                '12',
                (int)date('Y') + 1,
                'John Snow'
            )->capture(false)
        );

        // Then we capture the authorized transaction
        $capturedTransaction = $this->createERede()
            ->capture($authorizedTransaction);

        $this->assertEquals('00', $authorizedTransaction->getReturnCode());
        $this->assertEquals('00', $capturedTransaction->getReturnCode());
    }

    public function testShouldCancelATransaction(): void
    {
        // First we create a new transaction
        $authorizedTransaction = $this->createAnAuthorizedTransaction();

        $this->assertEquals('00', $authorizedTransaction->getReturnCode());

        // Then we capture the authorized transaction
        $canceledTransaction = $this->createERede()
            ->cancel((new Transaction(20.99))
                ->setTid((string)$authorizedTransaction->getTid()));

        $this->assertEquals('359', $canceledTransaction->getReturnCode());
    }

    /**
     * @testdox Should consult a transaction by its TID
     */
    public function testShouldConsultATransactionByItsTID(): void
    {
        // First we create a new transaction
        $authorizedTransaction = $this->createAnAuthorizedTransaction();
        $contultedTransaction = $this->createERede()->get((string)$authorizedTransaction->getTid());
        $authorization = $contultedTransaction->getAuthorization();

        if ($authorization === null) {
            throw new RuntimeException('Something happened with the authorized transaction');
        }

        $this->assertEquals($authorizedTransaction->getTid(), $authorization->getTid());
    }

    public function testShouldConsultATransactionByReference(): void
    {
        // First we create a new transaction
        $authorizedTransaction = $this->createAnAuthorizedTransaction();
        $contultedTransaction = $this->createERede()->getByReference((string)$authorizedTransaction->getReference());
        $authorization = $contultedTransaction->getAuthorization();

        if ($authorization === null) {
            throw new RuntimeException('Something happened with the authorized transaction');
        }

        $this->assertEquals($authorizedTransaction->getReference(), $authorization->getReference());
    }

    public function testShouldConsultTheTransactionRefunds(): void
    {
        // First we create a new transaction
        $authorizedTransaction = $this->createAnAuthorizedTransaction();

        $this->assertEquals('00', $authorizedTransaction->getReturnCode());

        // Them we cancel the authorized transaction
        $canceledTransaction = $this->createERede()
            ->cancel((new Transaction(20.99))
                ->setTid((string)$authorizedTransaction->getTid()));

        $this->assertEquals('359', $canceledTransaction->getReturnCode());

        // Now we can consult the refunds
        $refundedTransactions = $this->createERede()->getRefunds((string)$authorizedTransaction->getTid());

        $this->assertCount(1, $refundedTransactions->getRefunds());

        foreach ($refundedTransactions->getRefunds() as $refund) {
            $this->assertEquals($canceledTransaction->getRefundId(), $refund->getRefundId());
        }
    }

    /**
     * @return Transaction
     */
    private function createAnAuthorizedTransaction(): Transaction
    {
        return $this->createERede()->create(
            (new Transaction(20.99, $this->generateReferenceNumber()))->creditCard(
                '5448280000000007',
                '235',
                12,
                (int)date('Y') + 1,
                'John Snow'
            )->capture()
        );
    }

    /**
     * @return eRede
     */
    private function createERede(): eRede
    {
        if ($this->store === null || $this->logger === null) {
            throw new RuntimeException('Store cant be null');
        }

        return new eRede($this->store, $this->logger);
    }
}
