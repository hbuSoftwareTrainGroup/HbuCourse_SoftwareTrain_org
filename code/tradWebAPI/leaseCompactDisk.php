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
$video_disk_id = $receiveData->{'video_disk_id'};

$dataBase->open();

$sqlSelect1 = "select * from `compact_disk` where `id`='$video_disk_id' ";
$selectCompactDiskResult =mysql_fetch_array($dataBase->select($sqlSelect1));
if($selectCompactDiskResult["stock"]>0){
    $username = $receiveData->{'username'};
    $phone = $receiveData->{'phone'};
    $rental_date = $receiveData->{'rental_date'};
    $return_date = $receiveData->{'return_date'};
    $rental = $receiveData->{'rental'};
    $deposit = $receiveData->{'deposit'};
    $receipt_id = $receiveData->{'receipt_id'};

    $sqlSelect2 = "select * from `user_account` where (`id`='$username'&& `phone`='$phone') ";
    $selectUserAccount = $dataBase->select($sqlSelect2);
    var_dump($selectUserAccount);
    exit(0);

    $sqlInsert = "INSERT INTO compact_disk(`position`,`price`,`video_name`,`lead_actor`,`stock`,`input_goods`,`serial_number`) VALUES ('$position','$price','$video_name','$lead_actor','$stock','$input_goods','$serial_number')";
    $res = $dataBase->insert($sql);
}else{
    $data=array(
        'code'=>503,
        'state'=>"出租失败，库存不足"
    );
}


    $data=array(
        'code'=>200,
        'state'=>"入库成功"
    );

echo $RAP->outputStream($data);