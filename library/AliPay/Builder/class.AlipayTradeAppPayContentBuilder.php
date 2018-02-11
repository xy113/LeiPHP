<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/13
 * Time: 下午1:27
 */

namespace Payment\AliPay\Builder;


class AlipayTradeAppPayContentBuilder
{
    private $bizContent = array(

        'product_code'=>'QUICK_MSECURITY_PAY',
        'out_trade_no'=>'',//订单号
        'total_amount'=>'',//订单金额
        'subject'=>'',//商品名称
        'body'=>'',//商品描述,
        'timeout_express'=>'1m',
    );

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value){
        $this->bizContent[$key] = $value;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key){
        return $this->bizContent[$key];
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

    public function setTimeout_express($value){
        $this->bizContent['timeout_express'] = $value;
    }

    public function getTimeout_express(){
        return $this->bizContent['timeout_express'];
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