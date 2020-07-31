<?php
use Firebase\JWT\JWT;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * ajax 请求正确返回
 * @param string $msg
 * @param array $data
 * @return json
 */
function return_ok($data = array(), $msg = '')
{
    $result['status'] = 1;
    $result['data']   = $data;
    $result['msg']    = $msg;
    $result['code']   = 200;
    // 返回JSON数据格式到客户端 包含状态信息
    header('Content-Type:application/json; charset=utf-8');
    exit(json_encode($result));
}


/**
 * ajax 请求错误返回
 * @param string $msg
 * @param string $code
 * @return json
 */
function return_error($msg = null, $code = 500)
{
    if ($msg == null) {
        $msgDefault    = config('error');
        $result['msg'] = $msgDefault [$code];
    } else {
        $result['msg'] = $msg;
    }
    $result['status'] = 0;
    $result['code']   = $code;
    // 返回JSON数据格式到客户端 包含状态信息
    header('Content-Type:application/json; charset=utf-8');
    exit(json_encode($result));
}

/**
 * 抛出异常处理
 * @param string $msg 异常消息
 * @param integer $code 异常代码 默认为0
 * @param string $exception 异常类
 *
 * @throws Exception
 */
function my_exception($msg = null, $code = 0, $exception = '')
{
    if ($msg == null) {
        $msgDefault = config('error');
        $msg        = $msgDefault [$code];
    } else {
        $msg = $msg;
    }
    $e = $exception ?: '\think\Exception';
    throw new $e($msg, $code);
}

/**
 * 返回json
 * @param array $data
 */
function json_return($data = array())
{
    // 返回JSON数据格式到客户端 包含状态信息
    header('Content-Type:application/json; charset=utf-8');
    exit(json_encode($data));
}

/** 自定义模型实例化 能指定模块
 * @param $name Model名称
 * @param $layer 业务层名称
 * @param $common 模块名
 * @param bool $appendSuffix 是否添加类名后缀
 * @return object
 */
function my_model($name, $layer, $common, $appendSuffix = false)
{
    return \think\Loader::model($name, $layer, $appendSuffix, $common);
}

/**
 * 用户密码加密方法，可以考虑盐值包含时间（例如注册时间），
 * @param string $pass 原始密码
 * @return string 多重加密后的32位小写MD5码
 */
function encrypt_pass($pass)
{
    if ('' == $pass) {
        return '';
    }
    $salt = config('system.pass_salt');
    return md5(sha1($pass) . $salt);
}

/** 自定义实例化验证器 能指定模块
 * @param $name Model名称
 * @param $layer 业务层名称
 * @param $common 模块名
 * @param bool $appendSuffix 是否添加类名后缀
 * @return object
 */
function my_validate($name, $common, $layer = 'validate', $appendSuffix = false)
{
    return \think\Loader::validate($name, $layer, $appendSuffix, $common);
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key 加密密钥
 * @return string
 */
function think_decrypt($data, $key = '')
{
    $key  = md5(empty($key) ? config('extra.pass_salt') : $key);
    $data = substr($data, 32);
    $data = str_replace(array('-', '_'), array('+', '/'), $data);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    $data   = base64_decode($data);
    $expire = substr($data, 0, 10);
    $data   = substr($data, 10);

    if ($expire > 0 && $expire < time()) {
        return '';
    }
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = $str = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        } else {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}

/**
 * 返回格式化信息
 * @param string/array $msg 信息内容
 * @param string $code 错误码
 * @param number $status 状态 0 错误 ，1 成功
 * @return array
 */
function msg_return($status = 0, $msg = null, $code = 0)
{
    return array('status' => $status, "code" => $code, "msg" => $msg);
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key 加密密钥
 * @param int $expire 过期时间 单位 秒
 * @return string
 */
function think_encrypt($data, $key = '', $expire = 0)
{
    $key  = md5(empty($key) ? config('extra.pass_salt') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time() : 0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
    }

    $str = str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($str));
    return strtoupper(md5($str)) . $str;
}


