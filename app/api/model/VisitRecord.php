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

class VisitRecord extends \app\api\model\Common
{

    public function setComeinDataAttr($val){
        return json_encode($val);
    }

    public function getComeinDataAttr($val){
        return json_decode($val,true);
    }

}