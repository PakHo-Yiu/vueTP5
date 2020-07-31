<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class Admin extends Model{
    
    public function getAll(){
        return Db::name('admin')->where('id','neq','null')->order('id asc')->select();
    }

    public function loginAdmin($name){
        $where = "a.name = " .$name;
        return Db::name('admin')->alias('a')->field('a.*')->where('name','eq',$name)->find();
    }

    public function change($rname,$name,$password){
        return Db::name('admin')->where('name','eq',$name)->update(['name'=>$rname,'password'=>$password]);
    }

    public function getAdmin($name){
        return Db::name('admin')->where('name','eq',$name)->find();
    }

    public function pHelp($data){
        return Db::name('help')->insert($data);
    }
}