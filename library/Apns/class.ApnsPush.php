<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/3
 * Time: 上午3:12
 */

namespace Apns;

const APNS_ENVIRONMENT_PRODUCTION = 0; //生产环境
const APNS_ENVIRONMENT_SANDBOX = 1; //测试环境
class ApnsPush
{
    private $certfile;
    private $deviceToken;
    private $environment;
    private $gateway = "tls://gateway.sandbox.push.apple.com:2195";
    private $timeout = 60;

    /**
     * ApnsPush constructor.
     */
    function __construct($environment = APNS_ENVIRONMENT_PRODUCTION)
    {
        $this->environment = $environment;
        if ($environment == APNS_ENVIRONMENT_PRODUCTION){
            $this->setCertfile(CERT_PATH.'apns/apns.pem');
            $this->gateway = "tls://gateway.push.apple.com:2195";
        }else {
            $this->setCertfile(CERT_PATH.'apns/apns_dev.pem');
            $this->gateway = "tls://gateway.sandbox.push.apple.com:2195";
        }
    }

    /**
     * @param $pem
     */
    public function setCertfile($pem){
        $this->certfile = $pem;
    }

    public function setDeviceToken($deviceToken){
        $this->deviceToken = $deviceToken;
    }

    /**
     * @return mixed
     */
    public function getDeviceToken(){
        return $this->deviceToken;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout = 60){
        $this->timeout = $timeout;
    }

    /**
     * @param ApnsNotification $notification
     * @throws \Exception
     */
    public function send(ApnsNotification $notification){
        if (!is_file($this->certfile)){
            throw new \Exception('加载certfile文件出错');
        }
        if (!$this->deviceToken){
            throw new \Exception('deviceToken参数不能为空');
        }
        if (!$notification->getText()) {
            throw new \Exception('消息内容不能为空');
        }
        $ctx = stream_context_create();
        stream_context_set_option($ctx, "ssl", "local_cert", $this->certfile);
        $fp = stream_socket_client($this->gateway, $err, $errstr, $this->timeout, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp) {
            throw new \Exception($err.':'.$errstr);
        }
        $this->deviceToken = str_replace(' ', '', $this->deviceToken);
        $payload = $notification->getContent();
        $msg = chr(0) . pack("n",32) . pack('H*', $this->deviceToken) . pack("n",strlen($payload)) . $payload;
        fwrite($fp, $msg);
        fclose($fp);
    }
}