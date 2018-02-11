<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/17
 * Time: 下午3:43
 */

namespace Payment\AliPay;

require_once __DIR__.'/AopClient.php';
/**
 * 自动加载类
 * @param $class
 */
spl_autoload_register(function ($class){
    $classpath = __DIR__.'/Request/'.$class.'.php';
    if (is_file($classpath)) require_once $classpath;
}, true);

class AlipayClient extends \AopClient
{
    /**
     * AlipayClient constructor.
     */
    function __construct()
    {
        $this->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $this->appId = setting('alipay_appid');
        $this->rsaPrivateKey = setting('alipay_private_key');
        $this->apiVersion = '1.0';
        $this->signType = 'RSA2';
        $this->postCharset= 'utf-8';
        $this->format='json';
    }
}