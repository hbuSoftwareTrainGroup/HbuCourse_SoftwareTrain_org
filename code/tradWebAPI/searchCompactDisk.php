<?php
/**
*影碟查询（查询标记 影碟名-1、主演名-2、影碟编号-3）
*Ncf
*/



require_once 'readAndPrint.class.php';
require_once 'dataBase.class.php';
$RAP = new readAndPrint();
$dataBase = new dataBase();

$receiveData = $RAP->inputStream();
$mark = $receiveData->{'mark'};
//$mark = 1;

switch ($mark){
    case 1:
		$video_name = $receiveData->{'video_name'};
		//$video_name="笑傲江湖";
		$dataBase->open();
		$sql = "select * from compact_disk where `video_name`='$video_name'";
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
				'state'=>"不存在该影片"
			);
		}
		//print_r($res);
		echo $RAP->outputStream($data);
        break;
    case 2:
		$lead_actor = $receiveData->{'lead_actor'};
		$dataBase->open();
		$sql = "select * from compact_disk where `lead_actor`='$lead_actor'";
		$res = $dataBase->selectAll($sql);//查询结果封装成数组
		if($res){
			$data=array(
				'res'=>$res,
				'code'=>200,
				'state'=>"查询成功"
			);
		}else{
			$data=array(
				'code'=>503,
				'state'=>"不存在该影片"
			);
		}
		echo $RAP->outputStream($data);
        break;
    case 3:
		$serial_number = $receiveData->{'serial_number'};
		$dataBase->open();
		$sql = "select * from compact_disk where `serial_number`='$serial_number'";
		$res = $dataBase->selectAll($sql);//查询结果封装成数组
		if($res){
			$data=array(
				'res'=>$res,
				'code'=>200,
				'state'=>"查询成功"
			);
		}else{
			$data=array(
				'code'=>503,
				'state'=>"不存在该影片"
			);
		}
		echo $RAP->outputStream($data);
        break;
    default:
		$data=array(
				'code'=>503,
				'state'=>"查询错误"
			);
		echo $RAP->outputStream($data);
        break;
}


?>
