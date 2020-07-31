<?php
namespace app\admin\controller;

use think\Controller;
use think\Model;
use think\Db;

class Admin extends Controller{
    public function getThis(){
        $result = my_model("Admin","model","admin")->getAll();
        return_ok($result);
        
    }

    public function loginAdmin(){
        if($this->request->isPost()){
            $name=input('name','','trim');
            $password = input('password','','trim');
            $admin = my_model("Admin","model","admin")->loginAdmin($name);

            if (empty($admin)) {
                return_error('账号或密码错误');
            }
            if($admin['password'] !== $password){
                return_error('账号或密码错误');
            }
            // //密码验证
            // if ($admin['password'] !== $password) {
            //     return_error('账户或密码不正确');

            // }
            return_ok($admin,"欢迎 $name 登录到管理员页面");
        }
    }
    public function change1(){
        if($this->request->isPost()){
            $name = input('name','','trim');
            $password = input('password','','trim');
            $rname = $name;
            $admin = my_model("Admin","model","admin")->change($rname,$name,$password);
            return_ok($admin,"修改信息成功");   
        }
    }

    public function change2(){
        if($this->request->isPost()){
            $rname = input('rname','','trim');
            $name = input('name','','trim');
            $password = input('password','','trim');
            $user = my_model("Admin","model","admin")->getAdmin($rname);
            if(!empty($user)){
                return_error('该用户名已存在');
            }else{

                $admin = my_model("Admin","model","admin")->change($rname,$name,$password);
                return_ok($admin,"修改信息成功");
            }   
        }
    }

    public function test(){
            $rname = input('rname','pika','trim');
            $name = input('name','pika','trim');
            $password = input('password','333333','trim');
            $user = my_model("Admin","model","admin")->getAdmin($name);
            if(!empty($user)){
                echo '此用户存在';
            }
            $admin = my_model("Admin","model","admin")->change($rname,$name,$password);

            echo $admin;
    }

    public function pHelp(){
        $userName = input('userName','','trim');
        $name = input('name','','trim');
        $desc = input('desc','','trim');
        $phone = input('phone','','trim');
        $data =['userName'=>$userName,
        'name'=>$name,
        'desc'=>$desc,
        'phone'=>$phone
        ];
        $result = my_model("Admin","model","admin")->pHelp($data);
        return_ok($result,'提交成功');
    }

}