<?php

namespace app\api\controller\v1;

use app\api\model\AdminRole;
use app\api\model\LoginRecord;
use Firebase\JWT\JWT;
use think\Cache;
use think\Controller;
use think\Exception;
use think\exception\ValidateException;
use think\Loader;
use think\Request;
use app\BaseController;

class Login extends \app\api\controller\Common
{
    /**
     * @OA\Post(
     *     tags={"admin"},
     *     path=".login/signin",
     *     summary="登录接口",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"username":"admin","password":"admin"}
     *             )
     *         ),
     *
     *     description="username:登录名|邮件|手机号；password:密码,返回数据：status: 1:正常，其它禁止登录；ava.path:头像，token:本地保存，保存期限有token_valid_time确定单位秒，"
     *     ),

    @OA\Response(
    response=200,
    description="正常；请求已完成"
    ),
    @OA\Response(
    response=204,
    description="正常；无响应 — 已接收请求，但不存在要回送的信息"
    ),

    @OA\Response(
    response=302,
    description="已找到 — 请求的数据临时具有不同 URI",
    ),
    @OA\Response(
    response=401,
    description="未授权 — 未授权客户机访问数据"
    ),
    @OA\Response(
    response=404,
    description="找不到 — 服务器找不到给定的资源；文档不存在"
    ),

    @OA\Response(
    response=500,
    description="服务器错误"
    ),
     * )
     */

    public function signin()
    {
        if($this->request->isPost()){
            $data = input('post.');
            try{
                $this->validate($data, 'AdminUser.login');
            }catch (ValidateException $e){
                return $this->json("",400,$e->getError());
            }
            $username=trim($data['username']);
            $res=\app\api\model\AdminUser::with('ava')->where('email',$username)->where('trash',0)->whereOr('username',$username)->whereOr('mobile',$username)->find();
            if(empty($res)) return $this->json("用户不存在",401);
            if(!$res['status'] || !$res['role'])  return $this->json("用户禁止登录或者没有有效角色",401);
            $password=trim($data['password']);
            if(password_verify($password,$res['password'])){
                \app\api\model\AdminUser::where('id',$res['id'])->update(['last_login_time'=>time(),'last_login_ip'=>$this->request->ip()]);//更新最后登录时间和登录ip
                $token=base64_encode(JWT::encode(["uid"=>$res['id'],"time"=>time()],config('app.jwt_key')));
                $rtn=[
                    'id'=>$res->id,
                    'username'=>$res->username,
                    'nickname'=>$res->nickname,
                    'email'=>$res->email,
                    'mobile'=>$res->mobile,
                    'avatar'=>$res->avatar,
                    'role'=>$res->role,
                    'status'=>$res->status,
                    'create_time'=>$res->create_time,
                    'token'=>$token,
                    'token_valid_time'=>config('app.maintain_login_time'),
                    'last_login_time'=>$res->last_login_time,
                    'last_login_time'=>$res->last_login_time,
                    'ava'=>$res->ava,
                ];

                #权限菜单保存
                if(config('app.auth_power_validate') && $rtn['role']){
                    $menu=AdminRole::getUserPower($rtn['role']);
                    cache($res['id'].'_power',$menu,config('app.maintain_login_time'));//保存当前用户权限
                }
                cache($res['id'].'_info',$rtn,config('app.maintain_login_time'));
                if(empty($rtn['ava'])) $rtn['ava']['path']=config('app.server_url').'/static/api/img/avatar.png';
                return $this->json($rtn,200,"登录成功");

            }else{
                return $this->json("",401,"密码错误");
            }
        }
        return $this->json("",401,"请使用POST请求");
    }

}
