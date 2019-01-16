<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/14
 * Time: 17:08
 */
require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';

$RAP = new readAndPrint();
$dataBase = new dataBase();

$receiveData = $RAP->inputStream();
$video_disk_id = $receiveData->{'video_disk_id'};

$dataBase->open();
$sql = "delete from `compact_disk` WHERE `id` = '$video_disk_id'";

$res = $dataBase->delete($sql);

if($res){
    $data=array(
        'code'=>200,
        'state'=>"删除成功"
    );
}else{
    $data=array(
        'code'=>503,
        'state'=>"删除失败"
    );
}
echo $RAP->outputStream($data);