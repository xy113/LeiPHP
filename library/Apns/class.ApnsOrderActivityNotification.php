<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/3
 * Time: 上午3:40
 */

namespace Apns;


class ApnsOrderActivityNotification extends ApnsNotification
{

    /**
     * ApnsOrderActivityNotification constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->content['msgType'] = 'orderActivity';
    }

    /**
     * @param $order_id
     */
    public function setOrder_id($order_id){
        $this->content['order_id'] = $order_id;
    }

    /**
     * @return mixed
     */
    public function getOrder_id(){
        return $this->content['order_id'];
    }
}