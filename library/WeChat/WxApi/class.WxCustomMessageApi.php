<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/10
 * Time: 下午3:29
 */

namespace WxApi;


use Core\Http;
use WxApi\Builder\WxCustomMessageBuilder;

class WxCustomMessageApi extends WxApi
{
    /**
     * 发送模板消息
     * @param WxCustomMessageBuilder $message
     * @return mixed
     * @throws \Exception
     */
    public function sendMessage(WxCustomMessageBuilder $message){
        if (!$message->getTouser()){
            throw new \Exception('Empty touser value');
        }

        if (!$message->getMsgtype()){
            throw new \Exception('Empty msgtype value');
        }

        if (!$message->getParams()){
            throw new \Exception('Empty params value');
        }

        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$this->getAccessToken(), $message->getMsgContent());
        return $res;
    }
}