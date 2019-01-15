<?php
/**
*订单查询
*Ncf
*/

require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';
$RAP = new readAndPrint();
$dataBase = new dataBase();

$dataBase->open();
$sql = "select the_order.id as order_id,compact_disk.id as video_disk_id,user_account.username,rental_date,return_date,rental,deposit,receipt_id
            from `compact_disk`,`the_order`,`user_account` 
			    where compact_disk.id = the_order.compact_disk_id 
					and user_account.id = the_order.user_id";
$res = $dataBase->selectAll($sql);//查询结果封装成数组
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
//print_r($res);
echo $RAP->outputStream($data);



?>
