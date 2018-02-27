<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:59
 */

namespace WeChat\WxApi\Message;

//发送微信卡券
class WxCustomWxcardMessage extends WxCustomMessage
{
    protected $msgtype = 'wxcard';

    /**
     * @param $value
     */
    public function setCardId($value){
        $this->params['card_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getCardId(){
        return $this->params['card_id'];
    }
}
