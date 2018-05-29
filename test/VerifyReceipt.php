<?php
/*
 * 결제 검증 관련 예제입니다.
 */
require_once('../autoload.php');
spl_autoload_register('BootpayAutoload');

use Bootpay\Rest\BootpayApi;

$receiptId = '주문번호';

$bootpay = BootpayApi::setConfig(
    '59bfc738e13f337dbd6ca48a',
    'FQj3jOvQYp053nxzWxHSuw+cq3zUlSWZV2ec/8fkiyA=',
    'development'
);

$response = $bootpay->requestAccessToken();

if ($response->status === 200) {
    $result = $bootpay->verify($receiptId);
    var_dump($result);
}