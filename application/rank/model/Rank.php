<?php

namespace app\rank\model;

use think\Model;
use think\Db;

class Rank extends Model{
    public function getRankg(){
        return Db::name('rank')->where('id','>',0)->order('getNum desc')
        ->limit(10)->select();
    }
    public function getRankp(){
        return Db::name('rank')->where('id','>',0)->order('pstNum desc')
        ->limit(10)->select();
    }

    // public function add($data){
    //     return Db::name('rank')->insert($data);
    // }

    // public function change($userName,$data){
    //     return Db::name('rank')->where('userName',$userName)->update($data);
    // }
   
    // public function del($userName){
    //     return Db::name('rank')->where('userName',$userName)->delete();
    // }

    // public function pst($userName){
    //     return Db::name('rank')->where('userName',$userName)->setInc('pstNum',1);
    // }

    // public function get($userName){
    //     return Db::name('rank')->where('userName',$userName)->setInc('getNum',1);
    // }
   
}