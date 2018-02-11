<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/10
 * Time: 下午3:32
 */

namespace WxApi\Builder;


class WxCustomMessageBuilder
{
    protected $touser;
    protected $msgtype;
    protected $params = array();
    protected $customservice = array('kf_account'=>'');

    /**
     * @param $value
     */
    public function setTouser($value){
        $this->touser = $value;
    }

    /**
     * @return mixed
     */
    public function getTouser(){
        return $this->touser;
    }

    /**
     * @param $value
     */
    public function setMsgtype($value){
        $this->msgtype = $value;
    }

    /**
     * @return mixed
     */
    public function getMsgtype(){
        return $this->msgtype;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setParam($key, $value){
        $this->params[$key] = $value;
    }

    /**
     * @param null $key
     * @return array|mixed
     */
    public function getParams($key = null){
        if (is_null($key)) {
            return $this->params;
        }else {
            return $this->params[$key];
        }
    }

    /**
     * @param $value
     */
    public function setKf_account($value){
        $this->customservice['kf_account'] = $value;
    }

    /**
     * @return mixed
     */
    public function getKf_account(){
        return $this->customservice['kf_account'];
    }

    /**
     * @return string
     */
    public function getMsgContent(){
        $content = array('touser'=>$this->touser, 'msgtype'=>$this->msgtype);
        $content[$this->msgtype] = $this->params;
        if ($this->customservice['kf_account']) $content['customservice'] = $this->customservice;
        return json_encode($content, JSON_UNESCAPED_UNICODE);
    }
}