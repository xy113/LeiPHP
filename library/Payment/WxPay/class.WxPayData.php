<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/15
 * Time: 下午2:59
 */
namespace Payment\WxPay;
class WxPayData{
    protected $values = array();
    private $mchKey = '';

    /**
     * 设置参数
     * @param string $key
     * @param string $value
     */
    public function setData($key, $value){
        $this->values[$key] = $value;
    }

    /**
     *  获取参数
     * @param $key
     * @return mixed
     */
    public function getData($key){
        return $this->values[$key];
    }

    /**
     * 设置APPID
     * @param null $value
     */
    public function setAppid($value = null){
        if (is_null($value)) {
            $this->values['appid'] = setting('wx_appid');
        }else {
            $this->values['appid'] = $value;
        }
    }

    /**
     * 获取APPID
     * @return mixed
     */
    public function getAppid(){
        return $this->values['appid'];
    }

    /**
     * 判断微信分配的公众账号ID是否存在
     * @return true 或 false
     **/
    public function isAppidSet(){
        return array_key_exists('appid', $this->values);
    }

    public function setMch_id($value = null){
        if (is_null($value)) {
            $this->values['mch_id'] = setting('wx_mch_id');
        }else {
            $this->values['mch_id'] = $value;
        }
    }

    public function getMch_id(){
        return $this->values['mch_id'];
    }

    /**
     * 判断微信支付分配的商户号是否存在
     * @return true 或 false
     **/
    public function isMch_idSet(){
        return array_key_exists('mch_id', $this->values);
    }

    public function getMchKey(){
        return $this->mchKey ? $this->mchKey : setting('wx_mch_key');
    }

    public function setMchKey($value=null){
        if (is_null($value)) {
            $this->mchKey = setting('wx_mch_key');
        }else {
            $this->mchKey = $value;
        }
    }

    /**
     * 设置签名，详见签名生成算法
     * @param string $value
     * @return 签名
     */
    public function setSign(){
        $sign = $this->makeSign();
        $this->values['sign'] = $sign;
        return $sign;
    }

    /**
     * 获取签名，详见签名生成算法的值
     * @return 值
     */
    public function getSign(){
        return $this->values['sign'];
    }

    /**
     * 判断签名，详见签名生成算法是否存在
     * @return true 或 false
     **/
    public function isSignSet(){
        return array_key_exists('sign', $this->values);
    }

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function makeSign(){
        //签名步骤一：按字典序排序参数
        ksort($this->values);
        $string = $this->toUrlParams();
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$this->getMchKey();
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 获取设置的值
     */
    public function getValues(){
        return $this->values;
    }

    /**
     * 输出xml字符
     * @throws WxPayException
     **/
    public function toXml(){
        if(!is_array($this->values)
            || count($this->values) <= 0)
        {
            throw new \Exception("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($this->values as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @return array|mixed
     * @throws \Exception
     */
    public function fromXml($xml){
        if(!$xml){
            throw new \Exception("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $this->values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $this->values;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public function toUrlParams(){
        $buff = "";
        foreach ($this->values as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
}
