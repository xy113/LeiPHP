<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午1:49
 */

namespace WeChat\WxPay\Model;

use WeChat\WxPay\WxPayModel;

//企业付款输入对象
class WxPayTransfer extends WxPayModel
{
    /**
     * @param $value
     */
    public function setMchAppid($value = null){
        if (is_null($value)) {
            $this->values['mch_appid'] = setting('wx.appid');
        }else {
            $this->values['mch_appid'] = $value;
        }
    }

    /**
     * @return mixed
     */
    public function getMchAppid(){
        return $this->values['mch_appid'];
    }

    /**
     * @param $value
     */
    public function setMchid($value = null){
        if (is_null($value)) {
            $this->values['mchid'] = setting('wx.mch_id');
        }else {
            $this->values['mchid'] = $value;
        }
    }

    /**
     * @return mixed
     */
    public function getMchid(){
        return $this->values['mchid'];
    }

    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
     * @param string $value
     **/
    public function setNonceStr($value = null)
    {
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
     * 设置调用微信支付API的机器IP
     * @param string $value
     **/
    public function setSpbillCreateIp($value = null)
    {
        if (is_null($value)) {
            $this->values['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
        }else {
            $this->values['spbill_create_ip'] = $value;
        }
    }

    /**
     * 获取调用微信支付API的机器IP 的值
     * @return string 值
     **/
    public function getSpbillCreateIp()
    {
        return $this->values['spbill_create_ip'];
    }

    /**
     * @param $value
     */
    public function setPartnerTradeNo($value){
        $this->values['partner_trade_no'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPartnerTradeNo(){
        return $this->values['partner_trade_no'];
    }

    /**
     * @param string $value
     */
    public function setCheckName($value = 'NO_CHECK'){
        $this->values['check_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getCheckName(){
        return $this->values['check_name'];
    }

    /**
     * @param $value
     */
    public function setAmount($value){
        $this->values['amount'] = $value;
    }

    /**
     * @return mixed
     */
    public function getAmount(){
        return $this->values['amount'];
    }

    /**
     * @param $value
     */
    public function setDesc($value){
        $this->values['desc'] = $value;
    }

    /**
     * @return mixed
     */
    public function getDesc(){
        return $this->values['desc'];
    }

    /**
     * @param $value
     */
    public function setOpenid($value){
        $this->values['openid'] = $value;
    }

    /**
     * @return mixed
     */
    public function getOpenid(){
        return $this->values['openid'];
    }

    /**
     * @param $value
     */
    public function setReUserName($value){
        $this->values['re_user_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getReUserName(){
        return $this->values['re_user_name'];
    }
}
