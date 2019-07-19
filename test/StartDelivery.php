<?php
/*
 * 에스크로 배송 시작 관련 로직입니다.
 */

/*
 * delivery_no - 운송장 번호
 * delivery_corp - 배송업체 코드
 *
 * LOGIS_CODE_TO_NAME
    '000': 'ETC',
    '001': 'CJ대한통운',
    '002': '한진택배',
    '003': '롯데택배 (구. 현대택배)',
    '004': 'KG로지스',
    '005': '동부익스프레스',
    '006': '우체국택배',
    '007': '로젠택배',
    '008': '옐로우캡',
    '009': '경동택배',
    '010': '대신택배',
    '011': '사가와택배',
    '100': '직접배달',
    '101': '퀵서비스'
 */
require_once('../autoload.php');
spl_autoload_register('BootpayAutoload');
use Bootpay\Rest\BootpayApi;

$receiptId = '5c6e0836e13f3371b38f9033';

$bootpay = BootpayApi::setConfig(
    '59bfc738e13f337dbd6ca48a',
    'pDc0NwlkEX3aSaHTp/PPL/i8vn5E/CqRChgyEp/gHD0='
);

$response = $bootpay->requestAccessToken();

if ($response->status === 200) {
    $result = $bootpay->startDelivery([
        'receipt_id' => $receiptId,
        'delivery_no' => '399938989289', # 운송장 번호입니다.
        'delivery_corp' => '001' # 배송업체 코드 - 상단에 코드가 나와있으니 사용하시면 됩니다.
    ]);
    var_dump($result);
}