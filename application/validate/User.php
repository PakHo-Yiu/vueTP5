<?php

namespace app\validate;

use \think\Validate;

/**
 * 管理员
 */
class Admin extends Validate
{
    //验证规则
    protected $rule = [

        'password' => ['require'],
        'phone'    => ['regex' => '/1[3458]{1}\d{9}$/'],
        'email'    => ['email'],
        'verify'   => ['require', 'captcha']
    ];

    //提示信息
    protected $message = [
        'password'         => '密码必须',
        'phone.regex'      => '手机格式错误',
        'email'            => '邮箱格式错误',
        'verify.require'   => '验证码必须',
        'verify.captcha'   => '验证码错误'
    ];

    //验证场景
    protected $scene = [
        
 
    ];


}
