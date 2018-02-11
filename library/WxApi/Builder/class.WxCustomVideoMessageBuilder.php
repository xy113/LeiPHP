<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:43
 */

namespace WxApi\Builder;


class WxCustomVideoMessageBuilder extends WxCustomMessageBuilder
{
    protected $msgtype = 'video';

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
    public function setDescription($value){
        $this->params['description'] = $value;
    }

    /**
     * @return mixed
     */
    public function getDescription(){
        return $this->params['description'];
    }
}