# SDK PHP

SDK de integração eRede

# Instalação

## Dependências

* PHP >= 5.6

## Instalando o SDK

Se já possui um arquivo `composer.json`, basta adicionar a seguinte dependência ao seu projeto:

```json
{
"require": {
    "developersrede/erede-php": "*"
}
}

```

Com a dependência adicionada ao `composer.json`, basta executar:

```
composer install
```

Alternativamente, você pode executar diretamente em seu terminal:

```
composer require "developersrede/erede-php"
```

# Utilizando

## Autorizando uma transação

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new \Rede\Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
);

// Autoriza a transação
$transaction = (new \Rede\eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
```

Por padrão, a transação é capturada automaticamente; caso seja necessário apenas autorizar a transação, o método `Transaction::capture()` deverá ser chamado com o parâmetro `false`:

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new \Rede\Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
)->capture(false);

// Autoriza a transação
$transaction = (new \Rede\eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
//...
```

## Adiciona informação adicional de gateway e módulo

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new \Rede\Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
)->additional(1234, 56);

// Autoriza a transação
$transaction = (new \Rede\eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
```

## Autorizando uma transação com MCC dinâmico

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new \Rede\Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
)->mcc(
    'LOJADOZE',
    '22349202212',
    new \Rede\SubMerchant(
       '1234',
       'São Paulo',
       'Brasil'
    )
);

// Autoriza a transação
$transaction = (new \Rede\eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
//...
```

## Autorizando uma transação IATA

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new \Rede\Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
)->iata('code123', '250');

// Autoriza a transação
$transaction = (new \Rede\eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
```

## Cria uma transação com Antifraude

```php
<?php
//Define o ambiente da integração
// Ambiente de produção
$environment = \Rede\Environment::production();

// Ambiente sandbox
// $environment = \Rede\Environment::sandbox();

$environment->setIp('127.0.0.1');
$environment->setSessionId('NomeEstabelecimento-WebSessionID');

// Configuração da loja
$store = new \Rede\Store('PV', 'TOKEN', $environment);

// Transação que será autorizada
$transaction = (new \Rede\Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
);

//Dados do antifraude
$antifraud = $transaction->antifraud($environment);
$antifraud->consumer('Fulano', 'fulano@de.tal', '11111111111')
    ->setGender(\Rede\Consumer::MALE)
    ->setPhone(new \Rede\Phone('011', '999999999'))
    ->addDocument('RG', '111111111');

$antifraud->address()
    ->setAddresseeName('Fulano')
    ->setAddress('Rua dos bobos')
    ->setNumber('0')
    ->setZipCode('01122123')
    ->setNeighbourhood('Bairro legal')
    ->setCity('Cidade Bonita')
    ->setState('UF')
    ->setType(\Rede\Address::COMMERCIAL);

$antifraud->addItem(
    (new \Rede\Item('123123', 1, \Rede\Item::PHYSICAL))
        ->setAmount(200000)
        ->setDescription('Televisão')
        ->setFreight(199)
        ->setDiscount(199)
        ->setShippingType('Sedex')
);

// Autoriza a transação
$transaction = (new \Rede\eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    $antifraud = $transaction->getAntifraud();
    
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
    
    printf("\tAntifraude: %s\n", $antifraud->isSuccess() ? 'Sucesso' : 'Falha');
    printf("\tScore: %s\n", $antifraud->getScore());
    printf("\tNível de Risco: %s\n", $antifraud->getRiskLevel());
    printf("\tRecomendação: %s\n", $antifraud->getRecommendation());
}
```

## Cria uma transação com Antifraude para companhias aéreas

```php
<?php
//Define o ambiente da integração
// Ambiente de produção
$environment = \Rede\Environment::production();

// Ambiente sandbox
// $environment = \Rede\Environment::sandbox();

$environment->setIp('127.0.0.1');
$environment->setSessionId('NomeEstabelecimento-WebSessionID');

// Configuração da loja
$store = new \Rede\Store('PV', 'TOKEN', $environment);

// Transação que será autorizada
$transaction = (new \Rede\Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
);

//Dados do antifraude
$antifraud = $transaction->antifraud($environment);
$antifraud->consumer('Guilherme', 'lorem@ipsum.com', '15153855406')
    ->setGender(\Rede\Consumer::MALE)
    ->setPhone(new \Rede\Phone('011', '912341234'))
    ->addDocument('RG', '3123123123123');

$antifraud->address()
    ->setAddresseeName('Daenerys')
    ->setAddress('Avenida Paulista')
    ->setNumber('123')
    ->setComplement('Ap 2')
    ->setZipCode('01122123')
    ->setNeighbourhood('Bela Vista')
    ->setCity('Sao Paulo')
    ->setState('SP')
    ->setType(\Rede\Address::COMMERCIAL);

//Dados do voo e passageiro
$antifraud->setIata(
    (new \Rede\Flight('123213', 'Los Angeles, LA', 'New York, NY', '2017-02-15T10:54:45-9:00'))
        ->setPassenger((new \Rede\Passenger('Arya Stark', 'lorem@ipsum.com', '32423432432'))
            ->setPhone(new \Rede\Phone('011', '912341234')))
);

// Autoriza a transação
$transaction = (new \Rede\eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    $antifraud = $transaction->getAntifraud();
    
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
    
    printf("\tAntifraude: %s\n", $antifraud->isSuccess() ? 'Sucesso' : 'Falha');
    printf("\tScore: %s\n", $antifraud->getScore());
    printf("\tNível de Risco: %s\n", $antifraud->getRiskLevel());
    printf("\tRecomendação: %s\n", $antifraud->getRecommendation());
}
```

## Capturando uma transação

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será capturada
$transaction =  (new \Rede\eRede($store))->capture((new \Rede\Transaction(20.99))->setTid('TID123'));

if ($transaction->getReturnCode() == '00') {
    printf("Transação capturada com sucesso; tid=%s\n", $transaction->getTid());
}
```

## Cancelando uma transação

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será canelada
$transaction = (new \Rede\eRede($store))->cancel((new \Rede\Transaction(20.99))->setTid('TID123'));

if ($transaction->getReturnCode() == '359') {
    printf("Transação cancelada com sucesso; tid=%s\n", $transaction->getTid());
}
```

## Consultando uma transação pelo ID

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

$transaction = (new \Rede\eRede($store))->get('TID123');

printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());
```

## Consultando uma transação pela referência

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

$transaction = (new \Rede\eRede($store))->getByReference('pedido123');

printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());
```

## Consultando cancelamentos de uma transação

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

$transaction = (new \Rede\eRede($store))->getRefunds('TID123');

printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());
```

## Transação com autenticação

```php
<?php
// Configuração da loja em modo produção
$store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Configura a transação que será autorizada após a autenticação
$transaction = (new \Rede\Transaction(25, 'pedido' . time()))->debitCard(
    '5277696455399733',
    '123',
    '01',
    '2020',
    'John Snow'
);

// Configura o 3dSecure para autenticação
$transaction->threeDSecure(\Rede\ThreeDSecure::DECLINE_ON_FAILURE);
$transaction->addUrl('https://redirecturl.com/3ds/success', \Rede\Url::THREE_D_SECURE_SUCCESS);
$transaction->addUrl('https://redirecturl.com/3ds/failure', \Rede\Url::THREE_D_SECURE_FAILURE);

$transaction = (new \Rede\eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '220') {
    printf("Redirecione o cliente para \"%s\" para autenticação\n", $transaction->getThreeDSecure()->getUrl());
}
```
