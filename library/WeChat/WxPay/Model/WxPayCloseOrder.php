<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/11
 * Time: 上午11:50
 */

namespace WeChat\WxPay\Model;


use WeChat\WxPay\WxPayModel;

class WxPayCloseOrder extends WxPayModel
{
    /**
     * 设置商户系统内部的订单号
     * @param string $value
     **/
    public function setOutTradeNo($value){
        $this->values['out_trade_no'] = $value;
    }

    /**
     * 获取商户系统内部的订单号的值
     * @return string 值
     **/
    public function getOutTradeNo(){
        return $this->values['out_trade_no'];
    }


    /**
     * 设置商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号
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
     * 获取商户系统内部的订单号,32个字符内、可包含字母, 其他说明见商户订单号的值
     * @return string 值
     **/
    public function getNonceStr(){
        return $this->values['nonce_str'];
    }
}
