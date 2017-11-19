<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?
use Bitrix\Main\Application;

include(GetLangFileName(dirname(__FILE__) . "/", "/.description.php"));

$psTitle = "Mercury Pay - сервис рассрочки покупок";
$psDescription = "<a href=\"http://www.mercurypos.ru\" target=\"_blank\">http://www.mercurypos.ru</a>";
$host = Application::getInstance()->getContext()->getServer()->getHttpHost();

$arPSCorrespondence = array(
    "STORE_PRIVATE_KEY" => array(
        "NAME" => GetMessage("STORE_PRIVATE_KEY"),
        "DESCR" => GetMessage("STORE_PRIVATE_KEY_DESC"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "CORE_API_URL" => array(
        "NAME" => GetMessage("CORE_API_URL"),
        "DESCR" => GetMessage("CORE_API_URL_DESC"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "SHOULD_PAY" => array(
        "NAME" => GetMessage("SHOULD_PAY"),
        "DESCR" => GetMessage("SHOULD_PAY"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "CURRENCY" => array(
        "NAME" => GetMessage("CURRENCY"),
        "DESCR" => GetMessage("CURRENCY"),
        "VALUE" => "RUB",
        "TYPE" => ""
    ),
    "ORDER_ID" => array(
        "NAME" => GetMessage("SALE_ORDER_ID"),
        "DESCR" => GetMessage("SALE_DESC_ORDER_ID"),
        "VALUE" => "ID",
        "TYPE" => "ORDER"
    ),
    "ADDRESS" => array(
        "NAME" => GetMessage("ADDRESS"),
        "DESCR" => GetMessage("ADDRESS_DESC"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "PHONE" => array(
        "NAME" => GetMessage("PHONE"),
        "DESCR" => GetMessage("PHONE_DESC"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "customerMiddleName" => array(
        "NAME" => GetMessage("customerMiddleName"),
        "DESCR" => GetMessage("customerMiddleName_DESC"),
        "VALUE" => "",
        "TYPE" => ""
    ),
    "customerFirstName" => array(
        "NAME" => GetMessage("customerFirstName"),
        "DESCR" => GetMessage("customerFirstName_DESC"),
        "VALUE" => "",
        "TYPE" => ""
    ),
     "customerLastName" => array(
        "NAME" => GetMessage("customerLastName"),
        "DESCR" => GetMessage("customerLastName_DESC"),
        "VALUE" => "",
        "TYPE" => ""
    ),
     "customerEmail" => array(
        "NAME" => GetMessage("customerEmail"),
        "DESCR" => GetMessage("customerEmail_DESC"),
        "VALUE" => "",
        "TYPE" => ""
    ),


);
