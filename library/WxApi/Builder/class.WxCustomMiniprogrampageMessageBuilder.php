<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午3:02
 */

namespace WxApi\Builder;

//发送小程序
class WxCustomMiniprogrampageMessageBuilder extends WxCustomMessageBuilder
{
    protected $msgtype = 'miniprogrampage';

    /**
     * @param $value
     */
    public function setTitle($value){
        $this->params['title'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTitle(){
        return $this->params['title'];
    }

    /**
     * @param $value
     */
    public function setAppid($value){
        $this->params['appid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getAppid(){
        return $this->params['appid'];
    }

    /**
     * @param $value
     */
    public function setPagepath($value){
        $this->params['pagepath'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPagepath(){
        return $this->params['pagepath'];
    }

    /**
     * @param $value
     */
    public function setThumb_media_id($value){
        $this->params['thumb_media_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getThumb_media_id(){
        return $this->params['thumb_media_id'];
    }
}