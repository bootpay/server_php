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
        return static::$instances->tokenInstance(static::$instances->defaultParams);
    }

    public static function confirm($data)
    {
        $payload = array_merge($data, static::$instances->defaultParams);
        return static::$instances->confirmInstance($payload);
    }

    public static function cancel($data)
    {
        $payload = array_merge($data, static::$instances->defaultParams);
        return static::$instances->cancelInstance($payload);
    }

    private function getRestUrl()
    {
        return $this->baseUrl[$this->mode];
    }

    public function cancelInstance($data)
    {
        return self::post(implode('/', [$this->getRestUrl(), 'cancel']), $data);
    }

    public function confirmInstance($data)
    {
        return self::get(implode('/', [$this->getRestUrl(), 'receipt', $data['receipt_id'] . "?" . http_build_query($data)]), []);
    }

    public function tokenInstance($data)
    {
        return self::post(implode('/', [$this->getRestUrl(), 'request', 'token']), $data);
    }

//  공통 부분
    public static function get($url, $data)
    {
        $ch = self::getCurlHandler($url, $data, false);
        return self::execute($ch);
    }

    public static function post($url, $data)
    {
        $ch = self::getCurlHandler($url, $data, true);
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

    private static function getCurlHandler($url, $data = array(), $isPost = true)
    {
        $headers = array('Content-Type: application/json');
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
