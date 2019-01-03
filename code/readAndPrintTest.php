<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/3
 * Time: 9:03
 */
require_once 'readAndPrint.class.php';
$test = new readAndPrint();
$app=array(
    'code'=>'403',
    'message'=> '账号未激活',
    'data'=>NULL,
);
echo $test->outputStream($app);