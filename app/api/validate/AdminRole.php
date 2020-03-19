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

class AdminRole extends Validate
{
    //定义验证规则
    protected $rule = [
        'name' => 'require',
        'menu_auth' => 'require',
    ];

    //定义验证提示
    protected $message = [
        'name.require' =>'名字不能为空',
        'menu_auth.require' =>'权限不能为空',
    ];
    protected $scene=['auth'=>['','','']];
}