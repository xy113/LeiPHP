<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:16
 */

namespace WxApi\Builder;


class WxCustomTextMessageBuilder extends WxCustomMessageBuilder
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