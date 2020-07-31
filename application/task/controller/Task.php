<?php
namespace app\task\controller;

use think\Controller;
use think\Model;
use think\Db;

class Task extends Controller{
    public function getAll(){
        $result = my_model("Task","model","task")->getAll();
        return_ok($result);
        
    }

    public function getAAll(){
        $result = my_model("Task","model","task")->getAAll();
        return_ok($result);
        
    }

    public function getTask(){
        if($this->request->isPost()){
            $user_id=input('user_id','','trim');
            $result = my_model("Task","model","task")->getTask($user_id);
            return_ok($result);
        }
    }

    public function getTasks(){
        if($this->request->isPost()){
            $id = input('id','','trim');
            $result = my_model("Task","model","task")->getTasks($id);
            return_ok($result);
        }
    }

    public function addTask(){
        if($this->request->isPost()){
            $user_id=input('user_id','','trim');
            $title =input('title','','trim');
            $content=input('content','','trim');
            $money =input('money','','trim');
            $time=input('time','','trim');
            $address =input('address','','trim');
            $phone=input('phone','','trim');
            $state = '0';
            $data = [
                'user_id'=>$user_id,
                'title'=>$title,
                'content'=>$content,
                'money'=>$money,
                'time'=>$time,
                'address'=>$address,
                'state'=>$state,
                'phone'=>$phone
            ];
            $user = my_model("Task","model","task")->checkUser($user_id);
            if($user['money'] < $money){
                return_error('余额不足,发布失败!');
            }else{
                $result = my_model("Task","model","task")->addTask($data);
                return_ok($result,'发布成功');
            }
        }
    }

    public function add(){
        if($this->request->isPost()){
            $userName=input('user_id','','trim');
            $title =input('title','','trim');
            $money =input('money','','trim');
            $content = input('content','','trim');
            $state = input('state','','trim');
            $address = input('address','','trim');
            $time = input('time','','trim');
            $state = '0';
            $phone = input('phone','','trim');
            $data = [
                'user_id'=>$userName,
                'title'=>$title,
                'content'=>$content,
                'state'=>$state,
                'address'=>$address,
                'time'=>$time,
                'money'=>$money,
                'state'=>$state,
                'phone'=>$phone
            ];
            //$u=action('rank/Rank/pst',['userName'=>$userName]);
            $result = my_model('Task','model','task')->add($data);
            return_ok($result,'新增成功');
        }
    }

    public function del(){
        if($this->request->isPost()){
            $userName=input('user_id','','trim');
            $id = input('id','','trim');
            //$u=action('rank/Rank/pst',['userName'=>$userName]);
            $result = my_model('Task','model','task')->del($id,$userName);
            return_ok($result,'删除成功');
        }
    }

    public function change(){
        if($this->request->isPost()){
            $id = input('id','','trim');
            $user_id=input('user_id','','trim');
            $user_id2=input('user_id2','','trim');
            $title =input('title','','trim');
            $money =input('money','','trim');
            $content = input('content','','trim');
            $state = input('state','','trim');
            $address = input('address','','trim');
            $time = input('time','','trim');
            $phone = input('phone','','trim');
            $data = [
                'id' =>$id,
                'user_id'=>$user_id,
                'user_id2'=>$user_id2,
                'title'=>$title,
                'content'=>$content,
                'state'=>$state,
                'address'=>$address,
                'time'=>$time,
                'money'=>$money,
                'phone'=>$phone
            ];
            $result = my_model('Task','model','task')->change($data);
            return_ok($data,'修改成功');
        }
    }


    public function getTaskp(){
        if($this->request->isPost()){
            $user_id = input('user_id','','trim');
            $result = my_model("Task","model","task")->getTaskp($user_id);
            return_ok($result);
        }
    }

    public function getTaskg(){
        if($this->request->isPost()){
            $user_id = input('user_id','','trim');
            $result = my_model("Task","model","task")->getTaskg($user_id);
            return_ok($result);
        }
    }

    public function getThis(){
        if($this->request->isPost()){
            $id = input('id','','trim');
            $user_id2 = input('user_id2','','trim');
            //$data = ['id'=>$id,'user_id2'=>$user_id2];
            $result = my_model("Task","model","task")->getThis($id,$user_id2);
            return_ok($result,"领取成功");
        }
    }

    public function doneTask(){
        if($this->request->isPost()){
            $task_id = input('id','','trim');
            $result = my_model("Task","model","task")->done($task_id);
            return_ok($result,"完成任务成功");
        }
    }

    public function confirmTask(){
        if($this->request->isPost()){
            $task_id = input('id','','trim');
            $result = my_model("Task","model","task")->confirm($task_id);
            return_ok($result,"确认完成任务成功");
        }
    }

    public function removeTask(){
        if($this->request->isPost()){
            $task_id = input('id','','trim');
            $result = my_model("Task","model","task")->remove($task_id);
            return_ok($result,"取消任务成功");
        }
    }

    public function gaveTask(){
        if($this->request->isPost()){
            $task_id = input('id','','trim');
            $result = my_model("Task","model","task")->gave($task_id);
            return_ok($result,"放弃任务成功");
        }
    }

    public function halo(){
        $id = '1';
        $result = my_model("Task","model","task")->getTasks($id);
        return_ok($result);
    }
}