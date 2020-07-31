<?php
namespace app\rank\controller;

use think\Controller;
use think\Model;
use think\Db;

class Rank extends Controller{
    
//领取排行榜
    public function getRankg(){
        $result = my_model("Rank","model","rank")->getRankg();
        return_ok($result);
        //return_ok('','hello');
    }
    
//发布排行榜
    public function getRankp(){
        $result = my_model("Rank","model","rank")->getRankp();
        return_ok($result);

    }

    // public function add($userName='',$getNum='',$pstNum='',$name=''){
    //     $data = [
    //         'userName'=>$userName,
    //         'getNum'=>$getNum,
    //         'pstNum'=>$pstNum,
    //         'name'=>$name
    //     ];
    //     my_model("Rank","model","rank")->add($data);
    // }

    // public function change($userName='',$getNum='',$pstNum='',$name=''){
    //     $data = [
    //         'getNum'=>$getNum,
    //         'pstNum'=>$pstNum,
    //         'name'=>$name
    //     ];
    //     my_model("Rank","model","rank")->change($userName,$data);
    // }

    // public function del($userName=''){
    //     my_model("Rank","model","rank")->del($userName);
    // }

    // public function pst($userName=''){
    //     my_model("Rank","model","rank")->pst($userName);
    // }

    // public function get($userName=''){
    //     my_model("Rank","model","rank")->get($userName);
    // }

    public function test()
    {
        return_ok('heelo');
        # code...
    }
}


