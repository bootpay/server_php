<?php

namespace Bootpay\Rest;

/**
 * Created by IntelliJ IDEA.
 * User: ehowlsla
 * Date: 2017. 8. 3.
 * Time: PM 5:37
 */
class BootpayApi
{
    use Singleton;

    public $mode = '';
    private $defaultParams = [];
    private $accessToken = null;

    private $baseUrl = [
        'development' => 'https://dev-api.bootpay.co.kr',
        'production' => 'https://api.bootpay.co.kr'
    ];

    public static function setConfig($applicationId, $privateKey, $mode = 'production')
    {
        static::instance();
        static::$instances->defaultParams = [
            'application_id' => $applicationId,
            'private_key' => $privateKey
        ];
        static::$instances->mode = $mode;
        return static::$instances;
    }

    public static function requestAccessToken()
    {
        $result = static::$instances->tokenInstance(static::$instances->defaultParams);
        if ($result->status === 200) {
            static::$instances->setAccessToken($result->data->token);
        }
        return $result;
    }

    public static function verify($receiptId)
    {
        return static::$instances->verifyInstance($receiptId);
    }

    public static function cancel($receiptId, $price = null, $name = null, $reason = null)
    {
        return static::$instances->cancelInstance($receiptId, $price, $name, $reason);
    }

    public static function subscribeCardBilling($data)
    {
        return static::$instances->subscribeCardBillingInstance($data);
    }

    public static function subscribeCardBillingReserve($data)
    {
        return static::$instances->subscribeCardBillingReserveInstance($data);
    }

    private function getRestUrl()
    {
        return $this->baseUrl[$this->mode];
    }

    public function setAccessToken($token)
    {
        return $this->accessToken = $token;
    }

    public function cancelInstance($receiptId, $price, $name, $reason)
    {
        return self::post(
            implode('/', [$this->getRestUrl(), 'cancel']),
            [
                'receipt_id' => $receiptId,
                'price' => $price,
                'name' => $name,
                'reason' => $reason
            ],
            [
                "Authorization: {$this->accessToken}"
            ]
        );
    }

    public function verifyInstance($receiptId)
    {
        return self::get(
            implode('/', [$this->getRestUrl(), 'receipt', $receiptId]),
            [],
            [
                "Authorization: {$this->accessToken}"
            ]
        );
    }

    public function subscribeCardBillingInstance($data)
    {
        return self::post(
            implode('/', [$this->getRestUrl(), 'subscribe', 'billing.json']),
            $data,
            [
                "Authorization: {$this->accessToken}"
            ]
        );
    }

    public function subscribeCardBillingReserveInstance($data)
    {
        return self::post(
            implode('/', [$this->getRestUrl(), 'subscribe', 'billing', 'reserve.json']),
            $data,
            [
                "Authorization: {$this->accessToken}"
            ]
        );
    }

    public function tokenInstance($data)
    {
        return self::post(implode('/', [$this->getRestUrl(), 'request', 'token']), $data);
    }

//  공통 부분
    public static function get($url, $data, $headers = [])
    {
        $ch = self::getCurlHandler($url, $data, false, $headers);
        return self::execute($ch);
    }

    public static function post($url, $data, $headers = [])
    {
        $ch = self::getCurlHandler($url, $data, true, $headers);
        return self::execute($ch);
    }

    private static function execute($ch)
    {
        $response = curl_exec($ch);
        $errno = curl_errno($ch);
        $errstr = curl_error($ch);
        if ($errno) throw new Exception('error: ' . $errno . ', msg: ' . $errstr);

        $json = json_decode(trim($response));
        curl_close($ch);
        return $json;
    }

    private static function getCurlHandler($url, $data = array(), $isPost = true, $headers = [])
    {
        $headers = array_merge(['Content-Type: application/json'], $headers);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $isPost);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($isPost) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        return $ch;
    }

    public function __construct()
    {
    }
}
