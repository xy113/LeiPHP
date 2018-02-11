<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午12:45
 */

namespace WeChat\WxPay\Model;


use WeChat\WxPay\WxPayModel;

//短链转换输入对象
class WxPayShortUrl extends WxPayModel
{
    /**
     * 设置需要转换的URL，签名用原串，传输需URL encode
     * @param string $value
     **/
    public function setLongUrl($value)
    {
        $this->values['long_url'] = $value;
    }

    /**
     * 获取需要转换的URL，签名用原串，传输需URL encode的值
     * @return string 值
     **/
    public function getLongUrl()
    {
        return $this->values['long_url'];
    }

    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
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
     * 获取随机字符串，不长于32位。推荐随机数生成算法的值
     * @return string 值
     **/
    public function getNonceStr()
    {
        return $this->values['nonce_str'];
    }
}
