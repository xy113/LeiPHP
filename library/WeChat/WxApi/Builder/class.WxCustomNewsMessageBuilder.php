<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 下午2:53
 */

namespace WxApi\Builder;


class WxCustomNewsMessageBuilder extends WxCustomMessageBuilder
{
    protected $msgtype = 'news';

    /**
     * @param $value
     */
    public function setArticels($value){
        $this->params['articles'] = $value;
    }

    /**
     * @return mixed
     */
    public function getArticles(){
        return $this->params['articles'];
    }

    /**
     * @param $title
     * @param $description
     * @param $url
     * @param $picurl
     */
    public function addArticle($title, $description, $url, $picurl){
        if (!isset($this->params['articles'])) {
            $this->params['articles'] = array();
        }
        array_push($this->params['articles'], array(
            'title'=>$title,
            'description'=>$description,
            'url'=>$url,
            'picurl'=>$picurl
        ));
    }
}