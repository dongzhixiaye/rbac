<?php
namespace app\api\validate;

use app\api\model\Attachment;
use app\api\model\Message;
use app\common\model\Common;
use Firebase\JWT\JWT;
use think\Cache;
use think\Collection;
use think\helper\Hash;
use think\Model;
use think\Response;
use app\api\model\UserChild;
use think\Validate;

class AdminUser extends Validate
{
    //定义验证规则
    protected $rule = [
        'username' => 'require|unique:admin_user',
        'role' => 'require',
        'email' => 'require|email|unique:admin_user',
        'mobile' => 'require|unique:admin_user',
        'password'    => 'require|length:5,20',
        'nickname'    => 'require'
    ];

    //定义验证提示
    protected $message = [
        'username.require' =>'登录名名字不能为空',
        'username.unique' =>'登录名字不能重复',
        'role.require' =>'角色选择不能为空',
        'email.require' =>'邮箱不能为空',
        'email.unique' =>'邮箱不能重复',
        'email.email' => '邮箱格式不正确',
        'password.require' => '密码不能为空',
        'password.length' => '密码长度不合法6-20',
        'mobile.length' => '手机号不能为空',
        'mobile.unique' => '手机不能重复',
        'nickname' => '昵称不能为空',
    ];
    protected $scene=['login'=>['username.require','password'],'edit'=>['email.require','mobile.require','nickname.require'],'reset'=>['password']];
}