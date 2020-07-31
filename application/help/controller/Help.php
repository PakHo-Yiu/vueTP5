<?php
namespace app\help\controller;

use think\Controller;
use think\Model;
use think\Db;

class Help extends Controller{
    public function pHelp(){
        $userName = input('userName','','trim');
        $name = input('name','','trim');
        $phone = input('phone','','trim');
        $desc = input('desc','','trim');
        $state = input('state','待解决','trim');
        $data = ['name'=>$name,
        'phone'=>$phone,
        'desc'=>$desc,
        'state'=>$state,
        'userName'=>$userName
        ];
        $result = my_model("Help","model","help")->pHelp($data);
        return_ok($result,'提交成功');
        
    }

    public function getAll(){
        $result = my_model('Help','model','help')->getAll();
        return_ok($result);
    }

    public function change(){
        $id= input('id','','trim');
        $more = input('more','','trim');
        $result = my_model('Help','model','help')->change($id,$more);
        return_ok($result,'备注成功');
    }

    public function del(){
        $id= input('id','','trim');
        $state = input('state','已解决','trim');
        $result = my_model('Help','model','help')->del($id,$state);
        return_ok($result);
    }
}
