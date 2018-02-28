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
 * Time: 上午9:26
 */

namespace App\Controllers\Material;


use App\Models\Material;

class ImageController extends BaseController
{
    /**
     *
     */
    public function index(){

    }

    /**
     * 弹窗选择
     */
    public function plugin(){
        global $_G,$_lang;

        $material = new Material();
        $pagesize = $_GET['pagesize'] ? intval($_GET['pagesize']) : 20;
        $condition  = array('uid'=>$this->uid, 'type'=>'image');
        $totalcount = $material->where($condition)->count();
        $pagecount  = $totalcount < $pagesize ? 1 : ceil($totalcount/$pagesize);
        $imagelist  = $material->where($condition)->page($_G['page'], $pagesize)->order('id', 'DESC')->select();
        $pagination = $this->pagination($_G['page'], $pagecount, $totalcount);

        include view('image_plugin');
    }

    /**
     * 上传图片
     */
    public function upload(){
        global $_lang;
        $upload = new \Core\UploadImage();
        if ($filedata = $upload->save()){
            $data = array(
                'uid'=>$this->uid,
                'albumid'=>intval($_GET['albumid']),
                'name'=>$filedata['name'],
                'type'=>'image',
                'path'=>$filedata['image'],
                'thumb'=>$filedata['thumb'],
                'width'=>$filedata['width'],
                'height'=>$filedata['height'],
                'extension'=>$filedata['type'],
                'size'=>$filedata['size']
            );
            $material = new Material();
            $id = $material->data($data)->add();
            $image = $material->where(array('id'=>$id))->getOne();
            $image['image'] = $image['path'];
            $image['imageurl'] = image($image['image']);
            $image['thumburl'] = image($image['thumb']);
            $image['formatted_size'] = formatSize($image['size']);
            $image['formatted_time'] = formatTime($image['create_at'], 'Y-m-d H:i:s');
            unset($image['path']);
            $this->showAjaxReturn($image);
        }else {
            $this->showAjaxError($upload->errCode, $_lang['upload_error'][$upload->errCode]);
        }
    }
}
