<?php
/**
*影碟推荐
*Ncf
*/

require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';
$RAP = new readAndPrint();
$dataBase = new dataBase();

$dataBase->open();
$sql = "select serial_number,video_name,lead_actor,stock,position,price,count(compact_disk_id) 
			from compact_disk,the_order where compact_disk.id=the_order.compact_disk_id
			group by `compact_disk_id` 
			order by count(compact_disk_id) DESC limit 10";
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
