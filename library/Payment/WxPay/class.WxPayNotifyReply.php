<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午12:23
 */

namespace Payment\WxPay;

//回调基础类
class WxPayNotifyReply extends WxPayData
{
    /**
     *
     * 设置错误码 FAIL 或者 SUCCESS
     * @param string
     */
    public function setReturn_code($return_code)
    {
        $this->values['return_code'] = $return_code;
    }

    /**
     *
     * 获取错误码 FAIL 或者 SUCCESS
     * @return string $return_code
     */
    public function getReturn_code()
    {
        return $this->values['return_code'];
    }

    /**
     *
     * 设置错误信息
     * @param string $return_code
     */
    public function setReturn_msg($return_msg)
    {
        $this->values['return_msg'] = $return_msg;
    }

    /**
     *
     * 获取错误信息
     * @return string
     */
    public function getReturn_msg()
    {
        return $this->values['return_msg'];
    }
}