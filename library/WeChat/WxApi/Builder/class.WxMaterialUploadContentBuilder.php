<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/10/11
 * Time: 上午9:34
 */

namespace WxApi\Builder;


class WxMaterialUploadContentBuilder
{
    public $media;

    /**
     * @return array
     * @throws \Exception
     */
    public function getContent(){
        if (!$this->media){
            throw new \Exception('Empty media value');
        }

        if (version_compare(PHP_VERSION,'5.5.0','<')){
            $media = '@'.$this->media;
        }else {
            $media = new \CURLFile($this->media);
        }
        //$name = substr($this->media, strrpos($this->media,'/'));
        return array('media'=>$media);
    }
}