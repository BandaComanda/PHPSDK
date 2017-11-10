<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?

use Bitrix\Main\Application;

if ($_SERVER["REQUEST_METHOD"] != "POST") die('41');

/*$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$orderId = $request->getPostList();*/

$mercury_request = json_decode($_POST['data']);

$token  = CSalePaySystemAction::GetParamValue('STORE_PRIVATE_KEY');


if (sha1($token) == $mercury_request->secret)
{
    $arOrder = CSaleOrder::GetByID($mercury_request->reference);
    if (!$arOrder) die('Договор не найден - код ошибки 44');

    CSalePaySystemAction::InitParamArrays($arOrder);

    if ($mercury_request->status == true)
    {
        if (CSaleOrder::PayOrder($arOrder["ID"], "Y"))
        {
            echo 'ok payment accept order is '. $mercury_request->mid;

        }
        else
        {
            echo ('not ok - error Pay check');
        }
    }
    else {
        if (CSaleOrder::PayOrder($arOrder["ID"], "N"))
        {
            echo 'ok payment cancel order is '. $mercury_request->mid;

        }
        else
        {
            echo ('not ok - error cancel Pay check');
        }

    }

}

else
{
    echo ("error 405");
}


