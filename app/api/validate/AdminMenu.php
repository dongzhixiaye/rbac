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

class AdminMenu extends Validate
{
    //定义验证规则
    protected $rule = [
        'name_ch' => 'require',
        'name_en' => 'require',
        'icon' => 'require',
        'route_value'    => 'require',
    ];

    //定义验证提示
    protected $message = [
        'name_ch.require' =>'中文名字不能为空',
        'name_en.require' =>'英文名字不能为空',
        'icon.require' =>'图标不能为空',
        'route_value.require' =>'前端rote值不能为空',

    ];
    protected $scene=['auth'=>['','','']];
}