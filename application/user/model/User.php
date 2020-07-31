<?php

namespace app\user\model;

use think\Model;
use think\Db;


class User extends Model
{
    
    public function getAll(){
        return Db::name('user')->alias("u")->join('rank r','u.userName = r.userName')->field('u.id,u.userName,u.name,u.password,u.desc,u.birthday,u.height,u.sex,u.img,u.update_time,u.money,r.getNum,r.pstNum')->order('id asc')->select();
    }
    // protected $autoWriteTimestamp=true;
    // protected static $updateTime = 'update_time';
    // protected static $createTime = 'create_time';

    /** 通过ID获取信息
     * @param $id
     */
    public function getUserById($id)
    {
        $where = " a.isDel = 0 and a.id = " . $id;
        return Db::name('user')->alias('a')->field('a.*')->where($where)->find();
    }

    /** 通过手机号获取信息
     * @param $phone
     */
    /*public function getUserByPhone($phone)
    {
        $where = " a.isDel = 0 and a.phone = " . $phone;
        return Db::name('user')->alias('a')->field('a.*')->where($where)->find();
    }

    /** 通过用户名获取信息
     * @param $name
     */
    public function getUserByName($userName)
    {
        return Db::name('user')->where('userName','eq',$userName)->find();
    }

    /**
     * 获取列表
     */
    public function getLists($userName, $nickName, $phone, $adzoneId, $realName, $openId, $startTime, $endTime, $isEnabled, $pid, $myorder, $page, $psize)
    {
        $where = 'a.isDel = 0';
        if ($userName) {
            $where .= " and a.userName = '" . $userName . "' ";
        }

        if ($nickName != '') {
            $where .= " and a.nickName =  '" . $nickName . "'";
        }

        if ($adzoneId != '') {
            $where .= " and a.adzoneId =  '" . $adzoneId . "'";
        }

        if ($realName != '') {
            $where .= " and a.realName =  '" . $realName . "'";
        }

        if ($phone != '') {
            $where .= " and a.phone =  '" . $phone . "'";
        }
        if ($openId != '') {
            $where .= " and a.openId =  '" . $openId . "'";
        }

        if ($startTime) {
            $where .= " and  a.loginTime >= " . $startTime . " ";
        }
        if ($endTime) {
            $where .= " and  a.loginTime <= " . $endTime . " ";
        }

        if ($isEnabled != -1) {
            $where .= " and a.isEnabled =  " . $isEnabled;
        }
        if ($pid != '') {
            $where .= " and (a.pid =  " . $pid . " or a.pid2 = " . $pid . ")";
        }
        return Db::name('user')->alias('a')->field('a.*')->where($where)->order($myorder)->page($page, $psize)->select();
    }


    /**
     * 获取数量
     */
    public function getTotal($userName, $nickName, $phone, $adzoneId, $realName, $openId, $startTime, $endTime, $isEnabled, $pid)
    {
        $where = 'a.isDel = 0';
        if ($userName) {
            $where .= " and a.userName = '" . $userName . "' ";
        }

        if ($nickName != '') {
            $where .= " and a.nickName =  '" . $nickName . "'";
        }

        if ($adzoneId != '') {
            $where .= " and a.adzoneId =  '" . $adzoneId . "'";
        }

        if ($realName != '') {
            $where .= " and a.realName =  '" . $realName . "'";
        }

        if ($phone != '') {
            $where .= " and a.phone =  '" . $phone . "'";
        }
        if ($openId != '') {
            $where .= " and a.openId =  '" . $openId . "'";
        }
        if ($startTime) {
            $where .= " and  a.loginTime >= " . $startTime . " ";
        }
        if ($endTime) {
            $where .= " and  a.loginTime <= " . $endTime . " ";
        }
        if ($isEnabled != -1) {
            $where .= " and a.isEnabled =  " . $isEnabled;
        }
        if ($pid != '') {
            $where .= " and (a.pid =  " . $pid . " or a.pid2 = " . $pid . ")";
        }
        return Db::name('user')->alias('a')->field('a.*')->where($where)->count();
    }

    /**
     * [check 检测是否存在]
     * @param  [type] $orderNum
     * @return [type]
     */
    public function check($userName)
    {
        $id = Db::name('user')->where('userName','eq',$userName)->value('id');
        if (empty($id)) {
            return 0;
        } else {
            return $id;
        }
    }

    /**新增
     * @param $data
     */
    public function add($data,$data2)
    {
        $u = Db::name('rank')->insert($data2);
        return Db::name('user')->insertGetId($data);
    }

    /** 更新
     * @param array $id
     * @param array $data
     * @return $this|void
     */
    public function modify($id, $data)
    {
        return Db::name('user')->where(['userName' => $id])->update($data);
    }
    /** 注册
     * @param array $id
     * @param array $data
     * @return $this|void
     */
    public function reg($userName,$password,$sex)
    {
        $data = ['userName'=>$userName,'password'=>$password,'sex'=>$sex];
        $data2 = ['userName'=>$userName];
        Db::name('rank')->insert($data2);
        return Db::name('user')->insert($data);
    }

    public function getUser($data){
        return Db::name('user')->where('userName','=',$data)->find();
    }
    
    public function set($userName,$password){
        return Db::name('user')->where('userName','eq',$userName)->update(['password' => $password]);
    }

    public function getUsers($id){
        return Db::name('user')->where('id','=',$id)->select();
    }

    public function change($userName,$data,$data2){
        $u =Db::name('rank')->where('userName',$userName)->update($data2);
        return Db::name('user')->where('userName',$userName)->update($data);
    }

    public function del($userName){
        $u = Db::name('rank')->where('userName',$userName)->delete();
        return Db::name('user')->where('userName',$userName)->delete();

    }

    public function setMoney($userName,$money){
        Db::name('money')->insertGetId(['userName'=>$userName,'money'=>$money]);
        return Db::name('user')->where('userName',$userName)->setInc('money',$money);
    }

    public function setImg($userName,$imgUrl){
        return Db::name('user')->where('userName',$userName)->update(['img'=>$imgUrl]);
    }
    public function setUser($userName,$data){
        return Db::name('user')->where('userName',$userName)->update($data);
    }
}