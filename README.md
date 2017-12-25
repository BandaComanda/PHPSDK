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
   $token   = $response->getToken;
}
```
Отображение Виджета для оплаты происходит с использоваение полученного $token в обхекте Response. 
Для отображения токена на странице необходимо: 
На странице инплементировать JS скрипт Mercury:
```javascript
<script language="javascript" src="/mercury/mercury.js" ></script>

```
На странице разместить DIV с id = mercury
```html
<div id="mercury"></div>
```

И с использованием $token отобразить виджет: 

```javascript
<script language="javascript">

Mercury.init({token: "<?echo $token;?>", onClose: function(id){
var frame = document.getElementById(id);
frame.parentNode.removeChild(frame);
}});
```



5. Обратный визов магазина (call back) осуществляется по URL который был передан в Mercury На этапе подключения пагазина. По изменению статуса заказа в системе Mercury 
будет произведен POST вызов:
Metod: POST
В теле запроса:
```php
"data" =>  {"secret":"20aec49a150a0a2d30a982ce015397a1a8ff3a49",
            "amount":"1579.10",
            "currency":"RUB",
            "reference":"75",
            "mid":"32f5fdb7-753e-4e08-9574-0f8bdb8bf34e",
            "status":true}
 ```
Где 
secret - sha1($token)

ammount - сумма заказа 

currency - валюта

reference - ID заказа в магазина (значение которое было передано в запросе От магазина, в $order)

mid - id заказа в Mercury

status - TRUE - рассрочка предоставлена, false - рассрочка не предоставлена.

См. описание запроса с определением списка обязательных и опциональных полей https://gql.mercurypos.online/docs/sessioninput.doc.html
