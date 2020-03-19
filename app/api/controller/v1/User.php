<?php

namespace app\api\controller\v1;

use app\api\model\AdminUser;
use app\common\model\Handle;
use think\Controller;
use think\exception\ValidateException;
use think\Request;

class User extends \app\api\controller\Auto
{
    /**
     *

    @OA\Get(
     *     tags={"admin"},
     *     path=".user/",
    summary="获取用户列表",

     *      * * @OA\Parameter(
    in="query",
    name="token",
    description="",
    @OA\Schema(
    type="string",
    default="ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SjFhV1FpT2pFc0luUnBiV1VpT2pFMU9EUTFNakE0TWpGOS4weFdTWUpHVEVwVERCQWRNX1d1d0tTN2xLQ3dMZHhueGZGaTh4WlpudkZN"
    ),
    ),
     *     *      * * @OA\Parameter(
    in="query",
    name="",
    description="登录名",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      * * @OA\Parameter(
    in="query",
    name="nickname",
    description="昵称",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      * * @OA\Parameter(
    in="query",
    name="email",
    description="邮箱",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      *      * * @OA\Parameter(
    in="query",
    name="mobile",
    description="手机号",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *
     *       *  *      *      * * @OA\Parameter(
    in="query",
    name="create_time[]",
    description="创建时间，传入数组，第一个元素为开始时间，第二个为结束时间",
    @OA\Schema(
    type="Array",
    default={"2020-03-17","2020-03-19"}
    ),
    ),
     *
     *     *      *      * * @OA\Parameter(
    in="query",
    name="sort_key",
    description="排序字段，凡使返回的属性都可以作为排序的key",
    @OA\Schema(
    type="string",
    default="id"
    ),
    ),
     *
     *      *     *      *      * * @OA\Parameter(
    in="query",
    name="sort_type",
    description="排序类型--1:降序，2：升序",
    @OA\Schema(
    type="number",
    default="1"
    ),
    ),
     *
    @OA\Response(
    response=200,
    description="正常；请求已完成",
     *         @OA\JsonContent(
     *             type="array",
     *     example={},
     *             @OA\Items(
     *


     * )
     *         ),
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

    )
     *
     * @return \think\Response
     */
    public function index()
    {

        $list=\app\api\model\AdminUser::with('ava')->withAttr('password',function($value,$data){
            return '';
        })->where(\app\api\model\AdminUser::__map())->order(AdminUser::getSort())->paginate(config('app.page_num'))->toArray();
        echo AdminUser::getLastSql();
        if($list['total']){
            return $this->json($list,'',"获取成功");
        }else{
            return $this->json('',204,"获取失败");
        }
    }
    /**
     *

    @OA\Get(
     *     tags={"admin"},
     *     path=".user/all",
    summary="获取全部管理用户列表无分页，做下拉选择使用",

     *
     *  *      * * @OA\Parameter(
    in="query",
    name="token",
    description="",
    @OA\Schema(
    type="string",
    default="ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SjFhV1FpT2pFc0luUnBiV1VpT2pFMU9EUTFNakE0TWpGOS4weFdTWUpHVEVwVERCQWRNX1d1d0tTN2xLQ3dMZHhueGZGaTh4WlpudkZN"
    ),
    ),
     *      * * @OA\Parameter(
    in="query",
    name="username",
    description="登录名",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      * * @OA\Parameter(
    in="query",
    name="nickname",
    description="昵称",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      * * @OA\Parameter(
    in="query",
    name="email",
    description="邮箱",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      *      * * @OA\Parameter(
    in="query",
    name="mobile",
    description="手机号",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *  *      *      * * @OA\Parameter(
    in="query",
    name="create_time[]",
    description="创建时间，传入数组，第一个元素为开始时间，第二个为结束时间",
    @OA\Schema(
    type="Array",
    default={"2020-03-17","2020-03-19"}
    ),
    ),
     *
     *
     *      *     *      *      * * @OA\Parameter(
    in="query",
    name="sort_key",
    description="排序字段，凡使返回的属性都可以作为排序的key",
    @OA\Schema(
    type="string",
    default="id"
    ),
    ),
     *
     *      *     *      *      * * @OA\Parameter(
    in="query",
    name="sort_type",
    description="排序类型--1:降序，2：升序",
    @OA\Schema(
    type="number",
    default="1"
    ),
    ),
     *
     *
    @OA\Response(
    response=200,
    description="正常；请求已完成",
     *         @OA\JsonContent(
     *             type="array",
     *     example={},
     *             @OA\Items(
     *


     * )
     *         ),
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

    )
     *
     * @return \think\Response
     */
    public function all()
    {

        $list=\app\api\model\AdminUser::where(\app\api\model\AdminUser::__map())->order(AdminUser::getSort())->field('id,username,email,mobile,role')->select()->toArray();
        if(!empty($list)){
            return $this->json($list,'',"获取成功");
        }else{
            return $this->json('',204,"获取失败");
        }
    }

    /**
     *
     * * @OA\Post(
     *     tags={"admin"},
     *     path=".user/save",
     *     summary="用户添加",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"username":"kefu","nickname":"客服","password":"newairtek@2019","email":"newairtek@126.com","avatar"="1","role":"1","mobile":"15154197763"}
     *             )
     *         ),
     *
     *     description="username:登录名，可用于户登录，不可重复；nickname:昵称；password:密码，email :邮箱，可用于用户登录不可重复，avatar:头像，通过上传文件接口返回的图片ID，role:角色,mobile:手机号，可用于用户登录，不可重复"
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
     *
     * 新建用户
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {

        if($request->isPost()){
            $data=$request->post();
            try{
                $this->validate($data, 'AdminUser');
            }catch (ValidateException $e){
                return  $this->json("",401,$e->getError());
            }
            $data['status']=1;
            $obj=\app\api\model\AdminUser::create($data);
            if($obj->id){
                return $this->json("",'',"操作成功");
            }else{
                return $this->json("",'',"操作失败");
            }
        }else{
            return $this->json('',403,"请求方式不正确");
        }

    }

    /**
     *
     *
    @OA\Get(
     *     tags={"admin"},
     *     path=".user/read",
    summary="读取单个用户",
     * @OA\Parameter(
    in="query",
    name="id",
    description="",
    @OA\Schema(
    type="number",
    minimum=1,
    default=4
    ),
    ),
     *
    @OA\Response(
    response=200,
    description="正常；请求已完成",
     *         @OA\JsonContent(
     *             type="array",
     *     example={},
     *             @OA\Items(
     *


     * )
     *         ),
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

    )
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read(Request $request,$id=0)
    {
        if($id && is_numeric($id)){
            $data=\app\api\model\AdminUser::with('ava')->where('id',$id)->find();
            if(!empty($data)){
                return $this->json($data,'',"获取成功");
            }else{
                return $this->json("",'',"获取失败");
            }
        }else{
            return $this->json('',403,"请求方式不正确");
        }

    }

    /**
     *
     * * @OA\Post(
     *     tags={"admin"},
     *     path=".user/update",
     *     summary="用户编辑",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"id":"4","nickname":"客服","email":"newairtek@126.com","mobile":"15154197763","avatar"="1","role":"1","first_name":"leon","last_name":"hu","qq":"4170974216","wechart":"leon_2342","gender":"男","status":"1"}
     *             )
     *         ),
     *
     *     description="nickname:昵称；email :邮箱，mobile:手机号，status 1:可正常登录，2：禁止登陆，avatar:头像,通过附件返回的ID，role:角色"
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
     更新用户

     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request,$id=0)
    {
        if($request->isPost()){
            $data=$request->post();
            try{
                $this->validate($data, 'AdminUser.edit');
            }catch (ValidateException $e){
                 return $this->json("",401,$e->getError());
            }
            if(!$id) return $this->json("","重要参数丢失",401);
            if(isset($data['username'])) unset($data['username']);
            if(isset($data['password'])) unset($data['password']);
            if(isset($data['order_count'])) unset($data['order_count']);
            $email=$data['email'];
            $mobile=$data['mobile'];
            $have_id=AdminUser::where('id','<>',$id)->where(function($query) use ($email,$mobile){
                $query->where('email','=',$email)->whereOr('mobile','=',$mobile);
            })->column('id');
//            $have_id=AdminUser::where([[['id','=',$id]],[['email','=',$data['email']],['mobile','=',$data['mobile']]]])->column('id');
            if($have_id) return $this->json("","邮箱或者手机号有重复，请按照真实信息填写",401);
            $affect=\app\api\model\AdminUser::update($data);
            if($affect!==false){
                return $this->json("",'',"操作成功");
            }else{
                return $this->json("",'',"操作失败");
            }
        }else{
            return $this->json('',403,"访问被拒绝");
        }
    }

    /**
     * 删除指定资源

    @OA\Get(
     *     tags={"admin"},
     *     path=".user/delete",
    summary="删除用户",
     * @OA\Parameter(
    in="query",
    name="id",
    description="",
    @OA\Schema(
    type="number",
    minimum=1,
    default=9
    ),
    ),
     *
    @OA\Response(
    response=200,
    description="正常；请求已完成",
     *         @OA\JsonContent(
     *             type="array",
     *     example={},
     *             @OA\Items(
     *


     * )
     *         ),
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

    )
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id=0)
    {
        if($id && is_numeric($id)){
            $affect=\app\api\model\AdminUser::where('id',$id)->update(['trash'=>1]);
            if($affect!==false){
                return $this->json("",'',"操作成功");
            }else{
                return $this->json("",'',"操作失败");
            }
        }else{
            return $this->json('',403,"访问被拒绝");
        }
    }


    /**
     * @OA\Post(
     *     tags={"admin"},
     *     path=".user/resetpw",
     *     summary="重置密码，超级管理员可以重置所有人的密码，用户ID为1的用户为超级管理员，非常超级管理员只能重置自己的密码",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"password":"123456","uid":"5","token":"ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SjFhV1FpT2pFc0luUnBiV1VpT2pFMU9EUTFNVGt4TmpCOS5iNjF3cEFoUFFVWE9FdnhtZ0dmUF9jaWFkNm9OUmlZcTRYRUtJNXRCajl3"}
     *             )
     *         ),
     *
     *     description="password:新密码，uid:重置密码的用户ID"
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


    public function resetpw()
    {

        if($this->request->isPost()){

            $data=$this->request->post();
            if($this->_uid!=$data['uid'] && $this->_uid!=1)  return $this->json("",403,"越权修改，无法完成");
            try{
                $this->validate($data, 'AdminUser.reset');
            }catch (ValidateException $e){
                return $this->json("",401,$e->getError());
            }
            $pw=password_hash((string)trim($data['password']),PASSWORD_BCRYPT);
            $res=AdminUser::where('id',$data['uid'])->update(['password'=>$pw]);
            if($res!==false){
                return $this->json("",200,"操作成功");
            }else{
                return $this->json("",500,"服务器错误");
            }

        }
        return $this->json("",403,"退出失败");
    }

    /**
     * @OA\Post(
     *     tags={"admin"},
     *     path=".user/logout",
     *     summary="登出接口",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"token":"ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SjFhV1FpT2pFc0luUnBiV1VpT2pFMU9EUTFNVGt4TmpCOS5iNjF3cEFoUFFVWE9FdnhtZ0dmUF9jaWFkNm9OUmlZcTRYRUtJNXRCajl3"}
     *             )
     *         ),
     *
     *     description=""
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
    public function logout(){
        if($this->request->isPost()){
            \think\facade\Cache::delete($this->_uid.'_info');//清楚缓存
            return $this->json("",'',"退出成功");
        }
        return $this->json("",403,"退出失败");
    }



}
