<?php

namespace app\api\controller\v1;

use app\api\model\AdminRole;
use think\Controller;
use think\exception\ValidateException;
use think\Request;

class Role extends \app\api\controller\Auto
{
    /**
     *

    @OA\Get(
     *     tags={"admin"},
     *     path=".role/",
    summary="获取角色列表",

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
    name="name",
    description="角色名字",
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
    default={"2020-03-17","2020-03-29"}
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

        $list=\app\api\model\AdminRole::where(AdminRole::__map())->order(AdminRole::getSort())->paginate(config('app.page_num'))->toArray();
        if($list['total']){
            return $this->json($list,'',"获取成功");
        }else{
            return $this->json('',204,"获取失败");
        }
    }

    /**
     *
     * * @OA\Post(
     *     tags={"admin"},
     *     path=".role/save",
     *     summary="角色添加",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"pid":"0","name":"客服","description":"描述","menu_auth":{"1","2","4"}}
     *             )
     *         ),
     *
     *     description="pid:父级角色，0:顶级角色，name：角色名字，menu_auth:角色拥有的菜单节点，选择菜单数据接口返回的菜单树"
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
                $this->validate($data, 'AdminRole');
            }catch (ValidateException $e){
                return  $this->json("",401,$e->getError());
            }
            $data['status']=1;
            $obj=\app\api\model\AdminRole::create($data);
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
     *     path=".role/read",
    summary="读取单个角色",
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
     *     * @OA\Parameter(
    in="query",
    name="token",
    description="",
    @OA\Schema(
    type="string",
    default="ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SjFhV1FpT2pVc0luUnBiV1VpT2pFMU9EUTJNVFUzTURCOS55d0lkNVJReUF6dUxiemhjZ1NUTkVyTnNSNWd4ZWNWRlBfaFdnX0RxNTlF"
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
            $data=\app\api\model\AdminRole::where('id',$id)->where(AdminRole::__map())->find();
            if(!empty($data)){
                return $this->json($data,'',"获取成功");
            }else{
                return $this->json("",'204',"获取失败");
            }
        }else{
            return $this->json('',403,"请求方式不正确");
        }

    }

    /**
     *
     * * @OA\Post(
     *     tags={"admin"},
     *     path=".role/update",
     *     summary="角色编辑",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                   example={"id":"1","pid":"0","name":"客服","description":"描述","menu_auth":{"1","2","4"}}
     *             )
     *         ),
     *
     *     description="pid:父级角色，0:顶级角色，name：角色名字，menu_auth:角色拥有的菜单节点，选择菜单数据接口返回的菜单树"
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
                $this->validate($data, 'AdminRole.edit');
            }catch (ValidateException $e){
                 return $this->json("",401,$e->getError());
            }
            $affect=\app\api\model\AdminRole::update($data);
            if($affect!==false){
                return $this->json("",'',"操作成功");
            }else{
                return $this->json("",'204',"操作失败");
            }
        }else{
            return $this->json('',403,"访问被拒绝");
        }
    }

    /**
     * 删除指定资源

    @OA\Get(
     *     tags={"admin"},
     *     path=".role/delete",
    summary="删除角色",
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
     *      *     * @OA\Parameter(
    in="query",
    name="token",
    description="",
    @OA\Schema(
    type="string",
    default="ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SjFhV1FpT2pVc0luUnBiV1VpT2pFMU9EUTJNVFUzTURCOS55d0lkNVJReUF6dUxiemhjZ1NUTkVyTnNSNWd4ZWNWRlBfaFdnX0RxNTlF"
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
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id=0)
    {
        if($id && is_numeric($id)){
            $affect=\app\api\model\AdminRole::where('id',$id)->update(['trash'=>1]);
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
     *
    @OA\Get(
     *     tags={"admin"},
     *     path=".role/tree",
    summary="获取角色树，选择父级菜单的时候使用",

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

     **     *      * * @OA\Parameter(
    in="query",
    name="name",
    description="角色名字",
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
    default={"2020-03-17","2020-03-28"}
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
    public function tree()
    {
        $list_arr=\app\api\model\AdminRole::where(\app\api\model\AdminRole::__map())->order("pid asc, sort desc,id desc")->column('id,pid,name,menu_auth','id');
        $list=AdminRole::_tree($list_arr);
        if(!empty($list)){
            return $this->json($list,'',"获取成功");
        }else{
            return $this->json('',204,"获取失败");
        }
    }



}
