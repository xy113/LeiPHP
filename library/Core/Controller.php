<?php
namespace Core;

use App\Models\Settings;

abstract class Controller{
    protected $var = array();
	protected $uid = 0;
	protected $username = '';
	protected $member   = array();
    protected $islogin  = 0;
    protected $inAjax = 0;

    /**
     * Controller constructor.
     */
    function __construct(){
        global $_G, $_settings;

        ob_start();
        $this->var = &$_G;
        $this->uid = intval(cookie('uid'));
        $this->username = trim(cookie('username'));
        if ($this->uid && $this->username){
            $this->islogin = 1;
        }
        $this->var['uid'] = &$this->uid;
        $this->var['username'] = &$this->username;
        $this->var['member']   = &$this->member;
        $this->var['islogin']  = &$this->islogin;

        // php 判断是否为 ajax 请求
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            // ajax 请求的处理方式
            $this->inAjax = 1;
        }else {
            if ($_GET['inajax'] == 1){
                $this->inAjax = 1;
            }
        }
        $this->var['inajax'] = &$this->inAjax;

        $this->var['settings']     = Settings::getInstance()->getCache();
        $this->var['title']        = $this->var['settings']['sitename'];
        $this->var['keywords']     = $this->var['settings']['keywords'];
        $this->var['description']  = $this->var['settings']['description'];
        $this->var['page'] = isset($_GET['page']) ? max(array(intval($_GET['page']), 1)) : 1;
        $this->var['BASEURL'] = curPageURL();
        $this->var['_userToken'] = md5($this->uid.C('AUTHKEY').formhash());
	}

    /**
     * 验证图形验证码
     * @param string $code
     * @param bool|int $inajax
     * @return bool
     */
	protected function checkCaptchacode($code, $inajax=0){
		$code = strtolower($code);
		if (!$code || ($code != cookie('captchacode'))){
			if ($inajax) {
				$this->showAjaxError(1001, 'captchacode_incorrect');
			}else {
				$this->showError('captchacode_incorrect');
			}
		}else {
			cookie('captchacode', null);
			return true;
		}
	}

	/**
	 * 判断是否表单提交
	 */
	protected function checkFormSubmit(){
		if (($_GET['_formsubmit'] !== 'yes') || ($_GET['_formhash'] !== FORMHASH)){
			return false;
		}
		return true;
	}


    /**
     * @param $uid
     * @param $token
     * @return bool
     */
    protected function checkUserToken($uid, $token){
	    !$uid && $uid = $this->uid;
	    return (md5($uid.C('AUTHKEY').formhash()) === $token);
    }

    /**
     * 跳转登录页面
     * @param null $redirect
     */
    protected function showLogin($redirect = null){
	    if (is_null($redirect)) {
	        $redirect = rawurlencode(curPageURL());
        }
        $this->redirect(U("m=account&c=login&a=index&redirect=").$redirect);
    }

	/**
	 * 显示系统信息
	 * @param string $msg 提示信息
	 * @param string $type 信息类型
	 * @param string $forward 跳转页面
	 * @param array $links 可选链接
	 * @param string $tips 提示信息
	 * @param bool $autoredirect 是否自动跳转
	 */
	protected function showMessage($msg='', $type='success', $forward='', $links=array(), $tips='', $autoredirect=false){
		global $_G, $_lang;
		$type = in_array($type, array('error', 'warning', 'information')) ? $type : 'success';
		if (empty($links)) {
			$links = array(
					array(
							'text'=>'go_back',
							'url'=>$_SERVER['HTTP_REFERER']
					)
			);
		}elseif (is_null($links)){
			$links = array();
		}
		$forward = $forward ? $forward : ($links ? $links[0]['url'] : $_SERVER['HTTP_REFERER']);

		if ($links){
			$newlinks = array();
			foreach ($links as $link){
				$link['text'] = isset($_lang[$link['text']]) ? $_lang[$link['text']] : $link['text'];
				$link['target'] = in_array($link['target'], array('_blank','_top','_self')) ? $link['target'] : '';
				$newlinks[] = $link;
			}
			$links = $newlinks;
			unset($newlinks);
		}
		$msg  = isset($_lang[$msg]) ? $_lang[$msg] : $msg;
		$tips = isset($_lang[$tips]) ? $_lang[$tips] : '';
		$_G['title'] = $_lang['system_message'];
		include view('message');
		exit();
	}
	protected function showSuccess($msg,$forward='',$links=array(),$tips='',$autoredirect=false){
		$this->showmessage($msg,'success',$forward,$links,$tips,$autoredirect);
	}
	protected function showError($msg,$forward='',$links=array(),$tips='',$autoredirect=false){
		$this->showmessage($msg,'error',$forward,$links,$tips,$autoredirect);
	}
	protected function showWarning($msg,$forward='',$links=array(),$tips='',$autoredirect=false){
		$this->showmessage($msg,'warning',$forward,$links,$tips,$autoredirect);
	}
	protected function showInformation($msg,$forward='',$links=array(),$tips='',$autoredirect=false){
		$this->showmessage($msg,'information',$forward,$links,$tips,$autoredirect);
	}
	protected function notFound($message=''){
		!$message && $message = 'page_not_found';
		$this->showmessage($message,'error');
	}

	/**
	 * 无权限提示
	 * @param string $message
	 */
	protected function noPermission($message=''){
		!$message && $message = 'no_permission';
		$this->showmessage($message,'error');
	}

	/**
	 * 返回Ajax数据
	 * @param mixed $data
	 */
	protected function showAjaxReturn($data=null){
		@header('Content-type: application/json');
		$return = array('errcode'=>0,'errmsg'=>'success');
		if (!is_null($data)) $return['data'] = $data;
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
		exit();
	}

	/**
	 * 返回AJAX错误信息
	 * @param integer $errcode
	 * @param string $errmsg
	 * @param mixed $data
	 */
	protected function showAjaxError($errcode, $errmsg='', $data=null){
	    global $_lang;
	    $errmsg = isset($_lang[$errmsg]) ? $_lang[$errmsg] : $errmsg;
		@header('Content-type: application/json');
		$return = array('errcode'=>$errcode,'errmsg'=>$errmsg);
		if (!is_null($data)) $return['data'] = $data;
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
		exit();
	}

	/**
	 * 页面跳转
	 * @param string $url
	 */
	protected function redirect($url){
		@header("location:$url");
		exit();
	}

    /**
     * 分页
     * @param $curr_page
     * @param $page_count
     * @param $total_count
     * @param string $extra
     * @param bool $show_total
     * @return string
     */
    protected function pagination($curr_page, $page_count, $total_count, $extra='', $show_total=FALSE){
	    return $this->showPages($curr_page, $page_count, $total_count, $extra, $show_total);
    }

    /**
     * Discuz 风格分页
     * @param int $curr_page 当前页
     * @param int $page_count 总页数
     * @param int $total_count 总记录
     * @param string $extra 附加参数
     * @param boolean $show_total 是否显总数目
     * @return string
     */
	protected function showPages($curr_page, $page_count, $total_count, $extra='', $show_total=FALSE){
		global $_G,$_lang;
        $multipage = $show_total ? '<span>总计'.$total_count.'条</span>' : '';
		$extra = $extra ? '&'.$extra : '';
		$url = getSiteURL().'/?m='.$_G['m'].'&c='.$_G['c'].'&a='.$_G['a'].$extra;
		if($page_count>1){
			$page = 10;
			$offset = 2;
			$pages = $page_count;
			$from = $curr_page-$offset;
			$to = $curr_page + $page - $offset - 1;
			if($page>$pages){
				$from=1;
				$to=$pages;
			}else{
				if($from<1){
					$to=$curr_page+1-$from;
					$from=1;
					if(($to-$from)<$page&&($to-$from)<$pages){
						$to=$page;
					}
				}elseif($to>$pages){
					$from=$curr_page-$pages+$to;
					$to=$pages;
					if(($to-$from)<$page&&($to-$from)<$pages){
						$from=$pages-$page+1;
					}
				}
			}

			if ($curr_page == 1){
				$multipage.= '';
			}else {
				$multipage .= "<a href=\"{$url}&page=1\">首页</a>";
				$multipage .= "<a href=\"{$url}&page=".($curr_page-1)."\">上一页</a>";
			}

			for($i=$from;$i<=$to;$i++){
				if($i!=$curr_page){
					$multipage.="<a href=\"{$url}&page=$i\">$i</a>";
				}else{
					$multipage.="<span class=\"cur\">$i</span>";
				}
			}

			if ($curr_page < ($page_count-5)){

			}

			if ($curr_page < $page_count){
				//$multipage.= $pages > $page ? "<span>...</span>" : '';
				$multipage.= "<a href=\"{$url}&page=".($curr_page+1)."\">下一页</a>";
				$multipage.= "<a href=\"{$url}&page=$pages\">尾页</a>";
			}
		}
		return   $multipage ;
	}

    /**
     * google风格分页
     * @param int $page 当前页
     * @param int $total 总页数
     * @param string $extra 附加参数
     * @return string
     */
	protected function googlePagination($page,$total,$extra=''){
	    global $_G;
		$extra = !empty($extra) ? $extra.'&' : '';
		$scr = '/?m='.$_G['m'].'&c='.$_G['c'].'&a='.$_G['a'].$extra;
		$prevs = $page-5;
		if($prevs<=0)$prevs = 1;
		$prev  = $page-1;
		if($prev<=0) $prev = 1;
		$nexts = $page+5;
		if($nexts>$total)$nexts=$total;
		$next  = $page+1;
		if($next>$total)$next=$total;
		$pagenavi ="<a href=\"{$scr}&page=1\">首页</a>";
		$pagenavi.="<a href=\"{$scr}&page=$prev\" class=\"prev\">上一页</a>";
		for($i=$prevs;$i<=$page-1;$i++){
			$pagenavi.="<a href=\"{$scr}&page=$i\">$i</a>";
		}
		$pagenavi.="<span class=\"cur\">$page</span>";
		for($i=$page+1;$i<=$nexts;$i++){
			$pagenavi.="<a href=\"{$scr}&page=$i\">$i</a>";
		}
		$pagenavi.="<a href=\"{$scr}&page=$next\" class=\"next\">下一页</a>";
		$pagenavi.="<a href=\"{$scr}&page=$total\">尾页</a>";
		return $pagenavi ;
	}

    /**
     * @param $name
     * @param $content
     * @return $this
     */
    protected function setHeader($name, $content){
	    @header($name.':'.$content);
	    return $this;
    }

    /**
     * @param $name
     * @param $value
     */
    protected function set($name, $value){
	    $this->var[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    protected function get($name){
	    return $this->var[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
		$this->$name = $value;
		$this->var[$name] = $value;
	}

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name) {
		return $this->$name;
	}

    /**
     * @param $name
     * @param $args
     * @throws \Exception
     */
    public function __call($name, $args){
		//die('Class "'.get_class($this).'" does not have a method named "'.$name.'".');
		throw new  \Exception('Class "'.get_class($this).'" does not have a method named "'.$name.'".');
	}

    /**
     *
     */
    function __destruct(){
		$content = ob_get_contents();
		ob_end_clean();
		if (setting('rewrite') && !defined('IN_ADMIN')) $content = rewrite($content);
		echo $content;
	}
}
