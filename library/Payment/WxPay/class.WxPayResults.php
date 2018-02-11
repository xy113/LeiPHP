<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/16
 * Time: 上午12:19
 */

namespace Payment\WxPay;

//接口调用结果类
class WxPayResults extends WxPayData
{
    /**
     *
     * 检测签名
     */
    public function CheckSign()
    {
        //fix异常
        if(!$this->isSignSet()){
            throw new \Exception("签名错误！");
        }

        $sign = $this->makeSign();
        if($this->getSign() == $sign){
            return true;
        }
        throw new \Exception("签名错误！");
    }

    /**
     *
     * 使用数组初始化
     * @param array $array
     */
    public function fromArray($array)
    {
        $this->values = $array;
    }

    /**
     *
     * 使用数组初始化对象
     * @param array $array
     * @param bool|是否检测签名 $noCheckSign
     * @return WxPayResults
     */
    public static function initFromArray($array, $noCheckSign = false)
    {
        $obj = new self();
        $obj->fromXml($array);
        if($noCheckSign == false){
            $obj->CheckSign();
        }
        return $obj;
    }
}