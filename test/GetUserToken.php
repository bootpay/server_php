<?php
/*
 * 카드 정기 결제 예약
 */
require_once('../autoload.php');
spl_autoload_register('BootpayAutoload');

use Bootpay\Rest\BootpayApi;

$bootpay = BootpayApi::setConfig(
    '59bfc738e13f337dbd6ca48a',
    'pDc0NwlkEX3aSaHTp/PPL/i8vn5E/CqRChgyEp/gHD0=',
    'development'
);

$response = $bootpay->requestAccessToken();
var_dump($response);

if ($response->status === 200) {
    $result = $bootpay->getUserToken([
        'user_id' => '[[ 회원 아이디 ]]', # 필수

    ]);
    var_dump($result);
}