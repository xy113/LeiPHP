<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午12:24
 */

namespace WeChat\WxApi\Message;


class WxTemplateMessage
{
    public $touser;//接收者openid
    public $template_id;//模板ID
    public $url;//模板跳转链接
    public $color;//模板内容字体颜色，不填默认为黑色
    public $data = array();//模板数据
    //小程序参数
    private $miniprogram = array(
        'appid'=>'',//所需跳转到的小程序appid（该小程序appid必须与发模板消息的公众号是绑定关联关系）
        'pagepath'=>''//所需跳转到小程序的具体页面路径，支持带参数,（示例index?foo=bar）
    );

    /**
     * 设置小程序参数
     * @param $appid
     * @param $pagepath
     */
    public function setMiniprogram($appid, $pagepath){
        $this->miniprogram = array(
            'appid'=>$appid,
            'pagepath'=>$pagepath
        );
    }

    /**
     * @param $value
     */
    public function addData($value){
        if (is_array($value)) array_push($this->data, $value);
    }

    /**
     * 创建消息内容
     */
    public function getMsgContent(){
        $content = array();
        if ($this->touser) {
            $content['touser'] = $this->touser;
        }

        if ($this->template_id) {
            $content['template_id'] = $this->template_id;
        }

        if ($this->url) {
            $content['url'] = $this->url;
        }

        if ($this->color) {
            $content['color'] = $this->color;
        }

        if ($this->miniprogram['appid'] && $this->miniprogram['pagepath']){
            $content['miniprogram'] = $this->miniprogram;
        }

        if ($this->data) {
            $content['data'] = $this->data;
        }

        return json_encode($content, JSON_UNESCAPED_UNICODE);
    }
}
