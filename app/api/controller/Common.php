<?php
/**
 * Created by PhpStorm.
 * User: YuboMAC
 * Date: 2019/4/1
 * Time: PM2:29
 */

namespace app\api\controller;


use app\api\model\VisitRecord;
use app\BaseController;
use app\common\model\Handle;
use app\common\model\UserInfo;
use Firebase\JWT\JWT;
use think\Controller;
use think\facade\Cache;


/**
 * @OA\Info(
 *  version="1.0",
 *  title="数字营销电商订单管理平台",
 *  description="数字营销电商订单管理平台自动生成api文档v1。除登录外的所有接口，共有参数，token：登录的时候回返回，项目集团内部是用，不做签名验证，共有参数可以放到header也可以放到参数中",
 *  termsOfService="http://newairtek.com",
 *  @OA\Contact(
 *      name="Leon",
 *      email="470974216@qq.com",
 * ),
 *     @OA\License(
 *  name="Apache 2.0",
 *  url="http://www.apache.org/licenses/LICENSE-2.0.html"
 * ),
 *
 * ),
 * @OA\Server(
 *     url="/api/v1",
 *     description="php resetful"
 * ),
 *

 *
 *  *@OA\Tag(
 *  *      name="admin",
 *  *     description="后台相关的接口"
 *  *),
 *

 *
 *
 */

class Common extends BaseController
{
    public function json($data, $code = '',$msg = '',  $type = '', array $header = [])
    {
        $code=empty($code)?200:$code;
        $msg=empty($msg)?"执行成功":$msg;
        $type=empty($type)?'json':$type;

        if(config('app.allow_origin.open',0)){
            $allow_origin=get_allow_origin();
        }else{
            $allow_origin=" *";
        }
        $head=[
            // TODO-限制特定域名
            'Access-Control-Allow-Origin'=>$allow_origin,
            'Access-Control-Allow-Methods'=>' GET, POST, PUT, OPTIONS',
            'Access-Control-Allow-Headers'=>'sign,token,timestamp,Origin,X-Requested-With,Content-Type,Accept',
        ];
        $header=array_merge($header,$head);
        $result = [
            'code'=>$code,
            'msg'  => $msg,
            'time' => time(),
            'data' => $data,
        ];
        return json($result,200,$header);
    }


    public  function getComeIn(){
        if(request()->isPost()){
            $data=request()->post();
        }else{
            $data=request()->get();
        }
        if(!isset($data['token'])) $data['token']=request()->header('token');
        if(!isset($data['timestamp'])) $data['timestamp']=request()->header('timestamp');
        return $data;
    }



}