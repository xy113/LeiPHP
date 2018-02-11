<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午1:02
 */

namespace WeChat\WxPay\Model;

use WeChat\WxPay\WxPayModel;

//扫码支付模式一生成二维码参数
class WxPayBizPayUrl extends WxPayModel{

    /**
     * 设置支付时间戳
     * @param string $value
     **/
    public function setTimetamp($value = null){
        if (is_null($value)) {
            $this->values['time_stamp'] = time();
        }else {
            $this->values['time_stamp'] = $value;
        }
    }

    /**
     * 获取支付时间戳的值
     * @return string 值
     **/
    public function getTimestamp(){
        return $this->values['time_stamp'];
    }

    /**
     * 设置随机字符串
     * @param string $value
     **/
    public function setNonceStr($value = null)
    {
        if (is_null($value)) {
            $this->values['nonce_str'] = md5(time().rand(100,999));
        }else {
            $this->values['nonce_str'] = $value;
        }
    }

    /**
     * 获取随机字符串的值
     * @return string 值
     **/
    public function getNonceStr(){
        return $this->values['nonce_str'];
    }

    /**
     * 设置商品ID
     * @param string $value
     **/
    public function setProductId($value){
        $this->values['product_id'] = $value;
    }

    /**
     * 获取商品ID的值
     * @return  string 值
     **/
    public function getProductId(){
        return $this->values['product_id'];
    }
}
