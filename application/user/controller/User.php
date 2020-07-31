<?php
namespace app\user\controller;

use think\Controller;
use think\Model;
use think\Db;
use app\validate\CommonConstant;
use \Firebase\JWT\JWT;
use app\common\util\JwtUtil;
vendor('Firebase.php-jwt.src.JWT');

class User extends Controller{
    public function getAll(){
        $result = my_model("User","model","user")->getAll();
        return_ok($result);
        
    }

    public  function getToken($uid){
        $secret = 'lazy';
        $time =time();
        $payload = [
            'exp'=>$time+3600*24*7,
            'iat'=>$time,
            'user'=>$uid,
        ];
        $token = JWT::encode($payload,$secret,'HS256');
        echo $token;
    }

    public function check(){
        $jwt = input("token");  //上一步中返回给用户的token
        $key = "huang";  //上一个方法中的 $key 本应该配置在 config文件中的
        $info = JWT::decode($jwt,$key,["HS256"]); //解密jwt
        return json($info);
    }

    public function index()
    {
        if ($this->request->isPost()) {
            //接收数据
            $data     = [
                'userName' => input('userName', '', 'trim'),
                'password' => input('password', '', 'trim'),
            ];
            //验证码
            //注册
            $result = model('User', 'user')->reg($data);
            return_ok([], '注册成功');
        }
    }

   
    public function halo(){
    //     $link = Db::connect();
    //     $result = $link->table('user')->select();
    //     $uid ='123';
    //     $token = my_model('index','JwtUtil','index')->getToekn($uid);
    //     return $token;
    //    halt($token);
    //     return_ok($result);
        echo 'hello';

    }
    /** 通过ID获取信息
     * @param $id
     */
    public function getUserById()
    {
        if($this->request->isPost()){
            $data =['userName'=> input('userName','','trim'),
            'password'=> input('password','','trim'),]; 
            $result = my_model('User', 'model', 'user')->getUserByName($data['userName']);
            if(!$result){
                $msg='用户不存在';
                return_error($msg);
            }else if($result['password']!=$data['password']){
                $msg ='用户或密码不正确';
                return_error($msg);
            }else{
                //$token = createToken($data['userName']);
                //$result['token'] = $token;
                return_ok($result);
            };
        }
    }

    /** 保存
     * @param $id
     * @param $data
     */
    public function modify($id, $data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = encrypt_pass($data['password']);
        }

        if ($id) {
            $data['updateTime'] = time();
            unset($data['regTime']);
            if (my_model('User', 'model', 'user')->check($data['userName']) && $id != my_model('User', 'model', 'user')->check($data['userName'])) {
                return_error('该手机号已存在!');
            }
            return my_model('User', 'model', 'user')->modify($id, $data);
        } 
    }
    /**
     * 登录。
 
     */



    // 用户登录
    public function login()
    {   
        if($this->request->isPost()){
            $userName=input('userName','','trim');
            $password =input('password','','trim');
            $user = my_model('User', 'model', 'user')->getUserByName($userName);
            if ($user['userName']!==$userName) {
                return_error('用户不存在');
 
            }
            //密码验证
            if ($user['password'] !== $password) {
                return_error('账户或密码不正确');

            }
            $payload['uid']       = $user['id'];
            $userToken            = JwtUtil::encode($payload);
            //返回
            $money= $user['money'];
            $data = ['userName'=>$userName,
            'money'=>$money,
            'userToken' => $userToken
            ];
            return_ok($data,'登录成功');
            
        }
    }


// 用户注册
    public function reg(){
        if($this->request->isPost()){
            
            $userName=input('userName','','trim');
            $password =input('password','','trim');
            $sex = input('sex','','trim');
            
            $user = my_model('User', 'model', 'user')->check($userName);
            if($user !=0){
                return_error('用户已存在');
            }
            if($user == 0) {
                $result = my_model('User','model','user')->reg($userName,$password,$sex);
                return_ok($result,'注册成功');
            }
            //return_ok($data,$user);
        }
    }

//新增用户
    public function add(){
        if($this->request->isPost()){

            $userName=input('user_id','','trim');
            $password =input('password','','trim');
            $money =input('money','0','trim');
            $sex = input('sex','','trim');
            $getNum = input('getNum','0','trim');
            $pstNum = input('pstNum','0','trim');
            $birthday = input('birthday','','trim');
            $height = input('height','','trim');
            $desc = input('desc','','trim');
            $data = [
                'userName'=>$userName,
                'password'=>$password,
                'money'=>$money,
                'sex'=>$sex,
                'height'=>$height,
                'birthday'=>$birthday,
                'desc'=>$desc
            ];
            $user = my_model('User', 'model', 'user')->check($userName);
            if($user !=0){
                return_error('用户已存在');
            }
            if($user == 0) {
                $data2=['userName'=>$userName,
                'getNum'=>$getNum,
                'pstNum'=>$pstNum,
                ];
                $result = my_model('User','model','user')->add($data,$data2);
                return_ok($result,'添加成功');
            }
        }
    }

    // public function getUser(){
    //     $data = 123;
    //     $result = my_model('User','model','user')->getUser($data);
    //     return_ok($result,'heello');
    // }
    
//修改信息
    public function change()
    {
        $userName=input('user_id','','trim');
        $password =input('password','','trim');
        $money = input('money','0','trim');
        $img = input('img','0','trim');
        $sex = input('sex','','trim');
        $getNum = input('getNum','0','trim');
        $pstNum = input('pstNum','0','trim');
        $birthday = input('birthday','','trim');
        $height = input('height','','trim');
        $desc = input('desc','','trim');
        $data =[
            'password'=>$password,
            'money'=>$money,
            'sex'=>$sex,
            'height'=>$height,
            'birthday'=>$birthday,
            'desc'=>$desc,
            'img'=>$img
        ];
        $data2=['userName'=>$userName,
            'getNum'=>$getNum,
            'pstNum'=>$pstNum,
            ]; 
        $result = my_model('User', 'model', 'user')->change($userName,$data,$data2);
        return_ok($result,"修改成功");
        
    }
//删除用户
    public function del(){
        $userName =input('user_id','','trim');
        //$u=action('rank/Rank/del',['userName'=>$userName]);
        $result = my_model('User', 'model', 'user')->del($userName);
        return_ok($result,'删除成功');
    }

    public function test(){
        $data = 2;
        $result = my_model('User','model','user')->set($data);
        echo $result;
    }

    public function test2(){
        $id = 1;
        $result = my_model('User','model','user')->getUsers($id);
        return $result;
    }

    public function getUser(){
        $userName = input('user_id','','trim');
        $result = my_model('User','model','user')->getUser($userName);
        return_ok($result);
    }

    public function reset(){
        $userName = input('user_id','','trim');
        $password = input('password','','trim');
        $result = my_model('User','model','user')->set($userName,$password);
        return_ok($result,'修改密码成功');
    }

    public function setMoney(){
            $userName = input('userName','','trim');
            $money = input('money','','trim');
            $result = my_model('User','model','user')->setMoney($userName,$money);
            return_ok($result,'充值成功');
    }

    public function upload()
    {   
       
        $userName = input('name','','trim');
        $file = request()->file('file');
        $url = 'Vue\public\static\upload\avatar';
        $info = $file->move(ROOT_PATH.'public\static\upload'.DS.'avatar',$userName);
        if($info){
            $imgUrl = 'http://localhost:8888/Vue/public/static/upload/avatar/'.$info->getSaveName();
            my_model('User','model','user')->setImg($userName,$imgUrl);
            return_ok(['img'=>$imgUrl],'上传成功');
        }else{
            return_error('上传失败');
        }
    }

    public function setUser(){
        $userName = input('userName','','trim');
        $sex = input('sex','','trim');
        $height = input('height','','trim');
        $birthday = input('birthday','','trim');
        $desc = input('desc','','trim');
        $data =['sex'=>$sex,
            'height'=>$height,
            'birthday'=>$birthday,
            'desc'=>$desc
        ];
        $result = my_model('User','model','user')->setUser($userName,$data);
        return_ok($result,'修改成功');
}
}