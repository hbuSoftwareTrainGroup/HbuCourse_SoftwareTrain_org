<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/14
 * Time: 16:51
 */
require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';

$RAP = new readAndPrint();
$dataBase = new dataBase();

$receiveData = $RAP->inputStream();
$id = $receiveData->{'id'};
$position = $receiveData->{'position'};
$price = $receiveData->{'price'};
$video_name = $receiveData->{'video_name'};
$lead_actor = $receiveData->{'lead_actor'};
$stock = $receiveData->{'stock'};
$input_goods = $receiveData->{'input_goods'};

$dataBase->open();
$sql = "UPDATE `compact_disk` SET `position`='$position',`price`='$price',`video_name`='$video_name',`lead_actor`='$lead_actor',`stock`='$stock',`input_goods`='$input_goods' WHERE `id` = '$id'";
$res = $dataBase->update($sql);

if($res){
    $data=array(
        'code'=>200,
        'state'=>"更新成功"
    );
}else{
    $data=array(
        'code'=>503,
        'state'=>"更新失败"
    );
}
echo $RAP->outputStream($data);