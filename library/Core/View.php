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
 * Time: 上午9:45
 */

namespace Core;

class View{
    /**
     * @param $tplfile
     * @param $objfile
     */
    public static function parse($tplfile, $objfile) {

		if(!@$fp = fopen($tplfile, 'r')) {
			exit("Current template file '/".str_replace(ROOT_PATH, '', $tplfile)."' not found or have no access!");
		}

		$template = fread($fp, filesize($tplfile));
		$template = "<?php if (!defined('IN_LEIPHP')) die('Access Denied!');?>".$template;
		fclose($fp);

		//$template = preg_replace("/([\n\r]+)\t+/s", "\\1", $template);
		$template = preg_replace("/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template);
		$template = str_replace("{LF}", "<?=\"\\n\"?>", $template);

		$template = preg_replace("/\{(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}/s", "<?=\\1?>", $template);
        $template = preg_replace_callback("/[\n\r\t]*\{template\s+([a-z0-9_:]+)\}[\n\r\t]*/is", function ($matches){
            return View::stripvtemplate($matches[1]);
        }, $template);
        $template = preg_replace_callback("/[\n\r\t]*\{template\s+(.+?)\s+(.+?)\}[\n\r\t]*/is", function ($matches){
            return View::stripvtemplate($matches[1], $matches[2]);
        }, $template);
        $template = preg_replace_callback("/[\n\r\t]*\{template\s+(.+?)\}[\n\r\t]*/is", function ($matches){
            return View::stripvtemplate($matches[1]);
        }, $template);

        $template = preg_replace_callback("/[\n\r\t]*\{eval\s+(.+?)\}[\n\r\t]*/is", function ($matches){
            return View::stripvtags('<?php '.$matches[1].'; ?>', '');
        }, $template);
        $template = preg_replace_callback("/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/is", function ($matches){
            return View::stripvtags('<?php echo '.$matches[1].'; ?>', '');
        }, $template);
        $template = preg_replace_callback("/([\n\r\t]*)\{elseif\s+(.+?)\}([\n\r\t]*)/is", function ($matches){
            return View::stripvtags($matches[1].'<? } elseif('.$matches[2].') { ?>'.$matches[3], '');
        }, $template);
		$template = preg_replace("/([\n\r\t]*)\{else\}([\n\r\t]*)/is", "\\1<? } else { ?>\\2", $template);

		//自定义标签
		$template = preg_replace_callback('/\<php\>(.*?)\<\/php\>/is', function($matches){
			return View::stripvtags('<?php '.$matches[1].' ?>', '');
		}, $template);

		//替换头像
		$template = preg_replace_callback('/{avatar\:(.+?)\|([big|middle|small]+)\}/is', function($matches){
			return View::stripvtags('<?php echo avatar('.$matches[1].',\''.$matches[2].'\'); ?>','');
		}, $template);

        //替换配置内容
        $template = preg_replace_callback('/{C\s+(.+?)\}/is', function($matches){
            return View::stripvtags('<?php echo C('.$matches[1].'); ?>','');
        }, $template);

		//替换语言
		$template = preg_replace_callback('/{lang\s+(.+?)\}/is', function($matches){
			return View::stripvtags('<?php echo L('.$matches[1].'); ?>','');
		}, $template);

        //替换系统设置
        $template = preg_replace_callback('/{setting\s+(.+?)\}/is', function($matches){
            return View::stripvtags('<?php echo setting('.$matches[1].'); ?>','');
        }, $template);

        //替换COOCKIE值
        $template = preg_replace_callback('/{cookie\s+(.+?)\}/is', function($matches){
            return View::stripvtags('<?php echo cookie('.$matches[1].'); ?>','');
        }, $template);

        //解析图片URL
        $template = preg_replace_callback('/{img\s+(.+?)\}/is', function($matches){
            return View::stripvtags('<?php echo image('.$matches[1].'); ?>','');
        }, $template);

        //解析URL
        $template = preg_replace_callback('/{URL\:\((.+?)\)\}/is', function($matches){
            return View::stripvtags('<?php echo URL('.$matches[1].'); ?>','');
        }, $template);

        //格式化日期
        $template = preg_replace_callback('/{date\:(.+?)\|(.+?)\}/is', function($matches){
            return View::stripvtags('<?php echo @date('.$matches[2].','.$matches[1].'); ?>','');
        }, $template);

        //格式化金额
        $template = preg_replace_callback('/{amount\:(.+?)\}/is', function($matches){
            return View::stripvtags('<?php echo formatAmount('.$matches[1].'); ?>','');
        }, $template);

        $template = preg_replace_callback('/{__formhash__}/is', function(){
            $content = '<input type="hidden" name="_formsubmit" value="yes">';
            $content.= '<input type="hidden" name="_formhash" value="<?php echo formhash(); ?>">';
            return View::stripvtags($content, '');
        }, $template);

		for($i = 0; $i < 5; $i++) {
            $template = preg_replace_callback("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r]*(.+?)[\n\r]*\{\/loop\}[\n\r\t]*/is", function ($matches){
                return View::stripvtags('<?php if(is_array('.$matches[1].')) { foreach('.$matches[1].' as '.$matches[2].') { ?>',$matches[3].'<?php } } ?>');
            }, $template);
            $template = preg_replace_callback("/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*(.+?)[\n\r\t]*\{\/loop\}[\n\r\t]*/is", function ($matches){
                return View::stripvtags('<?php if(is_array('.$matches[1].')) { foreach('.$matches[1].' as '.$matches[2].'=>'.$matches[3].') { ?>',$matches[4].'<?php } } ?>');
            }, $template);
		    $template = preg_replace_callback("/([\n\r\t]*)\{if\s+(.+?)\}([\n\r]*)(.+?)([\n\r]*)\{\/if\}([\n\r\t]*)/is", function ($matches){
		        return View::stripvtags($matches[1].'<?php if('.$matches[2].') { ?>'.$matches[3], $matches[4].$matches[5].'<?php } ?>'.$matches[6]);
            }, $template);
		}

        for($i = 0; $i < 5; $i++) {
            $template = preg_replace_callback("/[\n\r\t]*\{foreach\s+(\S+)\s+(\S+)\}[\n\r]*(.+?)[\n\r]*\{\/foreach\}[\n\r\t]*/is", function ($matches){
                return View::stripvtags('<?php if(is_array('.$matches[1].')) { foreach('.$matches[1].' as '.$matches[2].') { ?>',$matches[3].'<?php } } ?>');
            }, $template);
            $template = preg_replace_callback("/[\n\r\t]*\{foreach\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*(.+?)[\n\r\t]*\{\/foreach\}[\n\r\t]*/is", function ($matches){
                return View::stripvtags('<?php if(is_array('.$matches[1].')) { foreach('.$matches[1].' as '.$matches[2].'=>'.$matches[3].') { ?>',$matches[4].'<?php } } ?>');
            }, $template);
            $template = preg_replace_callback("/([\n\r\t]*)\{if\s+(.+?)\}([\n\r]*)(.+?)([\n\r]*)\{\/if\}([\n\r\t]*)/is", function ($matches){
                return View::stripvtags($matches[1].'<?php if('.$matches[2].') { ?>'.$matches[3], $matches[4].$matches[5].'<?php } ?>'.$matches[6]);
            }, $template);
        }

		$const_regexp = "([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)";
		$template = preg_replace("/\{$const_regexp\}/s", "<?php echo \\1; ?>", $template);
		$template = preg_replace("/ \?\>[\n\r]*\<\? /s", " ", $template);

        $template = preg_replace_callback("/\"(http)?[\w\.\/:]+\?[^\"]+?&[^\"]+?\"/", function ($matches){
            return View::transamp($matches[0]);
        }, $template);
        $template = preg_replace_callback("/\<script[^\>]*?src=\"(.+?)\".*?\>\s*\<\/script\>/is", function ($matches){
            return View::stripscriptamp($matches[1]);
        }, $template);
		$template = preg_replace("/\<\?(\s{1})/is", "<?php\\1", $template);
		$template = preg_replace("/\<\?\=(.+?)\?\>/is", "<?php echo \\1;?>", $template);
		/* 修正css路径 */
		/*
		$template = preg_replace('/(<link\shref=["|\'])(?:\.\/|\.\.\/)?(css\/)?([a-z0-9A-Z_]+\.css["|\']\srel=["|\']stylesheet["|\']\stype=["|\']text\/css["|\'])/i','\1' . STATICURL . '\2\3', $template);
		$pattern = array(
				'/(href=["|\'])\.\.\/(.*?)(["|\'])/i',  // 替换相对链接
				'/((?:background|src)\s*=\s*["|\'])(?:\.\/|\.\.\/)?(images\/.*?["|\'])/is', // 在images前加上 STATICURL
				'/((?:background|background-image):\s*?url\()(?:\.\/|\.\.\/)?(images\/)/is', // 在images前加上 STATICURL
				'/([\'|"])\.\.\//is', // 以../开头的路径全部修正为空
		);
		$replace = array(
				'\1\2\3',
				'\1' . STATICURL . '\2',
				'\1' . STATICURL . '\2',
				'\1'
		);
		$template = preg_replace($pattern, $replace, $template);
		*/
		if (is_file($objfile)) @chmod($objfile, 0644);
		if(!@$fp = fopen($objfile, 'w')) {
			exit("Directory './runtime/templates/' not found or have no access!");
		}
		flock($fp, 2);
		fwrite($fp, $template);
		fclose($fp);
	}

	/**
	 * 几个替换，过滤掉一些东西
	 */
	public static function transamp($str) {
		//$str = str_replace('&', '&amp;', $str);
		//$str = str_replace('&amp;amp;', '&amp;', $str);
		$str = str_replace('\"', '"', $str);
		return $str;
	}
	/**
	 * 从正则表达式来看是给ubb代码去掉一个\符号的，应该是为安全性着想的
	 */
	public static function addquote($var) {
		return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
	}
	/**
	 * 去掉自定义的一些tag
	 */
	public static function stripvtags($expr, $statement) {
		$expr = preg_replace("/\<\?\=(\\\$.+?)\?\>/s", "\\1", $expr);
		$expr = str_replace("\\\"", "\"", $expr);
		$statement = str_replace("\\\"", "\"", $statement);
		return $expr.$statement;
	}
	/**
	 * 作用是把&符号的html编码形式换成&，然后换成javascript引用的形式。
	 */
	public static function stripscriptamp($s) {
		$s = str_replace('&amp;', '&', $s);
		return "<script src=\"$s\" type=\"text/javascript\"></script>";
	}

    /**
     * 解析子模板
     * @param $tpl
     * @param string $mod
     * @return string
     */
    public static function stripvtemplate($tpl, $mod='') {
		if ($mod) {
			return self::stripvtags("<? include view('$tpl', '$mod'); ?>", '');
		}else {
			return self::stripvtags("<? include view('$tpl'); ?>", '');
		}
	}
}
