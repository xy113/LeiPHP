<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:16
 */

namespace WeChat\WxApi\Message;


class WxCustomTextMessage extends WxCustomMessage
{
    protected $msgtype = 'text';
    /**
     * @param $value
     */
    public function setContent($value){
        $this->params['content'] = $value;
    }

    /**
     * @return mixed
     */
    public function getContent(){
        return $this->params['content'];
    }
}
