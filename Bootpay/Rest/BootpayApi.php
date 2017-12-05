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

    private $defaultParams = [];

    const BASE_URL = 'https://api.bootpay.co.kr/';
    const URL_CONFIRM = self::BASE_URL . 'receipt/';
    const URL_CANCEL = self::BASE_URL . 'cancel';

    public static function setConfig($applicationId, $privateKey)
    {
        static::instance();
        static::$instances->defaultParams = [
            'application_id' => $applicationId,
            'private_key' => $privateKey
        ];
        return static::$instances;
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

    public function cancelInstance($data)
    {
        return self::post(self::URL_CANCEL, $data);
    }

    public function confirmInstance($data)
    {
        return self::get(self::URL_CONFIRM . $data['receipt_id'] . "?" . http_build_query($data), []);
    }

//  공통 부분
    public static function get($url, $data)
    {
        $ch = self::getCurlHandler($url, $data, false);
        return self::excute($ch);
    }

    public static function post($url, $data)
    {
        $ch = self::getCurlHandler($url, $data, true);
        return self::excute($ch);
    }

    private static function excute($ch)
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
