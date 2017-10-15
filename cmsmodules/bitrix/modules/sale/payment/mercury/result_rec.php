<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?

use Bitrix\Main\Application;

if ($_SERVER["REQUEST_METHOD"] != "POST") die('41');

$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$orderId = (int)$request->get("reference");


include(GetLangFileName(dirname(__FILE__) . "/", "/result_rec.php"));

$arOrder = CSaleOrder::GetByID($orderId);
if (!$arOrder) die('44');


CSalePaySystemAction::InitParamArrays($arOrder);


CSaleOrder::PayOrder($arOrder["ID"], "Y");




echo 'ok';


/*
 *
 * {
"secret": "aaa.bbb.ccc",
"amount": 8750.40,
"currency": "RUB",
"reference": "ID in the Merchant's DB",
"mid": "ID in the Mercury's DB"
}

 * */
