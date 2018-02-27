<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/10
 * Time: 下午2:09
 */

namespace WeChat\WxApi;

use Core\Http;

class WxApi
{
    public $appid = '';
    public $appsecret = '';

    /**
     * WxApi constructor.
     */
    function __construct()
    {
        $this->appid = setting('wx_appid');
        $this->appsecret = setting('wx_appsecret');
    }

    /**
     * @return bool
     */
    public function getAccessToken(){
        $data = cache('weixin_access_token');
        if ($data && $data['expires_time'] > time()){
            return $data['access_token'];
        }else {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
            $res = Http::curlGet($url);
            $data = json_decode($res, true);
            if ($data['access_token']) {
                $data['expires_time'] = time()+7000;
                $data['create_time'] = date('Y-m-d H:i:s');
                cache('weixin_access_token', $data);
                return $data['access_token'];
            }else {
                return false;
            }
        }
    }

    /**
     * @return bool
     */
    public function getJsApiTicket(){
        // 如果是企业号用以下 URL 获取 ticket
        // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
        $data = cache('weixin_jsapi_ticket');
        if ($data && $data['expire_time'] > time()){
            return $data['ticket'];
        }else {
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$this->getAccessToken();
            $res = Http::curlGet($url);
            $data = json_decode($res, true);
            if ($data['ticket']){
                $data['expires_time'] = time()+7000;
                $data['create_time'] = date('Y-m-d H:i:s');
                cache('weixin_jsapi_ticket', $data);
                return $data['ticket'];
            }else {
                return false;
            }
        }
    }
}
