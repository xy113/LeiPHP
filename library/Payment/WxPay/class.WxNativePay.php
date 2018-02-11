<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/14
 * Time: 下午12:25
 */
namespace Payment\WxPay;
class WxNativePay{
    /**
     * 生成扫描支付URL,模式一
     * @param $product_id
     * @return string
     * @internal param BizPayUrlInput $bizUrlInfo
     */
    public function getPrePayUrl($product_id){
        $payData = new WxPayBizPayUrl();
        $payData->setProduct_id($product_id);
        $payData->setAppid();
        $payData->setMch_id();
        $payData->setTime_stamp();
        $payData->setNonce_str();
        $payData->makeSign();
        $values = $payData->getValues();
        $url = "weixin://wxpay/bizpayurl?" . $this->buildParams($values);
        return $url;
    }

    /**
     *
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param UnifiedOrderInput|WxPayData|WxPayUnifiedOrder $input
     * @return 成功时返回
     */
    public function getPayUrl(WxPayUnifiedOrder $input){
        $input->setTrade_type('NATIVE');
        return WxPayApi::unifiedOrder($input);
    }

    /**
     *
     * 参数数组转换为url参数
     * @param array $urlObj
     * @return string
     */
    private function buildParams($urlObj){
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            $buff .= $k . "=" . $v . "&";
        }

        $buff = trim($buff, "&");
        return $buff;
    }
}