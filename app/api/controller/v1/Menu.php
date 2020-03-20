<?php

namespace app\api\controller\v1;

use app\api\model\AdminMenu;
use app\common\model\Handle;
use think\Controller;
use think\exception\ValidateException;
use think\Request;

class Menu extends \app\api\controller\Auto
{
    /**
     *

    @OA\Get(
     *     tags={"admin"},
     *     path=".menu/",
    summary="获取菜单列表",

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
    name="name_ch",
    description="中文名字",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      * * @OA\Parameter(
    in="query",
    name="name_en",
    description="英文名字",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      * * @OA\Parameter(
    in="query",
    name="route_value",
    description="路由",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      *      * * @OA\Parameter(
    in="query",
    name="system_menu",
    description="是否系统菜单",
    @OA\Schema(
    type="string",
    default="1"
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

        $list=\app\api\model\AdminMenu::withAttr('password',function($value,$data){
            return '';
        })->where(\app\api\model\AdminMenu::__map())->order(AdminMenu::getSort())->paginate(config('app.page_num'))->toArray();
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
     *     path=".menu/save",
     *     summary="添加菜单",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  example={"id":"3","pid":"0","module":"admin","tag":"tag_name","name_ch":"中文名字","name_en":"英文名字","icon"="icon-shoucang1","route_value":"/user/add","url_value":"后台验证待接口","tree_hide":"0","system_menu":"1","sort":"100","tree_hide":0}
     *             )
     *         ),
     *
     *     description="pid:父级菜单，0:顶级菜单,module:菜单分组，tag:菜单别名，icon:菜单图标，route_value:前端路由地址，url_value:路由败给绑定后台接口地址，tree_hide:是否在菜单树中显示，system_menu:是否是系统菜单，系统菜单不允许删除,sort:排序降序排列,tree_hide:是否在菜单书中显示"
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
                $this->validate($data, 'AdminMenu');
            }catch (ValidateException $e){
                return  $this->json("",400,$e->getError());
            }
            $data['status']=1;
            $data['uid']=$this->_uid;
            $obj=\app\api\model\AdminMenu::create($data);
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
     *     path=".menu/read",
    summary="读取单条菜单数据",
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
            $data=\app\api\model\AdminMenu::where('id',$id)->where(AdminMenu::__map())->find();
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
     *     path=".menu/update",
     *     summary="菜单编辑",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  example={"id":"3","pid":"0","module":"admin","tag":"tag_name","name_ch":"中文名字","name_en":"英文名字","icon"="icon-shoucang1","route_value":"/user/add","url_value":"后台验证待接口","tree_hide":"0","system_menu":"1","sort":"100","tree_hide":0}
     *             )
     *         ),
     *
     *     description="pid:父级菜单，0:顶级菜单,module:菜单分组，tag:菜单别名，icon:菜单图标，route_value:前端路由地址，url_value:该路由败给绑定后台接口地址，tree_hide:是否在菜单树中显示，system_menu:是否是系统菜单，系统菜单不允许删除,sort:排序降序排列,tree_hide:是否在菜单书中显示"
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
                $this->validate($data, 'AdminMenu.edit');
            }catch (ValidateException $e){
                 return $this->json("",400,$e->getError());
            }
            if(!$id) return $this->json("","重要参数丢失",401);
            $affect=\app\api\model\AdminMenu::update($data);
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
     *     path=".menu/delete",
    summary="删除菜单",
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
            $affect=\app\api\model\AdminMenu::where('id',$id)->update(['trash'=>1]);
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
     *     path=".menu/tree",
    summary="获取菜单树",

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
    name="name_ch",
    description="中文名字",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      * * @OA\Parameter(
    in="query",
    name="name_en",
    description="英文名字",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      * * @OA\Parameter(
    in="query",
    name="route_value",
    description="路由",
    @OA\Schema(
    type="string",
    default=""
    ),
    ),
     *      *      * * @OA\Parameter(
    in="query",
    name="system_menu",
    description="是否系统菜单",
    @OA\Schema(
    type="string",
    default="1"
    ),
    ),
     * *      *      * * @OA\Parameter(
    in="query",
    name="tree_hide",
    description="是否过滤，tree_hide=1的菜单，默认0",
    @OA\Schema(
    type="string",
    default="0"
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
        $list_arr=\app\api\model\AdminMenu::where(\app\api\model\AdminMenu::__map())->order("pid asc, sort desc,id desc")->column('id,pid,module,tag,name_ch,name_en,url_value,route_value,sort','id');
        $list=AdminMenu::_tree($list_arr);
        if(!empty($list)){
            return $this->json($list,'',"获取成功");
        }else{
            return $this->json('',204,"获取失败");
        }
    }



}
