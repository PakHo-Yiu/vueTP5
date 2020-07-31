<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]
// $host_name = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : "*";
$host = 'http://localhost:8080';
header("Access-Control-Allow-Origin:http://localhost:8080");
header("Access-Control-Allow-Credentials: true ");
// header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization,");
    exit;
}

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
