<?php

namespace app\task\model;

use think\Model;
use think\Db;

class Task extends Model{
    public function getAll(){
        return Db::name('task')->where('state','eq','0')->order('id desc')->select();
    }

    public function getAAll(){
        return Db::name('task')->where('id','neq','null')->order('id asc')->select();
    }

    public function getTask($id){
        return Db::name('task')->where('user_id2','null')->where('user_id','neq',$id)->order('id desc')->select();
    }

    public function getTasks($id){
        return Db::name('task')->where('id',$id)->select();
    }

    public function addTask($data){
        Db::name('user')->where('userName','eq',$data['user_id'])->setDec('money',$data['money']);
        return Db::name('task')->insert($data);
        
    }

    public function checkUser($userName){
        return Db::name('user')->where('userName','eq',$userName)->find();

    }

    public function add($data){
        $u = Db::name('rank')->where('userName',$data['user_id'])->setInc('pstNum',1);
        return Db::name('task')->insert($data);
        
    }

    public function del($id,$userName){
        $u = Db::name('rank')->where('userName',$userName)->setDec('pstNum',1);
        return Db::name('task')->where('id',$id)->delete();
        
    }

    public function change($data){
        $u = Db::name('rank')->where('userName',$data['user_id2'])->setInc('getNum',1);
        return Db::name('task')->where('id',$data['id'])->update($data);
        
    }

    public function getTaskp($id){
        $exp = new \think\db\Expression('field(state,0,1,2,3),update_time desc');
        //$result = $query->where(['id'=>['in','3,6,9,1,2,5,8,7']])->order($exp)->select();
        //return Db::name('task')->where('user_id',$id)->order('id desc')->select();
        return Db::name('task')->where('user_id',$id)->where(['state'=>['in','0,1,2,3']])->order($exp)->select();
    }

    public function getTaskg($id){
        $exp = new \think\db\Expression('field(state,0,1,2,3),update_time desc');
        return Db::name('task')->where('user_id2',$id)->where(['state'=>['in','0,1,2,3']])->order($exp)->select();
    }

    public function getThis($id,$user_id2){
        $data = ['user_id2'=>$user_id2,'state'=>'1'];
        return Db::name('task')->where('id',$id)->update($data);
    }

    public function getUserByName($id)
    {
        $where = " user_id = " . $id;
        return Db::name('task')->where($where)->find();
    }

    public function done($id){
        $where = " id = " .$id;
        return Db::name('task')->where($where)->update(['state'=>'2']);
    }

    public function gave($id){
        $where = " id = " .$id;
        return Db::name('task')->where($where)->update(['user_id2'=>'','state'=>'0']);
    }

    public function confirm($id){
        $where = " id = " .$id;
        $u =Db::name('task')->where($where)->find();
        Db::name('rank')->where('userName',$u['user_id'])->setInc('pstNum',1);
        Db::name('rank')->where('userName',$u['user_id2'])->setInc('getNum',1);
        Db::name('user')->where('userName',$u['user_id2'])->setInc('money',$u['money']);
        return Db::name('task')->where($where)->update(['state'=>'3']);

    }

    public function remove($id){

        // return Db::name('task')->where('id',$id)->delete();
        return Db::name('task')->where('id',$id)->update(['state'=>4]);
    }

    public function halo($halo){
        $halo1 = $halo;
        return $halo1;
    }
}