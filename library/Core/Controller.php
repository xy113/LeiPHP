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

        global $_settings;
        $_settings = Settings::getInstance()->getCache();
        $this->var['settings']     = $_settings;
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
     * 分页函数
     * @param int $curPage
     * @param int $pageSize
     * @param int $totalCount
     * @param array|string $params
     * @param bool $showTotal
     * @return string
     */
    protected function mutipage($curPage, $pageSize, $totalCount, $params = array(), $showTotal=true){
        $multipage = '<ul class="pagination">';
        $multipage.= $showTotal ? '<li><span>总计'.$totalCount.'条</span></li>' : '';
        $url = url('/'.$this->get('m').'/'.$this->get('c').'/'.$this->get('a'));
        $params = is_array($params) ? http_build_query($params) : $params;
        $url = strpos($url, '\?') ? $url.'&'.$params : $url.'?'.$params;

        $pageCount = $totalCount < $pageSize ? 1 : ceil($totalCount/$pageSize);
        $curPage = min(array($curPage, $pageCount));

        if ($curPage == 1) {
            $multipage.= '<li class="disabled"><span>&laquo;</span></li>';
        }else {
            $multipage.= "<li><a href=\"$url&page=".($curPage-1)."\">&laquo;</a></li>";
        }

        if ($pageCount < 10) {
            for ($i=1; $i<=$pageCount; $i++){
                if($i == $curPage){
                    $multipage.="<li class=\"active\"><span>$i</span></li>";
                }else{
                    $multipage.="<li><a href=\"$url&page=$i\">$i</a></li>";
                }
            }
        }else {
            if ($curPage > 5 && $curPage < $pageCount-4){
                $multipage.= "<li><a href=\"$url&page=1\">1</a></li>";
                $multipage.= "<li><a href=\"$url&page=2\">2</a></li>";
                $multipage.= '<li class="disabled"><span>...</span></li>';

                $page = $curPage - 2;
                for ($i = 0; $i<5; $i++){
                    if($page == $curPage){
                        $multipage.="<li class=\"active\"><span>$page</span></li>";
                    }else{
                        $multipage.="<li><a href=\"$url&page=$page\">$page</a></li>";
                    }
                    $page++;
                }
                $multipage.= '<li class="disabled"><span>...</span></li>';
                $multipage.= "<li><a href=\"$url&page=".($pageCount-1)."\">".($pageCount-1)."</a></li>";
                $multipage.= "<li><a href=\"$url&page=".$pageCount."\">".$pageCount."</a></li>";
            }else {
                if ($curPage < 7){
                    for ($page=1; $page<7; $page++){
                        if($page == $curPage){
                            $multipage.="<li class=\"active\"><span>$page</span></li>";
                        }else{
                            $multipage.="<li><a href=\"$url&page=$page\">$page</a></li>";
                        }
                    }
                }else {
                    $multipage.= "<li><a href=\"$url&page=1\">1</a></li>";
                    $multipage.= "<li><a href=\"$url&page=2\">2</a></li>";
                }
                $multipage.= '<li class="disabled"><span>...</span></li>';

                if ($curPage > ($pageCount-5)){
                    for ($page = $pageCount - 5; $page<=$pageCount; $page++){
                        if($page == $curPage){
                            $multipage.="<li class=\"active\"><span>$page</span></li>";
                        }else{
                            $multipage.="<li><a href=\"$url&page=$page\">$page</a></li>";
                        }
                    }
                }else {
                    $multipage.= "<li><a href=\"$url&page=".($pageCount-1)."\">".($pageCount-1)."</a></li>";
                    $multipage.= "<li><a href=\"$url&page=".$pageCount."\">".$pageCount."</a></li>";
                }
            }
        }

        if ($curPage < $pageCount){
            $multipage.= "<li><a href=\"$url&page=".($curPage+1)."\">&raquo;</a></li>";
        }else {
            $multipage.= '<li class="disabled"><span>&raquo;</span></li>';
        }

        return   $multipage.'</ul>';
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
