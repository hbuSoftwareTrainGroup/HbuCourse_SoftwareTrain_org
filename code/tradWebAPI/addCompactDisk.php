<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/14
 * Time: 15:51
 */
require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';

$RAP = new readAndPrint();
$dataBase = new dataBase();

$receiveData = $RAP->inputStream();
$position = $receiveData->{'position'};
$price = $receiveData->{'price'};
$video_name = $receiveData->{'video_name'};
$lead_actor = $receiveData->{'lead_actor'};
$stock = $receiveData->{'stock'};
$input_goods = $receiveData->{'input_goods'};
$serial_number = $receiveData->{'serial_number'};

$dataBase->open();
$sql = "INSERT INTO compact_disk(`position`,`price`,`video_name`,`lead_actor`,`stock`,`input_goods`,`serial_number`) VALUES ('$position','$price','$video_name','$lead_actor','$stock','$input_goods','$serial_number')";
$res = $dataBase->insert($sql);

if($res){
    $data=array(
        'code'=>200,
        'state'=>"入库成功"
    );
}else{
    $data=array(
        'code'=>503,
        'state'=>"入库失败"
    );
}
echo $RAP->outputStream($data);