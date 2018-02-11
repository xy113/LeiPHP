<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/18
 * Time: 上午11:16
 *
 * 功能：支付宝电脑网站alipay.trade.close (统一收单交易关闭接口)业务参数封装
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

namespace Payment\AliPay\Builder;

//关闭订单输入对象
class AlipayTradeCloseContentBuilder
{
    private $bizContent = array(
        'trade_no'=>'',//支付宝交易号
        'out_trade_no'=>'',//商户订单号
        'operator_id'=>''//卖家端自定义的的操作员 ID
    );

    public function setTrade_no($value){
        $this->bizContent['trade_no'] = $value;
    }

    public function getTrade_no(){
        return $this->bizContent['trade_no'];
    }

    /**
     * @param $value
     */
    public function setOut_trade_no($value){
        $this->bizContent['out_trade_no'] = $value;
    }

    /**
     * @return mixed
     */
    public function getOut_trade_no(){
        return $this->bizContent['out_trade_no'];
    }

    /**
     * @param $value
     */
    public function setOperator_id($value){
        $this->bizContent['operator_id'] = $value;
    }

    /**
     * @return mixed
     */
    public function getOperator_id(){
        return $this->bizContent['operator_id'];
    }

    /**
     *
     */
    public function getBizContent(){
        if (!empty($this->bizContent)){
            return json_encode($this->bizContent,JSON_UNESCAPED_UNICODE);
        }else {
            return $this->bizContent;
        }
    }
}