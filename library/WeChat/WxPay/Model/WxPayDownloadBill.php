<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午12:38
 */

namespace WeChat\WxPay\Model;

//下载对账单输入对象
use WeChat\WxPay\WxPayModel;

class WxPayDownloadBill extends WxPayModel
{
    /**
     * 设置微信支付分配的终端设备号，填写此字段，只下载该设备号的对账单
     * @param string $value
     **/
    public function setDeviceInfo($value)
    {
        $this->values['device_info'] = $value;
    }

    /**
     * 获取微信支付分配的终端设备号，填写此字段，只下载该设备号的对账单的值
     * @return string 值
     **/
    public function getDeviceInfo()
    {
        return $this->values['device_info'];
    }


    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
     * @param string $value
     **/
    public function setNonceStr($value = null){
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

    /**
     * 设置下载对账单的日期，格式：20140603
     * @param string $value
     **/
    public function setBillDate($value)
    {
        $this->values['bill_date'] = $value;
    }

    /**
     * 获取下载对账单的日期，格式：20140603的值
     * @return string 值
     **/
    public function getBillDate()
    {
        return $this->values['bill_date'];
    }

    /**
     * 设置ALL，返回当日所有订单信息，默认值SUCCESS，返回当日成功支付的订单REFUND，返回当日退款订单REVOKED，已撤销的订单
     * @param string $value
     **/
    public function setBillType($value)
    {
        $this->values['bill_type'] = $value;
    }

    /**
     * 获取ALL，返回当日所有订单信息，默认值SUCCESS，返回当日成功支付的订单REFUND，返回当日退款订单REVOKED，已撤销的订单的值
     * @return string 值
     **/
    public function getBillType()
    {
        return $this->values['bill_type'];
    }
}
