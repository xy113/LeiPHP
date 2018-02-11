<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/9
 * Time: 下午4:09
 */

/**
 * 配置全局变量
 * @param string $name
 * @param string $value
 * @return bool|string
 */
function G($name=null, $value=''){
	global $_G;
	if (is_null($name)){
		return $_G;
	}else {
	    if ($value === ''){
            return isset($_G[$name]) ? $_G[$name] : '';
        }elseif (is_null($value)) {
            unset($_G[$name]);
            return true;
        }else {
            $_G[$name] = $value;
            return $value;
        }
	}
}

/**
 * 语言设置
 * @param string $name
 * @param string $value
 * @return bool|string
 * @internal param string $langname
 */
function L($name=null, $value=''){
	global $_lang;
	if (is_null($name)){
		return $_lang;
	}else {
	    if ($value === ''){
            return isset($_lang[$name]) ? $_lang[$name] : $name;
        }elseif (is_null($value)){
            unset($_lang[$name]);
            return true;
        }else {
            $_lang[$name] = $value;
            return $value;
        }
	}
}

/**
 * 增加配置
 * @param string $name
 * @param string $value
 * @return bool|string
 */
function C($name=null, $value=''){
	global $_config;
	if (is_null($name)) {
		return $_config;
	}else {
        if ($value === ''){
            return isset($_config[$name]) ? $_config[$name] : '';
        }elseif (is_null($value)){
            unset($_config[$name]);
            return true;
        }else {
            $_config[$name] = $value;
            return $value;
        }
    }
}

/**
 * 获取数据连接单例
 * @return \Core\DB_Mysqli
 */
function DB(){
    return \Core\DB_Mysqli::getInstance();
}

/**
 * 创建链接
 * @param string $path
 * @param mixed $params
 * @return string
 */
function URL($path, $params=null){
    $url = getSiteURL();

    if (is_array($params)) {
        $params = empty($params) ? '' : http_build_query($params);
    }

    if ($path) {
        if (REWRITE_MOD) {
            $url.= $path;
        }else {
            $url.= '/index.php?';
            $paths = explode('/', $path);
            $url.= 'm='.$paths[1];
            $url.= isset($paths[2]) ? '&c='.$paths[2] : '';
            $url.= isset($paths[3]) ? '&a='.$paths[3] : '';
        }
    }else {
        $url.= '/';
    }

    if ($params) {
        $url.= strpos($url, '?') ? '&'.$params : '?'.$params;
    }
	return $url;
}

/**
 * 后台配置操作函数
 * @param string $name
 * @param string $value
 * @return bool|null|string
 */
function setting($name=null, $value=''){
    global $_settings;
    if (is_null($name)) {
        return $_settings;
    }else {
        if ($value === ''){
            return isset($_settings[$name]) ? $_settings[$name] : null;
        }elseif (is_null($value)){
            unset($_settings[$name]);
            return true;
        }else {
            $_settings[$name] = $value;
            return $value;
        }
    }
}

/**
 * 缓存操作
 * @param string $name
 * @param string $value
 * @return bool|mixed
 */
function cache($name, $value=''){
	$cache = Core\Cache::getInstance();
	if ($value === ''){
		return $cache->get($name);
	}elseif (is_null($value)){
		return $cache->rm($name);
	}else {
		return $cache->set($name,$value);
	}
}

/**
 * Cookie 操作
 * @param string $name
 * @param string $value
 * @param int $expire
 * @return null
 */
function cookie($name='', $value='', $expire=0, $encrypt=true){
	// 默认设置
    $config = C('cookie');
	$config['expire'] = $expire ? intval($expire) : $config['expire'];
	// 清除指定前缀的所有cookie
	if (is_null($name)) {
		if (empty($_COOKIE))
			return null;
			// 要删除的cookie前缀，不指定则删除config设置的指定前缀
			$prefix = empty($value) ? $config['prefix'] : $value;
			if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
				foreach ($_COOKIE as $key => $val) {
					if (0 === stripos($key, $prefix)) {
						setcookie($key, '', time() - 3600, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
						unset($_COOKIE[$key]);
					}
				}
			}
			return null;
	}elseif('' === $name){
		// 获取全部的cookie
		return $_COOKIE;
	}

	$name = $config['prefix'] . str_replace('.', '_', $name);
	if ('' === $value) {
		if (isset($_COOKIE[$name])) {
		    return $encrypt ? authcode($_COOKIE[$name], true) : $_COOKIE[$name];
        }else {
		    return null;
        }
	} else {
		if (is_null($value)) {
			setcookie($name, '', time() - 3600, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
			unset($_COOKIE[$name]); // 删除指定cookie
		} else {
			// 设置cookie
			if(is_array($value)){
				$value  = serialize($value);
			}
			$encrypt && $value = authcode($value);
			$expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
			setcookie($name, $value, $expire, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
			$_COOKIE[$name] = $value;
		}
	}
	return null;
}

/**
 * 获取用户头像地址
 * @param int|number $uid
 * @param string $size
 * @param int|number $img
 * @return string
 */
function avatar($uid=0,$size='big',$img=0){
	if (!$uid) return C('STATICURL').'images/common/avatar_default.png';
	$size = in_array($size, array('small','middle')) ? $size : 'big';
	$imgurl = getSiteURL().'/?m=plugin&c=avatar&uid='.$uid.'&size='.$size;
    return $img ? '<img src="' . $imgurl . '" border="0"/>' : $imgurl;
}

/**
 * 解析素材地址
 * @param string $file
 * @param string $type
 * @return string
 */
function material($file, $type='image'){
    if (preg_match("/([http|https|ftp]\:\/\/)(.*?)/is", $file)){
        $url = $file;
    }else {
        $url = C('ATTACHURL').$type.'/'.$file;
    }
    return $url;
}

/**
 * 地址图片解析
 * @param $file
 * @param int|number $html
 * @return string
 * @internal param string $path
 */
function image($file,$html=0){
	if (preg_match("/([http|https|ftp]\:\/\/)(.*?)/is", $file)){
		$url = $file;
	}else {
		if (is_file(C('ATTACHDIR').'image/'.$file)){
			$url = C('ATTACHURL').'image/'.$file;
		}else {
			$url = C('STATICURL').'images/common/placeholder.png';
		}
	}
	if ($html){
		return '<img src="'.$url.'" />';
	}else {
		return $url;
	}
}

/**
 * 解析视频地址
 * @param $file
 * @return string
 */
function video($file){
    return material($file, 'video');
}

/**
 * 解析音频地址
 * @param $file
 * @return string
 */
function voice($file){
    return material($file, 'voice');
}

/**
 * 格式化距离
 * @param string $distance
 * @return string
 */
function distance($distance){
	if (!$distance) return '';
	if ($distance < 1000){
		return $distance.'m';
	}else {
		return number_format($distance/1000,2).'km';
	}
}

/**
 * @desc 计算两点之间的距离
 * @param float $lat 纬度值
 * @param float $lng 经度值
 * @param float $lat2 纬度值
 * @param float $lng2 经度值
 * @return float
 */
function getDistance($lat1,$lng1,$lat2,$lng2){
	$earthRadius = 6377830;
	$lat1 = ($lat1 * pi() ) / 180;
	$lng1 = ($lng1 * pi() ) / 180;

	$lat2 = ($lat2 * pi() ) / 180;
	$lng2 = ($lng2 * pi() ) / 180;

	$calcLongitude = $lng2 - $lng1;
	$calcLatitude  = $lat2 - $lat1;
	$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);  $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
	$calculatedDistance = $earthRadius * $stepTwo;
	return round($calculatedDistance);
}

/**
 * 16位MD5散列值
 * @param $str
 * @return string
 */
function md5_16($str){
    return substr(md5($str), 0, 16);
}

/**
 * discuz 加减密方法
 * @param string $string
 * @param number $decode
 * @param string $key
 * @param number $expiry
 * @return string
 */
function authcode($string, $decode = 0, $key = '', $expiry = 0) {
    $ckey_length = 4;
    $key  = md5($key ? $key : C('AUTHKEY'));
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($decode ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $decode ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if($decode) {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

/**
 * 获取密码密文
 * @param string $password
 * @return string
 */
function getPassword($password){
	if ($password) {
		return sha1(md5($password));
	}else {
		return '';
	}
}

/**
 * 产生一个HASH字符串
 * @return string
 */
function formhash() {
    return md5(substr(time(), 0, -4).C('AUTHKEY'));
}

function daddslashes($string, $force = 0) {
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if(!MAGIC_QUOTES_GPC || $force) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val, $force);
            }
        } else {
            $string = addslashes($string);
        }
    }
    return $string;
}

/**
 * 按长度截取字符串
 * @param string $string
 * @param string $length
 * @param string $dot
 * @return string
 */
function cutstr($string, $length, $dot ='...', $charset='utf8') {
    if(strlen($string) <= $length) {
        return $string;
    }
    $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
    $strcut = '';
    if(strtolower($charset) == 'utf8') {
        $n = $tn = $noc = 0;
        while($n < strlen($string)) {
            $t = ord($string[$n]);
            if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif(194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 2;
            } elseif(224 <= $t && $t < 239) {
                $tn = 3; $n += 3; $noc += 2;
            } elseif(240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 2;
            } elseif(248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 2;
            } elseif($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 2;
            } else {
                $n++;
            }
            if($noc >= $length) {
                break;
            }
        }
        if($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
    } else {
        for($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
        }
    }
    $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
    return $strcut.$dot;
}

/**
 * 去除一些特殊字符
 * @param string $string
 * @return mixed
 */
function dhtmlspecialchars($string) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = dhtmlspecialchars($val);
        }
    } else {
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1',
        //$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
        str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
    }
    return $string;
}

/**
 * 生成一个随机字符串
 * @param number $length
 * @param int|number $numeric
 * @return string
 */
function random($length, $numeric = 0) {
    PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
    $seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
    $seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
    $hash = '';
    $max = strlen($seed) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $seed[mt_rand(0, $max)];
    }
    return $hash;
}

/**
 * 获取站点URL
 * @return string
 */
function getSiteURL(){
    $http = $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
    $http.= $_SERVER['HTTP_HOST'];//获取当前的服务器名
    $root = $_SERVER['DOCUMENT_ROOT'];//获取服务器的根目录
    return substr(str_replace($root , $http , ROOT_PATH), 0, -1);//获取当前站点根URL
}

/**
 * 去除HTML代码和空格
 * @param string $str
 * @return mixed
 */
function stripHtml($str){
    $str = strip_tags($str);
    $str = str_replace('&amp;', '&', $str);
    $str = str_replace(array('&ldquo;','&rdquo;'),array('“','”'),$str);
    $str = preg_replace('/\s|\n\r|　/', '', $str);
    return $str;
}

/**
 * 打印数组
 * @param mixed $array
 */
function print_array($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

/**
 * 获取模板文件路径
 * @param string $file
 * @param string $tpldir 目录
 * @param string $theme 主题
 * @return string
 */
function view($file, $model = '', $theme='') {
    global $_G;

    $tpldir = $model ? $model : ($_G['m'] ? strtolower($_G['m']) : 'common');
    if (defined('IN_ADMIN')) {
        $theme = 'default';
    }else {
        !$theme && $theme = defined('THEME') ? THEME : 'default';
    }

    $tplfile = TPL_PATH.$theme.'/'.$model.'/'.$file.'.php';
    if (!is_file($tplfile)){
        $tpldir2 = $tpldir;
        $tpldir  = 'common';
        $tplfile = TPL_PATH.$theme.'/common/'.$file.'.php';
        if (!is_file($tplfile)){
            $tpldir  = $tpldir2;
            $theme = 'default';
            $tplfile = TPL_PATH.'/default/'.$tpldir.'/'.$file.'.php';
            if (!is_file($tplfile)){
                $tpldir  = 'common';
                $tplfile = TPL_PATH.'default/common/'.$file.'.php';
            }
        }
    }

    $objfile = RUNTIME_DIR.'templates/'.$theme.'/'.$tpldir.'/'.md5($tplfile).'.php';
    if (!is_file($objfile) || filemtime($tplfile)>filemtime($objfile)){
        @mkdir(dirname($objfile),0777,true);
        \Core\View::parse($tplfile, $objfile);
    }
    return $objfile;
}

/**
 * 序列号ID
 * @param mixed $array
 * @return string
 */
function implodeids($array) {
    if(!empty($array)) {
        return "'".implode("','", is_array($array) ? $array : array($array))."'";
    } else {
        return '';
    }
}

/**
 * 格式时间
 * @param string $time
 * @param string $format
 * @return boolean
 */
function formatTime($time,$format=''){
    if(!$time) return false;
    !$format && $format = setting('dateformat');
    !$format && $format = 'Y-m-d';
    return @date($format,$time);
}

/**
 * 格式化文件尺寸
 * @param number $size
 * @return string
 */
function formatSize($size){
    $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    if ($size == 0) {
        return('n/a');
    } else {
        return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
    }
}

/**
 * 金额格式化
 * @param float $amount
 * @param number $decimals
 * @return string
 */
function formatAmount($amount, $decimals=2){
    $amount = floatval($amount);
	return @number_format($amount, $decimals, '.', '');
}

/**
 * 替换字符串
 * @param string $string
 * @param mixed $replacer
 * @return mixed
 */
function stringParser($string,$replacer){
    $result = str_replace(array_keys($replacer), array_values($replacer),$string);
    return $result;
}

/**
 * 获取当前页面地址
 * @return string
 */
function curPageURL() {
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["HTTP_HOST"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

/**
 * 获取用户真实IP
 * @return string
 */
function getIp() {
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * SQL反注入
 * @param string $sql
 * @return bool
 */
function injCheck($sql) {
    $check = preg_match('/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile/', $sql);
    if ($check) {
        return false;
    } else {
        return $sql;
    }
}

/**
 * 判断是否从移动客户端访问
 */
function mobilecheck()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}

/**
 * 清除文档格式
 */
function cleanUpStyle($str){
	$str = preg_replace('/\s*mso-[^:]+:[^;"]+;?/i', "", $str);
	$str = preg_replace('/\s*margin(.*?)pt\s*;/i', "", $str);
	$str = preg_replace('/\s*margin(.*?)cm\s*;/i', "", $str);
	$str = preg_replace('/\s*text-indent:(.*?)\s*;/i', "", $str);
	$str = preg_replace('/\s*line-height:(.*?)\s*;/i', "", $str);
	$str = preg_replace('/\s*page-break-before: [^\s;]+;?"/i', "", $str);
	$str = preg_replace('/\s*font-variant: [^\s;]+;?"/i', "", $str);
	$str = preg_replace('/\s*tab-stops:[^;"]*;?/i', "", $str);
	$str = preg_replace('/\s*tab-stops:[^"]*/i', "", $str);
	$str = preg_replace('/\s*face="[^"]*"/i', "", $str);
	$str = preg_replace('/\s*face=[^ >]*/i', "", $str);
	$str = preg_replace('/\s*font:(.*?);/i', "", $str);
	$str = preg_replace('/\s*font-size:(.*?);/i', "", $str);
	$str = preg_replace('/\s*font-weight:(.*?);/i', "", $str);
	$str = preg_replace('/\s*font-family:[^;"]*;?/i', "", $str);
	$str = preg_replace('/<span style="Times New Roman&quot;">\s\n<\/span>/i', "", $str);
	return $str;
}

/**
 * rewrite 伪静态
 * @param string $content
 * @return mixed
 */
function rewrite($content){
	 $content = preg_replace_callback('/\<a(.*?)href=\"(\/|\/index\.php)\?(.*?)\"(.*?)\>/', function($matches){
		 parse_str($matches[3], $arr);
		 $str = getSiteURL();
		 $str.= isset($arr['m']) ? '/'.$arr['m'] : DEFAULT_MODEL;
		 $str.= isset($arr['c']) ? '/'.$arr['c'] : '/index';
		 $str.= isset($arr['a']) ? '/'.$arr['a'] : '';
		 $str.= $str ? '.htm' : '';
		 unset($arr['m'], $arr['c'], $arr['a']);
		 if (!empty($arr)) {
		 	$query = http_build_query($arr);
		 	$str.= '?'.$query;
		 }
		 return '<a'.$matches[1].'href="'.$str.'"'.$matches[4].'>';
	 }, $content);
	 return $content;
}

/**
 * php生成全球唯一id，php生成随机码，php 生成永不重复字符串
 * @return string
 */
function guid() {
	$charid = strtoupper(md5(uniqid(mt_rand(), true)));
	$uuid = substr($charid, 0, 8).
	substr($charid, 8, 4).
	substr($charid,12, 4).
	substr($charid,16, 4).
	substr($charid,20,12);
	return $uuid;
}
