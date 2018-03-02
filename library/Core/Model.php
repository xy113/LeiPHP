<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018-02-08
 * ID: Model.php
 */

namespace Core;
abstract class Model{
	private $db;
	private $tableName;
    private $sql = '';
	private $data = array();
	private $option = array();
	private static $_instances = [];

    protected $table;
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * Model constructor.
     * @param mixed $data
     */
    function __construct($data = []){
		$this->db = DB_Mysqli::getInstance();

		$class = static::class;
		$this->table = $this->table ? $this->table : strtolower(substr($class, strrpos($class, '\\')+1));
		$this->tableName = $this->db->table($this->table);
		$this->resetOption();

		if (is_object($data)) {
		    $this->data(get_object_vars($data));
        }elseif (is_array($data)) {
		    $this->data($data);
        }
	}

    /**
     * @return static
     */
    public static function getInstance()
    {
        $ins = static::class;
        if(!isset(self::$_instances[$ins])){
            self::$_instances[$ins] = new static();
        }
        return self::$_instances[$ins];
    }

    /**
     * @param $table
     * @return Model
     */
    public static function from($table){
        $instance = new static();
        $instance->tableName = $instance->db->table($table);
        return $instance;
    }

    /**
     *
     */
    private function resetOption(){
        $this->option = array(
            'field'=>'*',
            'where'=>'',
            'order'=>'',
            'group'=>'',
            'having'=>'',
            'limit'=>'',
            'join'=>'',
            'union'=>'',
        );
    }

    /**
     * @param $alias
     * @return $this
     */
    public function alias($alias){
        $this->tableName = $this->db->table($this->table).' '.$alias;
        return $this;
    }

    /**
     * @param string $fields
     * @return $this
     */
    public function field($fields = '*'){
		if (is_array($fields)){
			$this->option['field'] = implode($fields, ',');
		}else {
			$this->option['field'] = $fields;
		}
		!$this->option['field'] && $this->option['feild'] = '*';
		return $this;
	}

    /**
     * @param $filed
     * @param null $glue
     * @param null $value
     * @return $this
     */
    public function where($filed, $glue=null, $value=null){
		if (!$filed) {
		    return $this;
        }else {
		    if (is_null($glue) && is_null($value)){
		        if (is_array($filed)) {
		            $arr = array();
                    foreach ($filed as $k=>$v){
                        if (is_numeric($k)) {
                            if (is_string($v)){
                                $arr[] = $v;
                            }else {
                                if (count($v) == 3){
                                    $arr[] = "`".$v[0]."`".$v[1]."'".$v[2]."'";
                                }elseif (count($v) == 2){
                                    $arr[] = "`".$v[0]."`='".$v[1]."'";
                                }elseif (count($v) == 1){
                                    $arr[] = $v[0];
                                }
                            }
                        }else {
                            $arr[] = "`$k`='$v'";
                        }
                    }
                    $wherestr = implode(' AND ', $arr);
                }else {
                    $wherestr = $filed;
                }
            }elseif (!empty($glue) && is_null($value)){
		        $wherestr = "`$filed`='$glue'";
            }else{
		        $wherestr = "`$filed`".$glue."'$value'";
            }
        }

        if ($wherestr) {
		    $this->option['where'] = $this->option['where'] ? $this->option['where'].' AND '.$wherestr : 'WHERE '.$wherestr;
        }
		return $this;
	}

    /**
     * @param $filed
     * @param null $glue
     * @param null $value
     * @return $this
     */
    public function orWhere($filed, $glue=null, $value=null){
        if (empty($filed)) {
            return $this;
        }else {
            if (is_null($glue) && is_null($value)){
                if (is_array($filed)) {
                    $arr = array();
                    foreach ($filed as $k=>$v){
                        if (is_numeric($k)) {
                            if (count($v) == 3){
                                $arr[] = "`".$v[0]."`".$v[1]."'".$v[2]."'";
                            }elseif (count($v) == 2){
                                $arr[] = "`".$v[0]."`='".$v[1]."'";
                            }elseif (count($v) == 1){
                                $arr[] = $v[0];
                            }
                        }else {
                            $arr[] = "`$k`='$v'";
                        }
                    }
                    $wherestr = implode(' OR ', $arr);
                }else {
                    $wherestr = $filed;
                }
            }elseif (!empty($glue) && is_null($value)){
                $wherestr = "`$filed`='$glue'";
            }else{
                $wherestr = "`$filed`".$glue."'$value'";
            }
        }

        if ($wherestr) {
            $this->option['where'] = $this->option['where'] ? $this->option['where'].' OR '.$wherestr : 'WHERE '.$wherestr;
        }
        return $this;
    }

    /**
     * @param $field
     * @param string $sort
     * @return $this
     */
    public function order($field, $sort = 'ASC'){
		if (func_num_args() == 1){
			if (is_string($field)){
				$this->option['order'] = $field;
			}elseif (is_array($field)){
				$order = array();
				foreach ($field as $k=>$v){
					if (is_numeric($k)){
						if (is_string($v)) {
							array_push($order, $v);
						}else {
							$v[1] = strtoupper($v[1]);
							!in_array($v[1], array('ASC','DESC')) && $v[1] = 'ASC';
							array_push($order, "$v[0] $v[1]");
						}
					}else {
						array_push($order, "$k $v");
					}
				}
				$this->option['order'] = implode(',', $order);
			}else {
				$this->option['order'] = '';
			}

		}else {
			$sort = strtoupper($sort);
			$sort = in_array($sort, array('ASC','DESC')) ? $sort : 'ASC';
			$this->option['order'] = is_string($field) ? " $field $sort" : '';
		}
		$this->option['order'] = $this->option['order'] ? "ORDER BY ".$this->option['order'] : "";
		return $this;
	}

    /**
     * @param $start
     * @param int $num
     * @return $this
     */
    public function limit($start, $num=0){
		if (func_num_args() == 1){
			if (is_string($start)){
				$this->option['limit'] = $start;
			}elseif (is_array($start)){
				$this->option['limit'] = "$start[0],$start[1]";
			}elseif (is_numeric($start)){
				$this->option['limit'] = "0,$start";
			}else {
				$this->option['limit'] = '';
			}
		}else {
			$num   = abs($num);
			$start = abs($start);
			if ($num > 0) {
				$this->option['limit'] = "$start,$num";
			}else {
				$this->option['limit'] = $start;
			}
		}

		$this->option['limit'] = $this->option['limit'] ? "LIMIT ".$this->option['limit'] : '';
		return $this;
	}

    /**
     * @param $page
     * @param int $rows
     * @return $this
     */
    public function page($page, $rows=10){
		$page  = intval($page);
		$rows  = intval($rows);
		$page  = max(array($page,1));
		$rows  = abs($rows);
		$start = ($page-1)*$rows;
		$this->limit($start,$rows);
		return $this;
	}

    /**
     * @param $field
     * @return $this
     */
    public function group($field){
		$this->option['group'] = $field ? 'GROUP BY '.$field : '';
		return $this;
	}

    /**
     * @param $having
     * @return $this
     */
    public function having($having){
		$this->option['having'] = $having ? "HAVING ".$having : "";
		return $this;
	}

    /**
     * join 操作
     * @param string $table
     * @param string $type
     * @param string $on
     * @return $this
     */
	public function join($table, $on='', $type='LEFT'){
		$joinstr = '';
		if (func_num_args() == 1){
			$jointype = 'LEFT JOIN';
		}else {
			$type = strtoupper($type);
			$type = in_array($type, array('LEFT','RIGHT','INNER')) ? $type :'';
			$jointype = $type ? $type.' JOIN' : 'JOIN';
		}

		if (is_array($table)){
			foreach ($table as $key=>$value){
				if (!is_numeric($key)) {
					$joinstr = ' '.$jointype.' '.$this->db->table($key). ' AS '.$value;
				}
			}
		}else {
			$joinstr.= ' '.$jointype.' '.$this->db->table($table);
		}

		$joinstr.= $on ? ' ON '.$on : '';
		$this->option['join'].= $joinstr;
		return $this;
	}

    /**
     * @param $table
     * @param bool $all
     * @return $this
     */
    public function union($table, $all=FALSE){
		$separate = $all ? 'UNION ALL ' : 'UNION ';
		$this->option['union'].= $separate."SELECT ".$this->option['field']." FROM ".$this->db->table($table);
		return $this;
	}

    /**
     * 返回DDL语句
     * @return string
     */
    public function getSQL(){
        $this->setSQL();
		return $this->sql;
	}

    /**
     * 设置DDL语句
     * @param string $type
     */
    private function setSQL($type='select'){
		if (!is_string($type)) {
			$type = 'select';
		}

		if ($type == 'select') {
			$this->option['field'] = $this->option['field'] ? $this->option['field'] : '*';
			$SQL = "SELECT ".$this->option['field']." FROM ".$this->tableName;
			$SQL.= $this->option['join']   ? ' '.$this->option['join']   : '';
			$SQL.= $this->option['union']  ? ' '.$this->option['union']  : '';
			$SQL.= $this->option['where']  ? ' '.$this->option['where']  : '';
			$SQL.= $this->option['group']  ? ' '.$this->option['group']  : '';
			$SQL.= $this->option['having'] ? ' '.$this->option['having'] : '';
			$SQL.= $this->option['order']  ? ' '.$this->option['order']  : '';
			$SQL.= $this->option['limit']  ? ' '.$this->option['limit']  : '';
			$this->sql = $SQL;
		}else {
			$this->sql = $type;
		}
	}

    /**
     * 返回结果列表
     * @param mixed $fields
     * @return array
     */
    public function select($fields = null) {
        if ($fields) $this->field($fields);
        $result = array();
		$this->setSQL('select');
		$query = $this->db->query($this->sql);
		while ($data = $this->db->fetch_array($query)){
			$result[] = $data;
		}
        $this->option = array();
		return $result;
	}

    /**
     * 返回一条记录
     * @param mixed $fileds
     * @return mixed
     */
    public function getOne($fileds = null){
        if ($fileds) $this->field($fileds);
		!$this->option['limit'] && $this->option['limit'] = " LIMIT 0,1";
		$this->setSQL('select');
		$query  = $this->db->query($this->sql,'U_B');
		$result = $this->db->fetch_array($query, MYSQLI_ASSOC);
        $this->option = array();
        return $result ? $result : false;
	}

    /**
     * @return array
     */
    public function getAll(){
        return $this->select();
    }

    /**
     * @return bool
     */
    public function first(){
        if ($this->primaryKey) {
            return $this->order($this->primaryKey, 'ASC')->getOne();
        }else {
            return $this->getOne();
        }
    }

    /**
     * @return bool
     */
    public function last(){
        if ($this->primaryKey) {
            return $this->order($this->primaryKey, 'DESC')->getOne();
        }else {
            return $this->getOne();
        }
    }

    /**
     * @param $count
     * @return array
     */
    public function find($count){
        if ($count) {
            return $this->limit(0, $count)->select();
        }else {
            return $this->select();
        }
    }

    /**
     * 返回记录数
     * @param string $field
     * @return mixed
     */
    public function count($field='*'){
		!$field && $field = '*';
		$row = $this->field("COUNT($field) AS num")->getOne();
        $this->option = array();
		return $row['num'];
	}

    /**
     * @param mixed $data
     * @return $this
     */
    public function data($data = null){
        if (!is_null($data)) {
            if (is_object($data)) {
                foreach (get_object_vars($data) as $name=>$value){
                    static::__set($name, $value);
                }
            }elseif (is_array($data)) {
                foreach ($data as $name=>$value){
                    static::__set($name, $value);
                }
            }
        }
		return $this;
	}

    /**
     * 插入一条记录
     * @param null $data
     * @param bool $return_insert_id
     * @param bool $replace
     * @return bool|int|\mysqli_result|string
     */
    public function add($data=null, $return_insert_id=true, $replace=false){
		return $this->insert($data, $return_insert_id, $replace);
	}

    /**
     * 替换目标记录
     * @param null $data
     * @param bool $return_insert_id
     * @return bool|int|\mysqli_result|string
     */
    public function replaceAdd($data=null, $return_insert_id=true){
        return $this->insert($data, $return_insert_id, true);
    }

    /**
     * 插入一条记录
     * @param null $data
     * @param bool $return_insert_id
     * @param bool $replace
     * @return bool|int|\mysqli_result|string
     */
    public function insert($data=null, $return_insert_id=false, $replace=false){
        if (!is_null($data)) $this->data($data);
		if ($this->data) {
            if ($this->timestamps && !$this->data['created_at']) $this->data['created_at'] = time();
			$sql = $this->db->implode_field_value($this->data);
			$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
			$return = $this->db->query("$cmd ".$this->tableName." SET $sql");
			return $return_insert_id ? $this->db->insert_id() : $return;
		}else {
			return false;
		}
	}

    /**
     * 插入一组记录
     * @param $array
     * @param bool $return_insert_id
     * @param bool $replace
     * @return array|bool
     */
    public function insertAll($array, $return_insert_id=false, $replace=false){
		if(!empty($array) && is_array($array)){
			$ids = array();
			foreach ($array as $data){
				$ids[] = $this->insert($data,$return_insert_id,$replace);
			}
			return $return_insert_id ? $ids : true;
		}else {
			return false;
		}
	}

    /**
     * 删除记录
     * @return bool|int
     */
    public function delete(){
        if (!$this->option['where']) {
            if (is_string($this->primaryKey) && array_key_exists($this->primaryKey, $this->data)){
                $this->where($this->primaryKey, '=', $this->data[$this->primaryKey]);
            }else {
                $arr = array();
                foreach ($this->data as $name=>$value){
                    $arr[] = "`$name`='$value'";
                }

                if ($arr) {
                    $where = implode(' AND ', $arr);
                }else {
                    $where = null;
                }
                $this->where($where);
            }
        }
		$res = $this->db->query("DELETE FROM ".$this->tableName." ".$this->option['where']);
        $this->resetOption();
		return $res ? $this->db->affected_rows() : false;
	}

    /**
     * 更新记录
     * @param $data
     * @param bool $unbuffered
     * @param bool $low_priority
     * @return bool|int
     */
    public function save($data=null, $unbuffered = false, $low_priority = false){
		return $this->update($data, $unbuffered, $low_priority);
	}

    /**
     * 更新记录
     * @param null $data
     * @param bool $unbuffered
     * @param bool $low_priority
     * @return bool|int
     */
    public function update($data=null, $unbuffered = false, $low_priority = false) {
        if (!is_null($data)) $this->data($data);
		if ($this->data) {
		    if (!$this->option['where']) {
		        if ($this->primaryKey && array_key_exists($this->primaryKey, $this->data)){
		            $this->where($this->primaryKey, '=', $this->data[$this->primaryKey]);
                }else {
		            return false;
                }
            }

            if ($this->timestamps && !$this->data['updated_at']) $this->data['updated_at'] = time();
			$sql = $this->db->implode_field_value($this->data);
			$cmd = "UPDATE ".($low_priority ? 'LOW_PRIORITY' : '');
			$res = $this->db->query("$cmd {$this->tableName} SET $sql ".$this->option['where'],$unbuffered ? 'UNBUFFERED' : '');
			$this->resetOption();
			return $res ? $this->db->affected_rows() : false;
		}else  {
			return false;
		}
	}

    /**
     * @param $array
     * @param bool $unbuffered
     * @param bool $low_priority
     * @return bool|int
     */
    public function updateAll($array, $unbuffered = false, $low_priority = false){
		$affect_rows = 0;
		foreach ($array as $data){
			$affect_rows+= $this->update($data,$unbuffered,$low_priority);
		}
		return $affect_rows;
	}

    /**
     * @return array
     */
    public function getData(){
        return $this->data;
    }

    /**
     * @return array
     */
    public function showFields(){
        return $this->db->show_table_fields($this->table);
    }

    /**
     * @return mixed
     */
    public function showCreate(){
        return $this->db->show_create_table($this->table);
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value){
        static::__set($name, $value);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name){
        return static::__get($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value) {
        $this->data[$name] = $value;
	}

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name) {
		return array_key_exists($name, $this->data) ? $this->data[$name] : null;
	}

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        // TODO: Implement __isset() method.
        return isset($this->data[$name]);
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        // TODO: Implement __unset() method.
        unset($this->data[$name]);
    }

    /**
     * @param $name
     * @param $args
     * @throws \Exception
     */
    public function __call($name, $args){
		throw new  \Exception('Class "'.get_class($this).'" does not have a method named "'.$name.'".');
	}
}
