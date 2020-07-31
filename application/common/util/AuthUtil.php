<?php

namespace app\common\util;

use app\common\util\JwtUtil;
use app\validate\CommonConstant;
use \think\Db;

/**
 * 权限认证
 * @author hardphp@163.com
 *
 */
class AuthUtil
{

    /**
     * 验证用户身份
     * @param string $type user 普通用户，admin 管理员，seller 商家
     * @return multitype:
     */
    public static function checkUser($type = 'user')
    {
        // JWT用户令牌认证，令牌内容获取
        $userToken = request()->header('x-access-token');
        if (empty($userToken)) {
            my_exception(null, CommonConstant::e_api_user_token_miss);
        }
        $userToken = think_decrypt($userToken);
        $payload   = JwtUtil::decode($userToken);
        if ($payload === false || empty($payload->uid) || empty($payload->loginTime)) {
            my_exception(null, CommonConstant::e_api_user_token_miss);
        }
        //用户登录有效期
        $userLoginTime = config('system.user_login_time');
        if ($payload->loginTime < time() - $userLoginTime) {
            my_exception(null, CommonConstant::e_api_user_token_expire);
        }
        // 实时用户数据
        $user = Db::name($type)->getById($payload->uid);
        //是否多设备登录
        if (!empty($user ['loginTime']) && $user ['loginTime'] != $payload->loginTime) {
            my_exception(null, CommonConstant::e_api_multiple_device_login);
        }
        //认证：状态
        if ($user ['isEnabled'] != CommonConstant::db_true) {
            my_exception(null, CommonConstant::e_user_disabled);
        }
        return msg_return(1, $user);
    }

}
