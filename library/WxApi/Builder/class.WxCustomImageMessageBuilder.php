<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:40
 */

namespace WxApi\Builder;


class WxCustomImageMessageBuilder extends WxCustomMessageBuilder
{
    protected $msgtype = 'image';

    /**
     * @param $value
     */
    public function setMedia_id($value){
        $this->params['media_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getMedia_id(){
        return $this->params['media_id'];
    }
}