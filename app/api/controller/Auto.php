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



class Auto extends Common
{

    protected $_uid=0;//用户iD
    protected $_time;//登录时间
    protected $_user;//用户信息
    public function initialize()
    {
        $token=request()->header('token');
        $token=trim($token);

        if(config('app.open_token_auth')){

            if(empty($token)) $token=input('param.token','','trim');
            if(empty($token)) json_return("",401,"token不能为空");
            //验证token
            try{
                $token_copy=$token;
                $token=base64_decode($token);
                $obj=JWT::decode($token,config('app.jwt_key'),array('HS256'));
                $this->_uid=$obj->uid;
                $this->_time=$obj->time;
                //判断token是否存在

                $user=cache($this->_uid.'_info');
                // 能够获取数据并且设置token,并且传入的token和保存的token一致说明是合法用户
                if(!(is_array($user) && isset($user['token']) && $token_copy==$user['token'])){
                    json_return("",401,'token失效，请重新登录');
                }else{
                    $this->_user=$user;
                }
            }catch (\Exception $e){
                json_return("",401,'token异常，请检查token，或者重新获取');
            }

            //验证签名是否合法，验证数据完整性
            if(config('auth_power_validate')){
                //TODO-权限验证
            }

        }
        //记录访问记录
//        if(config('visit_record') ){
        if(config('app.visit_record') && strtoupper($_SERVER['REQUEST_METHOD'])!='OPTIONS'){
            $visit_record_temp=[
                'ip'=>$_SERVER['REMOTE_ADDR'],
                'path'=>$_SERVER['PATH_INFO'],
                'method'=>$_SERVER['REQUEST_METHOD'],
                'comein_data'=>$this->getComeIn(),
                'uid'=>$this->_uid,
            ];
            VisitRecord::create($visit_record_temp);

        }

    }



}