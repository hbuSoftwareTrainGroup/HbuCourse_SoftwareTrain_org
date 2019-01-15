<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/14
 * Time: 17:16
 */

require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';

$RAP = new readAndPrint();
$dataBase = new dataBase();

$receiveData = $RAP->inputStream();
$theOrderId = $receiveData->{'order_id'};

$dataBase->open();

$sqlUpdate = "UPDATE `the_order` SET `state`='1' WHERE `id` = '$theOrderId'";
$updateResult =$dataBase->update($sqlUpdate);

if($updateResult){
    $data=array(
        'code'=>200,
        'state'=>"归还成功"
    );
}else{
    $data=array(
        'code'=>503,
        'state'=>"归还失败"
    );
}


echo $RAP->outputStream($data);