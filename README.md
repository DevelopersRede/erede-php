# SDK PHP

SDK de integração eRede

# Instalação

## Dependências

* PHP >= 7.2

**Atenção:** o PHP 7.2 tem atualizações de segurança apenas até 30 de Novembro de 2020. Por motivos de segurança, recomendamos que atualize a versão
seu PHP para a versão mais recente disponível. Veja mais sobre as versões suportadas em [Suportted Versions](https://www.php.net/supported-versions.php).

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

# Testes

O SDK utiliza PHPUnit com TestDox para os testes. Para executá-los em ambiente local, você precisa exportar
as variáveis de ambiente `REDE_PV` e `REDE_TOKEN` com suas credenciais da API. Feito isso, basta rodar:

```
export REDE_PV=1234
export REDE_TOKEN=5678

vendor/bin/phpunit --testdox --colors='always' test
```

Os testes também podem ser executados através de um container com a configuração ideal para o projeto. Para isso, basta
fazer:

```
docker build . -t erede-docker
docker run -e REDE_PV='1234' -e REDE_TOKEN='5678' erede-docker
```

Caso necessário, o SDK possui a possibilidade de logs de depuração que podem ser utilizados ao executar os testes. Para isso, 
basta exportar a variável de ambiente `REDE_DEBUG` com o valor 1:

```
export REDE_DEBUG=1
```

# Utilizando

## Autorizando uma transação

```php
<?php
// Configuração da loja em modo produção
$store = new Store('PV', 'TOKEN', Environment::production());

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
$store = new Store('PV', 'TOKEN', Environment::production());

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
$store = new Store('PV', 'TOKEN', Environment::production());

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
$store = new Store('PV', 'TOKEN', Environment::production());

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
$store = new Store('PV', 'TOKEN', Environment::production());

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
$store = new Store('PV', 'TOKEN', Environment::production());

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

## Capturando uma transação

```php
<?php
// Configuração da loja em modo produção
$store = new Store('PV', 'TOKEN', Environment::production());

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
$store = new Store('PV', 'TOKEN', Environment::production());

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
$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

$transaction = (new eRede($store))->get('TID123');

printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());
```

## Consultando uma transação pela referência

```php
<?php
// Configuração da loja em modo produção
$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

$transaction = (new eRede($store))->getByReference('pedido123');

printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());
```

## Consultando cancelamentos de uma transação

```php
<?php
// Configuração da loja em modo produção
$store = new Store('PV', 'TOKEN', Environment::production());

// Configuração da loja em modo sandbox
// $store = new \Rede\Store('PV', 'TOKEN', \Rede\Environment::sandbox());

$transaction = (new eRede($store))->getRefunds('TID123');

printf("O status atual da autorização é %s\n", $transaction->getAuthorization()->getStatus());
```

## Transação com autenticação

```php
<?php
// Configuração da loja em modo produção
$store = new Store('PV', 'TOKEN', Environment::production());

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
