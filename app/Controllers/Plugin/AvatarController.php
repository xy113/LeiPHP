<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/28
 * Time: 上午9:22
 */

namespace App\Controllers\Plugin;


class AvatarController extends BaseController
{
    /**
     *
     */
    public function index(){
        $uid  = intval($_GET['uid']);
        $size = trim($_GET['size']);
        $size = in_array($size, array('middel','small')) ? $size : 'big';
        $avatar = $uid.'/'.$uid.'_avatar_'.$size.'.jpg';
        $avatar2 = $uid.'/'.$size.'.png';
        if (is_file(C('AVATARDIR').$avatar2)){
            $avatar = C('AVATARDIR').$avatar2;
        }elseif (is_file(C('AVATARDIR').$avatar)){
            $avatar = C('AVATARDIR').$avatar;
        }else {
            $avatar = ROOT_PATH.'static/images/common/avatar_default.png';
        }
        $size = getimagesize($avatar);

        ob_end_flush();
        ob_end_clean();
        header("Content-type: {$size['mime']}");
        readfile($avatar);
        exit();
    }
}
