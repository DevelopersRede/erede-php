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
use Rede\Environment;use Rede\eRede;use Rede\Store;use Rede\Transaction;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
);

// Autoriza a transação
$transaction = (new eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
```

Por padrão, a transação é capturada automaticamente; caso seja necessário apenas autorizar a transação, o método `Transaction::capture()` deverá ser chamado com o parâmetro `false`:

```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;use Rede\Transaction;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
)->capture(false);

// Autoriza a transação
$transaction = (new eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
//...
```

## Adiciona configuração de parcelamento
```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;use Rede\Transaction;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
);

// Configuração de parcelamento
$transaction->setInstallments(3);

// Autoriza a transação
$transaction = (new eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
```

## Adiciona informação adicional de gateway e módulo

```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;use Rede\Transaction;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
)->additional(1234, 56);

// Autoriza a transação
$transaction = (new eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
```

## Autorizando uma transação com MCC dinâmico

```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;use Rede\SubMerchant;use Rede\Transaction;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
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

// Autoriza a transação
$transaction = (new eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
//...
```

## Autorizando uma transação IATA

```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;use Rede\Transaction;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será autorizada
$transaction = (new Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
)->iata('code123', '250');

// Autoriza a transação
$transaction = (new eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '00') {
    printf("Transação autorizada com sucesso; tid=%s\n", $transaction->getTid());
}
```

## Cria uma transação com Antifraude

```php
<?php
//Define o ambiente da integração
// Ambiente de produção
use Rede\Address;use Rede\Consumer;use Rede\Environment;use Rede\eRede;use Rede\Item;use Rede\Phone;use Rede\Store;use Rede\Transaction;$environment = Environment::production();

// Ambiente sandbox
// $environment = \Rede\Environment::sandbox();

$environment->setIp('127.0.0.1');
$environment->setSessionId('NomeEstabelecimento-WebSessionID');

// Configuração da loja
$store = new Store('PV', 'TOKEN', $environment);

// Transação que será autorizada
$transaction = (new Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
);

//Dados do antifraude
$antifraud = $transaction->antifraud();
$antifraud->consumer('Fulano', 'fulano@de.tal', '11111111111')
    ->setGender(Consumer::MALE)
    ->setPhone(new Phone('011', '999999999'))
    ->addDocument('RG', '111111111');

$antifraud->address()
    ->setAddresseeName('Fulano')
    ->setAddress('Rua dos bobos')
    ->setNumber('0')
    ->setZipCode('01122123')
    ->setNeighbourhood('Bairro legal')
    ->setCity('Cidade Bonita')
    ->setState('UF')
    ->setType(Address::COMMERCIAL);

$antifraud->addItem(
    (new Item('123123', 1, Item::PHYSICAL))
        ->setAmount(200000)
        ->setDescription('Televisão')
        ->setFreight(199)
        ->setDiscount(199)
        ->setShippingType('Sedex')
);

// Autoriza a transação
$transaction = (new eRede($store))->create($transaction);

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
use Rede\Address;use Rede\Consumer;use Rede\Environment;use Rede\eRede;use Rede\Flight;use Rede\Passenger;use Rede\Phone;use Rede\Store;use Rede\Transaction;$environment = Environment::production();

// Ambiente sandbox
// $environment = \Rede\Environment::sandbox();

$environment->setIp('127.0.0.1');
$environment->setSessionId('NomeEstabelecimento-WebSessionID');

// Configuração da loja
$store = new Store('PV', 'TOKEN', $environment);

// Transação que será autorizada
$transaction = (new Transaction(20.99, 'pedido' . time()))->creditCard(
    '5448280000000007',
    '235',
    '12',
    '2020',
    'John Snow'
);

//Dados do antifraude
$antifraud = $transaction->antifraud();
$antifraud->consumer('Guilherme', 'lorem@ipsum.com', '15153855406')
    ->setGender(Consumer::MALE)
    ->setPhone(new Phone('011', '912341234'))
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
    ->setType(Address::COMMERCIAL);

//Dados do voo e passageiro
$antifraud->setIata(
    (new Flight('123213', 'Los Angeles, LA', 'New York, NY', '2017-02-15T10:54:45-9:00'))
        ->setPassenger((new Passenger('Arya Stark', 'lorem@ipsum.com', '32423432432'))
            ->setPhone(new Phone('011', '912341234')))
);

// Autoriza a transação
$transaction = (new eRede($store))->create($transaction);

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
use Rede\Environment;use Rede\eRede;use Rede\Store;use Rede\Transaction;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será capturada
$transaction =  (new eRede($store))->capture((new Transaction(20.99))->setTid('TID123'));

if ($transaction->getReturnCode() == '00') {
    printf("Transação capturada com sucesso; tid=%s\n", $transaction->getTid());
}
```

## Cancelando uma transação

```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;use Rede\Transaction;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Transação que será cancelada
$transaction = (new eRede($store))->cancel((new Transaction(20.99))->setTid('TID123'));

if ($transaction->getReturnCode() == '359') {
    printf("Transação cancelada com sucesso; tid=%s\n", $transaction->getTid());
}
```

## Consultando uma transação pelo ID

```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

$transaction = (new eRede($store))->get('TID123');

printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());
```

## Consultando uma transação pela referência

```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

$transaction = (new eRede($store))->getByReference('pedido123');

printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());
```

## Consultando cancelamentos de uma transação

```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

$transaction = (new eRede($store))->getRefunds('TID123');

printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());
```

## Transação com autenticação

```php
<?php
// Configuração da loja em modo produção
use Rede\Environment;use Rede\eRede;use Rede\Store;use Rede\ThreeDSecure;use Rede\Transaction;use Rede\Url;$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

// Configura a transação que será autorizada após a autenticação
$transaction = (new Transaction(25, 'pedido' . time()))->debitCard(
    '5277696455399733',
    '123',
    '01',
    '2020',
    'John Snow'
);

// Configura o 3dSecure para autenticação
$transaction->threeDSecure(ThreeDSecure::DECLINE_ON_FAILURE);
$transaction->addUrl('https://redirecturl.com/3ds/success', Url::THREE_D_SECURE_SUCCESS);
$transaction->addUrl('https://redirecturl.com/3ds/failure', Url::THREE_D_SECURE_FAILURE);

$transaction = (new eRede($store))->create($transaction);

if ($transaction->getReturnCode() == '220') {
    printf("Redirecione o cliente para \"%s\" para autenticação\n", $transaction->getThreeDSecure()->getUrl());
}
```
