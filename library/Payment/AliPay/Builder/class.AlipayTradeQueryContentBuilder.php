<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/17
 * Time: 下午4:49
 */
namespace Payment\AliPay\Builder;
class AlipayTradeQueryContentBuilder
{
    private $bizContent = array(
        'trade_no'=>'',
        'out_trade_no'=>''
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