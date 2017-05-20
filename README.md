# PHPSDK

Для создания сессии в системе Mercury следует:

1. Подключить файл MercuryClient.php в свой скрипт
```php
require "MercuryClient.php";
```
2. Инстанцировать объект, в качестве аргументов для параметров конструктора следует передать URL сервиса и Токен Продавца, который был сгенерирован в рамках контракта.
```php
$url    = 'https://mercurypos.online/order';
$token  = 'secret.token.merchant';
$client = new MercuryClient($url, $token);
```

3. Передать информацию о заказе и товарах в метод query, см. пример:
```php
$order  = [
    'tax_amount' => 0,
    'amount'     => 4875,
    'reference'  => 'id in my store',
    'currency'   => 'RUB'
];

$items = [
    [
        'name'          => 'Стиральная машина',
        'price'         => 1875,
        'quantity'      => 1,
        'quantity_unit' => 'шт.',
        'reference'     => 'zdwfee',
        'amount'        => 1875,
        'category'      => 'b6155270-7537-457b-9156-d2a2ff7289d9'
    ],
    [
        'name'          => 'Горный велосипед',
        'price'         => 3000,
        'quantity'      => 1,
        'quantity_unit' => 'шт.',
        'reference'     => '1zdwfee',
        'amount'        => 3000,
        'category'      => 'b6155270-7537-457b-9156-d2a2ff7289d9'
    ],
];

$response = $client->query($order, $items);
```

4. В случае успеха - объект Response будет содержать токен и идентификатор открытой сессии, которые можно извлечь следующим образом:
```php

if (!$response->isError()) {
   $token   = $response->getData()[ 'data' ][ 'response' ][ 'token' ];
   $session = $response->getData()[ 'data' ][ 'response' ][ 'id' ];
}
```

См. описание запроса с определением списка обязательных и опциональных полей http://docs.nostromo.in/mutation.html (Mutation.createSession)
