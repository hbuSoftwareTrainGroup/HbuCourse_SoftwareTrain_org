<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/3
 * Time: 8:56
 * 用途:调整输入输出数据格式
 */

class readAndPrint
{
    public function inputStream(){
        $json=file_get_contents("php://input");
        $obj = json_decode($json);
        return $obj;
    }

    public function outputStream($data){
        $json = json_encode($data);
        return $json;
    }
}