<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/23
 * Time: 上午9:21
 */

namespace Core;


class Http
{
    /**
     * @param $url
     * @param int $ssl
     * @param int $timeout
     * @return mixed
     */
    public static function curlGet($url, $ssl=0, $timeout=500){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $ssl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $ssl);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

    /**
     * @param $url
     * @param string $data
     * @param int $ssl
     * @param int $timeout
     * @return mixed
     */
    public static function curlPost($url, $data='', $ssl=0, $timeout=500){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $ssl);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $ssl);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
}