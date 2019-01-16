<?php
/**
 * Created by PhpStorm.
 * User: 19597
 * Date: 2019/1/14
 * Time: 16:13
 */

class dataBase
{
    public function open(){
        $link=@mysql_connect("localhost","root","root");
        mysql_select_db("videorentalsystem",$link);
        mysql_query("set names utf8");
    }
    public function select($sql){
        $res=mysql_query($sql);
        return $res;
    }
    public function selectAll($sql){
        $res=mysql_query($sql);
        $end = array();
        while($rows=mysql_fetch_array($res)){
            $end[]=$rows;
        }
        return $end;
    }
    public function insert($sql){
        $res=mysql_query($sql);
        return $res;
    }
    public function update($sql){
        $res=mysql_query($sql);
        return mysql_affected_rows();
    }
    public function delete($sql){
        $res=mysql_query($sql);
        return mysql_affected_rows();
    }
}