<?php
//包含配置文件
require_once('Model.php');

/**
 * 数据库操作函数
 * @return \mysqli
 */
$_config = array(
    'DB_TYPE' => 'mysql',
    'DB_HOST' => '127.0.0.1',
    'DB_NAME' => 'videorentalsystem',
    'DB_USER' => 'root',
    'DB_PWD' => 'root',
    'DB_PORT' => '3306',
);
function M() {
    $db = new Model();
    if (mysqli_connect_errno())
        die("连接失败: " . mysqli_connect_error());
    return $db;
}
// 获取配置值
function C($name = null) {
    //静态全局变量，后面的使用取值都是在 $_config数组取
    global $_config;
    // 无参数时获取所有
    if (empty($name))
        return $_config;
    // 优先执行设置获取或赋值
    if (is_string($name)) {
        return $_config[$name];
    }

}
function ajaxReturn($data = null, $message = "", $status) {
    $ret = array();
    $ret["data"] = $data;
    $ret["message"] = $message;
    $ret["status"] = $status;
    echo json_encode($ret);
    die();
}

?>
