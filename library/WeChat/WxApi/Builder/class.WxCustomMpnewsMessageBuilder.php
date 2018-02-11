<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:57
 */

namespace WxApi\Builder;


class WxCustomMpnewsMessageBuilder extends WxCustomMessageBuilder
{
    protected $msgtype = 'mpnews';

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