<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/14
 * Time: 17:16
 */
/*
 * 流程：
 * 查询库存
 * 添加用户
 * 库存减一
 * 增加订单表信息
 * */
require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';

$RAP = new readAndPrint();
$dataBase = new dataBase();

$receiveData = $RAP->inputStream();
$video_disk_id = $receiveData->{'video_disk_id'};

$dataBase->open();

$sqlSelectcompact_disk = "select * from `compact_disk` where `id`='$video_disk_id' ";
$selectCompactDiskResult =mysql_fetch_array($dataBase->select($sqlSelectcompact_disk));
if($selectCompactDiskResult["stock"]>0){
    $username = $receiveData->{'username'};
    $phone = $receiveData->{'phone'};
    $rental_date = $receiveData->{'rental_date'};
    $return_date = $receiveData->{'return_date'};
    $rental = $receiveData->{'rental'};
    $deposit = $receiveData->{'deposit'};
    $receipt_id = $receiveData->{'receipt_id'};

    $sqlSelectUser = "select * from `user_account` where (`username`='$username' && `phone_number`='$phone') ";
    $selectUserAccount = mysql_fetch_array($dataBase->select($sqlSelectUser));

    //var_dump(($selectUserAccount));
    //exit(0);
    if(!($selectUserAccount)){
        //客户表里不存在
        $sqlInsertUser = "INSERT INTO user_account(`username`,`phone_number`) VALUES ('$username','$phone')";
        $insertUserRes = $dataBase->insert($sqlInsertUser);
        $userID=mysql_insert_id();
    }else{
        $insertUserRes = 1;
        $userID = $selectUserAccount["id"];
    }
    if(!($insertUserRes)){
        $data=array(
            'code'=>503,
            'state'=>"出租失败,因为登记姓名失败"
        );
    }else{
        //对库存减一
        $tmpCompactDiskStock = $selectCompactDiskResult["stock"] - 1;
        $tmpCompactDiskId = $selectCompactDiskResult["id"];
        $sqlChangeStock = "UPDATE `compact_disk` SET `stock`='$tmpCompactDiskStock' WHERE `id` = '$tmpCompactDiskId'";
        $resChangeStock = $dataBase->update($sqlChangeStock);
        if($resChangeStock){
            //增加一个订单
            $sqlInsertOrder = "INSERT INTO the_order(`deposit`,`user_id`,`compact_disk_id`,`receipt_id`,`state`,`rental`,`rental_date`,`return_date`) VALUES ('$deposit','$userID','$tmpCompactDiskId','$receipt_id','0','$rental','$rental_date','$return_date')";
            $resInsertOrder = $dataBase->insert($sqlInsertOrder);
            if(!$resInsertOrder){
                $data=array(
                    'code'=>503,
                    'state'=>"创建订单失败"
                );
            }else{
                $data=array(
                    'code'=>200,
                    'state'=>"订单创建成功"
                );
            }
        }else{
            $data=array(
                'code'=>503,
                'state'=>"修改库存失败"
            );
        }
    }
}else{
    $data=array(
        'code'=>503,
        'state'=>"出租失败，库存不足"
    );
}




echo $RAP->outputStream($data);