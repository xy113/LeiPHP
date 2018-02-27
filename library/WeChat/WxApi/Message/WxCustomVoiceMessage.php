<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:43
 */

namespace WeChat\WxApi\Message;


class WxCustomVoiceMessage extends WxCustomMessage
{
    protected $msgtype = 'voice';

    /**
     * @param $value
     */
    public function setMediaId($value){
        $this->params['media_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getMediaId(){
        return $this->params['media_id'];
    }
}
