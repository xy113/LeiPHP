<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 上午9:37
 */

namespace WeChat\WxApi\Content;


class WxVideoUploadContent
{
    public $media;
    public $title;
    public $introduction;

    /**
     * @return array
     * @throws \Exception
     */
    public function getContent(){
        if (!$this->media) {
            throw new \Exception('Empty media value', 1);
        }

        if (!$this->title){
            throw new \Exception('Empty title value', 2);
        }

        if (!$this->introduction){
            throw new \Exception('Empty introduction value', 3);
        }

        if (version_compare(PHP_VERSION,'5.5.0','<')){
            $media = '@'.$this->media;
        }else {
            $media = new \CURLFile($this->media);
        }

        return array(
            'media'=>$media,
            'description'=>json_encode(array(
                'title'=>$this->title,
                'introduction'=>$this->introduction
            ), JSON_UNESCAPED_UNICODE)
        );
    }
}
