<?php

namespace app\help\model;

use think\Model;
use think\Db;

class Help extends Model{
    public function getAll(){
        return Db::name('help')->where('id','neq','null')->order('id asc')->select();
    }

    public function pHelp($data){
        return Db::name('help')->insertGetId($data);
    }

    public function change($id,$more){
        return Db::name('help')->where('id',$id)->update(['more'=>$more]);
    }

    public function del($id,$state){
        return Db::name('help')->where('id',$id)->update(['state'=>$state]);
    }
}