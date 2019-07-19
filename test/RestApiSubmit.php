<?php
/*
 * 결제 검증 관련 예제입니다.
 */
require_once('../autoload.php');
spl_autoload_register('BootpayAutoload');

use Bootpay\Rest\BootpayApi;

$price = 3000; // 원래 서버에서 결제하려고 했던 금액
$receiptId = '5c6dfb1fe13f3371b38f9008';

$bootpay = BootpayApi::setConfig(
    '59bfc738e13f337dbd6ca48a',
    'pDc0NwlkEX3aSaHTp/PPL/i8vn5E/CqRChgyEp/gHD0='
);

$response = $bootpay->requestAccessToken();

if ($response->status === 200) {
    // 결제 승인 전 금액을 비교하기 위해서 verification함수를 호출합니다.
    $result = $bootpay->verify($receiptId);
    // 서버에서 200을 받고, 원래 결제하려고 했던 금액과 일치하면 서버에 submit을 보냅니다.
    if ($result->status == 200 && $result->data->price == $price) {
        $receiptData = $bootpay->submit($receiptId);
        // 결제 완료되면 status 200을 리턴하고 실패하면 에러를 호출하며, 결제가 승인이 되지 않은 사유에 대해서 $receiptData->message로 받아보실 수 있습니다.
        // 해당 데이터는 결제완료된 시점의 JS SDK의 done함수에서 호출되어 보내는 데이터와 동일합니다.
        var_dump($receiptData);
    }
}