<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:57
 */

namespace WeChat\WxApi\Message;


class WxCustomMpnewsMessage extends WxCustomMessage
{
    protected $msgtype = 'mpnews';

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
