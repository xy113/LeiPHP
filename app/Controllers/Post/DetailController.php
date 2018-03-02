<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/3/2
 * Time: 下午2:47
 */

namespace App\Controllers\Post;


use App\Models\PostCatlog;
use App\Models\PostContent;
use App\Models\PostImage;
use App\Models\PostItem;
use App\Models\PostMedia;

class DetailController extends BaseController
{
    private $aid = 0;
    /**
     *
     */
    public function index()
    {
        global $_G,$_lang;

        $this->aid = $_GET['aid'] ? intval($_GET['aid']) : intval($_GET['id']);
        PostItem::getInstance()->updateViewNum($this->aid);
        $article = PostItem::getInstance()->where(array('aid'=>$this->aid))->getOne();

        $article['tags'] = $article['tags'] ? unserialize($article['tags']) : array();
        if (!in_array($article['type'], array('image','video','voice'))){
            $article['type'] = 'article';
        }
        //文章内容
        $content = PostContent::getInstance()->where(array('aid'=>$this->aid))->getOne();

        if ($article['type'] == 'image'){
            $gallery = PostImage::getInstance()->where(array('aid'=>$this->aid))->order('displayorder ASC,id ASC')->select();
        }

        if ($article['type'] == 'video'){
            $media = PostMedia::getInstance()->where(array('aid'=>$this->aid))->getOne();
            $media['media_source'] = material($media['media_source'], 'video');
            $media['media_source'] = str_replace('https:', '', $media['media_source']);
        }

        $_G['title'] = $article['title'];
        $_G['keywords'] = $article['tags'] ? implode(',', $article['tags']) : $_G['keywords'];
        $_G['description'] = $article['summary'] ? $article['summary'] : $_G['keywords'];

        $catlogList = PostCatlog::getInstance()->getCache();

        include view($article['type']);
    }
}
