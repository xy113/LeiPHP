<?php
/**
 * ============================================================================
 * Copyright (c) 2014 WWW.DSXCMS.COM All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2014-07-02
 * $ID: class.ParseVideoUrl.php
 */
namespace Core;

class VideoParserModel{
    public $img;
    public $tit;
    public $url;
    public $swf;
}

class VideoParser{
	const URL_VILID = '/(youku\.com|tudou\.com|video\.sina\.com\.cn|tv\.sohu\.com|v\.qq\.com|56\.com|ku6\.com)/';
	static function parse($url=''){
		preg_match(self::URL_VILID, strtolower($url),$matches);
		switch ($matches[1]){
			case 'youku.com' :
				$data = self::_youku($url);
				break;
			case '56.com':
				$data = self::_parse56($url);
				break;
			case 'ku6.com':
				$data = self::_ku6($url);
				break;
			case 'v.qq.com':
				$data = self::_qq($url);
				break;
			case 'video.sina.com.cn':
				$data = self::_sina($url);
				break;
			default:
				$data = false;
		}
		return $data;
	}

    /**
     * @param $url
     * @return bool|VideoParserModel
     */
    public static function _youku($url){
		preg_match('/id\_(\w+)[\=|\.html]/', $url,$matches);
		$link = "https://openapi.youku.com/v2/videos/show_basic.json?video_id={$matches[1]}&client_id=b10ab8588528b1b1";
		$json = Http::curlGet($link);
		if($json){
			$array = json_decode($json, true);
			$video = new VideoParserModel();
			$video->img = $array['thumbnail'];
			$video->tit = $array['title'];
			$video->url = $array['link'];
			$video->swf = $array['player'];
            return $video;
		}else {
		    return false;
        }
	}


    /**
     * @param $url
     * @return bool|VideoParserModel
     */
    public static function _qq($url){
		preg_match('/\?vid=([a-zA-Z0-9]+)/', $url, $match1);
		$vid = $match1[1];
		if (!$vid) {
			preg_match('/\/([a-zA-Z0-9]+)\.html/', $url,$matches);
			$vid = $matches[1];
		}

		$xml = Http::curlGet('http://vv.video.qq.com/getinfo?otype=xml&vids='.$vid);
		//$xml = simplexml_load_string($xml);
		//$title = $xml->vl->vi->ti;
		//echo $title;
		//将XML转为array
		$array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		//echo $array_data['vl']['vi']['ti'];
        if ($array_data) {
            $video = new VideoParserModel();
            $video->url = $url;
            $video->tit = $array_data['vl']['vi']['ti'];
            $video->img = 'http://vpic.video.qq.com/'.date('mdHi').'/'.$vid.'_160_90_3.jpg';
            $video->swf = 'http://static.video.qq.com/TPout.swf?vid='.$vid;
            return $video;
        }else {
            return false;
        }
	}
	public static function _tudou($url){

	}
	public static function _sohu($url){

	}
	public static function _sina($url){
		if(preg_match('/opsubject_id=(.*?)\#([0-9]+)$/', $url,$matches)){
			$vid = $matches[2];
		}
		if(preg_match('/\/([0-9]+)\.html$/', $url,$matches)){
			$vid = $matches[1];
		}
		$imgstr = Http::curlGet('http://interface.video.sina.com.cn/interface/common/getVideoImage.php?vid='.$vid);
		return array(
			'url'=>$url,
			'img'=>str_replace('imgurl=', '', $imgstr),
			'swf'=>'http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid='.$vid.'_6/s.swf',
			'tit'=>''
		);
	}
	public static function _parse56($url){
		$data = array();
		preg_match('/v_(.*?)\.html/', $url,$matches);
		$json = Http::curlGet('http://vxml.56.com/json/'.$matches[1].'/?src=out');
		if($json){
			$array = json_decode($json,true);
			$data['img'] = $array['info']['img'];
			$data['tit'] = $array['info']['Subject'];
			$data['url'] = $url;
			$data['swf'] = "http://player.56.com/v_{$matches[1]}.swf";
		}
		return $data;
	}
	public static function _ku6($url){
		$data = array();
		preg_match('/show\/(.*?)\.\.\.html/', $url,$matches);
		if(!empty($matches[1])){
			$json = Http::curlGet('http://v.ku6.com/fetchVideo4Player/'.$matches[1].'.html');
			if($json){
				$array = json_decode($json,true);
				$data['img'] = $array['data']['picpath'];
				$data['tit'] = $array['data']['t'];
				$data['url'] = $url;
				$data['swf'] = "http://player.ku6.com/refer/{$matches[1]}/v.swf";
			}
		}
		return $data;
	}
}
