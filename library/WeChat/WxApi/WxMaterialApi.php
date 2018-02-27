<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/10
 * Time: 下午3:43
 */

namespace WeChat\WxApi;


use Core\Http;

class WxMaterialApi extends WxApi
{
    /**
     * @param $type
     * @param $data
     * @return mixed
     */
    public function add($type, $data){
        $access_token = $this->getAccessToken();
        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$access_token&type=$type", $data);
        return $res;
    }

    /**
     * @param $media_id
     * @return mixed
     */
    public function del($media_id){
        $access_data = json_encode(array('media_id'=>$media_id));
        $access_token = $this->getAccessToken();
        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$access_token", $access_data);
        return $res;
    }

    /**
     * @param $media_id
     * @return mixed
     */
    public function get($media_id){
        $access_data = json_encode(array('media_id'=>$media_id));
        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=".$this->getAccessToken(), $access_data);
        return $res;
    }

    /**
     * @return mixed
     */
    public function getCount(){
        $res = Http::curlGet("https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=".$this->getAccessToken());
        return $res;
    }

    /**
     * @param string $type
     * @param int $offset
     * @param int $count
     * @return mixed
     */
    public function batchget($type='image', $offset=0, $count=20){
        $access_data = json_encode(array(
            'type'=>$type,
            'offset'=>$offset,
            'count'=>$count
        ));
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$this->getAccessToken();
        $res = Http::curlPost($url, $access_data);
        return $res;
    }
}
