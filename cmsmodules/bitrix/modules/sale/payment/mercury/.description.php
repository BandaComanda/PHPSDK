<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?
use Bitrix\Main\Application;

include(GetLangFileName(dirname(__FILE__) . "/", "/.description.php"));

$psTitle = "Mercury - Istallment Payment System";
$psDescription = "<a href=\"http://www.mercurypos.ru\" target=\"_blank\">http://www.mercurypos.ru</a>";
$host = Application::getInstance()->getContext()->getServer()->getHttpHost();

$arPSCorrespondence = array(
    "STORE_PRIVATE_KEY" => array(
        "NAME" => GetMessage("STORE_PRIVATE_KEY"),
        "DESCR" => GetMessage("STORE_PRIVATE_KEY_DESC"),
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

    "SUCCESS_URL" => array(
        "NAME" => GetMessage("SALE_SUCCESS_URL"),
        "DESCR" => GetMessage("SALE_DESC_SUCCESS_URL"),
        "VALUE" => "http://{$host}/personal/order/",
        "TYPE" => ""
    ),
    "FAIL_URL" => array(
        "NAME" => GetMessage("SALE_FAIL_URL"),
        "DESCR" => GetMessage("SALE_DESC_FAIL_URL"),
        "VALUE" => "http://{$host}/personal/order/",
        "TYPE" => ""
    ),
    "ORDER_ID" => array(
        "NAME" => GetMessage("SALE_ORDER_ID"),
        "DESCR" => GetMessage("SALE_DESC_ORDER_ID"),
        "VALUE" => "ID",
        "TYPE" => "ORDER"
    ),
    "USER_LAST_NAME" => array(
        "NAME" => GetMessage("USER_LAST_NAME"),
        "DESCR" => GetMessage("USER_LAST_NAME_DESC"),
        "VALUE" => "LAST_NAME",
        "TYPE" => "USER"
    ),
    "USER_FIRST_NAME" => array(
        "NAME" => GetMessage("USER_FIRST_NAME"),
        "DESCR" => GetMessage("USER_FIRST_NAME_DESC"),
        "VALUE" => "NAME",
        "TYPE" => "USER"
    ),
    "USER_PATRONYMIC" => array(
        "NAME" => GetMessage("USER_PATRONYMIC"),
        "DESCR" => GetMessage("USER_PATRONYMIC_DESC"),
        "VALUE" => "SECOND_NAME",
        "TYPE" => "USER"
    ),
    "USER_EMAIL" => array(
        "NAME" => GetMessage("SALE_EMAIL"),
        "DESCR" => GetMessage("SALE_DESC_EMAIL"),
        "VALUE" => "EMAIL",
        "TYPE" => "USER"
    ),
);
