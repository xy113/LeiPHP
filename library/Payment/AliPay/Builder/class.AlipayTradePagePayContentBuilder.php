<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/17
 * Time: 下午4:58
 *
 * 功能：支付宝电脑网站支付(alipay.trade.page.pay)接口业务参数封装
 * 版本：2.0
 * 修改日期：2017-05-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

namespace Payment\AliPay\Builder;


class AlipayTradePagePayContentBuilder
{
    private $bizContent = array(
        'product_code'=>'FAST_INSTANT_TRADE_PAY',
        'out_trade_no'=>'',//订单号
        'total_amount'=>'',//订单金额
        'subject'=>'',//商品名称
        'body'=>''//商品描述
    );

    /**
     * @param string $value
     */
    public function setProduct_code($value = 'FAST_INSTANT_TRADE_PAY'){
        $this->bizContent['product_code'] = $value;
    }

    /**
     * @return mixed
     */
    public function getProduct_code(){
        return $this->bizContent['product_code'];
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

    public function setTotal_amount($value){
        $this->bizContent['total_amount'] = $value;
    }

    /**
     * @return mixed
     */
    public function getTotal_amount(){
        return $this->bizContent['total_amount'];
    }

    /**
     * @param $value
     */
    public function setSubject($value){
        $this->bizContent['subject'] = $value;
    }

    /**
     * @return mixed
     */
    public function getSubject(){
        return $this->bizContent['subject'];
    }

    /**
     * @param $value
     */
    public function setBody($value) {
        $this->bizContent['body'] = $value;
    }

    /**
     * @return mixed
     */
    public function getBody(){
        return $this->bizContent['body'];
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