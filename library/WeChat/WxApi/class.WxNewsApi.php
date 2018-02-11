<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 上午10:41
 */

namespace WxApi;

use Core\Http;

class WxNewsApi extends WxApi
{
    /**
     * @param $media_id
     * @return mixed
     */
    public function get($media_id){
        $access_data = json_encode(array('media_id'=>$media_id));
        $access_token = $this->getAccessToken();
        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=$access_token", $access_data);
        return $res;
    }
    /**
     * @param int $offset
     * @param int $count
     * @return mixed
     */
    public function batchget($offset=0, $count=20){
        $access_data = json_encode(array(
            'type'=>'news',
            'offset'=>$offset,
            'count'=>$count
        ));
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$this->getAccessToken();
        $res = Http::curlPost($url, $access_data);
        return $res;
    }

    /**
     * @param $data
     * @return mixed
     * @desc
     * {
    "articles": [{
    "title": TITLE,
    "thumb_media_id": THUMB_MEDIA_ID,
    "author": AUTHOR,
    "digest": DIGEST,
    "show_cover_pic": SHOW_COVER_PIC(0 / 1),
    "content": CONTENT,
    "content_source_url": CONTENT_SOURCE_URL
    },    //若新增的是多图文素材，则此处应还有几段articles结构
    ]
    }
     */
    public function add($data){
        $access_token = $this->getAccessToken();
        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=$access_token", $data);
        return $res;
    }

    /**
     * @param $media_id
     * @return mixed
     */
    public function delete($media_id){
        $access_data = json_encode(array('media_id'=>$media_id));
        $access_token = $this->getAccessToken();
        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$access_token", $access_data);
        return $res;
    }

    /**
     * @param $data
     * @return mixed
     * {
    "media_id":MEDIA_ID,
    "index":INDEX,
    "articles": {
    "title": TITLE,
    "thumb_media_id": THUMB_MEDIA_ID,
    "author": AUTHOR,
    "digest": DIGEST,
    "show_cover_pic": SHOW_COVER_PIC(0 / 1),
    "content": CONTENT,
    "content_source_url": CONTENT_SOURCE_URL
    }
    }
     */
    public function update($data){
        $access_token = $this->getAccessToken();
        $res = Http::curlPost("https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=$access_token", $data);
        return $res;
    }
}