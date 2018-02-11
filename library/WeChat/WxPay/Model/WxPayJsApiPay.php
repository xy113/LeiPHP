<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午12:53
 */

namespace WeChat\WxPay\Model;

use WeChat\WxPay\WxPayModel;

//提交JSAPI输入对象
class WxPayJsApiPay extends WxPayModel
{
    /**
     * 设置支付时间戳
     * @param string $value
     **/
    public function setTimeStamp($value){
        $this->values['timeStamp'] = $value;
    }

    /**
     * 获取支付时间戳的值
     * @return string 值
     **/
    public function getTimeStamp(){
        return $this->values['timeStamp'];
    }

    /**
     * 随机字符串
     * @param string $value
     **/
    public function setNonceStr($value = null)
    {
        if (is_null($value)) {
            $this->values['nonceStr'] = md5(time().rand(100, 999));
        }else {
            $this->values['nonceStr'] = $value;
        }
    }
    /**
     * 获取notify随机字符串值
     * @return string 值
     **/
    public function getNonceStr()
    {
        return $this->values['nonceStr'];
    }


    /**
     * 设置订单详情扩展字符串
     * @param string $value
     **/
    public function setPackage($value)
    {
        $this->values['package'] = $value;
    }
    /**
     * 获取订单详情扩展字符串的值
     * @return string 值
     **/
    public function getPackage()
    {
        return $this->values['package'];
    }

    /**
     * 设置签名方式
     * @param string $value
     **/
    public function setSignType($value)
    {
        $this->values['signType'] = $value;
    }

    /**
     * 获取签名方式
     * @return string 值
     **/
    public function getSignType()
    {
        return $this->values['signType'];
    }

    /**
     * 设置签名方式
     * @param string $value
     **/
    public function setPaySign($value)
    {
        $this->values['paySign'] = $value;
    }

    /**
     * 获取签名方式
     * @return string 值
     **/
    public function getPaySign()
    {
        return $this->values['paySign'];
    }
}
