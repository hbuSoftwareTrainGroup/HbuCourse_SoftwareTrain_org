<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/14
 * Time: 15:33
 */
require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';

$RAP = new readAndPrint();
$username = $RAP->inputStream()->{'username'};
$password = $RAP->inputStream()->{'password'};

$dataBase = new dataBase();
$dataBase->open();
$sql = "select * from `admin_account` where (`username`='$username' && `password`='$password')";
$list = mysql_fetch_array($dataBase->select($sql));

if(isset($list[0])){
    $data=array(
        'code'=>200,
        'state'=>"登陆成功"
    );
}else{
    $data=array(
        'code'=>503,
        'state'=>"登陆失败"
    );
}
echo $RAP->outputStream($data);