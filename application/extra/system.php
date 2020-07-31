<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------


return [

    'pass_salt'             => '58&%97@*^54*89',

    // jwt签名密钥
    'jwt_secret_key'        => 'lazy',
    // jwt算法 ，可配置的值取决于使用的jwt包支持哪些算法
    'jwt_algorithm'         => 'HS256',

    //app访问token有效期
    'access_token_time' => 60 * 60 * 24 * 7,
    //用户登录有效期
    'user_login_time'       => 60 * 60 * 24 * 7,

    //动态缩略图存放目录
    'thumb_dir'             => './runtime/thumb',

];
