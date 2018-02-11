<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午12:45
 */

namespace Payment\WxPay;

//短链转换输入对象
class WxPayShortUrl extends WxPayData
{
    /**
     * 设置需要转换的URL，签名用原串，传输需URL encode
     * @param string $value
     **/
    public function setLong_url($value)
    {
        $this->values['long_url'] = $value;
    }
    /**
     * 获取需要转换的URL，签名用原串，传输需URL encode的值
     * @return 值
     **/
    public function getLong_url()
    {
        return $this->values['long_url'];
    }
    /**
     * 判断需要转换的URL，签名用原串，传输需URL encode是否存在
     * @return true 或 false
     **/
    public function isLong_urlSet()
    {
        return array_key_exists('long_url', $this->values);
    }


    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
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
     * 获取随机字符串，不长于32位。推荐随机数生成算法的值
     * @return 值
     **/
    public function getNonce_str()
    {
        return $this->values['nonce_str'];
    }
    /**
     * 判断随机字符串，不长于32位。推荐随机数生成算法是否存在
     * @return true 或 false
     **/
    public function isNonce_strSet()
    {
        return array_key_exists('nonce_str', $this->values);
    }
}