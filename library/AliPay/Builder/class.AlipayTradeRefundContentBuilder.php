<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/18
 * Time: 上午11:20
 *
 * 功能：支付宝电脑网站支付退款接口(alipay.trade.refund)接口业务参数封装
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

namespace Payment\AliPay\Builder;


class AlipayTradeRefundContentBuilder
{
    private $bizContent = array(
        //支付宝交易号
        'trade_no'=>'',
        //商户订单号
        'out_trade_no'=>'',
        //退款金额
        'refund_amount'=>'',
        //退货原因
        'refund_reason'=>'',
        //标识一次退款请求号，同一笔交易多次退款保证唯一，部分退款此参数必填
        'out_request_no'=>''
    );

    /**
     * @param $value
     */
    public function setTrade_no($value){
        $this->bizContent['trade_no'] = $value;
    }

    /**
     * @return mixed
     */
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
    public function setRefund_amount($value){
        $this->bizContent['refund_amount'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_amount(){
        return $this->bizContent['refund_amount'];
    }

    /**
     * @param $value
     */
    public function setRefund_reason($value){
        $this->bizContent['refund_reason'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRefund_reason(){
        return $this->bizContent['refund_reason'];
    }

    /**
     * @param $value
     */
    public function setOut_request_no($value){
        $this->bizContent['out_request_no'] = $value;
    }

    /**
     * @return mixed
     */
    public function getOut_request_no(){
        return $this->bizContent['out_request_no'];
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