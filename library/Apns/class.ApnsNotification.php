<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/3
 * Time: 上午3:37
 */

namespace Apns;


class ApnsNotification
{
    protected $content = array(
        "badge" => 1,
        "sound" => 'received5.caf',
        "alert" => 'notification message',
        "msgType" => 'update'
    );

    /**
     * ApnsNotification constructor.
     */
    function __construct()
    {
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value){
        $this->content[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key){
        return $this->content[$key];
    }

    /**
     * @param $badge
     */
    public function setBadge($badge){
        $this->content['badge'] = $badge;
    }

    /**
     * @return mixed
     */
    public function getBadge(){
        return $this->content['badge'];
    }

    /**
     * @param $sound
     */
    public function setSound($sound){
        $this->content['sound'] = $sound;
    }

    /**
     * @return mixed
     */
    public function getSound(){
        return $this->content['sound'];
    }

    /**
     * @param $text
     */
    public function setText($text){
        $this->content['alert'] = $text;
    }

    /**
     * @return mixed
     */
    public function getText(){
        return $this->content['alert'];
    }

    /**
     * @param $text
     */
    public function setAlert($text){
        $this->content['alert'] = $text;
    }

    /**
     * @return mixed
     */
    public function getAlert(){
        return $this->content['alert'];
    }

    /**
     * @param $msgType
     */
    public function setMsgType($msgType){
        $this->content['msgType'] = $msgType;
    }

    /**
     * @return mixed
     */
    public function getMsgType(){
        return $this->content['msgType'];
    }

    /**
     * @return array
     */
    public function getContent(){
        return json_encode(array("aps" => $this->content), JSON_UNESCAPED_UNICODE);
    }
}