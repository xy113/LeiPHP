<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:59
 */

namespace WxApi\Builder;

//发送微信卡券
class WxCustomWxcardMessageBuilder extends WxCustomMessageBuilder
{
    protected $msgtype = 'wxcard';

    /**
     * @param $value
     */
    public function setCard_id($value){
        $this->params['card_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getCard_id(){
        return $this->params['card_id'];
    }
}