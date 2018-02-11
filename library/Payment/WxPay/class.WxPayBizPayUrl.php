<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午1:02
 */

namespace Payment\WxPay;

//扫码支付模式一生成二维码参数
class WxPayBizPayUrl extends WxPayData
{
    /**
     * 设置支付时间戳
     * @param string $value
     **/
    public function setTime_stamp($value = null)
    {
        if (is_null($value)) {
            $this->values['time_stamp'] = time();
        }else {
            $this->values['time_stamp'] = $value;
        }
    }
    /**
     * 获取支付时间戳的值
     * @return 值
     **/
    public function getTime_stamp()
    {
        return $this->values['time_stamp'];
    }
    /**
     * 判断支付时间戳是否存在
     * @return true 或 false
     **/
    public function isTime_stampSet()
    {
        return array_key_exists('time_stamp', $this->values);
    }

    /**
     * 设置随机字符串
     * @param string $value
     **/
    public function setNonce_str($value = null)
    {
        if (is_null($value)) {
            $this->values['nonce_str'] = md5(time().rand(100,999));
        }else {
            $this->values['nonce_str'] = $value;
        }
    }
    /**
     * 获取随机字符串的值
     * @return 值
     **/
    public function getNonce_str()
    {
        return $this->values['nonce_str'];
    }
    /**
     * 判断随机字符串是否存在
     * @return true 或 false
     **/
    public function isNonce_strSet()
    {
        return array_key_exists('nonce_str', $this->values);
    }

    /**
     * 设置商品ID
     * @param string $value
     **/
    public function setProduct_id($value)
    {
        $this->values['product_id'] = $value;
    }
    /**
     * 获取商品ID的值
     * @return 值
     **/
    public function getProduct_id()
    {
        return $this->values['product_id'];
    }
    /**
     * 判断商品ID是否存在
     * @return true 或 false
     **/
    public function isProduct_idSet()
    {
        return array_key_exists('product_id', $this->values);
    }
}