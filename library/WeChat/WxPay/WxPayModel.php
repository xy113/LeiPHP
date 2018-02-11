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
 * Time: 上午11:31
 */

namespace WeChat\WxPay;


abstract class WxPayModel
{
    protected $values = [];
    protected $mchKey = '';

    /**
     * WxPayModel constructor.
     * @param $values
     */
    public function __construct($values = null)
    {
        if ($values) {
            static::setValues($values);
        }
    }

    /**
     * 设置APPID
     * @param mixed $value
     */
    public function setAppid($value = null){
        $this->values['appid'] = $value ? $value : setting('wx.appid');
    }

    /**
     * 获取APPID
     * @return mixed
     */
    public function getAppid(){
        return $this->values['appid'];
    }

    /**
     * @param $value
     */
    public function setMchId($value = null){
        $this->values['mch_id'] = $value ? $value : setting('wx.mch_id');
    }

    /**
     * @return bool|mixed|null|string
     */
    public function getMchId(){
        return $this->values['mch_id'];
    }

    /**
     * @return string
     */
    public function getMchKey()
    {
        return $this->mchKey ? $this->mchKey : setting('wx.mch_key');
    }

    /**
     * @param string $mchKey
     * @return WxPayModel
     */
    public function setMchKey($mchKey = '')
    {
        $this->mchKey = $mchKey ? $mchKey : setting('wx.mch_key');
        return $this;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->values[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        // TODO: Implement __get() method.
        return isset($this->values[$name]) ? $this->values[$name] : null;
    }


    /**
     * 设置签名，详见签名生成算法
     * @param string $value
     * @return string 签名
     */
    public function setSign(){
        $sign = $this->makeSign();
        $this->values['sign'] = $sign;
        return $sign;
    }

    /**
     * 获取签名，详见签名生成算法的值
     * @return string 值
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
     * @return string 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
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
     * @param mixed $values
     */
    public function setValues($values)
    {
        if (is_object($values)) {
            $this->values = get_object_vars($values);
        }else {
            $this->values = $values;
        }
    }

    /**
     * 获取设置的值
     */
    public function getValues(){
        return $this->values;
    }

    /**
     * 输出xml字符
     * @return string
     * @throws \Exception
     */
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
