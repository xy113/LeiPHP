<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午3:15
 */

namespace WeChat\WxApi;


use Core\Http;

class WxKefuApi extends WxApi
{
    /**
     * 添加客服账号
     * @param $kf_account
     * @param $nickname
     * @param $password(md5 password)
     * @return mixed({"errcode" : 0,"errmsg" : "ok"})
     */
    public function add($kf_account, $nickname, $password){
        $data = json_encode(array(
            'kf_account'=>$kf_account,
            'nickname'=>$nickname,
            'password'=>$password
        ));
        $res = Http::curlPost("https://api.weixin.qq.com/customservice/kfaccount/add?access_token=".$this->getAccessToken(), $data);
        return $res;
    }

    /**
     * 修改客服账号
     * @param $kf_account
     * @param $nickname
     * @param $password
     * @return mixed
     */
    public function update($kf_account, $nickname, $password){
        $data = json_encode(array(
            'kf_account'=>$kf_account,
            'nickname'=>$nickname,
            'password'=>$password
        ));
        $res = Http::curlPost("https://api.weixin.qq.com/customservice/kfaccount/update?access_token=".$this->getAccessToken(), $data);
        return $res;
    }

    /**
     * 删除客服账号
     * @param $kf_account
     * @param $nickname
     * @param $password
     * @return mixed
     */
    public function delete($kf_account, $nickname, $password){
        $data = json_encode(array(
            'kf_account'=>$kf_account,
            'nickname'=>$nickname,
            'password'=>$password
        ));
        $res = Http::curlPost("https://api.weixin.qq.com/customservice/kfaccount/del?access_token=".$this->getAccessToken(), $data);
        return $res;
    }

    /**
     * 上传客服头像
     * @param $kf_account
     * @param $imgfile --头像绝对路径
     * @return mixed
     */
    public function uploadHeadimg($kf_account, $imgfile){
        $access_token = $this->getAccessToken();
        if (version_compare(PHP_VERSION,'5.5.0','<')){
            $media = '@'.$imgfile;
        }else {
            $media = new \CURLFile($imgfile);
        }
        $access_data = array('media'=>$media);
        $url = "http://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token=$access_token&kf_account=$kf_account";
        return Http::curlPost($url, $access_data);
    }

    /**
     * 获取客服列表
     * @return mixed
     */
    public function getKfList(){
        $url = "https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=".$this->getAccessToken();
        return Http::curlGet($url);
    }
}
