<?php
/**
 * 数据库模型类
 */
require_once 'common.php';
class Model {
 // 当前数据库操作对象
 protected $db = null;
 // 当前查询ID
 protected $queryID = null;
 // 当前SQL指令
 protected $queryStr = '';
 // 是否已经连接数据库
 protected $connected = false;
 // 返回或者影响记录数
 protected $numRows = 0;
 // 返回字段数
 protected $numCols = 0;
 // 最近错误信息
 protected $error = '';
 public function __construct() {
  $this->db = $this->connect();//设置数据库对象为数据库连接对象
 }
 /**
  * 连接数据库方法
  */
 public function connect() {
    $config = array(
     'username' => C('DB_USER'),
     'password' => C('DB_PWD'),
     'hostname' => C('DB_HOST'),
     'hostport' => C('DB_PORT'),
     'database' => C('DB_NAME')
    );
   $link = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);
   if (mysqli_connect_errno())
       die("连接失败: " . mysqli_connect_error());
   $this->connected = true;
   //返回数据库连接对象
   return $link;
  }
  
 /**
  * 初始化数据库连接
  */
 public function query($sql){
     return $this->db->query($sql);
 }
 protected function initConnect() {
  if (!$this->connected) {
   $this->db = $this->connect();
  }
 }
 /**
  * 获得所有的查询数据
  * @access private
  * @param string $sql sql语句
  * @return array
  */
 public function select($sql) {
  $this->initConnect();
  if (!$this->db)
   return false;
  $query = $this->db->query($sql);
  $list = array();
  if (!$query)
   return $list;
  while ($rows = $query->fetch_assoc()) {
   $list[] = $rows;
  }
  return $list;
 }
 /**
  * 只查询一条数据
  */
 public function find($sql) {
  $resultSet = $this->select($sql);
  if (false === $resultSet) {
   return false;
  }
  if (empty($resultSet)) {// 查询结果为空
   return null;
  }
  $data = $resultSet[0];
  return $data;
 }
 /**
  * 获取一条记录的某个字段值 , sql 由自己组织
  * 例子： $model->getField("select id from user limit 1")
  */
 public function getField($sql) {
  $resultSet = $this->select($sql);
  if (!empty($resultSet)) {
   return reset($resultSet[0]);
  }
 }
 /**
  * 执行语句 ， 例如插入，更新操作
  * @access public
  * @param string $str sql指令
  * @return integer
  */
 public function execute($str) {
  $this->initConnect();
  if (!$this->db)
   return false;
  $this->queryStr = $str;
  //释放前次的查询结果
  if ($this->queryID)
   $this->free();
  $result = $this->db->query($str);
  if (false === $result) {
   $this->error();
   return false;
  } else {
   $this->numRows = $this->db->affected_rows;
   $this->lastInsID = $this->db->insert_id;
   return $this->numRows;
  }
 }
 /**
  * 获得所有的查询数据
  * @access private
  * @param string $sql sql语句
  * @return array
  */
 private function getAll() {
  //返回数据集
  $result = array();
  if ($this->numRows > 0) {
   //返回数据集
   for ($i = 0; $i < $this->numRows; $i++) {
    $result[$i] = $this->queryID->fetch_assoc();
   }
   $this->queryID->data_seek(0);
  }
  return $result;
 }
 /**
  * 返回最后插入的ID
  */
 public function getLastInsID() {
  return $this->db->insert_id;
 }
 /**
  * 释放查询结果
  */
 public function free() {
  $this->queryID->free_result();
  $this->queryID = null;
 }
 /**
  * 关闭数据库
  */
 public function close() {
  if ($this->db) {
   $this->db->close();
  }
  $this->db = null;
 }
 /**
  * 析构方法
  */
 public function __destruct() {
  if ($this->queryID) {
   $this->free();
  }
  // 关闭连接
  $this->close();
 }
}
