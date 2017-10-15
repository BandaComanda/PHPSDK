# PHPSDK

Для создания сессии в системе Mercury следует:

1. Подключить файл MercuryClient.php в свой скрипт
```php
require "MercuryClient.php";
```
Для работы клиента необходимо установленная библиотека Php - Curl.

2. Инстанцировать объект, в качестве аргумента для параметра конструктора следует передать Токен Продавца, который был сгенерирован в рамках контракта с Mercury.
```php
$token  = 'secret.token.merchant';
$client = new MercuryClient($token);
```

3. Передать информацию о заказе и товарах в метод createSession, см. пример, опционально можно передать телефон и адрес доставки покупателя:
```php
$order  = [
    'taxAmount' => 0, 
    'amount'     => 4875,
    'reference'  => 'Уникальный ID Заказа в Магазине',
    'currency'   => 'RUB'
];

$items = [
    [
        'name'          => 'Стиральная машина',
        'price'         => 1875,
        'quantity'      => 1,
        'quantityUnit' => 'шт.',
        'reference'     => 'id товара в магазине',
        'amount'        => 1875
    ],
    [
        'name'          => 'Горный велосипед',
        'price'         => 3000,
        'quantity'      => 1,
        'quantityUnit' => 'шт.',
        'reference'     => 'id Товара в Магазине',
        'amount'        => 3000
    ],
];

$response = $client->createSession($order, $items);
```

4. В случае успеха - объект Response будет содержать токен для инициализации виджета, который можно извлечь следующим образом:
```php

if (!$response->isError()) {
   $token   = $response->getData()[ 'data' ][ 'token' ];
}
```

См. описание запроса с определением списка обязательных и опциональных полей https://gql.mercurypos.online/docs/index.html (Mutation.openSession)
