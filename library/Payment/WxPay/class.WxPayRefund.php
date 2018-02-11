<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午12:31
 */

namespace Payment\WxPay;

//提交退款输入对象
class WxPayRefund extends WxPayData
{
    /**
     * 设置微信支付分配的终端设备号，与下单一致
     * @param string $value
     **/
    public function setDevice_info($value)
    {
        $this->values['device_info'] = $value;
    }
    /**
     * 获取微信支付分配的终端设备号，与下单一致的值
     * @return 值
     **/
    public function getDevice_info()
    {
        return $this->values['device_info'];
    }
    /**
     * 判断微信支付分配的终端设备号，与下单一致是否存在
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
     * 设置微信订单号
     * @param string $value
     **/
    public function setTransaction_id($value)
    {
        $this->values['transaction_id'] = $value;
    }
    /**
     * 获取微信订单号的值
     * @return 值
     **/
    public function getTransaction_id()
    {
        return $this->values['transaction_id'];
    }
    /**
     * 判断微信订单号是否存在
     * @return true 或 false
     **/
    public function isTransaction_idSet()
    {
        return array_key_exists('transaction_id', $this->values);
    }


    /**
     * 设置商户系统内部的订单号,transaction_id、out_trade_no二选一，如果同时存在优先级：transaction_id> out_trade_no
     * @param string $value
     **/
    public function setOut_trade_no($value)
    {
        $this->values['out_trade_no'] = $value;
    }
    /**
     * 获取商户系统内部的订单号,transaction_id、out_trade_no二选一，如果同时存在优先级：transaction_id> out_trade_no的值
     * @return 值
     **/
    public function getOut_trade_no()
    {
        return $this->values['out_trade_no'];
    }
    /**
     * 判断商户系统内部的订单号,transaction_id、out_trade_no二选一，如果同时存在优先级：transaction_id> out_trade_no是否存在
     * @return true 或 false
     **/
    public function isOut_trade_noSet()
    {
        return array_key_exists('out_trade_no', $this->values);
    }


    /**
     * 设置商户系统内部的退款单号，商户系统内部唯一，同一退款单号多次请求只退一笔
     * @param string $value
     **/
    public function setOut_refund_no($value)
    {
        $this->values['out_refund_no'] = $value;
    }
    /**
     * 获取商户系统内部的退款单号，商户系统内部唯一，同一退款单号多次请求只退一笔的值
     * @return 值
     **/
    public function getOut_refund_no()
    {
        return $this->values['out_refund_no'];
    }
    /**
     * 判断商户系统内部的退款单号，商户系统内部唯一，同一退款单号多次请求只退一笔是否存在
     * @return true 或 false
     **/
    public function isOut_refund_noSet()
    {
        return array_key_exists('out_refund_no', $this->values);
    }


    /**
     * 设置订单总金额，单位为分，只能为整数，详见支付金额
     * @param string $value
     **/
    public function setTotal_fee($value)
    {
        $this->values['total_fee'] = $value;
    }
    /**
     * 获取订单总金额，单位为分，只能为整数，详见支付金额的值
     * @return 值
     **/
    public function getTotal_fee()
    {
        return $this->values['total_fee'];
    }
    /**
     * 判断订单总金额，单位为分，只能为整数，详见支付金额是否存在
     * @return true 或 false
     **/
    public function isTotal_feeSet()
    {
        return array_key_exists('total_fee', $this->values);
    }


    /**
     * 设置退款总金额，订单总金额，单位为分，只能为整数，详见支付金额
     * @param string $value
     **/
    public function setRefund_fee($value)
    {
        $this->values['refund_fee'] = $value;
    }
    /**
     * 获取退款总金额，订单总金额，单位为分，只能为整数，详见支付金额的值
     * @return 值
     **/
    public function getRefund_fee()
    {
        return $this->values['refund_fee'];
    }
    /**
     * 判断退款总金额，订单总金额，单位为分，只能为整数，详见支付金额是否存在
     * @return true 或 false
     **/
    public function isRefund_feeSet()
    {
        return array_key_exists('refund_fee', $this->values);
    }


    /**
     * 设置货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     * @param string $value
     **/
    public function setRefund_fee_type($value)
    {
        $this->values['refund_fee_type'] = $value;
    }
    /**
     * 获取货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型的值
     * @return 值
     **/
    public function getRefund_fee_type()
    {
        return $this->values['refund_fee_type'];
    }
    /**
     * 判断货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型是否存在
     * @return true 或 false
     **/
    public function isRefund_fee_typeSet()
    {
        return array_key_exists('refund_fee_type', $this->values);
    }


    /**
     * 设置操作员帐号, 默认为商户号
     * @param string $value
     **/
    public function setOp_user_id($value)
    {
        $this->values['op_user_id'] = $value;
    }
    /**
     * 获取操作员帐号, 默认为商户号的值
     * @return 值
     **/
    public function getOp_user_id()
    {
        return $this->values['op_user_id'];
    }
    /**
     * 判断操作员帐号, 默认为商户号是否存在
     * @return true 或 false
     **/
    public function isOp_user_idSet()
    {
        return array_key_exists('op_user_id', $this->values);
    }

    /**
     * @param $value
     */
    public function setRefund_desc($value){
        $this->values['refund_desc'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_desc(){
        return $this->values['refund_desc'];
    }
}