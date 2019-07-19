<?php
/*
 * 카드 정기 결제 요청 REST 방식
 */
require_once('../autoload.php');
spl_autoload_register('BootpayAutoload');

use Bootpay\Rest\BootpayApi;

$bootpay = BootpayApi::setConfig(
    '59bfc738e13f337dbd6ca48a',
    'pDc0NwlkEX3aSaHTp/PPL/i8vn5E/CqRChgyEp/gHD0='
);

$response = $bootpay->requestAccessToken();

if ($response->status === 200) {
    $result = $bootpay->getSubscribeBillingKey([
        'pg' => 'nicepay',
        'order_id' => time(),
        'item_name' => '30일 정기권 결제',
        'card_no' => '[ 카드 번호 ]',
        'card_pw' => '[ 카드 비밀번호 앞에 2자리 ]',
        'expire_year' => '[ 카드 만료 연도 2자리 ]',
        'expire_month' => '[ 카드 만료 월 2자리 ]',
        'identify_number' => '[ 카드 비밀번호 2자리 ]'
    ]);
    var_dump($result);
    # 발급 받은 Billing key를 Expire 시키는 함수
    $result = $bootpay->destroySubscribeBillingKey('[ billing key ]');
    var_dump($result);
}
