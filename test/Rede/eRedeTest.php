<?php

namespace Rede;

// Configuração da loja em modo produção
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class eRedeTest extends TestCase
{
    const FILIATION = '10000850';
    const TOKEN = 'eb3c322b84ff475c95abb16673659664';

    public function testShouldAuthorizeACreditCardTransaction()
    {
        $store = new Store(eRedeTest::FILIATION, eRedeTest::TOKEN, Environment::sandbox());

        $transaction = (new Transaction(20.99, 'pedido' . time()))->creditCard(
            '5448280000000007',
            '235',
            '12',
            date('Y') + 1,
            'John Snow'
        );

        $logger = new Logger('eRede SDK Test');
        $logger->pushHandler(new StreamHandler('php://stdout'));

        $transaction = (new eRede($store, $logger))->create($transaction);

        $this->assertEquals('00', $transaction->getReturnCode());
    }
}
