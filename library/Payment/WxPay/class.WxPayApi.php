<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/8/14
 * Time: 下午12:23
 */
namespace Payment\WxPay;
class WxPayApi{
    /**
     * 以post方式提交xml到对应的接口url
     * @param string $xml 需要post的xml数据
     * @param string $url url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second url执行超时时间，默认30s
     * @return mixed
     * @throws \Exception
     */
    public static function postXmlCurl($xml, $url, $useCert = false, $second = 30){
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        //如果有配置代理这里就设置代理
        /*
        if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0){
            curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        */
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, ROOT_PATH.'cert/wxpay/apiclient_cert.pem');
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, ROOT_PATH.'cert/wxpay/apiclient_key.pem');
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new \Exception("curl出错，错误码:$error");
        }
    }


    /**
     * 统一下单
     * @param WxPayUnifiedOrder $inputObj
     * @param int $timeout
     * @return array|mixed
     * @throws WxPayException
     * @throws \Exception
     */
    public static function unifiedOrder(WxPayUnifiedOrder $inputObj, $timeout = 20){
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        if(!$inputObj->getOut_trade_no()){
            throw new \Exception('缺少统一支付接口必填参数out_trade_no！', 1);

        }elseif (!$inputObj->getBody()){
            throw new \Exception('缺少统一支付接口必填参数body！',2);

        }elseif (!$inputObj->getTotal_fee()){
            throw new \Exception('缺少统一支付接口必填参数total_fee！',3);

        }elseif (!$inputObj->getTrade_type()){
            throw new \Exception('缺少统一支付接口必填参数trade_type！',4);
        }

        if ($inputObj->getTrade_type() == 'JSAPI' && !$inputObj->getOpenid()){
            throw new \Exception('统一支付接口中，缺少必填参数openid！',5);
        }

        if ($inputObj->getTrade_type() == 'NATIVE' && !$inputObj->getProduct_id()){
            throw new \Exception('统一支付接口中，缺少必填参数product_id！',6);
        }

        if (!$inputObj->getNotify_url()) {
            throw new \Exception('统一支付接口中，缺少必填参数notify_url！',7);
        }

        if (!$inputObj->getAppid()){
            $inputObj->setAppid();
        }

        if (!$inputObj->getMch_id()){
            $inputObj->setMch_id();
        }

        if (!$inputObj->getMchKey()){
            $inputObj->setMchKey();
        }

        $inputObj->setNonce_str();
        $inputObj->setSpbill_create_ip();
        $inputObj->setSign();
        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, false, $timeout);

        $obj = new WxPayUnifiedOrder();
        return $obj->fromXml($response);
    }

    /**
     *
     * 查询订单，out_trade_no、transaction_id至少填一个
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayOrderQuery $inputObj
     * @param int $timeout
     * @return 成功时返回
     * @throws WxPayException
     * @throws \Exception
     * @internal param WxPayOrderQuery $inputObj
     * @internal param int $timeOut
     */
    public static function orderQuery(WxPayOrderQuery $inputObj, $timeout=20){
        $url = "https://api.mch.weixin.qq.com/pay/orderquery";
        if (!$inputObj->getOut_trade_no() && !$inputObj->getTransaction_id()){
            throw new \Exception('订单查询接口中，out_trade_no、transaction_id至少填一个！');
        }

        if (!$inputObj->getAppid()) {
            $inputObj->setAppid();
            $inputObj->setMch_id();
        }
        $inputObj->setNonce_str();
        $inputObj->setSign();
        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, false, 20);

        $obj = new WxPayOrderQuery();
        return $obj->fromXml($response);
    }

    /**
     *
     * 撤销订单API接口，参数out_trade_no和transaction_id必须填写一个
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayData|WxPayReverse $inputObj
     * @param int $timeOut
     * @return array
     * @throws WxPayException
     * @throws \Exception
     */
    public static function reverse(WxPayReverse $inputObj, $timeOut = 20){
        $url = "https://api.mch.weixin.qq.com/secapi/pay/reverse";
        //检测必填参数
        if(!$inputObj->getOut_trade_no() && !$inputObj->getTransaction_id()) {
            throw new \Exception("撤销订单API接口中，参数out_trade_no和transaction_id必须填写一个！");
        }

        $inputObj->setAppid();//公众账号ID
        $inputObj->setMch_id();//商户号
        $inputObj->setNonce_str();//随机字符串
        $inputObj->setSign();//签名
        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, true, $timeOut);

        $obj = new WxPayReverse();
        return $obj->fromXml($response);
    }

    /**
     *
     * 关闭订单，out_trade_no必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayCloseOrder|WxPayData $inputObj
     * @param int $timeOut
     * @return 成功时返回
     * @throws WxPayException
     * @throws \Exception
     */
    public static function closeOrder(WxPayCloseOrder $inputObj, $timeOut = 20){
        $url = "https://api.mch.weixin.qq.com/pay/closeorder";
        //检测必填参数
        if(!$inputObj->getOut_trade_no()) {
            throw new \Exception("订单查询接口中，out_trade_no必填！");
        }
        $inputObj->setAppid();//公众账号ID
        $inputObj->setMch_id();//商户号
        $inputObj->setNonce_str();//随机字符串
        $inputObj->setSign();//签名
        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, true, $timeOut);

        $obj = new WxPayCloseOrder();
        return $obj->fromXml($response);
    }

    /**
     *
     * 申请退款，out_trade_no、transaction_id至少填一个且
     * out_refund_no、total_fee、refund_fee、op_user_id为必填参数
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayData|WxPayRefund $inputObj
     * @param int $timeOut
     * @return 成功时返回
     * @throws \Exception
     */
    public static function refund(WxPayRefund $inputObj, $timeOut = 20){
        $url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
        //检测必填参数
        if(!$inputObj->getOut_trade_no() && !$inputObj->getTransaction_id()) {
            throw new \Exception("退款申请接口中，out_trade_no、transaction_id至少填一个！");

        }else if(!$inputObj->getOut_refund_no()){
            throw new \Exception("退款申请接口中，缺少必填参数out_refund_no！");

        }else if(!$inputObj->getTotal_fee()){
            throw new \Exception("退款申请接口中，缺少必填参数total_fee！");

        }else if(!$inputObj->getRefund_fee()){
            throw new \Exception("退款申请接口中，缺少必填参数refund_fee！");

        }
        $inputObj->setAppid();//公众账号ID
        $inputObj->setMch_id();//商户号
        $inputObj->setNonce_str();//随机字符串

        $inputObj->setSign();//签名
        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, true, $timeOut);

        $obj = new WxPayRefund();
        return $obj->fromXml($response);
    }

    /**
     * 查询退款
     * 提交退款申请后，通过调用该接口查询退款状态。退款有一定延时，
     * 用零钱支付的退款20分钟内到账，银行卡支付的退款3个工作日后重新查询退款状态。
     * WxPayRefundQuery中out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayData|WxPayRefundQuery $inputObj
     * @param int $timeOut
     * @return 成功时返回
     * @throws \Exception
     */
    public static function refundQuery(WxPayRefundQuery $inputObj, $timeOut = 6){
        $url = "https://api.mch.weixin.qq.com/pay/refundquery";
        //检测必填参数
        if(!$inputObj->getOut_refund_no() &&
            !$inputObj->getOut_trade_no() &&
            !$inputObj->getTransaction_id() &&
            !$inputObj->getRefund_id()) {
            throw new \Exception("退款查询接口中，out_refund_no、out_trade_no、transaction_id、refund_id四个参数必填一个！");
        }
        $inputObj->setAppid();//公众账号ID
        $inputObj->setMch_id();//商户号
        $inputObj->setNonce_str();//随机字符串

        $inputObj->setSign();//签名
        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, true, $timeOut);

        $obj = new WxPayRefundQuery();
        return $obj->fromXml($response);
    }

    /**
     * 下载对账单，bill_date为必填参数
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayData|WxPayDownloadBill $inputObj
     * @param int $timeOut
     * @return 成功时返回
     * @throws \Exception
     */
    public static function downloadBill(WxPayDownloadBill $inputObj, $timeOut = 6){
        $url = "https://api.mch.weixin.qq.com/pay/downloadbill";
        //检测必填参数
        if(!$inputObj->getBill_date()) {
            throw new \Exception("对账单接口中，缺少必填参数bill_date！");
        }
        $inputObj->setAppid();//公众账号ID
        $inputObj->setMch_id();//商户号
        $inputObj->setNonce_str();//随机字符串

        $inputObj->setSign();//签名
        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, true, $timeOut);
        return $response;
    }

    /**
     * 提交被扫支付API
     * 收银员使用扫码设备读取微信用户刷卡授权码以后，二维码或条码信息传送至商户收银台，
     * 由商户收银台或者商户后台调用该接口发起支付。
     * WxPayWxPayMicroPay中body、out_trade_no、total_fee、auth_code参数必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayData|WxPayWxPayMicroPay $inputObj
     * @param int $timeOut
     * @return array|mixed
     * @throws \Exception
     */
    public static function micropay(WxPayMicroPay $inputObj, $timeOut = 10){
        $url = "https://api.mch.weixin.qq.com/pay/micropay";
        //检测必填参数
        if(!$inputObj->getBody()) {
            throw new \Exception("提交被扫支付API接口中，缺少必填参数body！");

        } else if(!$inputObj->getOut_trade_no()) {
            throw new \Exception("提交被扫支付API接口中，缺少必填参数out_trade_no！");

        } else if(!$inputObj->getTotal_fee()) {
            throw new \Exception("提交被扫支付API接口中，缺少必填参数total_fee！");

        } else if(!$inputObj->getAuth_code()) {
            throw new \Exception("提交被扫支付API接口中，缺少必填参数auth_code！");
        }

        $inputObj->setSpbill_create_ip();//终端ip
        $inputObj->setAppid();//公众账号ID
        $inputObj->setMch_id();//商户号
        $inputObj->setNonce_str();//随机字符串

        $inputObj->setSign();//签名
        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, true, $timeOut);

        $obj = new WxPayMicroPay();
        return $obj->fromXml($response);
    }

    /**
     * 企业付款给用户
     * @param WxPayTransfer $inputObj
     * @param int $timeout
     * @return array|mixed
     * @throws \Exception
     */
    public static function transfer(WxPayTransfer $inputObj, $timeout = 10){
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
        if (!$inputObj->getPartner_trade_no()){
            throw new \Exception("企业付款接口中，缺少必填参数partner_trade_no！");
        }

        if (!$inputObj->getAmount()){
            throw new \Exception("企业付款接口中，缺少必填参数amount！");
        }

        if (!$inputObj->getDesc()){
            throw new \Exception("企业付款接口中，缺少必填参数desc！");
        }

        if (!$inputObj->getOpenid()){
            throw new \Exception("企业付款接口中，缺少必填参数openid！");
        }

        $inputObj->setMch_appid();
        $inputObj->setMchid();
        $inputObj->setNonce_str();
        $inputObj->setSign();

        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, true, $timeout);

        $obj = new WxPayTransfer();
        return $obj->fromXml($response);
    }

    /**
     *
     * 转换短链接
     * 该接口主要用于扫码原生支付模式一中的二维码链接转成短链接(weixin://wxpay/s/XXXXXX)，
     * 减小二维码数据量，提升扫描速度和精确度。
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayData|WxPayShortUrl $inputObj
     * @param int $timeOut
     * @return 成功时返回
     * @throws \Exception
     */
    public static function shorturl(WxPayShortUrl $inputObj, $timeOut = 10){
        $url = "https://api.mch.weixin.qq.com/tools/shorturl";
        //检测必填参数
        if(!$inputObj->getLong_url()) {
            throw new \Exception("需要转换的URL，签名用原串，传输需URL encode！");
        }
        $inputObj->setAppid();//公众账号ID
        $inputObj->setMch_id();//商户号
        $inputObj->setNonce_str();//随机字符串

        $inputObj->setSign();//签名
        $xml = $inputObj->toXml();
        $response = self::postXmlCurl($xml, $url, true, $timeOut);

        $obj = new WxPayShortUrl();
        return $obj->fromXml($response);
    }

    /**
     *
     * 支付结果通用通知
     * @param function $callback
     * 直接回调函数使用方法: notify(you_function);
     * 回调类成员函数方法:notify(array($this, you_function));
     * $callback  原型为：function function_name($data){}
     * @return bool|mixed
     */
    public static function notify($callback, &$msg){
        //获取通知的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        //如果返回成功则验证签名
        try {
            $result = self::xml2array($xml);
        } catch (\Exception $e){
            $msg = $e->getMessage();
            return false;
        }
        return call_user_func($callback, $result);
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @return array|mixed
     * @throws WxPayException
     */
    public static function xml2array($xml){
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $array = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array;
    }
}
