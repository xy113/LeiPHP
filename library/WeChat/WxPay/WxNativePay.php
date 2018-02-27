<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/14
 * Time: 下午12:25
 */
namespace WeChat\WxPay;
use WeChat\WxPay\Model\WxPayBizPayUrl;
use WeChat\WxPay\Model\WxPayUnifiedOrder;

class WxNativePay{
    /**
     * 生成扫描支付URL,模式一
     * @param $product_id
     * @return string
     * @internal param BizPayUrlInput $bizUrlInfo
     */
    public function getPrePayUrl($product_id){
        $payData = new WxPayBizPayUrl();
        $payData->setProductId($product_id);
        $payData->setAppid();
        $payData->setMchId();
        $payData->setTimetamp();
        $payData->setNonceStr();
        $payData->makeSign();
        $values = $payData->getValues();
        $url = "weixin://wxpay/bizpayurl?" . $this->buildParams($values);
        return $url;
    }

    /**
     *
     * 生成直接支付url，支付url有效期为2小时,模式二
     * @param WxPayUnifiedOrder $input
     * @return mixed 成功时返回
     * @throws \Exception
     */
    public function getPayUrl(WxPayUnifiedOrder $input){
        $input->setTradeType('NATIVE');
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
