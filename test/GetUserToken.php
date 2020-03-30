<?php
/*
 * 카드 정기 결제 예약
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
    $result = $bootpay->getUserToken([
        'user_id' => '[[ 회원 아이디 ]]', # 필수
        'email' => '[[ 이메일 ]]', # 선택
        'name' => '[[ 회원 이름 ]]', # 선택
        'gender' => '[[ 회원 성별, 0 - 여자, 1 - 남자 ]]', # 선택
        'birth' => '[[ 회원 생년월일 6자리 ]]', # 선택
        'phone' => '[[ 회원의 연락가능한 전화번호 ]]' # 페이앱의 경우만 필수, 나머지 선택
    ]);
    var_dump($result);
}