<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:48
 */

namespace WxApi\Builder;


class WxCustomMusicMessageBuilder extends WxCustomMessageBuilder
{
    protected $msgtype = 'music';

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

    /**
     * @param $value
     */
    public function setMusicurl($value){
        $this->params['musicurl'] = $value;
    }

    /**
     * @return mixed
     */
    public function getMusicurl(){
        return $this->params['musicurl'];
    }

    /**
     * @param $value
     */
    public function setHqmusicurl($value){
        $this->params['hpmusicurl'] = $value;
    }

    /**
     * @return mixed
     */
    public function getHqmusicurl(){
        return $this->params['hpmusicurl'];
    }
}