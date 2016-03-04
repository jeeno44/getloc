<?php

if (! function_exists('checkYandexSign')) {

    /**
     * Проверка цифровой подписи запроса от Якассы
     * @param array $request
     * @return bool
     */
    function checkYandexSign(array $request)
    {
        $config = \Config::get('yakassa');
        extract($request);
        extract($config);
        if ($md5 == strtoupper(md5("$action;$orderSumAmount;$orderSumCurrencyPaycash;$orderSumBankPaycash;$shopId;$invoiceId;$customerNumber;$shopPassword"))) {
            return true;
        }
        return false;
    }
}