<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

require(dirname(__FILE__) . '/MercuryClient.php');


$url    = CSalePaySystemAction::GetParamValue('CORE_API_URL');

$token  = CSalePaySystemAction::GetParamValue('STORE_PRIVATE_KEY');

$client = new MercuryClient($url, $token);

$order_id = strlen(CSalePaySystemAction::GetParamValue('ORDER_ID')) > 0 ? CSalePaySystemAction::GetParamValue('ORDER_ID') : $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['ID'];

$order  = [
    "tax_amount" => 0,
    'amount'     => number_format(CSalePaySystemAction::GetParamValue('SHOULD_PAY'), 2, '.', ''),
    'reference'  => strlen(CSalePaySystemAction::GetParamValue('ORDER_ID')) > 0 ? CSalePaySystemAction::GetParamValue('ORDER_ID') : $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['ID'],
    'currency'   => CSalePaySystemAction::GetParamValue('CURRENCY')
];



$dbBasket = CSaleBasket::GetList( array(
                "NAME" => "ASC",
                "ID" => "ASC"
            ), Array("ORDER_ID"=>$order_id));

while ($arItems = $dbBasket->Fetch())
{
    if (strlen($arItems["CALLBACK_FUNC"]) > 0)
    {
        CSaleBasket::UpdatePrice($arItems["ID"],
                                 $arItems["CALLBACK_FUNC"],
                                 $arItems["MODULE"],
                                 $arItems["PRODUCT_ID"],
                                 $arItems["QUANTITY"]);
        $arItems = CSaleBasket::GetByID($arItems["ID"]);
    }

    $arBasketItems[] = $arItems;
}

$items = [];

foreach ($arBasketItems as $item) {
array_push($items, [
  'name'          => $item['NAME'],
  'price'         => $item['PRICE'],
  'quantity'      => $item['QUANTITY'],
  'quantity_unit' => 'шт.',
  'reference'     => $item['PRODUCT_ID'],
  'amount'        => $item['PRICE']*$item['QUANTITY']]);
}

$response = $client->createSession($order, $items);

if (!$response->isError()) {

   $token   = $response->getToken();
   $session = $response->getData()[ 'data' ][ 'response' ][ 'id' ];

}
else {
echo ("Что то пошло не так. С вами свяжется менеджер магазина. Код ошибки: ");
echo ($response->isError());

}


?>




<script language="javascript" src="/mercury/mercury.js" ></script>
<div id="mercury"></div>

<script language="javascript">

Mercury.init({token: "<?echo $token;?>", onClose: function(id){
var frame = document.getElementById(id);
frame.parentNode.removeChild(frame);
}});

</script>
