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
        $end=mysql_fetch_array($res);
        return $end;
    }
    public function insert($sql){
        $res=mysql_query($sql);
        return $res;
    }
    public function update($sql){
        $link=@mysql_connect("localhost","root","root");
        mysql_select_db("shopping",$link);
        mysql_query("set names utf8");
    }
    public function dalete($sql){
        $link=@mysql_connect("localhost","root","root");
        mysql_select_db("shopping",$link);
        mysql_query("set names utf8");
    }
}