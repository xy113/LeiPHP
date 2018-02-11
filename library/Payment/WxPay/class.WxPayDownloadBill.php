<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午12:38
 */

namespace Payment\WxPay;

//下载对账单输入对象
class WxPayDownloadBill extends WxPayData
{
    /**
     * 设置微信支付分配的终端设备号，填写此字段，只下载该设备号的对账单
     * @param string $value
     **/
    public function setDevice_info($value)
    {
        $this->values['device_info'] = $value;
    }
    /**
     * 获取微信支付分配的终端设备号，填写此字段，只下载该设备号的对账单的值
     * @return 值
     **/
    public function getDevice_info()
    {
        return $this->values['device_info'];
    }
    /**
     * 判断微信支付分配的终端设备号，填写此字段，只下载该设备号的对账单是否存在
     * @return true 或 false
     **/
    public function isDevice_infoSet()
    {
        return array_key_exists('device_info', $this->values);
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

    /**
     * 设置下载对账单的日期，格式：20140603
     * @param string $value
     **/
    public function setBill_date($value)
    {
        $this->values['bill_date'] = $value;
    }
    /**
     * 获取下载对账单的日期，格式：20140603的值
     * @return 值
     **/
    public function getBill_date()
    {
        return $this->values['bill_date'];
    }
    /**
     * 判断下载对账单的日期，格式：20140603是否存在
     * @return true 或 false
     **/
    public function isBill_dateSet()
    {
        return array_key_exists('bill_date', $this->values);
    }

    /**
     * 设置ALL，返回当日所有订单信息，默认值SUCCESS，返回当日成功支付的订单REFUND，返回当日退款订单REVOKED，已撤销的订单
     * @param string $value
     **/
    public function setBill_type($value)
    {
        $this->values['bill_type'] = $value;
    }
    /**
     * 获取ALL，返回当日所有订单信息，默认值SUCCESS，返回当日成功支付的订单REFUND，返回当日退款订单REVOKED，已撤销的订单的值
     * @return 值
     **/
    public function getBill_type()
    {
        return $this->values['bill_type'];
    }
    /**
     * 判断ALL，返回当日所有订单信息，默认值SUCCESS，返回当日成功支付的订单REFUND，返回当日退款订单REVOKED，已撤销的订单是否存在
     * @return true 或 false
     **/
    public function isBill_typeSet()
    {
        return array_key_exists('bill_type', $this->values);
    }
}