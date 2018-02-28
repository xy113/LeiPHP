<?php
namespace Core;
class Upload{
	public $savepath = '';
    public $allowtypes = array();
    public $maxsize = 0;
    public $errCode = 0;
    private $file;

    public function __construct($inputname = 'filedata'){
        $this->file = &$_FILES[$inputname];
    }

    /**
     * 保存文件
     * @param string $saveName
     * @return mixed
     */
    protected function save($saveName = ''){
    	if (!$this->savepath) $this->savepath = C('ATTACHDIR');
    	if (!$saveName) $saveName = $this->setfilename();
    	$filepath = $this->savepath.$saveName;
        @mkdir(dirname($filepath),0777,true);

        $fileext = $this->getfileextension();
        if (!in_array($fileext, $this->allowtypes)){
        	$this->errCode = 1;
        	return false;
        }
        if ($this->file['size'] > $this->maxsize){
        	$this->errCode = 2;
        	return false;
        }
        if (!@is_uploaded_file($this->file['tmp_name'])){
        	$this->errCode = 3;
        	return false;
        }
        if (!@move_uploaded_file($this->file['tmp_name'], $filepath)){
        	$this->errCode = 4;
        	return false;
        }else {
        	return array(
        			'name'=>$this->oriname(),
        			'file'=>$saveName,
        			'type'=>$fileext,
        			'size'=>$this->size()
        	);
        }
    }

    /**
     * 设置文件名
     */
    protected function setfilename(){
    	return date('YmdHis').rand(100,999).rand(100,999).'.'.$this->getfileextension();
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    protected function getfileextension(){
    	$file = $this->file['name'];
    	return strtolower(str_replace(".", "", substr($file, strrpos( $file,'.'))));
    }

    protected function oriname(){
    	return $this->file['name'];
    }
    protected function type(){
    	return $this->file['type'];
    }
    protected function size(){
    	return $this->file['size'];
    }
}
