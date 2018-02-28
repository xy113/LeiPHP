<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/10
 * Time: 下午3:40
 */

namespace WeChat\WxApi;


use Core\Http;
use WeChat\WxApi\Message\WxTemplateMessage;

class WxTemplateMessageApi extends WxApi
{

    /**
     * 添加模板
     * @param $template_id_short
     * @return mixed
     */
    public function addTemplate($template_id_short){
        $data = json_encode(array('template_id_short'=>$template_id_short));
        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=".$this->getAccessToken(), $data);
        return $res;
    }

    /**
     * 获取所有消息模板
     * @return mixed
     */
    public function getAllTemplate(){
        $res = Http::curlGet("https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=".$this->getAccessToken());
        return $res;
    }

    /**
     * 删除模板
     * @param $template_id
     * @return mixed
     */
    public function deleteTemplate($template_id){
        $data = json_encode(array('template_id'=>$template_id));
        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token=".$this->getAccessToken(), $data);
        return $res;
    }


    /**
     * 发送模板消息
     * @param WxTemplateMessage $message
     * @return string
     * @throws \Exception
     * 返回示例{
     *"errcode":0,
     *"errmsg":"ok",
     *"msgid":200228332
     *}
     */
    public function sendMessage(WxTemplateMessage $message){
        if (!$message->touser) {
            throw new \Exception('Empty touser value', 1);
        }

        if (!$message->template_id) {
            throw new \Exception('Empty template_id value', 2);
        }

        if (!$message->data) {
            throw new \Exception('Empty data value', 3);
        }

        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->getAccessToken(), $message->getMsgContent());
        return $res;
    }
}
