<?php
/**
*订单查询
*Ncf
*/

require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';
$RAP = new readAndPrint();
$dataBase = new dataBase();

$receiveData = $RAP->inputStream();
//$order_id = $receiveData->{'order_id'};
$order_id=2;

$dataBase->open();
$sql = "select * from `order` where `id`='$order_id'";
$res = $dataBase->select($sql);//查询结果封装成数组
if($res){
	$data=array(
		'res'=>$res,//查询结果
		'code'=>200,
		'state'=>"查询成功"
	);
}else{
	$data=array(
		'code'=>503,
		'state'=>"不存在该订单"
	);
}
echo $RAP->outputStream($data);



?>
