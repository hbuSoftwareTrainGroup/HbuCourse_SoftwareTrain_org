<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/15
 * Time: 16:22
 */
require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';

$RAP = new readAndPrint();
$video_disk_id = $RAP->inputStream()->{'video_disk_id'};

$dataBase = new dataBase();
$dataBase->open();
$sql = "select * from `compact_disk` where (`id`='$video_disk_id')";
$selectRes = mysql_fetch_array($dataBase->select($sql));

$url = $selectRes["position"];
if($selectRes){
    $data=array(
        'url' => $url,
        'code'=>200,
        'state'=>"获取播放链接成功"
    );
}else{
    $data=array(
        'url' => NULL,
        'code'=>503,
        'state'=>"获取播放链接失败"
    );
}
echo $RAP->outputStream($data);