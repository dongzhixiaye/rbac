<?php
namespace app\api\model;

use app\api\model\Message;
use app\common\model\Common;
use Firebase\JWT\JWT;
use think\Cache;
use think\Collection;
use think\helper\Hash;
use think\Model;
use think\Response;
use app\api\model\UserChild;

class AdminRole extends \app\api\model\Common
{


    public function setMenuAuthAttr($val)
    {
        return json_encode($val);
    }


    public function getMenuAuthAttr($val)
    {
        return json_decode($val,true);
    }

    public static function getUserPower($role=0){
        if(!$role) return [];
        $role_list=self::where('id',$role)->column('id,pid,menu_auth');
        $role_list=$role_list['0'];
        $menu=$role_list['menu_auth'];
        $menu=json_decode($menu,true);
        if($role_list['pid']){//支持二级继承关系
            $parent_menu=self::where('id',$role_list['pid'])->value('menu_auth');
            $parent_menu=json_decode($parent_menu,true);
            $menu=array_merge((array)$menu,(array)$parent_menu);
        }

        $menu=array_unique($menu);
        $menu_list=AdminMenu::where('id','IN',$menu)->where('trash','0')->field('url_value')->select()->toArray();
        $menu_list=array_column($menu_list,'url_value');
        return $menu_list;
    }

}