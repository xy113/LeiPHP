<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/10
 * Time: 下午3:29
 */

namespace WeChat\WxApi;


use Core\Http;
use WeChat\WxApi\Message\WxCustomMessage;

class WxCustomMessageApi extends WxApi
{
    /**
     * 发送模板消息
     * @param WxCustomMessage $message
     * @return mixed
     * @throws \Exception
     */
    public function sendMessage(WxCustomMessage $message){
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
