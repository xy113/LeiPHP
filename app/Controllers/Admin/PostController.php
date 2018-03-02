<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/2/10
 * Time: 上午10:16
 */

namespace App\Controllers\Admin;


use App\Models\PostCatlog;
use App\Models\PostComment;
use App\Models\PostContent;
use App\Models\PostImage;
use App\Models\PostItem;
use App\Models\PostLog;
use App\Models\PostMedia;
use Core\VideoParser;

class PostController extends BaseController
{
    public function index(){
        $this->itemlist();
    }

    /**
     * 文章列表
     */
    public function itemlist(){
        global $_G,$_lang;

        $condition = $queryParams = array();
        $searchType = intval($_GET['searchType']);
        $queryParams['searchType'] = $searchType;

        $title = htmlspecialchars($_GET['title']);
        if ($title) {
            $condition[] = "i.title LIKE '$title'";
            $queryParams['title'] = $title;
        }

        $username = htmlspecialchars($_GET['username']);
        if ($username) {
            $condition[] = "i.username='$username'";
            $queryParams['username'] = $username;
        }

        $catid = htmlspecialchars($_GET['catid']);
        if ($catid) {
            $condition[] = "i.catid='$catid'";
            $queryParams['catid'] = $catid;
        }

        $status = htmlspecialchars($_GET['status']);
        if ($status != '') {
            $condition[] = "i.status='$status'";
            $queryParams['status'] = $status;
        }

        $type = htmlspecialchars($_GET['type']);
        if ($type) {
            $condition[] = "i.type='$type'";
            $queryParams['type'] = $type;
        }

        $time_begin = htmlspecialchars($_GET['time_begin']);
        if ($time_begin) {
            $condition[] = "i.pubtime>".strtotime($time_begin);
            $queryParams['time_begin'] = $time_begin;
        }

        $time_end = htmlspecialchars($_GET['time_end']);
        if ($time_end) {
            $condition[] = "i.pubtime<".strtotime($time_end);
            $queryParams['time_end'] = $time_end;
        }

        $q = htmlspecialchars($_GET['q']);
        if ($q) $condition[] = "i.title LIKE '%$q%'";

        $pagesize  = 20;
        $model = PostItem::getInstance()->alias('i');
        $totalcount = $model->join('post_catlog c', 'c.catid=i.catid')->where($condition)->count();
        $itemlist = $model->join('post_catlog c', 'c.catid=i.catid')
                            ->field('i.*,c.name as cat_name')
                            ->where($condition)->page($this->get('page'), $pagesize)
                            ->order('aid', 'DESC')->select();
        $pagination = $this->mutipage($this->get('page'), 20, $totalcount, $queryParams, 1);
        unset($condition, $queryParams);

        $catloglist = PostCatlog::getInstance()->getCatlogTree();
        include view('post/list');
    }

    /**
     * 删除文章
     */
    public function delete(){
        if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            if ($items && is_array($items)){
                foreach ($items as $aid){
                    $condition = array('aid'=>$aid);
                    PostItem::getInstance()->where($condition)->delete();
                    PostLog::getInstance()->where($condition)->delete();
                    PostImage::getInstance()->where($condition)->delete();
                    PostMedia::getInstance()->where($condition)->delete();
                    PostContent::getInstance()->where($condition)->delete();
                    PostComment::getInstance()->where($condition)->delete();
                }
            }
        }
        $this->showAjaxReturn();
    }

    /**
     * 移动文章
     */
    public function move(){
        if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            $target = intval($_GET['target']);
            if ($items && is_array($items)){
                foreach ($items as $aid){
                    PostItem::getInstance()->where(array('aid'=>$aid))->data(array('catid'=>$target))->save();
                }
            }
        }
        $this->showAjaxReturn();
    }

    /**
     * 审核文章
     */
    public function review(){
        $event = trim($_GET['event']);
        if ($this->checkFormSubmit()){
            $items = $_GET['items'];
            if ($items && is_array($items)){
                foreach ($items as $aid){
                    if ($event == 'pass'){
                        PostItem::getInstance()->where(array('aid'=>$aid))->data(array('status'=>1))->save();
                    }else {
                        PostItem::getInstance()->where(array('aid'=>$aid))->data(array('status'=>-1))->save();
                    }
                }
            }
        }
        $this->showAjaxReturn();
    }

    /**
     * 设置文章图片
     */
    public function setimage(){
        $aid = intval($_GET['aid']);
        $image = htmlspecialchars($_GET['image']);
        if ($aid && $image){
            PostItem::getInstance()->where(array('aid'=>$aid))->data(array('image'=>$image))->save();
            $this->showAjaxReturn(0);
        }else {
            $this->showAjaxError(1, 'invalid parameter');
        }
    }

    /**
     * 发布文章
     */
    public function publish(){
        global $_G,$_lang;

        $aid = intval($_GET['aid']);
        if ($aid) {
            $item = PostItem::getInstance()->where(array('aid'=>$aid))->getOne();
            $item['create_at'] = $item['create_at'] ? @date('Y-m-d H:i:s', $item['create_at']) : @date('Y-m-d H:i:s');
            $type = in_array($item['type'], array('image','video')) ? $item['type'] : 'article';
            $catid = $item['catid'];

            $content = PostContent::getInstance()->where(array('aid'=>$aid))->getOne();
            $editorcontent = $content['content'];
            //相册列表
            $gallery = PostImage::getInstance()->where(array('aid'=>$aid))->order('displayorder ASC,id ASC')->select();
            //获取媒体信息
            $media = PostMedia::getInstance()->where(array('aid'=>$aid))->getOne();
        }else {
            $catid = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
            $type = in_array($_GET['type'], array('image','video', 'voice')) ? $_GET['type'] : 'article';
            $item['from']    = setting('sitename');
            $item['fromurl'] = setting('siteurl');
            $item['author']  = $this->username;
            $item['price']   = 0;
            $item['create_at'] = @date('Y-m-d H:i:s');
        }

        $editorname = "content";
        $catloglist = PostCatlog::getInstance()->getCatlogTree();
        include view('post/publish');
    }

    /**
     * 保存文章
     */
    public function save(){
        global $_G;

        $newpost = $_GET['newpost'];
        $content = $_GET['content'];
        if (is_array ($newpost)) {
            $item = new PostItem($newpost);
            if (!$item->title) {
                $this->showError('empty post_title');
            }
            if (!$item->get('from')) $item->set('from', setting('sitename'));
            if (!$item->get('fromurl')) $item->set('fromurl', setting('siteurl'));

            $summary = $item->get('summary');
            if (!$summary) {
                $summary = mb_substr(stripHtml($content), 120);
            }
            $summary = str_replace('&amp;', '&', $summary);
            $summary = str_replace('&nbsp;', '', $summary);
            $summary = str_replace('　', '', $summary);
            $summary = preg_replace('/\s/', '', $summary);
            $item->set('summary', $summary);

            //发布时间设置
            $create_at = $item->get('create_at');
            $create_at = $create_at ? strtotime($create_at) : time();
            $item->set('create_at', $create_at);

            $aid = intval($_GET['aid']);
            if ($_GET['aid']) {
                //修改文章
                $item->aid = $aid;
                $item->save();
                //记录日志
                PostLog::getInstance()->data(array(
                    'aid'=>$aid,
                    'title'=>$item->get('title'),
                    'uid'=>$this->uid,
                    'username'=>$this->username,
                    'action_type'=>'update'
                ))->add();
            }else {
                //添加新文章
                $item->set('uid', $this->uid);
                $item->set('username', $this->username);
                $aid = $item->add();

                //记录日志
                PostLog::getInstance()->data(array(
                    'aid'=>$aid,
                    'title'=>$item->get('title'),
                    'uid'=>$this->uid,
                    'username'=>$this->username,
                    'action_type'=>'insert'
                ))->add();
            }

            if ($_GET['aid']) {
                //修改文章内容
                $postcontent = new PostContent();
                $postcontent->set('aid', $aid);
                $postcontent->set('content', $content);
                if ($postcontent->count()){
                    $postcontent->save();
                }else {
                    $postcontent->add();
                }
            }else {
                //添加文章内容
                //修改文章内容
                $postcontent = new PostContent();
                $postcontent->set('aid', $aid);
                $postcontent->set('content', $content);
                $postcontent->add();
            }

            //添加相册
            $gallery = $_GET['gallery'];
            //print_array($gallery);exit();
            if ($gallery) {
                $imageList = array();
                if ($_GET['aid']) {
                    $aid = intval($_GET['aid']);
                    foreach (PostImage::getInstance()->where(array('aid'=>$aid))->order('displayorder')->select() as $img){
                        $imageList[$img['id']]['mark'] = 'delete';
                        $imageList[$img['id']]['img'] = $img;
                    }
                }

                $displayorder = 0;
                foreach ($gallery as $id=>$img){
                    $imageList[$id]['img'] = $img;
                    $imageList[$id]['img']['displayorder'] = $displayorder++;
                    if (isset($imageList[$id])) {
                        $imageList[$id]['mark'] = 'update';
                    }else {
                        $imageList[$id]['mark'] = 'insert';
                    }
                }

                foreach ($imageList as $id=>$img){
                    if ($img['mark'] == 'insert'){
                        $img['img']['aid'] = $aid;
                        $img['img']['uid'] = $this->uid;
                        PostImage::getInstance()->data($img['img'])->add();
                    }elseif ($img['mark'] == 'update'){
                        PostImage::getInstance()->where(array('id'=>$id))->data($img['img'])->save();
                    }else {
                        PostImage::getInstance()->where(array('id'=>$id))->delete();
                    }
                }
                //将第一张设为文章图片
                if (!$item->get('image')) {
                    $image = reset($gallery);
                    $item->data(array('image'=>$image['image']))->save();
                }
            }

            $media = $_GET['media'];
            if ($media && $media['original_url']){
                if ($source = VideoParser::parse($media['original_url'])) {
                    $mediaModel = new PostMedia($media);
                    $mediaModel->set('media_source', $source->swf);
                    $mediaModel->set('media_thumb', $source->img);
                    $mediaModel->set('media_link', $source->url);
                    $mediaModel->set('aid', $aid);

                    if ($_GET['aid']) {
                        $mediaModel->where(array('aid'=>$aid))->save();
                    }else {
                        $mediaModel->add();
                    }
                }
            }

            if ($_GET['aid']){
                $links = array (
                    array (
                        'text' => 'reedit',
                        'url' => URL('/admin/post/publish', array('aid'=>$aid))
                    ),
                    array (
                        'text'=>'view',
                        'url'=>URL('/post/detail', array('aid'=>$aid)),
                        'target'=>'_blank'
                    ),
                    array(
                        'text'=>'back_list',
                        'url'=>URL('/admin/post/index')
                    )
                );
                $this->showSuccess('post_update_succeed', null, $links, null,false);
            }else {
                $links = array (
                    array (
                        'text' => 'continue_publish',
                        'url' => URL('/admin/post/publish', array('type'=>$item->get('type'), 'catid'=>$item->get('catid')))
                    ),
                    array (
                        'text'=>'view',
                        'url'=>URL('/post/detail', array('aid'=>$aid)),
                        'target'=>'_blank'
                    ),
                    array(
                        'text'=>'back_list',
                        'url'=>URL('/admin/post/index')
                    )
                );
                $this->showSuccess('post_save_succeed', null, $links, null,true);
            }

        } else {
            $this->showError('invalid_parameter');
        }
    }
}
