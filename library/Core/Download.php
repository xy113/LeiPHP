<?php
/**
 * Created by PhpStorm.
 * User: songdewei
 * Date: 2017/9/7
 * Time: 上午10:21
 */

namespace Core;


class Download
{

    /**
     * 下载文件
     * @param $file
     * @param null $outfile
     * @param bool $delsource
     * @return bool
     */
    public static function downFile($file, $outfile=null, $delsource=false){
        if (is_file($file)) {
            if (is_null($outfile)) {
                $ext = strtolower(str_replace(".", "", substr($file, strrpos( $file,'.'))));
                $outfile = random(10).'.'.$ext;
            }
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.$outfile);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: '.filesize($file));
            readfile($file);
            if ($delsource) @unlink($file);
            exit();
        }else {
            return false;
        }
    }

    /**
     * 下载Excel表格
     * @param $file
     * @param null $outfile
     * @param bool $delsource
     * @return bool
     */
    public static function downExcel($file, $outfile=null, $delsource=false){
        if (is_file($file)){
            if (is_null($outfile)) $outfile = random(10).'.xls';
            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: inline; filename=".$outfile);
            readfile($file);
            if ($delsource) @unlink($file);
            exit();
        }else {
            return false;
        }
    }
}