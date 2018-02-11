<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午1:49
 */

namespace Payment\WxPay;

//企业付款输入对象
class WxPayTransfer extends WxPayData
{
    /**
     * @param $value
     */
    public function setMch_appid($value = null){
        if (is_null($value)) {
            $this->values['mch_appid'] = setting('wx_appid');
        }else {
            $this->values['mch_appid'] = $value;
        }
    }

    /**
     * @return mixed
     */
    public function getMch_appid(){
        return $this->values['mch_appid'];
    }

    /**
     * @param $value
     */
    public function setMchid($value = null){
        if (is_null($value)) {
            $this->values['mchid'] = setting('wx_mch_id');
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
     * 设置调用微信支付API的机器IP
     * @param string $value
     **/
    public function setSpbill_create_ip($value = null)
    {
        if (is_null($value)) {
            $this->values['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
        }else {
            $this->values['spbill_create_ip'] = $value;
        }
    }
    /**
     * 获取调用微信支付API的机器IP 的值
     * @return 值
     **/
    public function getSpbill_create_ip()
    {
        return $this->values['spbill_create_ip'];
    }
    /**
     * 判断调用微信支付API的机器IP 是否存在
     * @return true 或 false
     **/
    public function isSpbill_create_ipSet()
    {
        return array_key_exists('spbill_create_ip', $this->values);
    }

    /**
     * @param $value
     */
    public function setPartner_trade_no($value){
        $this->values['partner_trade_no'] = $value;
    }

    /**
     * @return mixed
     */
    public function getPartner_trade_no(){
        return $this->values['partner_trade_no'];
    }

    /**
     * @param string $value
     */
    public function setCheck_name($value = 'NO_CHECK'){
        $this->values['check_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getCheck_name(){
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
    public function setRe_user_name($value){
        $this->values['re_user_name'] = $value;
    }

    /**
     * @return mixed
     */
    public function getRe_user_name(){
        return $this->values['re_user_name'];
    }
}