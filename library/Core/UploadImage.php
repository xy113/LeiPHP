<?php
namespace Core;
class UploadImage extends Upload{
	public $thumbWidth = 0;
	public $thumbHeight = 0;
	public $maxWidth    = 0;
	public $maxHeight   = 0;
	public $waterMark   = 0;
	public $waterType   = 0;
	public $waterImg    = '';
	public $waterText   = '';
	public $waterPos    = '';
	public $waterAlpha  = 0;
	public $waterFont   = '';
	public $waterSize   = 0;
	public $waterColor  = '';
	public $waterOffset = 0;
	public $waterAngle  = 0;

    /**
     * @param null $saveName
     * @return array|bool
     */
    public function save($saveName=null){
		$this->thumbWidth = $this->thumbWidth ? $this->thumbWidth : setting('image_thumb_width');
		$this->thumbHeight = $this->thumbHeight ? $this->thumbHeight : setting('image_thumb_height');
		$this->maxWidth = $this->maxWidth ? $this->maxWidth : setting('image_max_width');
		$this->maxHeight = $this->maxHeight ? $this->maxHeight : setting('image_max_height');
		
		$this->waterMark = $this->waterMark ? 1 : setting('water_mark');
		$this->waterType = $this->waterType ? 1 : setting('water_type');
		$this->waterImg  = $this->waterImg  ? $this->waterImg : ROOT_PATH.'static/images/common/water.png';
		$this->waterText = $this->waterText ? $this->waterText : setting('water_text');
		$this->waterPos  = $this->waterPos  ? $this->waterPos : setting('water_pos');
		$this->waterAlpha = $this->waterAlpha ? $this->waterAlpha : setting('water_alpha');
		$this->waterFont  = $this->waterFont ? $this->waterFont : ROOT_PATH.'static/font/water.ttf';
		$this->waterSize  = $this->waterSize ? $this->waterSize : setting('water_size');
		$this->waterColor = $this->waterColor ? $this->waterColor : setting('water_color');
		$this->waterOffset = $this->waterOffset ? $this->waterOffset : setting('water_offset');
		$this->waterAngle  = $this->waterAngle ? $this->waterAngle : setting('water_angle');
		
		$this->savepath = $this->savepath ? $this->savepath : C('ATTACHDIR').'image/';
		$this->maxsize  = $this->maxsize ? $this->maxsize : setting('image_max_size') * 1048576;
		$this->allowtypes = $this->allowtypes ? $this->allowtypes : @explode(',', setting('image_allow_types'));
		$filename = date('Y').'/'.date('m').'/'.$this->setfilename();
		if ($filedata = parent::save('photo/'.$filename)){
			$size = $this->size();
			$sourceimg = $this->savepath.$filedata['file'];
            $this->removeExif($sourceimg);
			$imgobj = new Image($sourceimg);
			//自动压缩图片
			if ($this->maxWidth || $this->maxHeight) {
				if ($imgobj->width() > $this->maxWidth || $imgobj->height() > $this->maxHeight){
					$imgobj->thumb($this->maxWidth, $this->maxHeight);
					$imgobj->save($sourceimg);
					$size = filesize($sourceimg);
				}
			}
			//生成缩略图
			$thumb = 'thumb/'.$filename;
			@mkdir(dirname($this->savepath.$thumb), 0777, true);
			$imgobj->thumb($this->thumbWidth, $this->thumbHeight);
			$imgobj->save($this->savepath.'thumb/'.$filename);
			if ($this->waterMark) {
				$imgobj = new Image($sourceimg);
				if ($this->waterType == 1){
					$imgobj->water($this->waterImg, $this->waterPos, $this->waterAlpha);
				}else {
					$imgobj->text($this->waterText, $this->waterFont, $this->waterSize, $this->waterColor, $this->waterPos, $this->waterOffset, $this->waterAngle);				
				}
				$imgobj->save($sourceimg);
			}
			return array(
					'name'=>$filedata['name'],
					'width'=>intval($imgobj->width()),
					'height'=>intval($imgobj->height()),
					'type'=>$imgobj->type(),
					'size'=>$size,
					'image'=>'photo/'.$filename,
					'thumb'=>'thumb/'.$filename
			);
		}else {
			return false;
		}
	}

    /**
     * 自动旋转照片
     * @param $imgFile
     * @return bool
     */
    private function removeExif($imgFile) {
        if (!function_exists('exif_read_data')) {
            return false;
        }
        $img  = @imagecreatefromjpeg($imgFile);
        if($img === false){
            return false;
        }
        $exif = @exif_read_data($imgFile);
        if (!empty($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 8:
                    $image = imagerotate($img, 90, 0);
                    break;
                case 3:
                    $image = imagerotate($img, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($img, -90, 0);
                    break;
            }
        }
        imagedestroy($img);
        if (isset($image)) {
            imagejpeg($image, $imgFile);
            imagedestroy($image);
        }
    }
}